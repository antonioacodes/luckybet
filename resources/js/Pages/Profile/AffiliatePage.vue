<template>
    <BaseLayout>
       <LoadingComponent :isLoading="isLoading">
        <div class="text-center">
          <span>Carregando afiliados...</span>
        </div>
      </LoadingComponent>
        <div class="affiliate-container">
            <div v-if="wallet && !isLoading" class="main-content">
                <!-- Hero Section -->
              <br>
                <div class="affiliate-hero">
                    <div class="hero-content">
                        <div class="affiliate-icon">
                            <span class="icon-emoji">💸</span>
                        </div>
                        <h1 class="hero-title">Programa de Afiliados</h1>
                        <p class="hero-subtitle">Ganhe muito dinheiro! <br> Receba {{ userData.affiliate_revenue_share_fake ? userData.affiliate_revenue_share_fake : userData.affiliate_revenue_share }}% de todos os depósitos</p>
                    </div>
                    
                    <!-- Earnings Status Card -->
                    <div class="earnings-status-card">
                        <div class="earnings-info">
                            <div class="earnings-amount">
                                <span class="amount-label">Saldo Disponível</span>
                                <span class="amount-value">{{ state.currencyFormat(parseFloat(wallet.refer_rewards), wallet.currency) }}</span>
                            </div>
                            <div class="earnings-stats">
                                <div class="stat-item">
                                    <span class="stat-number">{{ indications }}</span>
                                    <span class="stat-label">Indicações</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ userData.affiliate_revenue_share_fake ? userData.affiliate_revenue_share_fake : userData.affiliate_revenue_share }}%</span>
                                    <span class="stat-label">Comissão</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Affiliate Form Section -->
                <div v-if="isShowForm" class="affiliate-form-section">
                    <!-- Logo Banner -->
                    <div v-if="setting" class="logo-banner">
                        <img :src="`/storage/`+setting.software_logo_black2" alt="Logo" class="banner-logo" />
                    </div>

                    <!-- Sharing Section -->
                    <div class="sharing-section">
                        <div class="section-header">
                            <h2>🔗 Compartilhe e Ganhe</h2>
                            <p>Use seus links personalizados para convidar amigos</p>
                        </div>

                        <div class="share-cards">
                            <!-- Link Card -->
                            <div class="share-card">
                                <div class="share-card-header">
                                    <div class="share-icon">🌐</div>
                                    <div class="share-info">
                                        <h3>Seu Link de Convite</h3>
                                        <p>Compartilhe este link com seus amigos</p>
                                    </div>
                                </div>
                                <div class="share-input-group">
                                    <input 
                                        id="referenceLink"
                                        type="text"
                                        class="share-input"
                                        v-model="referencelink"
                                        readonly
                                    />
                                    <button 
                                        @click.prevent="copyLink" 
                                        class="copy-button"
                                    >
                                        <i class="fa-duotone fa-copy"></i>
                                        Copiar Link
                                    </button>
                                </div>
                            </div>

                            <!-- Code Card -->
                            <div class="share-card">
                                <div class="share-card-header">
                                    <div class="share-icon">🎯</div>
                                    <div class="share-info">
                                        <h3>Código de Referência</h3>
                                        <p>Código único para identificar suas indicações</p>
                                    </div>
                                </div>
                                <div class="share-input-group">
                                    <input 
                                        id="referenceCode"
                                        type="text"
                                        class="share-input"
                                        v-model="referencecode"
                                        readonly
                                    />
                                    <button 
                                        @click.prevent="copyCode" 
                                        class="copy-button"
                                    >
                                        <i class="fa-duotone fa-copy"></i>
                                        Copiar Código
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="statistics-section">
                        <div class="section-header">
                            <h2>📊 Suas Estatísticas</h2>
                            <p>Acompanhe seu desempenho em tempo real</p>
                        </div>

                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">💰</div>
                                <div class="stat-content">
                                    <div class="stat-title">CPA (R$)</div>
                                    <div class="stat-value">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}</div>
                                    <div class="stat-description">Custo por aquisição</div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">📈</div>
                                <div class="stat-content">
                                    <div class="stat-title">RevShare (%)</div>
                                    <div class="stat-value">{{ userData.affiliate_revenue_share_fake ? userData.affiliate_revenue_share_fake : userData.affiliate_revenue_share }}%</div>
                                    <div class="stat-description">Percentual de comissão</div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">👥</div>
                                <div class="stat-content">
                                    <div class="stat-title">Indicações</div>
                                    <div class="stat-value">{{ indications }}</div>
                                    <div class="stat-description">Pessoas que você indicou</div>
                                </div>
                            </div>

                            <div class="stat-card balance-card">
                                <div class="stat-icon">💎</div>
                                <div class="stat-content">
                                    <div class="stat-title">Saldo Disponível</div>
                                    <div class="stat-value balance-value">{{ state.currencyFormat(parseFloat(wallet.refer_rewards), wallet.currency) }}</div>
                                    <div class="stat-description">Pronto para saque</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawal Section -->
                    <div class="withdrawal-section">
                        <button 
                            @click.prevent="opemModalWithdrawal" 
                            class="withdrawal-button"
                        >
                            Solicitar Saque
                        </button>
                                                <a href="/affiliate/login" ><button 
                            class="affiliatepanel-button ring-1 ring-[#fffbb777] ml-2 mr-2 mt-2 hover:ring-0"
                        >
                            Painel
                        </button></a>
                    </div>
                </div>

                <!-- Get Started Section -->
                <div v-else class="get-started-section">
                    <div v-if="!isLoadingGenerate" class="get-started-content">
                        <div class="get-started-icon">🚀</div>
                        <h2>Torne-se um Afiliado</h2>
                        <p>Se torne agora mesmo um Afiliado da casa e lucre até R$20.000 por dia apenas indicando pessoas, acompanhe seus ganhos em tempo real!</p>
                        
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <span class="benefit-icon">✅</span>
                                <span>Comissões até 80%</span>
                            </div>
                            <div class="benefit-item">
                                <span class="benefit-icon">✅</span>
                                <span>Acompanhamento em tempo real</span>
                            </div>
                            <div class="benefit-item">
                                <span class="benefit-icon">✅</span>
                                <span>Painel de Controle exclusivo</span>
                            </div>
                            <div class="benefit-item">
                                <span class="benefit-icon">✅</span>
                                <span>Saques rápidos e seguros</span>
                            </div>
                        </div>

                        <button 
                            @click.prevent="generateCode" 
                            class="become-affiliate-button"
                        >
                            Tornar-me um Afiliado
                        </button>
                    </div>

                    <div v-if="isLoadingGenerate" class="loading-state">
                        <div class="loading-spinner">
                            <i class="fa-duotone fa-spinner-third fa-spin"></i>
                        </div>
                        <span class="loading-text">Gerando seu código...</span>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-else class="page-loading">
                <div class="loading-content">
                    <i class="fa-duotone fa-spinner-third fa-spin"></i>
                    <span class="loading-text">{{ $t('Loading') }}...</span>
                </div>
            </div>
        </div>

        <!-- Modais mantidos iguais ao original -->
        <!-- MODAL RECOMPENSAS DE REFERÊNCIA -->
        <div id="referenceRewardsEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <div class="flex justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>{{ $t('Referral Reward Rules') }}</h1>
                        <button class="" @click.prevent="toggleReferenceRewards">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="w-full flex justify-center p-4">
                        <div class="flex items-center">
                            <div class="l"></div>
                            <div class="text-white px-3">Regras de Desbloqueio</div>
                            <div class="r"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL RECOMPENSAS POR COMISSÃO -->
        <div id="commissionRewardsEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <div class="flex justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>Regras de recompensas por comissão</h1>
                        <button class="" @click.prevent="toggleCommissionRewards">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="flex flex-col w-full justify-center p-4">
                        <div class="flex items-center text-center w-full justify-center">
                            <div class="l"></div>
                            <div class="text-white px-3">Taxas de comissões</div>
                            <div class="r"></div>
                        </div>
                        <div class="mt-5">
                            <ul>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-1 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">7%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> Os Jogos Originais</p>
                                    </div>
                                </li>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-2 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">7%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> slots de terceiros, cassino ao vivo</p>
                                    </div>
                                </li>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-3 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">25%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> Esportes</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-5 ml-4">
                            <ul class="list-outside list-disc">
                                <li class="mb-3">Em qualquer ambiente público (por exemplo, universidades, escolas, bibliotecas e espaços de escritório), apenas uma comissão pode ser paga para cada usuário, endereço IP, dispositivo eletrônico, residência, número de telefone, método de cobrança, endereço de e-mail e computador e IP endereço compartilhado com outras pessoas.</li>
                                <li class="mb-3">Nossa decisão de fazer uma aposta será baseada inteiramente em nosso critério depois que um depósito for feito e uma aposta for feita com sucesso.</li>
                                <li class="mb-3">As comissões podem ser retiradas em nossa carteira CREDK interna do painel a qualquer momento. (Veja a extração de sua comissão no painel e visualize o saldo na carteira).</li>
                                <li class="mb-3">Apoiamos a maioria das moedas no mercado.</li>
                                <li class="mb-3">O sistema calcula a comissão a cada 24 horas.</li>
                            </ul>
                        </div>
                        <div class="mt-5 w-full border dark:border-gray-500 p-4 rounded">
                            Se você tiver alguma dúvida sobre nossas regras, por favor <a href="" class="text-green-500 font-bold"> Contate-nos </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL SAQUE -->
        <div id="withdrawalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <div class="flex justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>Solicitação de Saque</h1>
                        <button class="" @click.prevent="opemModalWithdrawal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="flex flex-col w-full justify-center p-4">
                        <form action="" @submit.prevent="makeWithdrawal">
                            <div class="dark:text-gray-400 mb-3">
                                <label for="">Valor do Saque</label>
                                <input v-model="withdrawalForm.amount" type="number" class="input" placeholder="Valor do saque" required>
                                <span v-if="wallet" class="text-sm italic">Saldo: {{ state.currencyFormat(parseFloat(wallet?.refer_rewards), wallet?.currency) }}</span>
                            </div>
                            <div class="dark:text-gray-400 mb-3">
                                <label for="">Chave Pix</label>
                                <input v-model="withdrawalForm.pix_key" v-maska data-maska="['###.###.###-##', '##.###.###/####-##']" type="text" class="input" placeholder="Digite a sua Chave pix" required>
                            </div>
                            <div class="dark:text-gray-400 mb-3">
                                <label for="">Tipo de Chave</label>
                                <select v-model="withdrawalForm.pix_type" name="type_document" class="input" required>
                                    <option value="">Selecione uma chave</option>
                                    <option value="document">CPF/CNPJ</option>
                                </select>
                            </div>
                            <button type="submit" class="mt-5 w-full bg-green-800 text-white hover:bg-green-600 px-4 py-2 transition duration-700">
                                Solicitar agora <i class="fa-regular fa-arrow-right ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { Modal } from 'flowbite';
