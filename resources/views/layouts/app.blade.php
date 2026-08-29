<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        @php $setting = \Helper::getSetting() @endphp
        @if(!empty($setting['software_favicon']))
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/storage/' . $setting['software_favicon']) }}">
        @endif
		<link rel="apple-touch-icon" href="https://luckybet777.com.br/storage/uploads/p8r32rEB2Lmnkc3BTjpZ6eYOQkP2nAAVRDVAQT3E.png">

          <!-- OpenGraph Tags -->
        <meta property="og:title" content="@yield('og_title', 'LuckyBet | A Sorte Gira Com Você! 🍀🎰')" />
        <meta property="og:description" content="@yield('og_description', 'A melhor plataforma de apostas e jogos online. Registre-se e comece a ganhar!')" />
        <meta property="og:image" content="@yield('og_image', 'https://luckybet777.com.br/storage/uploads/p8r32rEB2Lmnkc3BTjpZ6eYOQkP2nAAVRDVAQT3E.png')" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="LuckyBet" />

        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="@yield('og_title', 'LuckyBet | A Sorte Gira Com Você! 🍀🎰')" />
        <meta name="twitter:description" content="@yield('og_description', 'A melhor plataforma de apostas e jogos online. Registre-se e comece a ganhar!')" />
        <meta name="twitter:image" content="@yield('og_image', 'https://luckybet777.com.br/storage/uploads/p8r32rEB2Lmnkc3BTjpZ6eYOQkP2nAAVRDVAQT3E.png')" />

        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100&display=swap" rel="stylesheet">        
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s){
                if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)
            }(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '{{ $pixelId }}');
            fbq('track', 'PageView');
        </script>

        <noscript>
            <img height="1" width="1" style="display:none" 
            src="https://www.facebook.com/tr?id={{ env('FB_API_PIXEL') }}&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->

        <title>{{ env('APP_NAME') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php $custom = \Helper::getCustom() @endphp
        <style>
            body{
                /* font-family: "'Roboto', sans-serif"; */
                font-family: "Montserrat", sans-serif;
            }
            :root {
                --ci-primary-color: {{ $custom['primary_color'] }};
                --ci-primary-opacity-color: {{ $custom['primary_opacity_color'] }};
                --ci-secundary-color: {{ $custom['secundary_color'] }};
                --ci-gray-dark: {{ $custom['gray_dark_color'] }};
                --ci-gray-light: {{ $custom['gray_light_color'] }};
                --ci-gray-medium: {{ $custom['gray_medium_color'] }};
                --ci-gray-over: {{ $custom['gray_over_color'] }};
                --title-color: {{ $custom['title_color'] }};
                --text-color: {{ $custom['text_color'] }};
                --sub-text-color: {{ $custom['sub_text_color'] }};
                --placeholder-color: {{ $custom['placeholder_color'] }};
                --background-color: {{ $custom['background_color'] }};
                --standard-color: #1C1E22;
                --shadow-color: #111415;
                --page-shadow: linear-gradient(to right, #111415, rgba(17, 20, 21, 0));
                --autofill-color: #f5f6f7;
                --yellow-color: #FFBF39;
                --yellow-dark-color: #d7a026;
                --border-radius: {{ $custom['border_radius'] }};
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-scroll-snap-strictness: proximity;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgba(59,130,246,.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;

                --input-primary: {{ $custom['input_primary'] }};
                --input-primary-dark: {{ $custom['input_primary_dark'] }};

                --carousel-banners: {{ $custom['carousel_banners'] }};
                --carousel-banners-dark: {{ $custom['carousel_banners_dark'] }};


                --sidebar-color: {{ $custom['sidebar_color'] }} !important;
              	--sidebar-color-gradient: {{ $custom['sidebar_color_gradient'] }} !important;
                --sidebar-color-dark: {{ $custom['sidebar_color_dark'] }} !important;
              	--sidebar-color-gradient-dark: {{ $custom['sidebar_color_gradient_dark'] }} !important;


                --navtop-color {{ $custom['navtop_color'] }};
                --navtop-color-dark: {{ $custom['navtop_color_dark'] }};


                --side-menu {{ $custom['side_menu'] }};
                --side-menu-dark: {{ $custom['side_menu_dark'] }};

              	--topbar-color1: {{ $custom['topbar_color1'] }};
                --topbar-color2: {{ $custom['topbar_color2'] }};
                --topbar-color3: {{ $custom['topbar_color3'] }};
              
                --footer-color {{ $custom['footer_color'] }};
              	--footer-color-gradient {{ $custom['footer_color_gradient'] }};
                --footer-color-dark: {{ $custom['footer_color_dark'] }};
              	--footer-color-dark-gradient: {{ $custom['footer_color_dark_gradient'] }};

                --card-color {{ $custom['card_color'] }};
                --card-color-dark: {{ $custom['card_color_dark'] }};
            }
            .navtop-color{
                background-color: {{ $custom['sidebar_color'] }} !important;
            }
            :is(.dark .navtop-color) {
                background-color: {{ $custom['sidebar_color_dark'] }} !important;
            }

            .bg-base {
                background-color: {{ $custom['background_base'] }};
            }
            :is(.dark .bg-base) {
                background-color: {{ $custom['background_base_dark'] }};
            }
            /* Oculta a scrollbar em navegadores WebKit */
            ::-webkit-scrollbar {
              display: none !important;
            }
            
            /* Para garantir que o conteúdo ainda seja rolável */
            html, body {
              scrollbar-width: none !important; /* Firefox */
              -ms-overflow-style: none !important; /* Internet Explorer e Edge */
            }
        </style>

        @if(!empty($custom['custom_css']))
            <style>
                {!! $custom['custom_css'] !!}
            </style>
        @endif

        @if(!empty($custom['custom_header']))
            {!! $custom['custom_header'] !!}
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body color-theme="dark" class="bg-base text-gray-800 dark:text-gray-300 ">
      @if (session('show_age_verification', true))
          @include('modals.age-verification')
      @endif
      

        <div id="viperpro"></div>
<!-- Start of Async ProveSource Code --><script>!function(o,i){window.provesrc&&window.console&&console.error&&console.error("ProveSource is included twice in this page."),provesrc=window.provesrc={dq:[],display:function(){this.dq.push(arguments)}},o._provesrcAsyncInit=function(){provesrc.init({apiKey:"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2NvdW50SWQiOiI2NjUxNjY0MWY4MzhhYzZhM2QwNjlmZDciLCJpYXQiOjE3MTY2MTA2MjV9.3XDOc8DolShHnxE4yXWrFHgpAVAMx4Z3P4QgaXxH6WY",v:"0.0.4"})};var r=i.createElement("script");r.type="text/javascript",r.async=!0,r["ch"+"ar"+"set"]="UTF-8",r.src="https://cdn.provesrc.com/provesrc.js";var e=i.getElementsByTagName("script")[0];e.parentNode.insertBefore(r,e)}(window,document);</script><!-- End of Async ProveSource Code -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/datepicker.min.js"></script>
        <script>
            window.Livewire?.on('copiado', (texto) => {
                navigator.clipboard.writeText(texto).then(() => {
                    Livewire.emit('copiado');
                });
            });

            window._token = '{{ csrf_token() }}';
            //if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.remove('dark')
                document.documentElement.classList.add('light');
            } else {
                document.documentElement.classList.remove('light')
                document.documentElement.classList.add('dark')
            }
        </script>

        @if(!empty($custom['custom_js']))
            <script>
                {!! $custom['custom_js'] !!}
            </script>
        @endif

        @if(!empty($custom['custom_body']))
            {!! $custom['custom_body'] !!}
        @endif

        @if(!empty($custom))
            <script>
                const custom = {!! json_encode($custom)  !!};
            </script>
        @endif
      
   <!-- Scripts no final do body -->
    <script src="/js/facebook-events.js"></script>
    
    <script>
        // Passar TODOS os dados do usuário para o JavaScript (se logado)
        @auth
        window.userSession = {
            id: {{ auth()->user()->id }},
            email: '{{ auth()->user()->email }}',
            firstName: '{{ auth()->user()->name }}',
            lastName: '{{ auth()->user()->last_name ?? "" }}',
            phone: '{{ auth()->user()->phone ?? "" }}',

            // CAMPOS ESPECÍFICOS DA SUA TABELA:
            cpf: '{{ auth()->user()->cpf ?? "" }}',
            dateOfBirth: '{{ auth()->user()->nascimento ? date("Ymd", strtotime(auth()->user()->nascimento)) : "" }}', // Formato YYYYMMDD
            city: '{{ auth()->user()->municipio ?? "" }}',
            state: '{{ auth()->user()->uf ?? "" }}',
            country: 'BR' // Brasil sempre
        };
        @endauth

        // Para usuários não logados, criar objeto vazio
        @guest
        window.userSession = {};
        @endguest

        // Inicializar eventos do Facebook quando DOM estiver pronto
        document.addEventListener('DOMContentLoaded', function() {
            const PIXEL_ID = '{{ env("FB_API_PIXEL") }}';
            window.fbEvents = new FacebookEvents(PIXEL_ID);

            // Rastrear página específica
            const currentPage = window.location.pathname;
            if (currentPage.includes('/deposit') || currentPage.includes('/deposito')) {
                window.fbEvents.trackViewContent('deposit_page', 'deposit');
            }
        });
    </script>
      
      <!-- Script Facebook acima -->
		
      
<!-- Script Proteção anti-cópia corrigido para mobile -->
<script>
    //SCRIPT DE PROTEÇÃO ANTI-CÓPIA//
    // 🔧 CONFIGURAÇÃO FÁCIL - MUDE AQUI:
    // true = PROTEÇÃO ATIVADA | false = PROTEÇÃO DESATIVADA
    const ENABLE_SITE_PROTECTION = false;

    if (ENABLE_SITE_PROTECTION) {
        console.log('🔒 Proteção do site ativada');

        // Detectar se é dispositivo móvel
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || 
                        ('ontouchstart' in window) || 
                        (window.innerWidth <= 768);

        // 1. Bloquear botão direito (só em desktop)
        document.addEventListener('contextmenu', e => {
            e.preventDefault();
            if (!isMobile) {
                showProtectionAlert('Botão direito desabilitado');
            }
        });

        // 2. Bloquear teclas importantes (só em desktop)
        document.addEventListener('keydown', e => {
            // Só aplica proteção de teclado em desktop
            if (!isMobile) {
                // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
                if (e.key === 'F12' || 
                    (e.ctrlKey && e.shiftKey && ['I', 'J'].includes(e.key)) ||
                    (e.ctrlKey && ['u', 's', 'a', 'p'].includes(e.key))) {
                    e.preventDefault();
                    showProtectionAlert('Ação bloqueada por segurança');
                }
            }
        });

        // 3. Bloquear seleção de texto
        document.addEventListener('selectstart', e => e.preventDefault());
        document.addEventListener('dragstart', e => e.preventDefault());

        // 4. Detectar DevTools (APENAS EM DESKTOP)
        if (!isMobile) {
            let devtools = {open: false, orientation: null};
            const threshold = 160;

            setInterval(() => {
                // Só verifica DevTools em desktop e se a janela for grande o suficiente
                if (window.innerWidth > 800 && window.innerHeight > 600) {
                    if (window.outerHeight - window.innerHeight > threshold || 
                        window.outerWidth - window.innerWidth > threshold) {
                        if (!devtools.open) {
                            devtools.open = true;
                            document.body.innerHTML = `
                                <div style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:linear-gradient(135deg,#FF6B6B,#FF8E53);display:flex;flex-direction:column;align-items:center;justify-content:center;color:#fff;font-family:Arial,sans-serif;z-index:999999">
                                    <h1 style="font-size:3rem;margin-bottom:20px">🚫 Acesso Bloqueado</h1>
                                    <p style="font-size:1.2rem;text-align:center">Ferramentas de desenvolvedor não são permitidas</p>
                                    <button onclick="location.reload()" style="margin-top:20px;padding:10px 20px;background:#fff;color:#333;border:none;border-radius:5px;cursor:pointer;font-size:1rem">Recarregar Página</button>
                                </div>
                            `;
                        }
                    }
                }
            }, 1000); // Aumentei o intervalo para ser menos agressivo
        }

        // 5. Limpar console (só em desktop para não afetar performance mobile)
        if (!isMobile) {
            setInterval(() => {
                console.clear();
                console.log('%c🔒 SITE PROTEGIDO', 'color:#FF6B6B;font-size:2rem;font-weight:bold');
            }, 3000); // Menos frequente para melhor performance
        }

        // Função para mostrar alertas de proteção
        function showProtectionAlert(message) {
            const alert = document.createElement('div');
            alert.style.cssText = `
                position:fixed;top:20px;right:20px;background:#FF6B6B;color:#fff;
                padding:12px 16px;border-radius:8px;font-weight:600;z-index:999999;
                box-shadow:0 4px 15px rgba(255,107,107,0.4);
                animation:slideInRight 0.3s ease;
                font-size:${isMobile ? '14px' : '16px'};
                max-width:${isMobile ? '280px' : '320px'};
            `;
            alert.textContent = `🔒 ${message}`;

            // Adiciona animação
            if (!document.getElementById('protection-styles')) {
                const style = document.createElement('style');
                style.id = 'protection-styles';
                style.textContent = `
                    @keyframes slideInRight{from{transform:translateX(100%)}to{transform:translateX(0)}}
                `;
                document.head.appendChild(style);
            }

            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 2500);
        }

        // Log específico para mobile
        if (isMobile) {
            console.log('📱 Proteção otimizada para mobile ativada');
        } else {
            console.log('💻 Proteção completa para desktop ativada');
        }

    } else {
        console.log('🔓 Proteção do site desativada');
    }
</script>

<style>
    /* Desabilita seleção quando proteção está ativa */
    body {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
    }

    /* Inputs e elementos necessários ainda podem ser selecionados */
    input, textarea, [contenteditable], button {
        -webkit-user-select: text;
        -moz-user-select: text;
        -ms-user-select: text;
        user-select: text;
    }

    /* Permitir toque em elementos interativos no mobile */
    @media (max-width: 768px) {
        button, a, input, textarea, select {
            -webkit-touch-callout: default;
        }
    }
</style>

<script>
    // Configuração adicional baseada no status da proteção
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ENABLE_SITE_PROTECTION !== 'undefined' && !ENABLE_SITE_PROTECTION) {
            // Se proteção estiver desativada, permite seleção normal
            document.body.style.userSelect = 'text';
            document.body.style.webkitUserSelect = 'text';
            document.body.style.webkitTouchCallout = 'default';
        }
    });
</script>
    </body>
</html>
