<!-- resources/views/modals/age-verification.blade.php -->
<div class="age-verification-modal" id="ageVerificationModal">
    <div class="modal-content">
        <div class="modal-header">
            <a href="/" class="logo">
                <img src="https://luckybet777.com.br/storage/uploads/8Wdza5NkFLBAkLjaPpCDSfEyYz3FXhsshzLRn7ow.png" alt="{{ config('app.name') }}" class="logo-img">
            </a>
        </div>
        <div class="modal-body">
            <!-- Tela inicial de verificação -->
            <div class="verification-screen" id="verificationScreen">
                <div class="modal-title">
                    <span>Você tem mais de 18 anos?</span>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-no" id="btnNo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="1em" height="1em">
                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" fill="currentColor"></path>
                        </svg>
                        Não
                    </button>
                    <button type="button" class="btn-yes" id="btnYes">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em" height="1em">
                            <path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" fill="currentColor"></path>
                        </svg>
                        Sim
                    </button>
                </div>
            </div>

            <!-- Tela de erro -->
            <div class="error-screen" id="errorScreen" style="display: none;">
                <div class="modal-title">
                    <span>Desculpe. Você é muito jovem para consumir esse conteúdo.</span>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-back" id="btnBack">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em" height="1em">
                            <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z" fill="currentColor"></path>
                        </svg>
                        Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
      if (window.self !== window.top) {
        document.getElementById('ageVerificationModal').style.display = 'none';
        return;
    }
  
    const ageVerificationModal = document.getElementById('ageVerificationModal');
    const yesButton = document.getElementById('btnYes');
    const noButton = document.getElementById('btnNo');
    const backButton = document.getElementById('btnBack');
    const verificationScreen = document.getElementById('verificationScreen');
    const errorScreen = document.getElementById('errorScreen');
  
    // Adiciona event listeners aos botões
    yesButton.addEventListener('click', function() {
        handleAgeVerification(1);
    });

    noButton.addEventListener('click', function() {
        // Mostra a tela de erro em vez de fazer a verificação
        showErrorScreen();
    });

    // Botão para voltar ao modal de verificação
    backButton.addEventListener('click', function() {
        showVerificationScreen();
    });

    function showErrorScreen() {
        verificationScreen.style.display = 'none';
        errorScreen.style.display = 'block';
    }

    function showVerificationScreen() {
        errorScreen.style.display = 'none';
        verificationScreen.style.display = 'block';
    }

    function handleAgeVerification(verified) {
        // Captura o código de afiliação da URL
        const urlParams = new URLSearchParams(window.location.search);
        const affiliateCode = urlParams.get('code');
        
        // Mostra no console para debug
        console.log('Código de afiliação capturado:', affiliateCode);
        
        fetch('{{ route("age.verification") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                age_verified: verified,
                code: affiliateCode
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resposta:', data);
            if (data.status === 'success') {
                // Esconde o modal
                document.getElementById('ageVerificationModal').style.display = 'none';
                // Se houver código de afiliação, redireciona
                if (data.code) {
                    window.location.href = `/register?code=${data.code}`;
                }
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    }
});
</script>

<style>
    .age-verification-modal {
        position: fixed;
        backdrop-filter: blur(15px);
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: var(--ci-gray-over);
        border-radius: 10px;
        width: 90%;
        max-width: 480px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    .modal-header {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #333;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-img {
        max-width: 170px;
        height: auto;
    }

    .modal-body {
        background-color: var(--ci-gray-medium);
        padding: 30px 20px;
    }

    .modal-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .modal-title span {
        font-size: 1.5rem;
        font-weight: 600;
        color: #ffffff;
    }

    .modal-buttons {
        display: flex;
        padding-left: auto;
        padding-right: auto;
        justify-content: center;
        gap: 15px;
    }

    .btn-no, .btn-yes, .btn-back {
        width: 160px;
        padding: 12px;
        height: 2.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-no, .btn-back {
        background-color: var(--ci-gray-over);
        border-style: solid;
        border-radius: 5px;
        color: var(--title-text);
    }

    .btn-yes {
        background-color: var(--ci-primary-color);
        border-style: solid;
        border-color: var(--ci-primary-color);
        border-radius: 5px;
        color: var(--ci-gray-over);
    }

    .error-screen .modal-buttons {
        justify-content: center;
    }

    .error-screen .modal-title span {
        font-size: 1.5rem;
        line-height: 1.4;
    }

    @media (max-width: 480px) {
        .modal-title span {
            font-size: 20px;
        }
        
        .error-screen .modal-title span {
            font-size: 18px;
        }
        
        .modal-buttons {
            flex-direction: column;
            align-items: center;
        }
      	.btn-no, .btn-yes {
          width: 230px;
      	}
    }
</style>