import LoadingComponent from '@/Components/UI/LoadingComponent.vue';
import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import {useSettingStore} from "@/Stores/SettingStore.js";
import {useRouter} from "vue-router";

export default {
    props: [],
    components: { BaseLayout, Modal, LoadingComponent },
    data() {
        return {
            isLoading: true,
            referenceRewards: null,
            commissionRewards: null,
            isShowForm: false,
            isLoadingGenerate: false,
            code: '',
            urlCode: '',
            setting: null,
            referencecode: '',
            referencelink: '',
            wallet: null,
            indications: 0,
            histories: null,
            withdrawalModal: null,
            withdrawalForm: {
                amount: 0,
                pix_key: '',
                pix_type: '',
            }
        }
    },
    setup(props) {
        const router = useRouter();
        // ATENÇÃO: O erro "ReferenceError: isCasinoPlayPage is not defined"
        // está sendo reportado na função setup. No código que você me forneceu,
        // não há uso de 'isCasinoPlayPage' aqui.
        // Por favor, Lucas, verifique seu código fonte original (não o compilado)
        // para encontrar onde essa variável está sendo usada dentro ou em relação à função setup
        // e certifique-se de que ela está corretamente definida ou importada.
        // Este erro é crítico e pode estar causando o comportamento inesperado de isLoadingGenerate.
        return {
            router
        };
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        }
    },
    mounted() {
        window.scrollTo(0, 0);
        this.referenceRewards = new Modal(document.getElementById('referenceRewardsEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {},
            onShow: () => {},
            onToggle: () => {},
        })
        console.log('Componente montado. isLoadingGenerate (mounted):', this.isLoadingGenerate); // console.log já estava presente
        this.commissionRewards = new Modal(document.getElementById('commissionRewardsEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {},
            onShow: () => {},
            onToggle: () => {},
        });
        this.withdrawalModal = new Modal(document.getElementById('withdrawalEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {},
            onShow: () => {},
            onToggle: () => {},
        });
    },
    methods: {
        async getSetting() {
            const _this = this;
            const settingStore = useSettingStore();
            _this.setting = settingStore.setting;
        },
        async getCode() { // ALTERADO: Função agora é assíncrona
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;
            console.log('getCode chamado. isLoadingGenerate (antes da API):', _this.isLoadingGenerate); // console.log já estava presente

            try { // ADICIONADO: Bloco try para tratamento de erros assíncronos
                const response = await HttpApi.get('profile/affiliates/'); // ALTERADO: Usando await para a requisição
                if(response.data.status) {
                    _this.wallet = response.data.wallet;
                    _this.indications = response.data.indications;
                    _this.referencecode = response.data.code;
                    _this.referencelink = response.data.url;
                    if(response.data.code !== null) {
                        _this.isShowForm = true;
                        console.log('Usuário É afiliado (code NÃO é null). isShowForm:', _this.isShowForm); // console.log já estava presente
                    } else {
                        _this.isShowForm = false;
                        console.log('Usuário NÃO é afiliado (code é null). isShowForm:', _this.isShowForm); // console.log já estava presente
                    }
                    console.log('Resposta da API getCode:', response.data); // console.log já estava presente
                }
            } catch (error) { // ADICIONADO: Bloco catch para capturar erros da requisição
                console.error('Erro na API getCode:', error); // ADICIONADO: Log de erro mais detalhado
                // ALTERADO: Tratamento de erro mais robusto para requisições HTTP
                if (error.response && error.response.data) {
                    if (typeof error.response.data === 'object' && error.response.data.message) {
                        _toast.error(error.response.data.message);
                    } else if (typeof error.response.data === 'string') {
                        _toast.error(error.response.data);
                    } else {
                        Object.values(error.response.data).forEach(messages => {
                            if (Array.isArray(messages)) {
                                messages.forEach(msg => _toast.error(msg));
                            } else {
                                _toast.error(messages);
                            }
                        });
                    }
                } else if (error.request) {
                    _toast.error('Erro de rede ou servidor não respondeu. Verifique sua conexão.');
                } else {
                    _toast.error('Ocorreu um erro inesperado ao carregar dados de afiliado.');
                }
            } finally { // ADICIONADO: Bloco finally para garantir que o loading seja desativado
                _this.isLoading = false;
                console.log('getCode finalizado. isLoading:', _this.isLoading, 'isShowForm:', _this.isShowForm, 'isLoadingGenerate:', _this.isLoadingGenerate); // console.log já estava presente
            }
        },
        async generateCode() { // ALTERADO: Função agora é assíncrona
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;
            console.log('generateCode chamado. isLoadingGenerate (antes da API):', _this.isLoadingGenerate); // console.log já estava presente

            try { // ADICIONADO: Bloco try para tratamento de erros assíncronos
                // ALTERADO: Requisição de GET para POST, pois está gerando/modificando dados no servidor
                const response = await HttpApi.post('profile/affiliates/generate'); // ALTERADO: Usando await para a requisição
                if(response.data.status) {
                    // ADICIONADO: Preencher referencecode e referencelink diretamente da resposta do backend
                    // (Isso requer que o backend retorne 'code' e 'url' no generateCode())
                    _this.referencecode = response.data.code;
                    _this.referencelink = response.data.url;
                    _this.isShowForm = true; // ADICIONADO: Exibir o formulário após a geração bem-sucedida
                    _toast.success(_this.$t('Your code was generated successfully'));
                    // ALTERADO: Chamar getCode() novamente para recarregar todos os dados, aguardando sua conclusão
                    await _this.getCode();
                }
            } catch (error) { // ADICIONADO: Bloco catch para capturar erros da requisição
                console.error('Erro na API generateCode:', error); // ADICIONADO: Log de erro mais detalhado
                // ALTERADO: Tratamento de erro mais robusto para requisições HTTP
                if (error.response && error.response.data) {
                    if (typeof error.response.data === 'object' && error.response.data.message) {
                        _toast.error(error.response.data.message);
                    } else if (typeof error.response.data === 'string') {
                        _toast.error(error.response.data);
                    } else {
                        Object.values(error.response.data).forEach(messages => {
                            if (Array.isArray(messages)) {
                                messages.forEach(msg => _toast.error(msg));
                            } else {
                                _toast.error(messages);
                            }
                        });
                    }
                } else if (error.request) {
                    _toast.error('Erro de rede ou servidor não respondeu. Verifique sua conexão.');
                } else {
                    _toast.error('Ocorreu um erro inesperado ao gerar código de afiliado.');
                }
            } finally { // ADICIONADO: Bloco finally para garantir que o loading seja desativado
                _this.isLoadingGenerate = false;
                console.log('generateCode finalizado. isLoadingGenerate setado para FALSE.'); // console.log já estava presente
            }
        },
        toggleCommissionRewards: function(event) {
            this.commissionRewards.toggle();
        },
        toggleReferenceRewards: function(event) {
            this.referenceRewards.toggle();
        },
        opemModalWithdrawal: function() {
            this.withdrawalModal.toggle();
        },
        async makeWithdrawal() { // ALTERADO: Função agora é assíncrona
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            try { // ADICIONADO: Bloco try para tratamento de erros assíncronos
                const response = await HttpApi.post('profile/affiliates/request', _this.withdrawalForm); // ALTERADO: Usando await para a requisição
                _this.opemModalWithdrawal();
                _toast.success(_this.$t(response.data.message));
                _this.router.push({ name: 'profileWallet' });
            } catch (error) { // ADICIONADO: Bloco catch para capturar erros da requisição
                console.error('Erro na API makeWithdrawal:', error); // ADICIONADO: Log de erro mais detalhado
                // ALTERADO: Tratamento de erro mais robusto para requisições HTTP
                if (error.response && error.response.data) {
                    if (typeof error.response.data === 'object' && error.response.data.message) {
                        _toast.error(error.response.data.message);
                    } else if (typeof error.response.data === 'string') {
                        _toast.error(error.response.data);
                    } else {
                        Object.values(error.response.data).forEach(messages => {
                            if (Array.isArray(messages)) {
                                messages.forEach(msg => _toast.error(msg));
                            } else {
                                _toast.error(messages);
                            }
                        });
                    }
                } else if (error.request) {
                    _toast.error('Erro de rede ou servidor não respondeu. Verifique sua conexão.');
                } else {
                    _toast.error('Ocorreu um erro inesperado ao realizar saque.');
                }
            } finally { // ADICIONADO: Bloco finally para garantir que o loading seja desativado
                _this.isLoading = false;
            }
        }
    },
    created() {
        console.log('Componente criado. isLoadingGenerate (created):', this.isLoadingGenerate); // console.log já estava presente
        this.getSetting();
        this.getCode();
    },
    watch: {},
};
</script>


