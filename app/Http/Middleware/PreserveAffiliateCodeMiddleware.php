<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreserveAffiliateCodeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Se houver um código de afiliação na URL, salve na sessão
        if ($request->has('code')) {
            session(['affiliate_code' => $request->input('code')]);
            
            \Log::info('Middleware - Affiliate Code Preserved', [
                'code' => $request->input('code'),
                'session_code' => session('affiliate_code')
            ]);
        }

        return $next($request);
    }
}