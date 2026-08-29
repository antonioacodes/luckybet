<template>
    <div v-if="cashback && cashback.enabled" class="cashback-wrapper">

        <!-- LOADING STATE -->
        <div v-if="isLoading" class="cashback-loading">
            <div class="spinner"></div>
            <span>Verificando Cashback...</span>
        </div>

        <!-- CONTENT -->
        <div v-else class="cashback-card" :class="statusClass">

            <!-- Header / Title -->
            <div class="cashback-header">
                <div class="cashback-icon-wrapper">
                    <span class="cashback-icon">💸</span>
                </div>
                <div class="cashback-info">
                    <h3>{{ cashbackTitle }}</h3>
                    <p>{{ cashbackSubtitle }}</p>
                </div>
            </div>

            <!-- STATE: AVAILABLE (Dinheiro na mesa!) -->
            <div v-if="cashback.status === 'available'" class="cashback-body available">
                <div class="amount-display">
                    <span class="currency">R$</span>
                    <span class="value">{{ formatMoney(cashback.amount) }}</span>
                </div>

                <div class="expiration-info" v-if="cashback.expiration">
                    <small>Disponível até: {{ formatDate(cashback.expiration) }}</small>
                </div>

                <button 
                    @click="claimCashback" 
                    :disabled="isClaiming"
                    class="btn-claim"
                >
                    <span v-if="!isClaiming">RESGATAR AGORA</span>
                    <span v-else>PROCESSANDO...</span>
                </button>
            </div>

            <!-- STATE: WAITING / NO LOSS (Informativo) -->
            <div v-else class="cashback-body info">
                <div class="status-message">
                    <p v-if="cashback.status === 'waiting_cycle'">
                        Seu próximo ciclo de análise já começou. Continue jogando!
                    </p>
                    <p v-else-if="cashback.status === 'no_loss'">
                        Você lucrou neste período! 🎉<br>
                        O cashback é ativado apenas quando há perdas líquidas.
                    </p>
                    <p v-else>
                        Aguarde o fechamento do período para nova análise.
                    </p>
                </div>

                <div class="next-check" v-if="cashback.next_check">
                    <small>Próxima análise: {{ formatDate(cashback.next_check) }}</small>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import HttpApi from "@/Services/HttpApi.js";
import Swal from 'sweetalert2'; // Opcional, para alertas bonitos

export default {
    name: 'CashbackWidget',
    data() {
        return {
            isLoading: true,
            isClaiming: false,
            cashback: null, // Dados vindos da API
        };
    },
    computed: {
        cashbackTitle() {
            if (!this.cashback) return '';
            const type = this.cashback.periodicity === 'daily' ? 'Diário' : 
                         this.cashback.periodicity === 'monthly' ? 'Mensal' : 'Semanal';
            return `Cashback ${type}`;
        },
        cashbackSubtitle() {
            if (!this.cashback) return '';
            if (this.cashback.status === 'available') return 'Você tem um valor pendente!';
            return `Devolução de ${this.cashback.percentage}% sobre perdas`;
        },
        statusClass() {
            if (!this.cashback) return '';
            return this.cashback.status; // 'available', 'no_loss', etc.
        }
    },
    methods: {
        formatMoney(value) {
            return parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        },
        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('pt-BR') + ' às ' + date.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'});
        },
        async checkStatus() {
            this.isLoading = true;
            try {
                const response = await HttpApi.get('/cashback/status');
                this.cashback = response.data;
            } catch (error) {
                console.error('Erro ao carregar cashback:', error);
                this.cashback = { enabled: false };
            } finally {
                this.isLoading = false;
            }
        },
        async claimCashback() {
            if (this.isClaiming) return;
            this.isClaiming = true;

            try {
                const response = await HttpApi.post('/cashback/claim');

                if (response.data.success) {
                    // Sucesso visual
                    this.$emit('cashback-claimed', response.data.new_balance); // Emite evento para atualizar saldo no pai

                    // Atualiza estado local para esconder o botão
                    this.cashback.status = 'claimed';
                    this.cashback.enabled = false; // Ou recarrega o status

                    // Alerta (se usar SweetAlert ou Toast)
                    // Swal.fire('Sucesso!', `Você recebeu R$ ${this.formatMoney(response.data.amount_added)}`, 'success');
                    alert(`Sucesso! R$ ${this.formatMoney(response.data.amount_added)} adicionados à sua carteira.`);
                }
            } catch (error) {
                console.error(error);
                alert('Erro ao resgatar. Tente novamente.');
            } finally {
                this.isClaiming = false;
                // Recarrega status para garantir consistência
                this.checkStatus();
            }
        }
    },
    mounted() {
        this.checkStatus();
    }
};
</script>

<style scoped>
.cashback-wrapper {
    margin-bottom: 30px;
    width: 100%;
}

.cashback-card {
    background: var(--ci-gray-medium); /* Fundo neutro escuro */
    border-radius: 15px;
    padding: 25px;
    border: 1px solid #ffd7004d;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* Estilo Especial quando Disponível */
.cashback-card.available {
    background: linear-gradient(135deg,#fe993f,#ec7201); /* Verde Vibrante */
}

.cashback-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
}

.cashback-icon-wrapper {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.cashback-info h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    color: #fff;
}

.cashback-info p {
    margin: 0;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
}

/* Body Styles */
.cashback-body {
    position: relative;
    z-index: 2;
}

.amount-display {
    background: rgba(0, 0, 0, 0.2);
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 15px;
}

.amount-display .currency {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    margin-right: 5px;
}

.amount-display .value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.expiration-info {
    text-align: center;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.btn-claim {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 10px;
    background: #fe993f;
    color: #fff;
    font-weight: 800;
    font-size: 1.1rem;
    cursor: pointer;
    transition: transform 0.2s;
    text-transform: uppercase;
}

.btn-claim:hover:not(:disabled) {
  	background: var(--ci-gray-medium);
    color: #fe993f;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

.btn-claim:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Status Messages */
.status-message {
    background: rgba(255, 255, 255, 0.05);
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
}

.next-check {
    text-align: center;
    margin-top: 10px;
    color: rgba(255, 255, 255, 0.5);
}

/* Loading */
.cashback-loading {
    text-align: center;
    padding: 20px;
    color: rgba(255, 255, 255, 0.5);
}

@keyframes pulse-border {
    0% { box-shadow: 0 0 0 0 rgba(56, 239, 125, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(56, 239, 125, 0); }
    100% { box-shadow: 0 0 0 0 rgba(56, 239, 125, 0); }
}

/* Responsividade */
@media (max-width: 768px) {
    .amount-display .value {
        font-size: 2rem;
    }
    .cashback-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>
