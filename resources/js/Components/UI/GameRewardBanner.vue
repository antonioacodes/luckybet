<template>
    <transition name="fade">
        <div v-if="hasReward && reward" class="w-full mb-6 relative z-20">
            <!-- Container com Gradiente Laranja/Amarelo -->
            <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-xl shadow-2xl p-1 relative overflow-hidden">

                <!-- Efeitos de Fundo (Brilho) -->
                <div class="absolute top-0 left-0 w-full h-full bg-white opacity-10 animate-pulse"></div>
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-300 rounded-full filter blur-2xl opacity-30"></div>

                <div class="bg-gray-900/10 backdrop-blur-sm rounded-lg p-4 flex flex-col sm:flex-row items-center justify-between gap-4">

                    <!-- Texto e Ícone -->
                    <div class="flex items-center gap-4">
                        <div class="bg-white p-3 rounded-full shadow-lg animate-bounce">
                          🎁
                        </div>
                        <div class="text-white text-center sm:text-left">
                            <h3 class="font-bold sm:text-xs text-md uppercase tracking-wider text-yellow-100">Recompensa Disponível!</h3>
                            <p class="text-sm font-medium">
                                Você tem <span class="text-yellow-300 font-bold sm:text-xs text-md">{{ reward.rounds }} Rodadas Grátis</span> para resgatar agora!
                            </p>
                        </div>
                    </div>

                    <!-- Botão de Ação -->
                    <button 
                        @click.prevent="activateReward" 
                        :disabled="loading"
                        class="group relative px-6 py-3 font-bold text-orange-600 transition-all duration-200 bg-white rounded-full shadow-lg hover:bg-yellow-50 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <span v-if="!loading" class="sm:text-xs text-md flex items-center gap-2">
                            RESGATAR AGORA
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </span>
                        <span v-else class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import HttpApi from "@/Services/HttpApi.js";
import { useToast } from "vue-toastification"; // Se você usar toast, senão use alert

export default {
    name: "GameRewardBanner",
    props: {
        gameId: {
            type: [Number, String],
            required: true
        }
    },
    data() {
        return {
            loading: false,
            hasReward: false,
            reward: null
        };
    },
    watch: {
        gameId: {
            immediate: true,
            handler(newVal) {
                if (newVal) this.checkReward();
            }
        }
    },
    methods: {
        async checkReward() {
            try {
                const response = await HttpApi.get(`user_rewards/check/${this.gameId}`);
                if (response.data.status) {
                    this.reward = response.data.reward;
                    this.hasReward = true;
                } else {
                    this.hasReward = false;
                    this.reward = null;
                }
            } catch (error) {
                console.error("Erro ao checar reward:", error);
            }
        },
        async activateReward() {
            if (!this.reward) return;

            this.loading = true;
            try {
                const response = await HttpApi.post(`user_rewards/activate/${this.reward.id}`);

                if (response.data.status) {
                    // Sucesso!
                    this.hasReward = false; // Esconde o banner
                    this.$emit('reward-activated'); // Avisa o pai

                    // Opcional: Mostrar Toast de sucesso
                    // const toast = useToast();
                    // toast.success(response.data.message);

                } else {
                    alert(response.data.message || 'Erro ao ativar bônus.');
                }
            } catch (error) {
                console.error("Erro ao ativar:", error);
                alert('Erro de conexão ao tentar ativar o bônus.');
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
