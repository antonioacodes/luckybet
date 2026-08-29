<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaptureTrackingParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Capturar FBCLID da URL
        if ($request->has('fbclid')) {
            $fbclid = $request->input('fbclid');
            session(['fbclid' => $fbclid]);
            
            // Converter para FBC e armazenar
            $fbc = 'fb.1.' . time() . '.' . $fbclid;
            session(['fb_fbc' => $fbc]);
            
            Log::info('FBCLID capturado pelo middleware', [
                'fbclid' => $fbclid,
                'fb_fbc' => $fbc,
                'url' => $request->fullUrl()
            ]);
        }
        
        // Capturar FBP do cookie
        if (isset($_COOKIE['_fbp'])) {
            session(['fb_fbp' => $_COOKIE['_fbp']]);
            
            Log::info('FBP capturado pelo middleware', [
                'fb_fbp' => $_COOKIE['_fbp']
            ]);
        }
        
        // Se o usuário estiver autenticado, armazene os parâmetros nele
        if (auth()->check()) {
            $user = auth()->user();
            $updateData = [];
            
            // Apenas atualize se não estiver definido ou se tiver um novo valor melhor
            if ((empty($user->fb_fbp) && session('fb_fbp')) || 
                (!empty(session('fb_fbp')) && $user->fb_fbp != session('fb_fbp'))) {
                $updateData['fb_fbp'] = session('fb_fbp');
            }
            
            if ((empty($user->fb_fbc) && session('fb_fbc')) || 
                (!empty(session('fb_fbc')) && $user->fb_fbc != session('fb_fbc'))) {
                $updateData['fb_fbc'] = session('fb_fbc');
            }
            
            if (!empty($updateData)) {
                $user->update($updateData);
                
                Log::info('Parâmetros de tracking atualizados no usuário pelo middleware', [
                    'user_id' => $user->id,
                    'fbp' => $updateData['fb_fbp'] ?? null,
                    'fbc' => $updateData['fb_fbc'] ?? null
                ]);
            }
        }
        
        return $next($request);
    }
}