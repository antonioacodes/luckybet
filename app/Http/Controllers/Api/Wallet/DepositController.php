<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Traits\Gateways\DigitoPayTrait;
use App\Traits\Gateways\MercadoPagoTrait;
use App\Traits\Gateways\SharkPayTrait;
use App\Traits\Gateways\SuitpayTrait;
use App\Traits\Gateways\BsPayTrait;
use App\Traits\Gateways\WazerPayTrait;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    use BsPayTrait, WazerPayTrait;

    /**
     * @param Request $request
     * @return array|false[]
     */
    public function hasRecentDeposit(Request $request)
    {
        $hasRecent = Deposit::where('user_id', auth()->id())
            ->where('status', 1)
            ->where('created_at', '>=', now()->subDays(7))
            ->exists();

        return response()->json(['hasRecentDeposit' => $hasRecent]);
    }

  
  	public function submitPayment(Request $request)
    {
        \Log::info($request->gateway);
        switch ($request->gateway) {
            case 'digitopay':
                return self::digitoPayRequestQrcode($request);
            case 'mercadopago':
                return self::requestQrcodeMercadoPago($request);
            case 'sharkpay':
                return self::requestQrcodeSharkPay($request);
            case 'suitpay':
                return self::requestQrcode($request);
            case 'bspay':
                return BsPayTrait::requestQrcode($request);
            case 'wazerpay':
                return self::requestQrcodeWazerPay($request);
            }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function consultStatusTransactionPix(Request $request)
    {
        return self::consultStatusTransaction($request);
    }

    /**
     * Display a listing of the resource.
     */
    public function firstDepositStatus()
    {
        $hasCompletedDeposit = Deposit::where('user_id', auth('api')->id())
            ->where('status', Deposit::STATUS_COMPLETED)
            ->exists();

        return response()->json(['hasCompletedDeposit' => $hasCompletedDeposit]);
    }

    public function index()
    {
        $deposits = Deposit::select('amount', 'created_at', 'currency', 'id', 'status', 'symbol', 'type', 'updated_at', 'user_id')
                        ->whereUserId(auth('api')->id())
                        ->paginate();
        return response()->json(['deposits' => $deposits], 200);
    }

}
