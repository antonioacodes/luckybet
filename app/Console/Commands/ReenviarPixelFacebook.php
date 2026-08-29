<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Deposit;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use FacebookAds\Object\ServerSide\CustomData;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReenviarPixelFacebook extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'facebook:reenviar-pixel 
                            {dias=30 : Buscar transações dos últimos X dias}
                            {--inicio_id= : ID da transação para começar (retomar de onde parou)}
                            {--limite=20 : Limite de transações por execução (recomendado: 15-25)}
                            {--delay_min=10 : Delay mínimo entre envios em segundos}
                            {--delay_max=18 : Delay máximo entre envios em segundos}
                            {--teste : Usar modo de teste}';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Reenvia eventos de compra históricos para o Facebook para aquecer o novo pixel';

    /**
     * Execute o comando.
     *
     * @return int
     */
    public function handle()
    {
        $dias = $this->argument('dias');
        $inicio_id = $this->option('inicio_id');
        $limite = $this->option('limite');
        $delay_min = $this->option('delay_min');
        $delay_max = $this->option('delay_max');
        $modoTeste = $this->option('teste');
        
        // Configurar novo pixel e token
        $pixel_id = env('NOVO_FB_PIXEL_ID');
        $access_token = env('NOVO_FB_API_TOKEN');
        $test_event_code = env('FB_TEST_EVENT_CODE');
        
        if (empty($access_token) || empty($pixel_id)) {
            $this->error('NOVO_FB_PIXEL_ID ou NOVO_FB_API_TOKEN não estão configurados no .env');
            return 1;
        }
        
        $this->info("Iniciando reenvio de eventos para o pixel {$pixel_id}");
        $this->info("Delay entre envios: {$delay_min}-{$delay_max} segundos (randomizado)");
        $this->info("Limite de {$limite} transações por execução");
        
        if ($inicio_id) {
            $this->info("Retomando a partir da transação ID: {$inicio_id}");
        }
        
        if ($modoTeste && $test_event_code) {
            $this->info("Executando em modo de teste com código: {$test_event_code}");
        }
        
        // Inicializar a API do Facebook
        Api::init(null, null, $access_token);
        $api = Api::instance();
        $api->setLogger(new CurlLogger());
        
        // Buscar transações completadas
        $dataLimite = Carbon::now()->subDays($dias);
        
        $query = Transaction::where('status', 1) // Transações com status de sucesso
            ->where('updated_at', '>=', $dataLimite);
            
        // Se foi especificado um ID de início, começa a partir dele
        if ($inicio_id) {
            $query->where('id', '>=', $inicio_id);
        }
            
        // Aplicar limite
        $query->limit($limite);
            
        $transacoes = $query->orderBy('id', 'asc')->get();
        
        $totalTransacoes = $transacoes->count();
        $this->info("Total de transações encontradas: {$totalTransacoes}");
        
        if ($totalTransacoes == 0) {
            $this->info("Nenhuma transação encontrada para processar.");
            return 0;
        }
        
        $this->output->progressStart($totalTransacoes);
        
        $sucessos = 0;
        $falhas = 0;
        $ultimaTransacaoId = null;
        
        foreach ($transacoes as $index => $transacao) {
            $ultimaTransacaoId = $transacao->id;
            
            // Buscar depósito correspondente
            $deposito = Deposit::where('payment_id', $transacao->payment_id)
                               ->where('status', 1)
                               ->first();
                               
            if (!$deposito) {
                $this->warn("\nDepósito não encontrado para transação ID {$transacao->id}, payment_id {$transacao->payment_id}");
                $falhas++;
                $this->output->progressAdvance();
                continue;
            }
            
            // Buscar usuário
            $usuario = User::find($transacao->user_id);
            
            if (!$usuario) {
                $this->warn("\nUsuário ID {$transacao->user_id} não encontrado para transação ID {$transacao->id}");
                $falhas++;
                $this->output->progressAdvance();
                continue;
            }
            
            try {
                // Calcular um delay aleatório entre o mínimo e máximo para parecer mais natural
                $delay = rand($delay_min, $delay_max);
                
                // Registrar nas métricas que estamos enviando
                $this->info("\nProcessando transação #{$transacao->id} (ID: {$transacao->payment_id}) - Valor: {$deposito->amount}");
                $this->info("Aguardando {$delay} segundos antes do envio...");
                
                // Pausa antes do envio (para parecer tráfego mais natural)
                sleep($delay);
                
                // Enviar evento para o Facebook
                $resultado = $this->enviarEventoCompra(
                    $usuario, 
                    $deposito, 
                    $transacao, 
                    $pixel_id, 
                    $modoTeste ? $test_event_code : null
                );
                
                if ($resultado) {
                    $sucessos++;
                    $this->info("✅ Evento enviado com sucesso para transação #{$transacao->id}");
                } else {
                    $falhas++;
                    $this->error("❌ Falha ao enviar evento para transação #{$transacao->id}");
                }
                
                $this->output->progressAdvance();
                
            } catch (\Exception $e) {
                $this->error("\nErro ao processar transação #{$transacao->id}: " . $e->getMessage());
                Log::error("Erro ao processar transação", [
                    'transaction_id' => $transacao->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $falhas++;
                $this->output->progressAdvance();
            }
        }
        
        $this->output->progressFinish();
        
        $this->info("\nReenvio concluído: {$sucessos} sucessos, {$falhas} falhas");
        $this->info("Última transação processada: #{$ultimaTransacaoId}");
        $this->info("Para continuar de onde parou, use: php artisan facebook:reenviar-pixel {$dias} --inicio_id=" . ($ultimaTransacaoId + 1) . " --delay_min={$delay_min} --delay_max={$delay_max} --limite={$limite}");
        
        return 0;
    }
    
    /**
     * Envia um evento de compra para o Facebook
     */
    private function enviarEventoCompra($usuario, $deposito, $transacao, $pixel_id, $test_event_code = null)
    {
        try {
            // Separando o nome em primeiro e último nome
            $nomeCompleto = $usuario->name;
            $nomePartes = explode(" ", $nomeCompleto);
            $firstName = $nomePartes[0];
            $lastName = isset($nomePartes[1]) ? $nomePartes[1] : '';
            
            // Formatação do telefone
            $phone = null;
            if (!empty($usuario->phone)) {
                $phoneClean = preg_replace('/[^0-9]/', '', $usuario->phone);
                if (strlen($phoneClean) <= 11) {
                    $phoneClean = '55' . $phoneClean;
                }
                $phone = hash('sha256', $phoneClean);
            }
            
            // Obter valores de tracking do Facebook se existirem
            $fbp = null;
            $fbc = null;
            
            // Verificar se a transação tem as propriedades fb_fbp e fb_fbc
            if (property_exists($transacao, 'fb_fbp') || isset($transacao->fb_fbp)) {
                $fbp = $transacao->fb_fbp;
            }
            
            if (property_exists($transacao, 'fb_fbc') || isset($transacao->fb_fbc)) {
                $fbc = $transacao->fb_fbc;
            }
            
            // Se não existirem na transação, tente obter do usuário
            if (empty($fbp) && (property_exists($usuario, 'fb_fbp') || isset($usuario->fb_fbp))) {
                $fbp = $usuario->fb_fbp;
            }
            
            if (empty($fbc) && (property_exists($usuario, 'fb_fbc') || isset($usuario->fb_fbc))) {
                $fbc = $usuario->fb_fbc;
            }
            
            // Gerar ID único para o evento - adicionando mais entropia
            $eventId = 'reenvio_' . $transacao->payment_id . '_' . time() . '_' . rand(1000, 9999);
            
            // Usar o timestamp original da transação, com pequeno offset para variar
            $eventTime = strtotime($transacao->updated_at) + rand(0, 300); // Até 5 minutos de variação
            
            // Definir dados do usuário
            $userData = (new UserData())
                ->setFirstName(hash('sha256', strtolower($firstName)))
                ->setLastName(hash('sha256', strtolower($lastName)))
                ->setEmail(hash('sha256', strtolower($usuario->email)))
                ->setExternalId(hash('sha256', (string)$usuario->id));
                
            // Adicionar telefone se disponível
            if ($phone) {
                $userData->setPhone($phone);
            }
            
            // Adicionar FBP e FBC se disponíveis
            if (!empty($fbp)) {
                $userData->setFbp($fbp);
            }
            
            if (!empty($fbc)) {
                $userData->setFbc($fbc);
            }
            
            // Definir dados personalizados do evento
            $customData = (new CustomData())
                ->setValue($deposito->amount)
                ->setCurrency('BRL')
                ->setContentIds([$transacao->payment_id])
                ->setContentType('product');
            
            // Criar o evento
            $event = (new Event())
                ->setEventName('Purchase')
                ->setEventTime($eventTime)
                ->setEventId($eventId)
                ->setEventSourceUrl(env('APP_URL') . '/deposito')
                ->setUserData($userData)
                ->setCustomData($customData)
                ->setActionSource("website");
            
            // Criar a requisição de evento
            $eventRequest = (new EventRequest($pixel_id))
                ->setEvents([$event]);
            
            // Adicionar código de teste se estiver em modo de teste
            if ($test_event_code) {
                $eventRequest->setTestEventCode($test_event_code);
            }
            
            // Executar a requisição
            $resultado = $eventRequest->execute();
            
            // Verificar e analisar a resposta
            if (isset($resultado['data']) && isset($resultado['data'][0]['events_received'])) {
                $eventsReceived = $resultado['data'][0]['events_received'];
                if ($eventsReceived > 0) {
                    // Log detalhado
                    Log::info("Evento Purchase reenviado com sucesso", [
                        'pixel_id' => $pixel_id,
                        'transaction_id' => $transacao->id,
                        'payment_id' => $transacao->payment_id,
                        'user_id' => $usuario->id,
                        'amount' => $deposito->amount,
                        'event_id' => $eventId,
                        'event_time' => date('Y-m-d H:i:s', $eventTime),
                        'mode' => $test_event_code ? 'teste' : 'produção',
                        'events_received' => $eventsReceived
                    ]);
                    return true;
                } else {
                    Log::warning("Evento enviado mas não recebido pelo Facebook", [
                        'transaction_id' => $transacao->id,
                        'resultado' => $resultado
                    ]);
                    return false;
                }
            } else {
                Log::warning("Resposta do Facebook em formato inesperado", [
                    'transaction_id' => $transacao->id,
                    'resultado' => $resultado
                ]);
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error("Erro ao enviar evento Purchase", [
                'transaction_id' => $transacao->id,
                'user_id' => $usuario->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
}