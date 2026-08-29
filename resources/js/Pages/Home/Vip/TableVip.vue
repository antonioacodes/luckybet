<template>
    <div class="relative overflow-x-auto w-full">
        <table v-if="nivelMonthly && nivelMonthly.length" class="w-full text-center" style="font-size: 12px;">
            <thead class="uppercase" style="border-radius: 12px;border: 0.1rem solid var(--carousel-banners);">
                <tr style="border-radius: 12px;">
                    <th scope="col" class="py-4" style="font-size: 10px;">
                        <p style="font-size: 10px;color: white;">Badge</p>
                    </th>
                    <th scope="col" class="" style="font-size: 10px;text-align: center;">
                        <p style="font-size: 10px;color: white;">Nível</p>
                    </th>
                    <th scope="col" class="" style="font-size: 10px;">
                        <p style="font-size: 10px;color: white;">Progresso do Nível</p>
                    </th>
                    <th scope="col" class="" style="font-size: 10px;">
                        <p style="font-size: 10px;color: white;">Bônus de Recompensa</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    v-for="(vip, index) in nivelMonthly" 
                    :key="index" 
                    class="odd:bg-white odd:dark:bg-[#17191A]" 
                    :class="{ 'current-level': vipPoints >= vip.bet_required }"
                    style="background-color: #17191A;"
                >
                    <th 
                        scope="row" 
                        class="px-2 text-gray-900 whitespace-nowrap dark:text-white" 
                        style="border-top-left-radius: 8px;border-bottom-left-radius: 8px;font-size: 10px;"
                    > 
                        <img 
                            :src="`/storage/${vip.bet_symbol}`" 
                            :alt="`Nível ${vip.bet_level}`" 
                            width="55"
                        >
                    </th>
                    <td 
                        scope="row" 
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ $t('Level') }} {{ vip.bet_level }}
                    </td>
                    <td class="px-6 py-4">
                        <p style="font-size:9px;color: var(--title-color);">{{ vip.bet_required }} pontos</p>
                        <p>
                            <div class="relative w-full bg-gray-200 rounded-full h-2 dark:bg-[#17191A]">
                                <div 
                                    :style="{
                                        width: getProgress(vip.bet_required) + '%', 
                                        backgroundColor: getProgressColor(vip.bet_level)
                                    }"
                                    class="h-3 rounded-lg text-center justify-center text-white"
                                >
                                </div>
                                <br><span 
                                                class="absolute w-full text-center" 
            style="padding-top:4px;left: 0; top: 100%; font-size: 9px; color: var(--ci-primary-color);"
                                >
                                    {{ vipPoints >= vip.bet_required 
                                        ? 'Concluído' 
                                        : `${vipPoints} / ${vip.bet_required}` 
                                    }}
                                </span>
                            </div>
                        </p>
                    </td>
                    <td 
                        class="px-6 py-4" 
                        style="color:#FFAC02;border-top-right-radius: 8px;border-bottom-right-radius: 8px;"
                    >
                        {{ vip.bet_bonus }}%
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else-if="isLoading" class="text-center py-4">
            Carregando níveis VIP...
        </div>
        <div v-else class="text-center py-4">
            Nenhum nível VIP encontrado
        </div>
    </div>
</template>

<script>
import HttpApi from '@/Services/HttpApi';

export default {
    data() {
        return {
            nivelToday: [],
            nivelWeekly: [],
            nivelMonthly: [],
            nivelYearly: [],
            currentLevel: null,
            nextLevel: null,
            vipPoints: 0,
            pointsToNextLevel: 0,
            isLoading: true,
            refreshInterval: null
        }
    },
    methods: {
    getProgress(requiredPoints) {
        // Calcular progresso baseado nos pontos reais do usuário
        if (this.vipPoints >= requiredPoints) {
            return 100;
        }
        return Math.min((this.vipPoints / requiredPoints) * 100, 100);
    },
        getProgressColor(level) {
            // Cores baseadas no nivel, similar à imagem
            const colors = {
                1: '#A0522D',    // Bronze
                2: '#C0C0C0',    // Silver
                3: '#FFD700',    // Gold
                4: '#4B0082',    // Purple
                5: '#FF4500'     // Laranja/Vermelho
            };
            return colors[level] || '#68707B';
        },
        async fetchVipLevels() {
            try {
                this.isLoading = true;
                const response = await HttpApi.get('/profile/vip/');
                
                // Desestruturar todos os dados da resposta
                const {
                    nivelToday,
                    nivelWeekly,
                    nivelMonthly,
                    nivelYearly,
                    currentLevel,
                    nextLevel,
                    vipPoints,
                    pointsToNextLevel
                } = response.data;

                // Atribuir todos os dados
                this.nivelToday = nivelToday || [];
                this.nivelWeekly = nivelWeekly || [];
                this.nivelMonthly = nivelMonthly || [];
                this.nivelYearly = nivelYearly || [];
                this.currentLevel = currentLevel;
                this.nextLevel = nextLevel;
                this.vipPoints = vipPoints || 0;
                this.pointsToNextLevel = pointsToNextLevel || 0;
                
                // Ordenar níveis por bet_level
                this.nivelMonthly.sort((a, b) => a.bet_level - b.bet_level);
            } catch (error) {
                console.error('Erro ao buscar níveis VIP:', error);
                this.$toast.error('Não foi possível carregar os níveis VIP');
            } finally {
                this.isLoading = false;
            }
        },
        startAutoRefresh() {
            // Atualiza a cada 30 segundos
            this.refreshInterval = setInterval(() => {
                this.fetchVipLevels();
            }, 30000);
        }
    },
    created() {
        this.fetchVipLevels();
        this.startAutoRefresh();
    },
    beforeUnmount() {
        // Limpar intervalo para evitar memory leak
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
};
</script>

<style scoped>
tr:nth-child(odd) {
    color: var(--title-color);
}
.current-level {
    background-color: rgba(104, 112, 123, 0.2) !important;
}
</style>