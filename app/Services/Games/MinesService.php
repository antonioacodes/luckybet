<?php

namespace App\Services\Games;

use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MinesService
{
    public function createGame(User $user, $amount, $minesCount)
    {
        try {
            // 1. Validações Básicas
            if ($amount <= 0) throw new Exception("Valor de aposta inválido");
            if ($minesCount < 1 || $minesCount > 24) throw new Exception("Número de minas inválido");

            return DB::transaction(function () use ($user, $amount, $minesCount) {
                // 2. Busca a Wallet de forma segura
                $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();

                if (!$wallet) {
                    throw new Exception("Carteira não encontrada para o usuário.");
                }

                // 3. Verifica Saldo Total (Real + Withdrawal + Bônus)
                // --- ALTERAÇÃO AQUI: Incluído balance_withdrawal ---
                $totalBalance = $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus;

                if ($totalBalance < $amount) {
                    throw new Exception("Saldo insuficiente. Você tem: " . number_format($totalBalance, 2));
                }

                // 4. Lógica de Desconto (Prioridade: Real -> Withdrawal -> Bônus)
                $debitReal = 0;
                $debitWithdrawal = 0; // Novo
                $debitBonus = 0;
                $remaining = $amount;

                // A. Tenta descontar do Balance (Principal)
                if ($wallet->balance > 0) {
                    if ($wallet->balance >= $remaining) {
                        $debitReal = $remaining;
                        $remaining = 0;
                    } else {
                        $debitReal = $wallet->balance;
                        $remaining -= $wallet->balance;
                    }
                }

                // B. Tenta descontar do Balance Withdrawal (Novo Passo)
                if ($remaining > 0 && $wallet->balance_withdrawal > 0) {
                    if ($wallet->balance_withdrawal >= $remaining) {
                        $debitWithdrawal = $remaining;
                        $remaining = 0;
                    } else {
                        $debitWithdrawal = $wallet->balance_withdrawal;
                        $remaining -= $wallet->balance_withdrawal;
                    }
                }

                // C. Tenta descontar do Bônus (Último recurso)
                if ($remaining > 0) {
                    $debitBonus = $remaining;
                }

                // Aplica os descontos no banco
                if ($debitReal > 0) $wallet->decrement('balance', $debitReal);
                if ($debitWithdrawal > 0) $wallet->decrement('balance_withdrawal', $debitWithdrawal);
                if ($debitBonus > 0) $wallet->decrement('balance_bonus', $debitBonus);

                // 5. Gera as Minas
                $grid = range(0, 24);
                shuffle($grid);
                $minePositions = array_slice($grid, 0, $minesCount);

                // 6. Cria o Pedido (Order)
                $uuid = (string) Str::uuid();

                $order = Order::create([
                    'user_id' => $user->id,
                    'session_id' => $uuid,
                    'transaction_id' => $uuid,
                    'game' => 'mines',
                    'game_uuid' => 'mines-original',
                    'type' => 'bet',
                    'type_money' => $debitBonus > 0 ? 'bonus' : 'real',
                    'amount' => $amount,
                    'providers' => 'in-house', 
                    'status' => 'pending',
                    'round_status' => 'active',
                    'game_data' => [
                        'mines' => $minePositions,
                        'mines_count' => $minesCount,
                        'revealed' => [],
                        'multiplier' => 1.00,
                        'current_payout' => $amount,
                        'state' => 'active'
                    ]
                ]);

                // Atualiza a wallet para pegar os valores novos
                $wallet->refresh();

                return [
                    'order_id' => $order->id,
                    // --- ALTERAÇÃO AQUI: Retorna a soma dos 3 saldos ---
                    'balance' => $wallet->balance + $wallet->balance_withdrawal + $wallet->balance_bonus,
                    'mines_count' => $minesCount
                ];
            });
        } catch (\Throwable $e) {
            Log::error("MINES ERROR: " . $e->getMessage());
            throw new Exception("Erro no servidor: " . $e->getMessage());
        }
    }

    public function playRound(User $user, $orderId, $tileIndex)
    {
        try {
            return DB::transaction(function () use ($user, $orderId, $tileIndex) {
                $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $data = $order->game_data;

                if (!$data || !isset($data['state']) || $data['state'] !== 'active') {
                    throw new Exception('Jogo finalizado ou inválido');
                }

                if (in_array($tileIndex, $data['revealed'])) {
                    return [
                        'status' => 'continue',
                        'tile' => $tileIndex,
                        'multiplier' => $data['multiplier'],
                        'current_payout' => $data['current_payout']
                    ];
                }

                // 💥 VERIFICA SE É BOMBA
                if (in_array($tileIndex, $data['mines'])) {
                    $data['state'] = 'lost';
                    $data['revealed'][] = $tileIndex;

                    $order->update([
                        'status' => 2, // Loss
                        'game_data' => $data
                    ]);

                    return [
                        'status' => 'game_over',
                        'mines' => $data['mines'],
                        'message' => 'Booooom!'
                    ];
                }

                // 💎 ACERTOU DIAMANTE
                $data['revealed'][] = $tileIndex;

                // Recalcula Multiplicador
                $totalTiles = 25;
                $minesCount = $data['mines_count'];
                $revealedCount = count($data['revealed']);

                $remainingTotal = $totalTiles - ($revealedCount - 1);
                $remainingSafe = ($totalTiles - $minesCount) - ($revealedCount - 1);

                $roundMultiplier = ($remainingTotal / $remainingSafe) * 0.97;

                $data['multiplier'] = round($data['multiplier'] * $roundMultiplier, 2);
                if ($data['multiplier'] < 1.01) $data['multiplier'] = 1.01;

                $data['current_payout'] = round($order->amount * $data['multiplier'], 2);

                $order->update(['game_data' => $data]);

                return [
                    'status' => 'continue',
                    'tile' => $tileIndex,
                    'multiplier' => $data['multiplier'],
                    'current_payout' => $data['current_payout']
                ];
            });
        } catch (\Throwable $e) {
            Log::error("MINES REVEAL ERROR: " . $e->getMessage());
            throw new Exception("Erro ao revelar: " . $e->getMessage());
        }
    }

    public function cashout(User $user, $orderId)
    {
        try {
            return DB::transaction(function () use ($user, $orderId) {
                $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $data = $order->game_data;

                if ($data['state'] !== 'active') {
                    throw new Exception('Jogo indisponível para saque');
                }

                $winAmount = $data['current_payout'];

                // Paga o usuário (Aqui mantive pagando no BALANCE principal, conforme padrão)
                // Se quiser pagar no balance_withdrawal, mude 'balance' para 'balance_withdrawal' abaixo
                $user->wallet->increment('balance', $winAmount);
                $user->wallet->increment('total_won', $winAmount);

                // Atualiza Order
                $data['state'] = 'cashed_out';
                $order->update([
                    'status' => 1, // Win
                    'payout' => $winAmount,
                    'game_data' => $data
                ]);

                $user->wallet->refresh();

                return [
                    'status' => 'win',
                    'amount' => $winAmount,
                    // --- ALTERAÇÃO AQUI: Retorna a soma dos 3 saldos ---
                    'balance' => $user->wallet->balance + $user->wallet->balance_withdrawal + $user->wallet->balance_bonus,
                    'mines' => $data['mines']
                ];
            });
        } catch (\Throwable $e) {
            Log::error("MINES CASHOUT ERROR: " . $e->getMessage());
            throw new Exception("Erro ao sacar: " . $e->getMessage());
        }
    }
}
