<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Serviço temporariamente indisponível</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font Awesome para ícones --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #1d253b 0, #020617 55%, #000 100%);
            color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 1.5rem;
            margin: 0;
        }

        .card {
            max-width: 520px;
            width: 100%;
            background: rgba(15, 23, 42, 0.9);
            border-radius: 1rem;
            padding: 2.25rem 2rem 2rem;
            box-shadow:
                0 25px 50px -12px rgba(15, 23, 42, 0.95),
                0 0 0 1px rgba(148, 163, 184, 0.12);
            position: relative;
            overflow: hidden;
        }

        /* brilho sutil de fundo */
        .card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.12), transparent 55%),
                radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.1), transparent 55%);
            opacity: 0.9;
            z-index: -1;
        }

        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(59, 246, 137, 0.25), transparent 70%);
            margin-bottom: 1.25rem;
            position: relative;
        }

        .icon-wrapper::after {
            content: "";
            position: absolute;
            inset: 4px;
            border-radius: inherit;
            border: 1px solid rgba(148, 163, 184, 0.35);
        }

        .icon-wrapper i {
            font-size: 1.75rem;
            color: #00FF5A;
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 1.6rem;
            margin: 0 0 .75rem;
            letter-spacing: 0.02em;
        }

        .subtitle {
            font-size: .98rem;
            color: #cbd5f5;
            margin-top: 0.15rem;
            line-height: 1.5;
        }

        .details {
            font-size: .85rem;
            color: #9ca3af;
            margin-top: 1.2rem;
            line-height: 1.6;
        }

        .support {
            margin-top: 1.4rem;
            font-size: .9rem;
            color: #e5e7eb;
        }

        .support a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 500;
        }

        .support a:hover {
            text-decoration: underline;
        }

        /* Loader animado */
        .loader {
            margin: 1.6rem auto 0;
            width: 60px;
            height: 6px;
            border-radius: 999px;
            background: rgba(148,163,184,0.25);
            overflow: hidden;
            position: relative;
        }

        .loader::before {
            content: "";
            position: absolute;
            inset: 0;
            width: 40%;
            border-radius: inherit;
            background: linear-gradient(to right, #38bdf8, #22c55e);
            animation: loading 1.4s ease-in-out infinite;
        }

        @keyframes loading {
            0% {
                transform: translateX(-100%);
            }
            50% {
                transform: translateX(60%);
            }
            100% {
                transform: translateX(140%);
            }
        }

        .hint {
            margin-top: 1rem;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .2em;
            color: #6b7280;
        }

        @media (max-width: 480px) {
            .card {
                padding: 1.75rem 1.5rem 1.5rem;
            }

            h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrapper">
            <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
        </div>

        <h1>Estamos fazendo alguns ajustes</h1>

        <p class="subtitle">
            O sistema está passando por uma manutenção rápida para continuar funcionando com segurança e estabilidade.
        </p>

        <p class="details">
            No momento, esta área não está disponível, mas nossa equipe já está cuidando de tudo.
            Tente novamente em alguns instantes.
        </p>

        <div class="loader" aria-hidden="true"></div>
        <div class="hint">Aguardando liberação do sistema</div>

        <p class="support">
            Precisa de ajuda agora? Entre em contato com o suporte oficial do LuckyBet para mais informações.
        </p>
    </div>
</body>
</html>