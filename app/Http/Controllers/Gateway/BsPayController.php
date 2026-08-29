<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Models\FacebookEvent; // Novo modelo para armazenar eventos pendentes
use App\Traits\Affiliates\AffiliateHistoryTrait;
use App\Traits\Gateways\BsPayTrait;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use FacebookAds\Object\ServerSide\CustomData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BsPayController extends Controller
{
    use BsPayTrait, AffiliateHistoryTrait;

    /**
     * Captura os valores de tracking do Facebook e armazena na sessão
     * 
     * Deve ser chamado o mais cedo possível na jornada do usuário
     */
    public function captureTrackingParams(Request $request)
    {
        // Capturar FBCLID da URL
        if ($request->has('fbclid')) {
            $fbclid = $request->input('fbclid');
            session(['fbclid' => $fbclid]);
            
            // Converter para FBC e armazenar
            $fbc = 'fb.1.' . time() . '.' . $fbclid;
            session(['fb_fbc' => $fbc]);
            
            // Log para diagnóstico
            Log::info('FBCLID capturado da URL', [
                'fbclid' => $fbclid,
                'fb_fbc' => $fbc
            ]);
        }
        
        // Capturar FBP do cookie
        if (isset($_COOKIE['_fbp'])) {
            session(['fb_fbp' => $_COOKIE['_fbp']]);
            
            Log::info('FBP capturado do cookie', [
                'fb_fbp' => $_COOKIE['_fbp']
            ]);
        }
        
        // Este método pode ser chamado via middleware ou rota específica
        return response()->json(['success' => true]);
    }

    /**
     * Captura os valores de tracking do Facebook de forma segura
     * Versão melhorada que prioriza valores persistidos
     */
    private function capturarValoresTracking(User $user = null)
    {
        // Inicializa valores
        $fbp = null;
        $fbc = null;

        // Prioridade 1: Valores armazenados no usuário (se disponível)
        if ($user && $user->fb_fbp) {
            $fbp = $user->fb_fbp;
        }
        
        if ($user && $user->fb_fbc) {
            $fbc = $user->fb_fbc;
        }
        
        // Prioridade 2: Valores na sessão
        if (empty($fbp)) {
            $fbp = session('fb_fbp');
        }

        if (empty($fbc)) {
            $fbc = session('fb_fbc');
        }
        
        // Prioridade 3: Cookies do navegador
        if (empty($fbp) && isset($_COOKIE['_fbp'])) {
            $fbp = $_COOKIE['_fbp'];
        }

        if (empty($fbc) && isset($_COOKIE['_fbc'])) {
            $fbc = $_COOKIE['_fbc'];
        }
        
        // Prioridade 4: Gerar FBC a partir do fbclid da sessão
        $fbclid = session('fbclid');
        if ($fbclid && empty($fbc)) {
            $fbc = 'fb.1.' . time() . '.' . $fbclid;
        }
        
        // Prioridade 5: Gerar FBC a partir do fbclid da URL (último recurso)
        $fbclid = request()->input('fbclid');
        if ($fbclid && empty($fbc)) {
            $fbc = 'fb.1.' . time() . '.' . $fbclid;
        }

        // Não gerar valores sintéticos para FBP a menos que seja absolutamente necessário
        // Valores sintéticos podem prejudicar a atribuição
        
        // Log detalhado para diagnóstico
        Log::info('Valores de tracking capturados', [
            'user_id' => $user ? $user->id : 'não autenticado',
            'fbp' => $fbp,
            'fbc' => $fbc,
            'fbclid' => $fbclid,
            'session_fbp' => session('fb_fbp'),
            'session_fbc' => session('fb_fbc'),
            'session_fbclid' => session('fbclid')
        ]);

        return [
            'fbp' => $fbp,
            'fbc' => $fbc
        ];
    }

    /**
     * Método para salvar parâmetros de tracking no usuário
     * Deve ser chamado no login, registro e início de sessão de pagamento
     */
    public function saveTrackingParams(User $user)
    {
        $tracking = $this->capturarValoresTracking();
        
        // Atualiza o usuário apenas se os valores existirem
        $updateData = [];
        
        if (!empty($tracking['fbp'])) {
            $updateData['fb_fbp'] = $tracking['fbp'];
        }
        
        if (!empty($tracking['fbc'])) {
            $updateData['fb_fbc'] = $tracking['fbc'];
        }
        
        if (!empty($updateData)) {
            $user->update($updateData);
            
            Log::info('Parâmetros de tracking salvos no usuário', [
                'user_id' => $user->id,
                'fbp' => $tracking['fbp'] ?? null,
                'fbc' => $tracking['fbc'] ?? null
            ]);
        }
        
        return $tracking;
    }

public function getQRCodePix(Request $request)
{
    // Captura valores de tracking
    $tracking = $this->capturarValoresTracking();

    // Adiciona os valores ao request
    $request->merge([
        'fb_fbp' => $tracking['fbp'], 
        'fb_fbc' => $tracking['fbc']
    ]);

    // Se o usuário estiver autenticado, salva os parâmetros nele
    if (auth()->check()) {
        $this->saveTrackingParams(auth()->user());
    }

    // ✅ CHAMA O MÉTODO ORIGINAL E PEGA A RESPOSTA
    $response = self::requestQrcode($request);

    // ✅ DECODIFICA A RESPOSTA PARA ADICIONAR OS EVENT IDs
    $responseData = $response->getData(true);

    // ✅ GERAR OS EVENT IDs ÚNICOS
    if (isset($responseData['idTransaction'])) {
        $transactionId = $responseData['idTransaction'];
        $responseData['addtocartEventId'] = "addtocart_" . $transactionId;
        $responseData['purchaseEventId'] = "purchase_" . $transactionId;

        Log::info('Event IDs gerados para o frontend', [
            'transaction_id' => $transactionId,
            'addtocartEventId' => $responseData['addtocartEventId'],
            'purchaseEventId' => $responseData['purchaseEventId']
        ]);
    }

    // ✅ RETORNA A RESPOSTA COM OS EVENT IDs
    return response()->json($responseData);
}


public function callbackMethod(Request $request)
{
    $request = $request->all();

    if (isset($request['requestBody']['external_id']) && $request['requestBody']['transactionType'] == 'RECEIVEPIX') {
        $transaction = Transaction::where('payment_id', $request['requestBody']['external_id'])->where('status', 0)->first();
        $deposit = Deposit::where('payment_id', $request['requestBody']['external_id'])->where('status', 0)->first();

        if (!empty($transaction) && !empty($deposit)) {
            $wallet = Wallet::where('user_id', $transaction->user_id)->first();
          
            // Chama o método finalizePayment que já incrementa o saldo
            $finalizeResult = self::finalizePayment($request['requestBody']['external_id']);

            \Log::info('Resultado Finalização Pagamento', [
                'finalize_result' => $finalizeResult,
                'external_id' => $request['requestBody']['external_id']
            ]);

            // Não incrementamos o saldo aqui, pois o finalizePayment já faz isso
            // Removemos os incrementos de saldo que estavam causando a triplicação

            $user = User::find($transaction->user_id);
            self::saveAffiliateHistory($user);
            
            // O FinishTransaction também pode estar causando duplicação de valores
            // Vamos comentar esta linha também
            // self::FinishTransaction($transaction->price, $user->id);

            // Recupera valores de tracking diretamente do usuário
            $tracking = [
                'fbp' => $user->fb_fbp,
                'fbc' => $user->fb_fbc
            ];

            // Atualiza a transação com os valores de tracking apenas se ainda não tiver
            if (empty($transaction->fb_fbp) || empty($transaction->fb_fbc)) {
                $transaction->update([
                    'fb_fbp' => $tracking['fbp'],
                    'fb_fbc' => $tracking['fbc']
                ]);
            }

            // Enviar dados para o Facebook
            self::enviarFacebookPixel($user, $deposit->amount, $transaction, 'Purchase');
            
            // Log detalhado da transação completa
            Log::info('Transação completada com sucesso', [
                'transaction_id' => $transaction->id,
                'payment_id' => $transaction->payment_id,
                'user_id' => $user->id,
                'amount' => $deposit->amount,
                'tracking' => $tracking
            ]);
        }
    }
}
public function enviarFacebookPixel($user, $amount, $transaction = null, $eventName = 'Purchase')
{
    try {
        $setting = Setting::first();

        if (! $setting || empty($setting->fb_api_token) || empty($setting->fb_pixel_token)) {
            Log::error('FB_API_TOKEN ou FB_API_PIXEL não configurados na tabela settings');
            return;
        }

        $access_token = $setting->fb_api_token;
        $pixel_id     = $setting->fb_pixel_token;
        $testEventCode = $setting?->fb_testevent_token;

        Api::init(null, null, $access_token);
        $api = Api::instance();
        $api->setLogger(new CurlLogger());

        // Separando o nome em primeiro e último nome
        $nomeCompleto = $user->name;
        $nomePartes = explode(" ", $nomeCompleto);
        $firstName = $nomePartes[0];
        $lastName = isset($nomePartes[1]) ? $nomePartes[1] : '';

        // Formatação do telefone
        $phone = null;
        if (!empty($user->phone)) {
            $phoneClean = preg_replace('/[^0-9]/', '', $user->phone);
            if (strlen($phoneClean) <= 11) {
                $phoneClean = '55' . $phoneClean;
            }
            $phone = hash('sha256', $phoneClean);
        }

        // Capturar valores de tracking
        $fbp = $transaction && $transaction->fb_fbp ? $transaction->fb_fbp : $user->fb_fbp;
        $fbc = $transaction && $transaction->fb_fbc ? $transaction->fb_fbc : $user->fb_fbc;

        // ✅ GERAR EVENT ID ÚNICO
        $eventId = null;
        if ($transaction) {
            $eventId = strtolower($eventName) . "_" . $transaction->payment_id;
        }

        Log::info('Valores de tracking para envio ao Facebook', [
            'event' => $eventName,
            'user_id' => $user->id,
            'fbp' => $fbp,
            'fbc' => $fbc,
            'transaction_id' => $transaction ? $transaction->id : 'N/A',
            'eventId' => $eventId // ✅ ADICIONAR NO LOG
        ]);

        // Definindo os dados do usuário
        $userData = (new UserData())
            ->setFirstName(hash('sha256', strtolower($firstName)))
            ->setLastName(hash('sha256', strtolower($lastName)))
            ->setEmail(hash('sha256', strtolower($user->email)))
            ->setExternalId(hash('sha256', (string)$user->id))
            ->setClientIpAddress(request()->ip())
            ->setClientUserAgent(request()->header('User-Agent'));

        if ($phone) {
            $userData->setPhone($phone);
        }

        if ($fbp) {
            $userData->setFbp($fbp);
        }

        if ($fbc) {
            $userData->setFbc($fbc);
        }

        $customData = (new CustomData())
            ->setValue($amount)
            ->setCurrency('BRL');

        if ($transaction) {
            $customData->setContentIds([$transaction->payment_id])
                      ->setContentType('product');
        }

        // Criando o evento
        $event = (new Event())
            ->setEventName($eventName)
            ->setEventTime(time())
            ->setEventSourceUrl(env('APP_URL') . '/deposito')
            ->setUserData($userData)
            ->setCustomData($customData)
            ->setActionSource("website");

        // ✅ ADICIONAR EVENT ID
        if ($eventId) {
            $event->setEventId($eventId);
        }

        // Criando a requisição de evento
        $eventRequest = (new EventRequest($pixel_id))
            ->setEvents([$event]);

        if (! empty($testEventCode)) {
            $eventRequest->setTestEventCode($testEventCode);
        }

        try {
            $resultado = $eventRequest->execute();

            Log::info("Evento {$eventName} enviado com sucesso para o Facebook", [
                'pixel_id' => $pixel_id,
                'user_id' => $user->id,
                'amount' => $amount,
                'eventId' => $eventId, // ✅ LOG DO EVENT ID
                'resultado' => $resultado
            ]);

            return $resultado;
        } catch (\Exception $e) {
            // ✅ CORRIGIR A REFERÊNCIA DO EVENT ID
            $this->armazenarEventoFalho($eventName, $user->id, $amount, $transaction ? $transaction->id : null, [
                'fbp' => $fbp,
                'fbc' => $fbc,
                'event_id' => $eventId, // ✅ USAR A VARIÁVEL CORRETA
                'erro' => $e->getMessage()
            ]);

            Log::error('Erro ao enviar evento para o Facebook: ' . $e->getMessage(), [
                'event' => $eventName,
                'user_id' => $user->id,
                'transaction_id' => $transaction ? $transaction->id : 'N/A',
                'eventId' => $eventId, // ✅ LOG DO EVENT ID
                'error_details' => $e->getTraceAsString()
            ]);

            return false;
        }
    } catch (\Exception $e) {
        Log::error("Erro ao preparar evento {$eventName}: " . $e->getMessage(), [
            'user_id' => $user->id,
            'trace' => $e->getTraceAsString()
        ]);
        return false;
    }
}

    
    /**
     * Armazena eventos que falharam para retry posterior
     */
    private function armazenarEventoFalho($eventName, $userId, $amount, $transactionId = null, $extraData = [])
    {
        try {
            // Crie um modelo FacebookEvent para armazenar eventos pendentes
            // Você precisará criar esta tabela no banco de dados
            FacebookEvent::create([
                'event_name' => $eventName,
                'user_id' => $userId,
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'payload' => json_encode($extraData),
                'attempts' => 0,
                'status' => 'pending'
            ]);
            
            Log::info('Evento falho armazenado para retry posterior', [
                'event' => $eventName,
                'user_id' => $userId,
                'transaction_id' => $transactionId
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao armazenar evento falho: ' . $e->getMessage());
        }
    }
    
    /**
     * Método para reenviar eventos que falharam
     * Este método pode ser chamado por um cron job a cada hora
     */
    public function retryFailedEvents()
    {
        $pendingEvents = FacebookEvent::where('status', 'pending')
            ->where('attempts', '<', 5)
            ->orderBy('created_at', 'asc')
            ->limit(50)
            ->get();
            
        foreach ($pendingEvents as $event) {
            try {
                $user = User::find($event->user_id);
                $transaction = $event->transaction_id ? Transaction::find($event->transaction_id) : null;
                
                if ($user) {
                    $resultado = $this->enviarFacebookPixel(
                        $user,
                        $event->amount,
                        $transaction,
                        $event->event_name
                    );
                    
                    if ($resultado) {
                        $event->update([
                            'status' => 'completed',
                            'completed_at' => now()
                        ]);
                        
                        Log::info('Evento pendente enviado com sucesso', [
                            'event_id' => $event->id,
                            'user_id' => $user->id
                        ]);
                    } else {
                        $event->increment('attempts');
                        $event->update([
                            'last_attempt' => now()
                        ]);
                    }
                } else {
                    // Usuário não encontrado, marcar como falha
                    $event->update([
                        'status' => 'failed',
                        'error' => 'Usuário não encontrado'
                    ]);
                }
            } catch (\Exception $e) {
                $event->increment('attempts');
                $event->update([
                    'last_attempt' => now(),
                    'error' => $e->getMessage()
                ]);
                
                Log::error('Erro ao tentar reenviar evento: ' . $e->getMessage(), [
                    'event_id' => $event->id
                ]);
            }
        }
        
        return 'Eventos processados: ' . $pendingEvents->count();
    }

    public function consultStatusTransactionPix(Request $request)
    {
        return self::consultStatusTransaction($request);
    }

    public function withdrawalFromModal($id)
    {
        $withdrawal = Withdrawal::find($id);
        if (! $withdrawal) {
            Notification::make()
                ->title('Erro')
                ->danger()
                ->body('Saque não encontrado.')
                ->send();
            return back();
        }

        $result = BsPayTrait::sendPixPayment($withdrawal);

        if (is_array($result) && $result['status'] === true) {
            $withdrawal->update([
                'status'         => 1,
                'transaction_id'=> $result['transactionId'],
                'proof'          => $result['external_id'],
            ]);

            Notification::make()
                ->title('Saque solicitado')
                ->success()
                ->body('Saque processado com sucesso via Pixup.')
                ->send();
        } else {
            Notification::make()
                ->title('Erro no saque')
                ->danger()
                ->body('Falha ao processar o pagamento via Pixup.')
                ->send();
        }

        return back();
    }
    
    /**
     * Cancel Withdrawal
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelWithdrawalFromModal($id, $action='user')
    {
        if($action == 'user') {
            return $this->cancelWithdrawalUser($id);
        }

        if($action == 'affiliate') {
            return $this->cancelWithdrawalAffiliate($id);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    private function cancelWithdrawalAffiliate($id)
    {
        $withdrawal = AffiliateWithdraw::find($id);
        if(!empty($withdrawal)) {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)
                ->where('currency', $withdrawal->currency)
                ->first();

            if(!empty($wallet)) {
                $wallet->increment('refer_rewards', $withdrawal->amount);

                $withdrawal->update(['status' => 2]);
                Notification::make()
                    ->title('Saque cancelado')
                    ->body('Saque cancelado com sucesso')
                    ->success()
                    ->send();

                return back();
            }
            return back();
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    private function cancelWithdrawalUser($id)
    {
        $withdrawal = Withdrawal::find($id);
        if(!empty($withdrawal)) {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)
                ->where('currency', $withdrawal->currency)
                ->first();

            if(!empty($wallet)) {
                $wallet->increment('balance_withdrawal', $withdrawal->amount);

                $withdrawal->update(['status' => 2]);
                Notification::make()
                    ->title('Saque cancelado')
                    ->body('Saque cancelado com sucesso')
                    ->success()
                    ->send();

                return back();
            }
            return back();
        }
        return back();
    }
}