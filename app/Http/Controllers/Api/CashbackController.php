<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; use Illuminate\Http\Request; use Illuminate\Support\Facades\DB; use Carbon\Carbon;

use App\Models\User; use App\Models\Order; use App\Models\Wallet; use App\Models\CashbackSetting; use App\Models\CashbackUser;

class CashbackController extends Controller { public function getStatus(Request $request) { $user = auth()->user();

    // 1. Verifica se o cashback está habilitado
    $settings = DB::table('settings')->first();
    if (!$settings || !$settings->cashback_enabled) {
        return response()->json(['enabled' => false, 'message' => 'Sistema de cashback desabilitado.']);
    }

    // 2. Pega as configurações de regra
    $rule = CashbackSetting::first();
    if (!$rule) {
        return response()->json(['enabled' => false, 'message' => 'Regras de cashback não configuradas.']);
    }

    // 3. Verifica se já existe um cashback DISPONÍVEL
    $existingCashback = CashbackUser::where('user_id', $user->id)
        ->where('status', 'available')
        ->where('expiration_date', '>', now())
        ->first();

    if ($existingCashback) {
        return response()->json([
            'enabled' => true,
            'status' => 'available',
            'amount' => $existingCashback->amount,
            'percentage' => $rule->percentage, // Garante que a % vá aqui
            'periodicity' => $rule->periodicity,
            'expiration' => $existingCashback->expiration_date,
        ]);
    }

            // 4. Define as datas de análise
        $dates = $this->getPeriodDates($rule->periodicity);
        $startDate = $dates['start'];
        $endDate = $dates['end'];

        // --- CORREÇÃO DE SEGURANÇA ---
        // Em vez de checar a data exata, checamos se o usuário já gerou cashback RECENTEMENTE.
        // Se for semanal, ele não pode ter gerado outro nos últimos 7 dias.

        $daysCooldown = match($rule->periodicity) {
            'daily' => 1,
            'weekly' => 7,
            'monthly' => 30,
            default => 7
        };

        // Verifica se existe algum cashback criado dentro desse intervalo de "descanso"
        $recentCashback = CashbackUser::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays($daysCooldown))
            ->first();

        if ($recentCashback) {
            // Calcula quando ele poderá pedir de novo
            $nextAvailableDate = $recentCashback->created_at->addDays($daysCooldown);

            return response()->json([
                'enabled' => true,
                'status' => 'waiting_cycle',
                'percentage' => $rule->percentage,
                'message' => 'Aguarde o próximo ciclo para novo resgate.',
                'next_check' => $nextAvailableDate,
            ]);
        }

    // 5. O CÁLCULO (Net Loss)
    // Somamos Amount onde type='bet' e subtraímos type='win'

    $totalBets = Order::where('user_id', $user->id)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('type', 'bet') 
        ->sum('amount');

    $totalWins = Order::where('user_id', $user->id)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('type', 'win') 
        ->sum('amount');

    // Perda Líquida
    $netLoss = $totalBets - $totalWins;

    // Debug (Opcional: descomente para ver no Network do navegador o que está sendo calculado)
    // return response()->json(['bets' => $totalBets, 'wins' => $totalWins, 'net' => $netLoss, 'start' => $startDate, 'end' => $endDate]);

    if ($netLoss <= 0) {
         return response()->json([
            'enabled' => true,
            'status' => 'no_loss',
            'percentage' => $rule->percentage, // CORREÇÃO: Enviando a % aqui também!
            'message' => 'Sem perdas registradas no período.',
        ]);
    }

    // Calcula o valor
    $cashbackAmount = ($netLoss * $rule->percentage) / 100;

    // Regra de expiração
    $expirationDays = ($rule->periodicity === 'daily') ? 1 : 3;

    // Cria o registro 'available'
    $newCashback = CashbackUser::create([
        'user_id' => $user->id,
        'amount' => $cashbackAmount,
        'status' => 'available',
        'period_start' => $startDate,
        'period_end' => $endDate,
        'expiration_date' => now()->addDays($expirationDays),
    ]);

    return response()->json([
        'enabled' => true,
        'status' => 'available',
        'amount' => $newCashback->amount,
        'percentage' => $rule->percentage,
        'expiration' => $newCashback->expiration_date,
    ]);
}

public function claim(Request $request)
{
    $user = auth()->user();

    $cashback = CashbackUser::where('user_id', $user->id)
        ->where('status', 'available')
        ->where('expiration_date', '>', now())
        ->first();

    if (!$cashback) {
        return response()->json(['error' => 'Nenhum cashback disponível.'], 400);
    }

    DB::beginTransaction();
    try {
        $cashback->update([
            'status' => 'claimed',
            'redeemed_at' => now(),
        ]);

        $wallet = Wallet::where('user_id', $user->id)->first();

        if ($wallet) {
            $wallet->balance += $cashback->amount;
            $wallet->save();
        } else {
            throw new \Exception("Carteira não encontrada.");
        }

        DB::commit();

        return response()->json([
            'success' => true, 
            'message' => 'Resgatado com sucesso!',
            'amount_added' => $cashback->amount,
            'new_balance' => $wallet->balance
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Erro ao processar.'], 500);
    }
}

private function getPeriodDates($periodicity)
{
    $now = Carbon::now();

    // CORREÇÃO: Usando endOfDay() do dia ATUAL ($now) para incluir apostas de hoje nos testes.

    switch ($periodicity) {
        case 'daily':
            return [
                'start' => Carbon::yesterday()->startOfDay(),
                'end' => Carbon::yesterday()->endOfDay()
            ];
        case 'weekly':
            // Últimos 7 dias INCLUINDO hoje
            return [
                'start' => $now->copy()->subDays(7)->startOfDay(),
                'end' => $now->copy()->endOfDay() 
            ];
        case 'monthly':
            // Últimos 30 dias INCLUINDO hoje
            return [
                'start' => $now->copy()->subDays(30)->startOfDay(),
                'end' => $now->copy()->endOfDay()
            ];
        default:
            return [
                'start' => $now->copy()->subDays(7)->startOfDay(),
                'end' => $now->copy()->endOfDay()
            ];
    }
}
}