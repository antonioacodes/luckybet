<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RouletteController extends Controller
{
    /**
     * Verifica o status da roleta para o usuário atual
     *
     * @param int $userId ID do usuário (opcional)
     * @return array Status do usuário para a roleta
     */
    public function checkStatus($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }
        
        // Verificar se o usuário tem depósitos confirmados nos últimos 7 dias
        $recentDeposit = DB::table('deposits')
            ->where('user_id', $userId)
            ->where('status', 1) // Status confirmado
            ->where('updated_at', '>=', now()->subDays(7))
            ->first();
        
        $hasRecentDeposit = $recentDeposit ? true : false;
        
        // Verificar se o usuário já girou hoje
        $lastSpin = DB::table('user_spins')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $spinsAvailable = 0;
        $nextSpinTime = null;
        
        if ($hasRecentDeposit) {
            if (!$lastSpin || (new Carbon($lastSpin->created_at))->startOfDay()->lt(now()->startOfDay())) {
                // Não girou hoje ainda, pode girar
                $spinsAvailable = 1;
            } else {
                // Já girou hoje, calcular próximo horário disponível
                $nextSpinTime = (new Carbon($lastSpin->created_at))->addDay()->format('Y-m-d H:i:s');
            }
        }
        
        return [
            'hasRecentDeposit' => $hasRecentDeposit,
            'spinsAvailable' => $spinsAvailable,
            'lastSpinDate' => $lastSpin ? $lastSpin->created_at : null,
            'nextSpinTime' => $nextSpinTime
        ];
    }
    
    /**
     * Retorna o status da roleta para o usuário atual (endpoint de API)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRouletteStatus(Request $request)
    {
        $status = $this->checkStatus();
        return response()->json($status);
    }
    
    /**
     * Registra um giro da roleta para o usuário atual
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function spin(Request $request)
    {
        $userId = auth()->id();
        
        // Validar se o usuário pode girar
        $status = $this->checkStatus($userId);
        
        if (!$status['spinsAvailable']) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum giro disponível no momento.'
            ], 400);
        }
        
        // Obter prêmios disponíveis do banco de dados
        $prizes = $this->getAvailablePrizes();
        
        // Em um sistema real, o prêmio seria determinado pelo servidor
        // para evitar manipulação pelo cliente
        $prizeIndex = rand(0, count($prizes) - 1); // Escolhe um prêmio aleatório
        $prize = $prizes[$prizeIndex];
        
        // Registrar o giro no banco de dados
        $spinId = DB::table('user_spins')->insertGetId([
            'user_id' => $userId,
            'prize_id' => $prize['id'],
            'prize_name' => $prize['name'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Conceder o prêmio ao usuário
        $this->awardPrize($userId, $prize);
        
        return response()->json([
            'success' => true,
            'spin_id' => $spinId,
            'prize' => $prize
        ]);
    }
    
    /**
     * Retorna a lista de prêmios disponíveis
     *
     * @return array
     */
    private function getAvailablePrizes()
    {
        // Idealmente, isso viria do banco de dados
        // Mas por enquanto vamos retornar uma lista fixa
        return [
            ['id' => 1, 'name' => 'Rodadas grátis Dice', 'type' => 'free_rounds', 'game' => 'dice', 'amount' => 5],
            ['id' => 2, 'name' => 'Rodadas grátis Limbo', 'type' => 'free_rounds', 'game' => 'limbo', 'amount' => 5],
            ['id' => 3, 'name' => 'Bônus de R$ 5', 'type' => 'bonus', 'amount' => 5.00],
            ['id' => 4, 'name' => 'Bônus de R$ 10', 'type' => 'bonus', 'amount' => 10.00],
            ['id' => 5, 'name' => 'Cashback 5%', 'type' => 'cashback', 'amount' => 5],
            ['id' => 6, 'name' => 'Cashback 10%', 'type' => 'cashback', 'amount' => 10],
            ['id' => 7, 'name' => 'Rodadas grátis Mines', 'type' => 'free_rounds', 'game' => 'mines', 'amount' => 3],
            ['id' => 8, 'name' => 'Rodadas grátis Crash', 'type' => 'free_rounds', 'game' => 'crash', 'amount' => 3],
            ['id' => 9, 'name' => '10 Rodadas grátis Dice', 'type' => 'free_rounds', 'game' => 'dice', 'amount' => 10],
            ['id' => 10, 'name' => '10 Rodadas grátis Limbo', 'type' => 'free_rounds', 'game' => 'limbo', 'amount' => 10],
            ['id' => 11, 'name' => 'Sem prêmio', 'type' => 'none', 'amount' => 0],
        ];
    }
    
    /**
     * Concede o prêmio ao usuário
     *
     * @param int $userId ID do usuário
     * @param array $prize Informações do prêmio
     * @return void
     */
    private function awardPrize($userId, $prize)
    {
        // Implemente a lógica para conceder o prêmio baseado no tipo
        switch ($prize['type']) {
            case 'free_rounds':
                // Adicionar rodadas grátis para o jogo específico
                DB::table('user_free_rounds')->insert([
                    'user_id' => $userId,
                    'game' => $prize['game'],
                    'rounds' => $prize['amount'],
                    'expires_at' => now()->addDays(7),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                break;
                
            case 'bonus':
                // Adicionar bônus à conta do usuário
                DB::table('user_bonuses')->insert([
                    'user_id' => $userId,
                    'amount' => $prize['amount'],
                    'wagering_requirement' => $prize['amount'] * 15, // 15x requisito de aposta
                    'wagered' => 0,
                    'expires_at' => now()->addDays(7),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                break;
                
            case 'cashback':
                // Aplicar cashback nas próximas perdas
                DB::table('user_cashbacks')->insert([
                    'user_id' => $userId,
                    'percentage' => $prize['amount'],
                    'max_amount' => 100.00, // Limite de R$100 para cashback
                    'expires_at' => now()->addDays(2),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                break;
                
            case 'none':
                // Sem prêmio, não faz nada
                break;
        }
        
        // Registro na tabela de histórico de prêmios
        DB::table('user_prize_history')->insert([
            'user_id' => $userId,
            'prize_id' => $prize['id'],
            'prize_name' => $prize['name'],
            'prize_type' => $prize['type'],
            'amount' => $prize['amount'] ?? 0,
            'created_at' => now()
        ]);
    }
    
    /**
     * Retorna o histórico de giros da roleta do usuário
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpinHistory(Request $request)
    {
        $userId = auth()->id();
        
        $history = DB::table('user_spins')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }
}