<?php

namespace App\Services\Games;

use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CrashService
{
    public function initGame(User $user, $amount)
    {
        // 1. Valida Saldo (Mesma lógica do Mines)
        $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();
        $totalBalance = $wallet->balance + $wallet->balance_bonus + $wallet->balance_withdrawal;

        if ($totalBalance < $amount) {
            throw new Exception("Saldo insuficiente.");
        }

        // 2. Gera o Ponto de Crash (Algoritmo simples de probabilidade)
        // Isso gera muitos valores baixos e poucos altos (curva exponencial)
        $crashPoint = $this->generateCrashPoint();

        return DB::transaction(function () use ($user, $wallet, $amount, $crashPoint) {
            // Debita saldo (Prioridade: Balance -> Withdrawal -> Bonus)
            $remaining = $amount;

            // Lógica simplificada de débito (pode copiar a completa do Mines se preferir)
            if ($wallet->balance >= $remaining) {
                $wallet->decrement('balance', $remaining);
            } else {
                $wallet->decrement('balance', $wallet->balance);
                $remaining -= $wallet->balance;
                // ... continua para withdrawal e bonus
                if ($remaining > 0) $wallet->decrement('balance_bonus', $remaining);
            }

            // Cria a Order
            $order = Order::create([
                'user_id' => $user->id,
                'session_id' => Str::uuid(),
                'transaction_id' => Str::uuid(),
                'game' => 'crash',
                'game_uuid' => 'crash-original',
                'amount' => $amount,
                'payout' => 0,
                'status' => 0, // Pending
                'type' => 'bet',
                'game_data' => [
                    'crash_point' => $crashPoint, // O segredo fica guardado aqui
                    'state' => 'active'
                ]
            ]);

            return [
                'order_id' => $order->id,
                'balance' => $wallet->balance + $wallet->balance_bonus + $wallet->balance_withdrawal,
                // NÃO enviamos o crash_point para o front para evitar hacks fáceis
                // O front vai "descobrir" quando chamar o cashout ou quando o tempo acabar
                // Mas para facilitar a animação sincronizada neste exemplo simples, 
                // vamos enviar encriptado ou enviar direto se for um MVP.
                // PARA ESTE EXEMPLO: Vamos enviar o crash_point para o front controlar a animação
                // (Em produção real, usa-se sockets ou hash verification)
                'crash_point' => $crashPoint 
            ];
        });
    }

    public function cashout(User $user, $orderId, $clientMultiplier)
    {
        return DB::transaction(function () use ($user, $orderId, $clientMultiplier) {
            $order = Order::where('id', $orderId)->where('user_id', $user->id)->lockForUpdate()->firstOrFail();
            $data = $order->game_data;

            if ($data['state'] !== 'active') throw new Exception('Jogo já finalizado');

            // Validação de Segurança:
            // Se o cliente tentar sacar num valor maior que o crash point gerado no inicio
            if ($clientMultiplier > $data['crash_point']) {
                $data['state'] = 'bust';
                $order->update(['status' => 2, 'game_data' => $data]);
                throw new Exception('Crashou antes do saque!');
            }

            $winAmount = round($order->amount * $clientMultiplier, 2);

            $user->wallet->increment('balance', $winAmount);
            $user->wallet->increment('total_won', $winAmount);

            $data['state'] = 'cashed_out';
            $data['cashed_at'] = $clientMultiplier;

            $order->update([
                'status' => 1, // Win
                'payout' => $winAmount,
                'game_data' => $data
            ]);

            return [
                'status' => 'win',
                'amount' => $winAmount,
                'balance' => $user->wallet->balance + $user->wallet->balance_bonus + $user->wallet->balance_withdrawal
            ];
        });
    }

    public function finishGame(User $user, $orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', $user->id)->first();
        if ($order && $order->game_data['state'] === 'active') {
            $data = $order->game_data;
            $data['state'] = 'bust';
            $order->update(['status' => 2, 'game_data' => $data]);
        }
    }

    // Algoritmo clássico de Crash
    private function generateCrashPoint()
    {
        // E = 100 / (100 - H) onde H é a margem da casa (ex: 4%)
        // Para simplificar:
        $r = (float)rand(1, 1000000) / 100; // 0.01 a 10000.00

        // Exemplo simples: 
        // Multiplicador = 0.99 / (0 a 1 random)
        // Mas vamos usar um hardcoded logic para testes se quiser, ou o real:

        $e = 2 ** 32;
        $h = php_uname('n') . microtime();
        $h = substr(hash_hmac('sha256', $h, 'secret'), 0, 13 / 4);
        $h = hexdec($h);

        $crash = floor((100 * $e - $h) / ($e - $h)) / 100;

        // House edge instant crash (1.00x)
        if ($crash % 33 == 0) return 1.00;

        return max(1.00, $crash);
    }
}
