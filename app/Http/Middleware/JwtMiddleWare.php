<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTMiddleWare
{
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                \Log::error('JWTMIDDLEWARE: Nenhum usuário autenticado pelo token');
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }

            \Log::info('✅ JWTMIDDLEWARE: Usuário autenticado', ['user_id' => $user->id]);
            return $next($request);

        } catch (TokenExpiredException $e) {
            \Log::error('🚨 JWT EXPIRED', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            \Log::error('🚨 JWT INVALID', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            \Log::error('🚨 JWT EXCEPTION', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Token ausente'], 401);
        } catch (\Exception $e) {
            \Log::error('🚨 ERRO DESCONHECIDO JWT', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Erro interno JWT'], 401);
        }
    }
}
