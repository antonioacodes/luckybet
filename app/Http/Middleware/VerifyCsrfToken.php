<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'digitopay/*',
        'slotegrator/*',
        'suitpay/*',
        'vgames/*',
        'webhooks/*',
        'drakon_api',
        'drakon_api/*',
        'salsa/*',
        'fivers/*',
        'bspay/',
        'bspay/*',
        'gold_api',
        'gold_api/*',
        'kagaming/*',
        'vibra/*',
        'cron/*',
        'venix_api',
        'venix_api/*',
        'ever/*',
        'ever',
        'playfiver/*',
        'pgclone',
        'pgclone/*',
        'tbs',
        'tbs/*',
        'voxelgator',
        'voxelgator/*',
        'mercadopago/*',
        'mercadopago'
    ];
}
