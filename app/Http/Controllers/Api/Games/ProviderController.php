<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Retorna os jogos de um provedor específico pelo ID.
     */
    public function getGamesByProvider($id)
    {
        $provider = Provider::with(['games' => function ($query) {
            $query->where('status', 1)
                  ->orderBy('views', 'desc');
        }])->find($id);

        if (!$provider) {
            return response()->json([
                'status' => false,
                'message' => 'Provedor não encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'provider' => $provider
        ]);
    }
}
