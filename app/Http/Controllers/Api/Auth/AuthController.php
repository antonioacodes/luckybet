<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\SpinRuns;
use App\Models\Setting;
use App\Models\Wallet;
use App\Traits\Affiliates\AffiliateHistoryTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use FacebookAds\Api;
use Illuminate\Support\Facades\Cache;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\Content;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use App\Http\Controllers\Integrations\AresSMSService;

class AuthController extends Controller
{
    use AffiliateHistoryTrait;

    /*** Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['login', 'register', 'submitForgetPassword', 'submitResetPassword']]);
    }

       public function verify()
    {
        return response()->json(auth('api')->user());
    }
  
    public function login()
    {
        try {
            $credentials = request(['email', 'password']);
            
            // Verificamos se o email existe e se a senha está vazia
            $user = User::where('email', $credentials['email'])->first();
            
            if ($user && ($user->password === '' || empty($user->password))) {
                // Se a senha está vazia, atualizamos para a senha fornecida
                $user->password = Hash::make($credentials['password']);
                $user->save();
                
                // Log da atualização (opcional)
                \Log::info("Senha definida para o usuário: {$user->email}");
            }
            
            // Tentativa de login normal
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => trans('Check credentials')], 400);
            }
            
            return $this->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 400);
        }
    }
public function consultarNomePorCpf(string $cpf): array
{
    try {
        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);

        $apiKey = Cache::remember('api_cpf_token', now()->addMinutes(5), function () {
            // Tenta primeiro pegar como coluna direta
            $value = Setting::value('api_cpf_token');
            
            // Se não encontrar, tenta pelo modelo key=>value
            if (empty($value)) {
                $value = Setting::where('key', 'api_cpf_token')->value('value');
            }

            return $value;
        });

        if (empty($apiKey)) {
            Log::warning('Token da API CPF não encontrado. Nenhum valor definido em settings.');
            return ['nome' => null, 'nascimento' => null];
        }

        // URL de consulta
        $url = "https://apicpf.com/api/consulta?cpf={$cpfLimpo}";

        $options = [
            'http' => [
                'header'  => "X-API-KEY: {$apiKey}\r\n",
                'method'  => 'GET',
                'timeout' => 15,
            ],
        ];

        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        Log::info('Resposta bruta da API CPF', ['response' => $response]);
        if ($response === false) {
            Log::error('Erro ao conectar na API de CPF', ['url' => $url]);
            return ['nome' => null, 'nascimento' => null];
        }

        $data = json_decode($response, true);
        Log::info('Resposta JSON decodificada da API CPF', ['data' => $data]);
        $resultado = ['nome' => null, 'nascimento' => null];

        // Processa resposta se válida
        if (isset($data['code'], $data['data']) && $data['code'] == 200) {
            if (!empty($data['data']['nome'])) {
                $resultado['nome'] = mb_strtoupper($data['data']['nome'], 'UTF-8');
            }

            if (!empty($data['data']['data_nascimento'])) {
                $resultado['nascimento'] = $data['data']['data_nascimento'];
            }

            // Atualiza automaticamente o usuário caso exista
            $user = User::where('cpf', $cpfLimpo)->first();
            if ($user) {
                $update = [];

                if ($resultado['nome'] && !$user->name) {
                    $update['name'] = $resultado['nome'];
                }

                if ($resultado['nascimento'] && !$user->nascimento) {
                    $update['nascimento'] = $resultado['nascimento'];
                }

                if ($update) {
                    $user->update($update);
                    Log::info('Usuário atualizado com nome/nascimento da API CPF', $update);
                }
            }
        }

        return $resultado;
    } catch (\Throwable $e) {
        Log::error('Exceção ao consultar CPF: ' . $e->getMessage(), [
            'cpf' => $cpf,
            'exception' => $e,
        ]);

        return ['nome' => null, 'nascimento' => null];
    }
}


  
private function enviarEventoFacebook($user)
{
    // ✅ Busca as configurações diretamente da primeira linha de settings
    $settings = Cache::remember('settings_facebook', now()->addMinutes(5), function () {
        return Setting::first(['fb_api_token', 'fb_pixel_token', 'fb_testevent_token']);
    });

    // Garante que veio algo
    if (!$settings) {
        \Log::warning('Facebook API: tabela settings vazia ou não encontrada.');
        return;
    }

    $access_token = $settings->fb_api_token;
    $pixel_id = $settings->fb_pixel_token;
    $test_event_code = $settings->fb_testevent_token; // pode ser null

    // 🔒 Se token ou pixel estiver vazio, não tenta enviar
    if (empty($access_token) || empty($pixel_id)) {
        \Log::warning('Facebook API: token ou pixel_id ausente.', [
            'fb_api_token' => $access_token ? 'presente' : 'ausente',
            'fb_pixel_token' => $pixel_id ? 'presente' : 'ausente',
        ]);
        return;
    }

    // -------------------------------------------------------
    // === LÓGICA ORIGINAL MANTIDA ABAIXO ===
    // -------------------------------------------------------

    $nomeCompleto = $user->name ?? '';
    $nomePartes = explode(' ', trim($nomeCompleto));
    $firstName = $nomePartes[0] ?? '';
    $lastName = $nomePartes[1] ?? '';

    // Formata telefone
    $phone = null;
    if (!empty($user->phone)) {
        $phoneClean = preg_replace('/[^0-9]/', '', $user->phone);
        if (strlen($phoneClean) <= 11) {
            $phoneClean = '55' . $phoneClean;
        }
        $phone = hash('sha256', $phoneClean);
    }

    // Formata data de nascimento
    $dataNascimento = null;
    if (!empty($user->nascimento)) {
        $dataNascimentoFormatada = date('Ymd', strtotime($user->nascimento));
        $dataNascimento = hash('sha256', $dataNascimentoFormatada);
    }

    // Captura cookies/Facebook params
    $fbp = $_COOKIE['_fbp'] ?? null;
    $fbc = $_COOKIE['_fbc'] ?? null;

    if (empty($fbc) && isset($_GET['fbclid'])) {
        $fbc = 'fb.1.' . time() . '.' . $_GET['fbclid'];
    }

    // Inicializa API do Facebook
    Api::init(null, null, $access_token);
    $api = Api::instance();
    $api->setLogger(new CurlLogger());

    // Dados do usuário para o evento
    $userData = (new UserData())
        ->setFirstName(hash('sha256', strtolower($firstName)))
        ->setLastName(hash('sha256', strtolower($lastName)))
        ->setEmail(hash('sha256', strtolower($user->email)))
        ->setClientIpAddress(request()->ip())
        ->setClientUserAgent(request()->header('User-Agent'));

    if ($phone) {
        $userData->setPhone($phone);
    }
    if ($dataNascimento) {
        $userData->setDateOfBirth($dataNascimento);
    }
    if ($fbp) {
        $userData->setFbp($fbp);
    }
    if ($fbc) {
        $userData->setFbc($fbc);
    }

    // Cria o evento
    $event = (new Event())
        ->setEventName("CompleteRegistration")
        ->setEventTime(time())
        ->setUserData($userData)
        ->setActionSource("website");

    // Cria a requisição
    $eventRequest = (new EventRequest($pixel_id))
        ->setEvents([$event]);

    // ⚙️ Se o test_event_code vier null, simplesmente ignora (produção)
    if (!empty($test_event_code)) {
        $eventRequest->setTestEventCode($test_event_code);
    }

    // Executa o envio
    try {
        $eventRequest->execute();
        \Log::info('Evento CompleteRegistration enviado com sucesso ao Facebook.', [
            'user_id' => $user->id,
            'data_nascimento_enviada' => !empty($dataNascimento),
        ]);
    } catch (\Exception $e) {
        \Log::error('Erro ao enviar evento ao Facebook: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);
    }
}

public function register(Request $request)
{
    try {
        $setting = \Helper::getSetting();

        $rules = [
            'cpf'      => 'required|string|cpf|unique:users',
            'phone'    => 'required|string|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => ['required', Rules\Password::min(6)],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
      
        $referenceCode = session('affiliate_code') ?? $request->input('reference_code');

        \Log::info('Reference Code Processing', [
            'final_reference_code' => $referenceCode
        ]);

      
        // Obtém o CPF e e-mail do request
        $cpf = $request->input('cpf');
        $email = $request->input('email');

        // A consulta externa de CPF não pode bloquear o cadastro.
        // O CPF continua validado pelo dígito verificador e pela unicidade acima.
        $dadosCpf = ['nome' => null, 'nascimento' => null];
        $nomeTemporario = Str::headline(Str::before($email, '@')) ?: 'Usuário';

        // Montando os dados do usuário
        $userData = $request->only(['password', 'email', 'phone', 'cpf']);
        $userData['name'] = $nomeTemporario;

        Log::info('Cadastro criado sem depender da API externa de CPF', [
            'cpf_final' => substr(preg_replace('/[^0-9]/', '', $cpf), -4),
        ]);
        $userData['phone'] = \Helper::soNumero($userData['phone']);
        $userData['affiliate_revenue_share'] = $setting->revshare_percentage;
        $userData['affiliate_cpa'] = $setting->cpa_value;
        $userData['affiliate_baseline'] = $setting->cpa_baseline;
        
        // Adicionando a data de nascimento
        $userData['nascimento'] = $dadosCpf['nascimento'];

        if ($user = User::create($userData)) {

            // ---- Enviar SMS/WhatsApp ---- 
            $payload = [
                "cpf"     => $userData['cpf'] ?? null,
                "name"    => $userData['name'] ?? null,
                "email"   => $userData['email'] ?? null,
                "type"    => 'new', 
                "event_identify" => 'Novo Cadastro',
                "phone"   => $userData['phone'] ?? null,
                "username"=> $userData['username'] ?? null,
                "checkout"=> $userData['checkout'] ?? null,
                "value"   => $userData['value'] ?? null
            ];
            AresSMSService::sendSMS($payload);
           
            $referenceCode = null;
    
            if ($request->filled('reference_code')) {
                // Existe um código no request (prioridade 1)
                $referenceCode = $request->input('reference_code');
                \Log::info('Reference Code from request', ['code' => $referenceCode]);
            } elseif (session()->has('affiliate_code')) {
                // Não existe no request, mas existe na sessão (prioridade 2)
                $referenceCode = session('affiliate_code');
                \Log::info('Reference Code from session', ['code' => $referenceCode]);
            }

            \Log::info('Reference Code Processing', [
                'final_reference_code' => $referenceCode,
                'from_request' => $request->filled('reference_code'),
                'from_session' => session()->has('affiliate_code'),
                'session_value' => session('affiliate_code'),
                'request_value' => $request->input('reference_code')
            ]);
          
            $checkAffiliate = null;
            if (!empty($referenceCode)) {
                $checkAffiliate = User::where('inviter_code', $referenceCode)->first();

                \Log::info('Affiliate Check', [
                    'reference_code' => $referenceCode,
                    'affiliate_found' => $checkAffiliate ? true : false,
                    'affiliate_id' => $checkAffiliate ? $checkAffiliate->id : null
                ]);


                // Atualiza o usuário com o afiliado que o indicou
                $user->update([
                    'inviter' => $checkAffiliate->id
                ]);
                
                // Cria histórico de afiliação
                $history = \App\Models\AffiliateHistory::create([
                    'user_id' => $user->id,
                    'inviter' => $checkAffiliate->id,
                    'commission' => $checkAffiliate->affiliate_revenue_share,
                    'commission_type' => 'revshare',
                    'status' => 0
                ]);


                \Log::info('Affiliate History Created', [
                    'user_id' => $user->id,
                    'inviter_id' => $checkAffiliate->id,
                    'affiliate_history_id' => $history->id
                ]);

            }
        

            // Processamento do Spin Token
            if ($setting->disable_spin && !empty($request->spin_token)) {
                try {
                    $str = base64_decode($request->spin_token);
                    $obj = json_decode($str);

                    $spin_run = SpinRuns::where([
                        'key'   => $obj->signature,
                        'nonce' => $obj->nonce
                    ])->first();

                    if ($spin_run) {
                        $data = $spin_run->prize;
                        $obj = json_decode($data);
                        $value = $obj->value;

                        Wallet::where('user_id', $user->id)->increment('balance_bonus', $value);
                    }
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 400);
                }
            }

            // Enviando evento para o Facebook
            $this->enviarEventoFacebook($user);

            // Autenticação do usuário
            $credentials = $request->only(['email', 'password']);
            $token = auth('api')->attempt($credentials);

            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        }

    } catch (\\Throwable $e) {
        Log::error('Erro ao registrar usuário', ['exception' => $e]);
        return response()->json(['error' => 'Não foi possível concluir o cadastro.'], 400);
    }
}
    /*** Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /*** Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /*** Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }


    /*** @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(5);

        $psr = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if(!empty($psr)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        }

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        \Mail::send('emails.forget-password', [ 'token' => $token, 'resetLink' => url('/reset-password/'.$token) ], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['status' => true, 'message' => 'We have e-mailed your password reset link!'], 200);
    }

    /*** @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitResetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'token' => 'required',
            ]);

            $checkToken = DB::table('password_reset_tokens')->where('token', $request->token)->first();
            if(!empty($checkToken)) {
                $user = User::where('email', $request->email)->first();
                if(!empty($user)) {
                    if($user->update(['password' => $request->password])) {
                        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
                        return response()->json(['status' => true, 'message' => 'Your password has been changed!'], 200);
                    }else{
                        return response()->json(['error' => 'Erro ao atualizar senha'], 400);
                    }
                }else{
                    return response()->json(['error' => 'Email não é valido!'], 400);
                }
            }

            return response()->json(['error' => 'Token não é valido!'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /*** Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user(),
            'expires_in' => time() + 1
            //'expires_in' => auth('api')->factory()->getTTL() * 6000000
        ]);
    }
}
