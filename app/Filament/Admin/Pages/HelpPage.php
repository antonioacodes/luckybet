<?php

namespace App\Filament\Admin\Pages;

use App\Models\Gateway;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\Report;

class HelpPage extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
	protected static ?string $title = 'Precisa de Ajuda?';
    protected static string $view = 'filament.pages.help-page';

    public ?array $data = [];
    public Gateway $setting;

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        $gateway = Gateway::first();
        if(!empty($gateway)) {
            $this->setting = $gateway;
            $this->form->fill($this->setting->toArray());
        }else{
            $this->form->fill();
        }
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Como Configurar e Personalizar minha Plataforma?')
                              ->description(new HtmlString('
                    <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                        • No menu lateral, entre na seção Configurações e preencha os campos básicos, como nome da marca, e demais opções de funcionamento. Essas definições são o ponto de partida para a identidade visual da sua solução.
<br><br>• Ainda no menu lateral, acesse Integrações. Aqui você deve inserir os tokens e chaves de acesso das APIs que a plataforma utiliza (gateway de pagamento, provedora de jogos, serviços de analytics, Facebook, etc.). Cada campo vem com instruções resumidas para facilitar o preenchimento.
<br><br>• Depois de salvar as configurações e as integrações, vá para a área Customização. Nessa tela é possível alterar banners, escolher paletas de cores, e modificar pequenos trechos de CSS/HTML que definem a aparência das páginas. Todas as alterações são aplicadas em tempo real, permitindo que você teste o visual antes de publicar.
<br><br>• Utilize o acesso a plataforma para conferir como a plataforma ficará em dispositivos desktop e mobile. Quando estiver satisfeito, siga para os próximos passos.
                    </div>
                ')),
                Section::make('Quero fazer uma personalização específica(integração/customização)')
                              ->description(new HtmlString('
                    <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                        • Esta plataforma foi entregue como white‑label e contém apenas o código necessário para operação padrão. Não há módulos ou bibliotecas expostos para que desenvolvedores externos adicionem funcionalidades sem intervenção da equipe de desenvolvimento oficial.
<br><br>• Caso precise de alguma integração adicional (por exemplo, novo provedor de pagamento, recurso de gamificação ou alteração de fluxo) ou deseje customizar partes avançadas da interface, entre em contato com o suporte técnico da plataforma. Eles analisarão a demanda, estimarão o esforço e, se aprovado, desenvolverão a solução de forma segura e compatível.
<br><br>• Alterar arquivos do core da aplicação por conta própria pode:
<br>
<br>Quebrar dependências internas, tornando a plataforma instável ou inoperante;
<br>Violiar os termos de uso, expondo‑o a sanções contratuais;
<br>Criar vulnerabilidades de segurança que podem ser exploradas por terceiros.
<br><br>Por esses motivos, quaisquer mudanças de código devem ser realizadas exclusivamente pela equipe de desenvolvimento oficial.
                    <br><br></div>
                                        <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                    Para relatar bugs, solicitar novas funcionalidades ou receber orientações de implementação, utilize apenas os canais oficiais.
                        <br><br></div>
                        <div style="color:#94a3b8; font-size: .875rem; line-height: 1.25rem; display: flex; align-items: center;">
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #5865f2;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://discord.gg/3RHH7eE62B" 
                           target="_blank">
                            Discord
                        </a>
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #58a8f2;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://telegram.com" 
                           target="_blank">
                            Telegram
                        </a>
                        <a class="dark:text-white" 
                           style="
                                font-size: 14px;
                                font-weight: 600;
                                width: 90px;
                                display: flex;
                                background-color: #00fd8f;
                                padding: 10px;
                                border-radius: 11px;
                                justify-content: center;
                                margin-left: 10px;
                           " 
                           href="https://igamingsolutionsbr.com" 
                           target="_blank">
                            Web
                        </a>
                        </div>
                ')),
              Section::make('O que eu preciso para iniciar a operação da minha plataforma? (Brasil)')
                              ->description(new HtmlString('
<div style="color:#94a3b8; font-size:.875rem; line-height:1.25rem; display:flex; align-items:center;">
    <div>
        <strong>Aviso importante – Uso da plataforma</strong><br><br>

        • <strong>Uso fora do Brasil:</strong> Esta plataforma foi desenvolvida para ser utilizada apenas em jurisdições onde a prática de jogos de azar e apostas online é legalmente permitida. O acesso por residentes no Brasil é de inteira responsabilidade do usuário.<br><br>

        • <strong>Idade mínima:</strong> É necessário ter, no mínimo, 18 (dezoito) anos completos para se cadastrar e utilizar os serviços. Ao criar a conta, você declara que atende a esse requisito.<br><br>

        • <strong>Moeda e métodos de pagamento:</strong> Todas as transações devem ser processadas por gateways internacionais e realizadas exclusivamente em moedas estrangeiras (USD, EUR, etc.). <br><br>

        • <strong>Comissão da plataforma:</strong> A desenvolvedora iGaming Solutions recebe uma comissão de <em>10 %</em> sobre cada recarga efetuada na carteira virtual da nossa provedora de jogos. Essa comissão é cobrada automaticamente e não configura operação de jogo por parte da plataforma.<br><br>

        • <strong>Política de anti‑lavagem de dinheiro (AML):</strong> Transações suspeitas ou de altos valores em USD/EUR podem exigir a apresentação de documentos de identificação (RG/CPF, passaporte, comprovante de residência). O não cumprimento pode resultar no bloqueio da conta.<br><br>

        • <strong>Obrigações fiscais:</strong> Cada usuário é responsável por declarar e pagar eventuais tributos sobre ganhos obtidos, de acordo com a legislação de seu país de residência. A plataforma não retém impostos nem fornece relatórios de renda.<br><br>

        • <strong>Responsabilidade do usuário:</strong> Você declara que:
            <ul style="margin:0; padding-left:1.2rem;">
                <li>Não está residindo no Brasil ou, se estiver, verifica que a legislação local permite a prática de jogos de azar.</li>
                <li>Não utilizará a plataforma para fins ilícitos, como lavagem de dinheiro ou financiamento ao terrorismo.</li>
                <li>Assume integralmente quaisquer consequências legais ou financeiras decorrentes do uso da plataforma.</li>
            </ul>
        <br>

        • <strong>Privacidade e proteção de dados:</strong> Seus dados são armazenados em servidores fora do Brasil e protegidos segundo padrões internacionais (GDPR, ISO 27001). Consulte nossa <a href="/privacy" style="color:#2563eb; text-decoration:underline;">Política de Privacidade</a> para mais detalhes.<br><br>

        • <strong>Geoblocking:</strong> Acesso a partir de endereços IP localizados no território brasileiro é bloqueado automaticamente. Caso identifiquemos tentativas de contorno, a conta será suspensa.<br><br>

        • <strong>Contato:</strong> Em caso de dúvidas sobre a legalidade do uso em sua região, entre em contato pelo e‑mail <a href="mailto:suporte@igamingsolutionsbr.com" style="color:#2563eb; text-decoration:underline;">suporte@igamingsolutionsbr.com</a>.<br><br>

		<strong>Compromisso com os saques</strong><br><br>

        • <strong>Processamento rápido:</strong> Todos os pedidos de saque devem ser analisados e aprovados em até <em>48 horas úteis</em> após a solicitação, desde que cumpram as políticas de verificação de identidade.<br><br>

        • <strong>Transparência:</strong> O usuário deve ser informado pelo próprio operador da plataforma em caso de saque cancelado/rejeitado.<br><br>

        • <strong>Política de retenção:</strong> Por lei, saques só podem ser retidos por motivos claros e documentados (ex.: suspeita de fraude, verificação de identidade incompleta, limites de valor diário). Nesses casos, o usuário será informado imediatamente sobre o motivo e o prazo estimado para resolução.<br><br>

        • <strong>Proibição de práticas abusivas:</strong> É terminantemente proibido ao operador:
            <ul style="margin:0; padding-left:1.2rem;">
                <li>Retornar fundos de forma arbitrária;</li>
                <li>Alterar ou negar saques sem justificativa legal;</li>
                <li>Manter valores de usuários retidos por períodos superiores ao que é descrito nas leis de jogos de azar.</li>
            </ul>
        Qualquer infração será considerada violação grave dos termos de uso e poderá resultar em suspensão da conta do operador e em responsabilização civil e criminal.<br><br>


        <em>Ao continuar, você confirma que leu, compreendeu e aceita todas as condições acima.</em>
    </div>
</div>

                '))
            ])
          	
          ;
    }


    /**
     * @return void
     */

}
