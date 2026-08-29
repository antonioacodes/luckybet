<?php

namespace App\Http\Middleware;

use App\Services\WhitelabelBillingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWhitelabelMaintenance
{
    public function __construct(
        protected WhitelabelBillingService $billingService,
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->billingService->isExpired()) {
            return $next($request);
        }

        $path = ltrim($request->path(), '/');

        // Libera admin e rotas relacionadas
        if (
            str_starts_with($path, 'igamingsolutions/admin') ||
            str_starts_with($path, 'livewire') ||
            str_starts_with($path, 'vendor') ||
            str_starts_with($path, 'storage') ||
            str_starts_with($path, 'assets') ||
            str_starts_with($path, 'build')
        ) {
            return $next($request);
        }

        return response()->view('errors.whitelabel_maintenance', [], 503);
    }
}