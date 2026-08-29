<?php

namespace App\Http\Controllers\Api\Missions;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MissionUserController extends Controller
{
    /**
     * Listar missões do usuário
     */
    public function index()
    {
        try {
            $userId = auth('api')->id();
            
            $userMissions = MissionUser::with('mission')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'missions' => $userMissions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Erro ao buscar missões do usuário'
            ], 500);
        }
    }

    /**
     * Participar de uma missão
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mission_id' => 'required|exists:missions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userId = auth('api')->id();
            $mission = Mission::findOrFail($request->mission_id);

            // Verificar se a missão está ativa
            if (!$mission->is_active) {
                return response()->json([
                    'status' => false,
                    'error' => 'Esta missão não está ativa no momento'
                ], 400);
            }

            // Verificar se já está participando
            $existing = MissionUser::where('user_id', $userId)
                ->where('mission_id', $request->mission_id)
                ->first();

            if ($existing) {
                return response()->json([
                    'status' => false,
                    'error' => 'Você já está participando desta missão'
                ], 400);
            }

            // Criar participação
            $missionUser = MissionUser::create([
                'user_id' => $userId,
                'mission_id' => $request->mission_id,
                'progress_current' => 0,
                'progress_target' => $mission->challenge_total,
                'is_completed' => false,
                'is_claimed' => false,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Você está participando da missão!',
                'mission_user' => $missionUser
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Erro ao participar da missão',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resgatar recompensa
     */
    public function update(Request $request, $id)
    {
        try {
            $userId = auth('api')->id();
            $missionUser = MissionUser::with('mission')
                ->where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            // Verificar se está completa
            if (!$missionUser->is_completed) {
                return response()->json([
                    'status' => false,
                    'error' => 'Missão ainda não foi completada'
                ], 400);
            }

            // Verificar se já foi resgatada
            if ($missionUser->is_claimed) {
                return response()->json([
                    'status' => false,
                    'error' => 'Recompensa já foi resgatada'
                ], 400);
            }

            DB::beginTransaction();

            try {
                $mission = $missionUser->mission;
                $user = User::findOrFail($userId);

                // Dar a recompensa
                if ($mission->reward_type === 'bonus') {
                    // Adicionar bônus à carteira
                    $user->wallet->increment('refer_rewards', $mission->challenge_bonus);
                    
                    $rewardMessage = 'R$ ' . number_format($mission->challenge_bonus, 2, ',', '.') . ' em bônus';
                } else {
                    // Adicionar rodadas grátis (você precisa ter um sistema de freespins)
                    // $user->freespins()->create([...]);
                    
                    $rewardMessage = $mission->reward_freespins . ' rodadas grátis';
                }

                // Marcar como resgatado
                $missionUser->update([
                    'is_claimed' => true,
                    'claimed_at' => Carbon::now()
                ]);

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Recompensa resgatada com sucesso!',
                    'reward' => $rewardMessage
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Erro ao resgatar recompensa',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar progresso (chamado automaticamente pelo sistema)
     */
    public function updateProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'mission_id' => 'required|exists:missions,id',
            'progress_increment' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $missionUser = MissionUser::where('user_id', $request->user_id)
                ->where('mission_id', $request->mission_id)
                ->first();

            if (!$missionUser) {
                return response()->json([
                    'status' => false,
                    'error' => 'Usuário não está participando desta missão'
                ], 404);
            }

            // Não atualizar se já completou
            if ($missionUser->is_completed) {
                return response()->json([
                    'status' => true,
                    'message' => 'Missão já completada'
                ]);
            }

            // Incrementar progresso
            $newProgress = $missionUser->progress_current + $request->progress_increment;
            $missionUser->progress_current = $newProgress;

            // Verificar se completou
            if ($newProgress >= $missionUser->progress_target) {
                $missionUser->is_completed = true;
                $missionUser->completed_at = Carbon::now();
            }

            $missionUser->save();

            return response()->json([
                'status' => true,
                'message' => 'Progresso atualizado',
                'mission_user' => $missionUser
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Erro ao atualizar progresso'
            ], 500);
        }
    }
}