<style scoped>
.affiliate-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    min-height: 100vh;
}

/* Hero Section */
.affiliate-hero {
    background: linear-gradient(135deg, #237e0a, #4e9b51);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.affiliate-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
    z-index: -1;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.hero-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 2;
}

.icon-emoji {
    font-size: 4rem;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
}

.affiliate-icon {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.hero-title {
    font-size: 1.6rem;
    font-weight: 800;
    margin: 0;
}

.hero-subtitle {
    font-size: 0.6rem;
    opacity: 0.9;
    margin: 0;
}

/* Earnings Status Card */
.earnings-status-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 30px;
    min-width: 300px;
    z-index: 2;
    position: relative;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.earnings-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.earnings-amount {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.amount-label {
    font-size: 1rem;
    opacity: 0.8;
}

.amount-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #FFD700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.earnings-stats {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4ECDC4;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Main Content */
.main-content {
    max-width: 668px;
    margin: 0 auto;
}

/* Logo Banner */
.logo-banner {
    margin-bottom: 30px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.banner-logo {
    width: 100%;
    height: auto;
    display: block;
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 30px;
}

.section-header h2 {
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 10px 0;
}

.section-header p {
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

/* Affiliate Form Section */
.affiliate-form-section {
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
}

/* Sharing Section */
.sharing-section {
    margin-bottom: 40px;
}

.share-cards {
    display: grid;
    gap: 20px;
    grid-template-columns: 1fr;
}

.share-card {
    background: var(--ci-gray-medium);
    border-radius: 15px;
    padding: 25px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.share-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.5);
}

.share-card-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.share-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #090a25, #091634);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #090720;
    font-weight: bold;
}

.share-info h3 {
    color: #fff;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0 0 5px 0;
}

.share-info p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin: 0;
}

.share-input-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.share-input {
    background: var(--input-primary, rgba(255, 255, 255, 0.1));
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 15px;
    color: #fff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.share-input:focus {
    outline: none;
    border-color: #FFD700;
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
}

.copy-button {
    background: var(--ci-primary-color);
    color: var(--ci-gray-over);
    border: none;
    border-radius: 10px;
    padding: 15px 20px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.copy-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 255, 90, 0.4);
}

/* Statistics Section */
.statistics-section {
    margin-bottom: 40px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 25px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    border-color: var(--ci-primary-color);
}

.stat-card.balance-card {
    border-color: rgba(255, 215, 0, 0.5);
    background: rgba(255, 215, 0, 0.1);
}

.stat-card.balance-card:hover {
    border-color: #FFD700;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--ci-gray-medium) 0%, var(--ci-gray-over) 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: #fff;
    flex-shrink: 0;
}

.balance-card .stat-icon {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #090720;
}

.stat-content {
    flex: 1;
}

.stat-title {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 8px;
}

.stat-value {
    color: #fff;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.balance-value {
    color: #FFD700;
}

.stat-description {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.8rem;
}

/* Withdrawal Section */
.withdrawal-section {
    text-align: center;
    margin-top: 30px;
}

.withdrawal-button {
    background: var(--ci-primary-color);
    color: var(--ci-gray-medium);
    border: none;
    border-radius: 15px;
    padding: 20px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 12px;
}

.withdrawal-button:hover {
    transform: translateY(-3px);
}

.affiliatepanel-button {
    background: var(--ci-gray-medium);
    color: #fffbb777;
    border-radius: 15px;
    padding: 20px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 12px;
}

.affiliatepanel-button:hover {
    transform: translateY(-3px);
    color: var(--ci-gray-medium);
    background: var(--ci-primary-color);
}


/* Get Started Section */
.get-started-section {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 20px;
    padding: 50px 30px;
    text-align: center;
    margin-bottom: 30px;
}

.get-started-content {
    max-width: 600px;
    margin: 0 auto;
}

.get-started-icon {
    font-size: 5rem;
    margin-bottom: 20px;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

.get-started-content h2 {
    color: #fff;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 20px 0;
}

.get-started-content p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 30px;
}

.benefits-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 40px;
    text-align: left;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    font-size: 1rem;
}

