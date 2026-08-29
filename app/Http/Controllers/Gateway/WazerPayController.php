<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Traits\Gateways\WazerPayTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Deposit;
use App\Helpers\Core as Helper;
use App\Models\User;

class WazerPayController extends Controller
{
    use WazerPayTrait;

    public function getQRCodePix(Request $request)
    {
        return self::requestQrcodeWazerPay($request);
    }

    public function consultStatusTransactionPix(Request $request)
    {
        return self::consultStatusTransactionWazer($request);
    }

    /**
     * Webhook WazerPay: tratar charge.paid e afins
     */
    public function webhook(Request $request)
    {
        Log::info('WazerPay - Webhook recebido', [
            'payload' => $request->all(),
        ]);

        $event = $request->input('event'); // ex: charge.paid
        $data  = $request->input('data');

        if ($event === 'charge.paid' || $event === 'payment.approved') {
            $metadata   = $data['metadata'] ?? [];
            $internalId = $metadata['internal_id'] ?? null; // payment_id que salvamos

            if (!$internalId) {
                Log::error('WazerPay - Webhook sem internal_id em metadata', ['data' => $data]);
                return response()->json(['message' => 'internal_id ausente'], 400);
            }

            $transaction = Transaction::where('payment_id', $internalId)
                ->where('status', 0)
                ->first();

            $deposit = Deposit::where('payment_id', $internalId)
                ->where('status', 0)
                ->first();

            if (!$transaction || !$deposit) {
                Log::warning('WazerPay - Transação ou Depósito não encontrados/pagos', [
                    'internal_id' => $internalId,
                ]);
                return response()->json(['message' => 'Transação não encontrada ou já processada'], 200);
            }

            // Usa a MESMA lógica de BsPay para finalizar
            $result = \App\Traits\Gateways\BsPayTrait::finalizePayment($internalId);

            if ($result) {
                Log::info('WazerPay - Pagamento finalizado com sucesso via finalizePayment', [
                    'internal_id' => $internalId,
                ]);
                return response()->json(['message' => 'OK'], 200);
            }

            Log::error('WazerPay - Erro ao finalizar pagamento', [
                'internal_id' => $internalId,
            ]);
            return response()->json(['message' => 'Erro ao finalizar pagamento'], 500);
        }

        // Outros eventos você pode simplesmente ignorar/logar
        Log::info('WazerPay - Evento ignorado', ['event' => $event]);
        return response()->json(['message' => 'Ignored'], 200);
    }
}
