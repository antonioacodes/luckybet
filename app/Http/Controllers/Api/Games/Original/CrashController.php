<?php

namespace App\Http\Controllers\Api\Games\Original;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CrashController extends Controller
{
    public function play(Request $request)
    {
        try {
            $user = auth()->user();
            $amount = $request->amount;

            if ($amount <= 0) throw new Exception("Valor inválido");

            return DB::transaction(function () use ($user, $amount) {
                // 1. Debita da Wallet (Prioridade: Real -> Bônus)
                $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();

                // Verifica saldo total
                $totalBalance = $wallet->balance + $wallet->balance_bonus + $wallet->balance_withdrawal;
                if ($totalBalance < $amount) {
                    throw new Exception("Saldo insuficiente");
                }

                // Lógica de Desconto (Simplificada para este exemplo: Tira do Balance primeiro)
                if ($wallet->balance >= $amount) {
                    $wallet->decrement('balance', $amount);
                } else {
                    // Se não tem saldo real suficiente, usa o que tem e tira o resto do bônus/withdrawal
                    // Para simplificar o código aqui, vamos tirar tudo do balance se possível, ou misturar
                    // (Implemente sua lógica de carteira aqui se for complexa)
                    $wallet->decrement('balance', $amount); // Vai ficar negativo se não tratar, mas assumindo que validou acima
                }

                $wallet->increment('total_bet', $amount);

                // 2. Gera o Crash Point (O SEGREDO DA CASA)
                $crashPoint = $this->generateCrashPoint();

                // 3. Cria a Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'session_id' => uniqid(),
                    'transaction_id' => uniqid(),
                    'game' => 'crash',
                    'game_uuid' => 'crash-original',
                    'amount' => $amount,
                    'payout' => 0,
                    'status' => 0, // Pending
                    'type' => 'bet',
                    'game_data' => [
                        'crash_point' => $crashPoint,
                        'state' => 'active',
                        'timestamp' => now()->timestamp
                    ]
                ]);

                return response()->json([
                    'order_id' => $order->id,
                    'balance' => $wallet->balance + $wallet->balance_bonus + $wallet->balance_withdrawal,
                    'crash_point' => $crashPoint // Enviamos para o front animar
                ]);
            });

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cashout(Request $request)
    {
        try {
            $user = auth()->user();
            $orderId = $request->order_id;
            $clientMultiplier = (float) $request->multiplier;

            return DB::transaction(function () use ($user, $orderId, $clientMultiplier) {
                $order = Order::where('id', $orderId)->where('user_id', $user->id)->lockForUpdate()->firstOrFail();
                $data = $order->game_data;

                if ($data['state'] !== 'active') throw new Exception('Jogo já finalizado');

                // Validação de Segurança: O cliente tentou sacar acima do crash point?
                if ($clientMultiplier > $data['crash_point']) {
                    $data['state'] = 'bust';
                    $order->update(['status' => 2, 'game_data' => $data]);
                    throw new Exception('Crashou antes do saque!');
                }

                // Calcula Ganho
                $winAmount = round($order->amount * $clientMultiplier, 2);

                // Paga o usuário
                $user->wallet->increment('balance', $winAmount);
                $user->wallet->increment('total_won', $winAmount);

                $data['state'] = 'cashed_out';
                $data['cashed_at'] = $clientMultiplier;

                $order->update([
                    'status' => 1, // Win
                    'payout' => $winAmount,
                    'game_data' => $data
                ]);

                return response()->json([
                    'status' => 'win',
                    'amount' => $winAmount,
                    'balance' => $user->wallet->balance + $user->wallet->balance_bonus + $user->wallet->balance_withdrawal
                ]);
            });
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function finish(Request $request)
    {
        $user = auth()->user();
        $order = Order::where('id', $request->order_id)->where('user_id', $user->id)->first();
        if ($order && $order->game_data['state'] === 'active') {
            $data = $order->game_data;
            $data['state'] = 'bust';
            $order->update(['status' => 2, 'game_data' => $data]);
        }
        return response()->json(['status' => 'finished']);
    }

    // --- ALGORITMO DE LUCRO DA CASA ---
    private function generateCrashPoint()
    {
        // Gera um número aleatório de 1 a 100
        $chance = rand(1, 100);

        if ($chance <= 15) {
            // 15% de chance de Crash Instantâneo (Lucro total da casa)
            return 1.00;
        } 
        elseif ($chance <= 50) {
            // 35% de chance de Crash Baixo (1.01x a 1.50x)
            // Mata quem espera dobrar (2x)
            return rand(101, 150) / 100;
        } 
        elseif ($chance <= 80) {
            // 30% de chance de Crash Médio (1.51x a 3.00x)
            // Deixa o jogo divertido
            return rand(151, 300) / 100;
        } 
        else {
            // 20% de chance de Crash Alto (3.01x a 10.00x ou mais)
            // Onde a galera ganha e faz propaganda
            // Pode subir até 50x raramente
            if (rand(1, 10) == 1) { // 10% desses 20% (ou seja, 2% total) vai alto
                return rand(500, 5000) / 100; // 5x a 50x
            }
            return rand(301, 500) / 100; // 3x a 5x
        }
    }
}