.benefit-icon {
    color: #4ECDC4;
    font-weight: bold;
}

.become-affiliate-button {
    background: linear-gradient(135deg, var(--ci-primary-color, #FFD700) 0%, #FFA500 100%);
    color: #090720;
    border: none;
    border-radius: 15px;
    padding: 20px 40px;
    font-size: 1.3rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 12px;
}

.become-affiliate-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(255, 215, 0, 0.4);
}

/* Loading States */
.loading-state,
.page-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 80px 20px;
    text-align: center;
}

.loading-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.loading-spinner i {
    font-size: 3rem;
    color: var(--ci-primary-color, #FFD700);
}

.loading-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
}

.btn-icon {
    font-size: 1.2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .affiliate-container {
        padding: 15px;
    }
    
    .affiliate-hero {
        flex-direction: column;
        text-align: center;
        gap: 25px;
        padding: 30px 20px;
    }
    
    .hero-title {
        font-size: 1.2rem;
    }
    
    .earnings-status-card {
        min-width: auto;
        width: 100%;
    }
    
    .amount-value {
        font-size: 1.2rem;
    }
    
    .earnings-stats {
        gap: 15px;
    }
    
    .stat-number {
        font-size: 0.8rem;
    }
    
    .share-cards {
        gap: 15px;
    }
    
    .share-card {
        padding: 20px;
    }
    
    .share-card-header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .get-started-content h2 {
        font-size: 2rem;
    }
    
    .benefits-list {
        text-align: center;
    }
    
    .withdrawal-button,
    .affiliatepanel-button,
    .become-affiliate-button {
        padding: 15px 30px;
        font-size: 1.1rem;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .amount-value {
        font-size: 1.8rem;
    }
    
    .section-header h2 {
        font-size: 1.5rem;
    }
    
    .share-input,
    .copy-button {
        padding: 12px;
        font-size: 0.9rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
    
    .get-started-icon {
        font-size: 4rem;
    }
    
    .get-started-content h2 {
        font-size: 1.8rem;
    }
}
</style>