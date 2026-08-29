<?php

namespace App\Http\Controllers\Api\Games\Original;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Games\MinesService;
use Illuminate\Support\Facades\Auth;

class MinesController extends Controller
{
    protected $service;

    public function __construct(MinesService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.4',
            'mines' => 'required|integer|min:1|max:24'
        ]);

        try {
            $user = Auth::guard('api')->user();
            $game = $this->service->createGame($user, $request->amount, $request->mines);
            return response()->json($game);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function reveal(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'tile' => 'required|integer|min:0|max:24'
        ]);

        try {
            $user = Auth::guard('api')->user();
            $result = $this->service->playRound($user, $request->order_id, $request->tile);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cashout(Request $request)
    {
        $request->validate(['order_id' => 'required']);

        try {
            $user = Auth::guard('api')->user();
            $result = $this->service->cashout($user, $request->order_id);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
