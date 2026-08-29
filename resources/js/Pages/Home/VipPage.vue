<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>Carregando informações VIP...</span>
            </div>
        </LoadingComponent>
        <br>
        <div v-if="!isLoading" class="vip-container sm:max-w-[690px] mx-auto w-full">
            <!-- Hero Section VIP -->
            <div class="vip-hero-section">
                <div class="vip-hero-content">
                    <div class="vip-crown-icon">
                        <img src="https://i.imgur.com/mFcu80S.png">
                    </div>
                    <h1 class="vip-hero-title">Clube VIP</h1>
                    <p class="vip-hero-subtitle">Desbloqueie benefícios exclusivos e recompensas premium</p>
                </div>
                
                <!-- Current Level Display -->
                <div class="current-level-card">
                    <div class="level-badge">
                        <img v-if="currentLevel" :src="`/storage/${currentLevel.bet_symbol}`" :alt="currentLevel.vip_name" class="level-symbol" />
                        <div class="level-info">
                            <div class="level-name">{{ currentLevel ? currentLevel.vip_name : 'Não definido' }}</div>
                            <div class="level-number">Nível {{ currentLevel ? currentLevel.bet_level : '0' }}</div>
                        </div>
                    </div>
                    <div class="vip-points">
                        <div class="points-value">{{ vipPoints.toLocaleString('pt-BR') }}</div>
                        <div class="points-label">Pontos VIP</div>
                    </div>
                </div>
            </div>
			<CashbackWidget @cashback-claimed="updateBalance" />
            <!-- Progress to Next Level -->
            <div class="next-level-progress" v-if="nextLevel">
                <div class="progress-header">
                    <div class="current-level-mini" v-if="currentLevel">
                        <img :src="`/storage/${currentLevel.bet_symbol}`" :alt="currentLevel.vip_name" />
                        <span>{{ currentLevel.vip_name }}</span>
                    </div>
                    <div class="progress-arrow" v-if="currentLevel && nextLevel">→</div>
                    <div class="next-level-mini">
                        <img :src="`/storage/${nextLevel.bet_symbol}`" :alt="nextLevel.vip_name" />
                        <span>{{ nextLevel.vip_name }}</span>
                    </div>
                </div>
                
                <div class="progress-info">
                    <span>Progresso para {{ nextLevel.vip_name }}</span>
                    <span>{{ progressToNextLevel }}%</span>
                </div>
                
                <div class="progress-bar">
                    <div class="progress-fill" :style="{width: progressToNextLevel + '%'}"></div>
                    <div class="progress-glow" :style="{width: progressToNextLevel + '%'}"></div>
                </div>
                
                <div class="progress-requirements">
                    <div class="requirement">
                        <span class="requirement-label">Necessário apostar:</span>
                        <span class="requirement-value">R$ {{ nextLevel.bet_required.toLocaleString('pt-BR') }}</span>
                    </div>
                    <div class="requirement">
                        <span class="requirement-label">Faltam:</span>
                        <span class="requirement-value remaining">R$ {{ pointsToNextLevel.toLocaleString('pt-BR') }}</span>
                    </div>
                </div>
            </div>

            <!-- Max Level Achieved -->
            <div class="max-level-achieved" v-else>
                <div class="max-level-content">
                    <div class="trophy-icon">🏆</div>
                    <h2>Parabéns! Nível Máximo Atingido!</h2>
                    <p>Você alcançou o mais alto nível do nosso Clube VIP</p>
                </div>
            </div>

            <!-- VIP Benefits Tabs -->
            <div class="vip-benefits-section">
                <div class="benefits-header">
                    <h2>Benefícios VIP</h2>
                    <p>Descubra todas as vantagens de cada nível</p>
                </div>
                
                <div class="benefits-tabs">
                    <button 
                        v-for="tab in benefitTabs" 
                        :key="tab.id"
                        @click="activeBenefitTab = tab.id"
                        :class="['benefit-tab', { active: activeBenefitTab === tab.id }]"
                    >
                        <span class="tab-icon" v-html="tab.icon"></span>
                        {{ tab.label }}
                    </button>
                </div>

                <!-- Current Level Benefits -->
                <div v-show="activeBenefitTab === 'current'" class="benefits-content">
                    <div class="current-benefits-card">
                        <div class="benefits-title px-4">
                            <h3>Seus Benefícios Atuais</h3>
                            <div class="level-indicator">{{ currentLevel ? currentLevel.vip_name : 'Nível 0' }}</div>
                        </div>
                        
                        <div class="benefits-grid">
                            <div class="benefit-item" v-if="currentLevel && currentLevel.weekly_bonus > 0">
                                <div class="benefit-icon">💰</div>
                                <div class="benefit-details">
                                    <div class="benefit-name">Bônus Semanal</div>
                                    <div class="benefit-value">R$ {{ currentLevel.weekly_bonus.toLocaleString('pt-BR') }}</div>
                                </div>
                            </div>
                            
                            <div class="benefit-item" v-if="currentLevel && currentLevel.monthly_bonus > 0">
                                <div class="benefit-icon">🎁</div>
                                <div class="benefit-details">
                                    <div class="benefit-name">Bônus Mensal</div>
                                    <div class="benefit-value">R$ {{ currentLevel.monthly_bonus.toLocaleString('pt-BR') }}</div>
                                </div>
                            </div>
                            
                            <div class="benefit-item" v-if="currentLevel && currentLevel.cashback_percentage > 0">
                                <div class="benefit-icon">💸</div>
                                <div class="benefit-details">
                                    <div class="benefit-name">Cashback</div>
                                    <div class="benefit-value">{{ currentLevel.cashback_percentage }}%</div>
                                </div>
                            </div>
                            
                            <div class="benefit-item" v-if="currentLevel && currentLevel.level_up_bonus > 0">
                                <div class="benefit-icon">⬆️</div>
                                <div class="benefit-details">
                                    <div class="benefit-name">Bônus de Nível</div>
                                    <div class="benefit-value">R$ {{ currentLevel.level_up_bonus.toLocaleString('pt-BR') }}</div>
                                </div>
                            </div>
                        </div>
<div class="benefits-grid" v-if="userRewards.length > 0">
  <div
    v-for="reward in userRewards"
    :key="reward.id"
    class="benefit-item reward-slot"
  >

    <!-- 🎰 FREE SPINS -->
    <a
      v-if="reward.reward_type === 'freespins'"
      :href="`/games/play/${reward.game_id}/${reward.game_code}`"
      target="_blank"
      class="reward-link"
    >
      <img
        :src="`${reward.image}` || '/images/default-slot.jpg'"
        :alt="reward.game_code || 'Jogo'"
        class="reward-img"
      />
      <div class="benefit-details">
        <div class="benefit-name">{{ reward.rounds }} Giros Grátis</div>
         <div class="benefit-value.epico" :class="reward.reward_type.toLowerCase()">
                                {{ reward.reward_type.toUpperCase() }}
        </div>
      </div>
    </a>

    <!-- 💰 BONUS -->
    <div
      v-else-if="reward.reward_type === 'bonus'"
      class="reward-link"
      @click="useBonusReward(reward)"
    >
      <img
        src="https://cdn.creazilla.com/emojis/47137/money-with-wings-emoji-clipart-lg.png"
        alt="Bônus"
        class="reward-img bonus-img"
      />
      <div class="benefit-details">
        <div class="benefit-name">
          R$ {{ parseFloat(reward.reward_bonus).toFixed(2) }} Bônus
        </div>
                              <div class="benefit-value.raro" :class="reward.reward_type.toLowerCase()">
                                {{ reward.reward_type.toUpperCase() }}
                              </div>
      </div>
    </div>

  </div>
</div>

                        
                        <div class="no-benefits" v-if="!currentLevel || (!currentLevel.weekly_bonus && !currentLevel.monthly_bonus && !currentLevel.cashback_percentage && !currentLevel.level_up_bonus)">
                            <p>Complete mais apostas para desbloquear benefícios VIP!</p>
                        </div>
                    </div>
                </div>

                <!-- All Levels Overview -->
                <div v-show="activeBenefitTab === 'levels'" class="benefits-content">
                    <div class="levels-overview">
                        <div 
                            v-for="level in allLevels" 
                            :key="level.id"
                            :class="['level-card', { 
                                current: currentLevel && level.id === currentLevel.id,
                                unlocked: currentLevel && level.bet_level <= currentLevel.bet_level,
                                locked: !currentLevel || level.bet_level > currentLevel.bet_level
                            }]"
                        >
                            <div class="level-header">
                                <div class="level-symbol-container">
                                    <img :src="`/storage/${level.bet_symbol}`" :alt="level.vip_name" class="level-symbol-small" />
                                    <div v-if="!currentLevel || level.bet_level > currentLevel.bet_level" class="locked-overlay">🔒</div>
                                </div>
                                <div class="level-title">
                                    <h4>{{ level.vip_name }}</h4>
                                    <span>Nível {{ level.bet_level }}</span>
                                </div>
                                <div v-if="currentLevel && level.id === currentLevel.id" class="current-badge">Atual</div>
                            </div>
                            
                            <div class="level-requirement">
                                <span>Apostar: R$ {{ level.bet_required.toLocaleString('pt-BR') }}</span>
                            </div>
                            
                            <div class="level-benefits">
                                <div v-if="level.weekly_bonus > 0" class="mini-benefit">
                                    <span class="mini-icon">💰</span>
                                    <span>R$ {{ level.weekly_bonus.toLocaleString('pt-BR') }}/sem</span>
                                </div>
                                <div v-if="level.monthly_bonus > 0" class="mini-benefit">
                                    <span class="mini-icon">🎁</span>
                                    <span>R$ {{ level.monthly_bonus.toLocaleString('pt-BR') }}/mês</span>
                                </div>
                                <div v-if="level.cashback_percentage > 0" class="mini-benefit">
                                    <span class="mini-icon">💸</span>
                                    <span>{{ level.cashback_percentage }}% cashback</span>
                                </div>
                                <div v-if="level.level_up_bonus > 0" class="mini-benefit">
                                    <span class="mini-icon">⬆️</span>
                                    <span>R$ {{ level.level_up_bonus.toLocaleString('pt-BR') }} bônus</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VIP Tips -->
            <div class="vip-tips-section">
                <div class="tips-header">
                    <h3>💡 Dicas VIP</h3>
                </div>
                <div class="tips-grid">
                    <div class="tip-card">
                        <div class="tip-icon">🎯</div>
                        <h4>Aposte Regularmente</h4>
                        <p>Faça apostas consistentes para acumular pontos VIP mais rapidamente</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">📅</div>
                        <h4>Recompensas Automáticas</h4>
                        <p>Bônus semanais e mensais são creditados automaticamente na sua conta</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">⚡</div>
                        <h4>Cashback Instantâneo</h4>
                        <p>Receba cashback nas suas perdas conforme seu nível VIP</p>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HttpApi from "@/Services/HttpApi.js";
import CashbackWidget from "@/Pages/Home/Vip/CashbackWidget.vue"

export default {
    components: { LoadingComponent, BaseLayout, CashbackWidget },
    data() {
        return {
            isLoading: true,
            activeBenefitTab: 'current',
            
            // VIP Data
          	userRewards: [],
            currentLevel: null,
            nextLevel: null,
            vipPoints: 0,
            pointsToNextLevel: 0,
            allLevels: [],
            totalEarned: 0,
            
            benefitTabs: [
                { id: 'current', label: 'Benefícios Atuais', icon: '<i class="fa-brands fa-web-awesome"></i>' },
                { id: 'levels', label: 'Todos os Níveis', icon: '📊' }
            ],
            
            // Mock rewards history - replace with API data
            rewardsHistory: [
                {
                    id: 1,
                    name: 'Bônus Semanal',
                    amount: 'R$ 150,00',
                    type: 'Bônus',
                    icon: '💰',
                    date: '2024-05-20'
                },
                {
                    id: 2,
                    name: 'Cashback',
                    amount: 'R$ 75,50',
                    type: 'Cashback',
                    icon: '💸',
                    date: '2024-05-18'
                },
                {
                    id: 3,
                    name: 'Bônus de Nível',
                    amount: 'R$ 500,00',
                    type: 'Bônus',
                    icon: '⬆️',
                    date: '2024-05-15'
                }
            ]
        }
    },
    
    computed: {
        progressToNextLevel() {
            if (!this.nextLevel || !this.currentLevel) return 0;
            const currentRequired = this.currentLevel.bet_required || 0;
            const nextRequired = this.nextLevel.bet_required;
            const totalNeeded = nextRequired - currentRequired;
            const currentProgress = Math.max(0, this.vipPoints - currentRequired);
            return Math.min(100, Math.round((currentProgress / totalNeeded) * 100));
        }
    },
    
    methods: {
      
     updateBalance(newBalance) {
            this.getVipData();
        },
      
        async getVipData() {
  try {
    // Carrega ambos os endpoints
    const [vipRes, walletRes] = await Promise.all([
      HttpApi.get('/profile/vip/'),
      HttpApi.get('/profile/wallet')
    ]);

    // Desestrutura as respostas
    const vipData = vipRes.data;
    const walletData = walletRes.data.wallet;

    // Define os dados principais usando os valores corretos
    this.currentLevel = vipData.currentLevel || null;
    this.nextLevel = vipData.nextLevel || null;

    // ✅ Usa o valor verdadeiro dos pontos vindo do wallet
    this.vipPoints = walletData.vip_points || vipData.vipPoints || 0;

    // Também podemos complementar o nível VIP pelo wallet (mais confiável)
    if (walletData.vip_level && this.currentLevel && !this.currentLevel.bet_level) {
      const foundLevel = (vipData.nivelMonthly || []).find(
        lvl => lvl.bet_level === walletData.vip_level
      );
      if (foundLevel) this.currentLevel = foundLevel;
    }

    this.pointsToNextLevel = vipData.pointsToNextLevel || 0;

    // Junta todos os níveis possíveis
    this.allLevels = [
      ...(vipData.nivelToday || []),
      ...(vipData.nivelWeekly || []),
      ...(vipData.nivelMonthly || []),
      ...(vipData.nivelYearly || [])
    ]
      .reduce((unique, level) => {
        if (!unique.find(l => l.id === level.id)) unique.push(level);
        return unique;
      }, [])
      .sort((a, b) => a.bet_level - b.bet_level);

    // Pega os giros/recompensas
    const rewardsRes = await HttpApi.get('/profile/rewards');
    this.userRewards = rewardsRes.data || [];

    // Exemplo de total recebido se quiser calcular
    this.totalEarned = this.rewardsHistory.reduce((total, reward) => {
      const amount = parseFloat(
        reward.amount.replace('R$ ', '').replace('.', '').replace(',', '.')
      );
      return total + amount;
    }, 0);

    this.isLoading = false;
  } catch (error) {
    console.error('Erro ao buscar dados VIP:', error);
    this.isLoading = false;
  }
},
        
        formatDate(date) {
            return new Date(date).toLocaleDateString('pt-BR');
        }
    },
    
    async created() {
        await this.getVipData();
    },
    
    mounted() {
        window.scrollTo(0, 0);
    }
};
</script>

<style scoped>
.vip-container {
    margin: 0 auto;
    padding: 20px;
    min-height: 100vh;
}

/* VIP Hero Section */
.vip-hero-section {
    background: linear-gradient(135deg, #fe993f, #ec7201);
    border-radius: 15px;
    padding: 40px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #ffffff;
    position: relative;
    overflow: hidden;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.vip-hero-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 2;
}

.vip-crown-icon {
    width: 90px;
    height: 90px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.vip-hero-title {
    font-size: 2.6rem;
    font-weight: 500;
    margin: 0;
}

.vip-hero-subtitle {
    font-size: 0.8rem;
    opacity: 0.9;
    margin: 0;
}

/* Current Level Card */
.current-level-card {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    min-width: 300px;
    z-index: 2;
}

.level-badge {
    display: flex;
    align-items: center;
    gap: 15px;
}

.level-symbol {
    width: 80px;
    height: 80px;
    border-radius: 15px;
    border: 3px solid rgba(0, 0, 0, 0.06);
}

.level-info {
    text-align: center;
}

.level-name {
    font-size: 1.2rem;
    font-weight: 500;
    margin-bottom: 5px;
}

.level-number {
    font-size: 1.1rem;
    opacity: 0.8;
}

.vip-points {
    text-align: center;
}

.points-value {
    font-size: 2.2rem;
    font-weight: 500;
    margin-bottom: 5px;
}

.points-label {
    font-size: 1rem;
    opacity: 0.8;
}

/* Next Level Progress */
.next-level-progress {
    background: var(--ci-gray-medium);
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 215, 0, 0.3);
}

.progress-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    margin-bottom: 25px;
}

.current-level-mini,
.next-level-mini {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.current-level-mini img,
.next-level-mini img {
    width: 70px;
    height: 70px;
    border-radius: 15px;
}

.current-level-mini span,
.next-level-mini span {
    color: #fff;
    font-weight: 600;
    font-size: 0.9rem;
}

.progress-arrow {
    color: #FFD700;
    font-size: 2rem;
    font-weight: bold;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    color: #fff;
    font-weight: 500;
}

.progress-bar {
    height: 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 20px;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #FFD700 0%, #FFA500 100%);
    border-radius: 15px;
    transition: width 0.5s ease;
}

.progress-glow {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.3) 50%, transparent 100%);
    border-radius: 15px;
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-requirements {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.requirement {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.requirement-label {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.requirement-value {
    color: #FFD700;
    font-weight: 500;
    font-size: 1rem;
}

.requirement-value.remaining {
    color: #FF6B6B;
}

/* Max Level */
.max-level-achieved {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    border-radius: 15px;
    padding: 40px;
    margin-bottom: 30px;
    text-align: center;
    color: white;
}

.max-level-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.trophy-icon {
    font-size: 4rem;
    animation: bounce 2s infinite;
}

.max-level-content h2 {
    font-size: 1.8rem;
    font-weight: 500;
    margin: 0;
}

.max-level-content p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

/* Benefits Section */
.vip-benefits-section {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
}

.benefits-header {
    text-align: center;
    margin-bottom: 30px;
}

.benefits-header h2 {
    color: #fff;
    font-size: 1.8rem;
    font-weight: 500;
    margin: 0 0 10px 0;
}

.benefits-header p {
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

.benefits-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    background: rgba(255, 255, 255, 0.05);
    padding: 10px;
    border-radius: 15px;
}

.benefit-tab {
    flex: 1;
    padding: 15px 20px;
    border: none;
    background: transparent;
    color: rgba(255, 255, 255, 0.6);
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 500;
}

.benefit-tab.active {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #000;
    transform: translateY(-2px);
}

.tab-icon {
    font-size: 1.2rem;
}

/* Current Benefits */
.current-benefits-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 5px;
    border: 1px solid rgba(255, 215, 0, 0.2);
}

.benefits-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-top:5px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.benefits-title h3 {
    color: #fff;
    font-size: 1.2rem;
    font-weight: 500;
    margin: 0;
}

.level-indicator {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #000;
    padding: 8px 16px;
    border-radius: 15px;
    font-weight: 500;
    font-size: 0.8rem;
}

.benefits-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.benefit-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.benefit-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.3);
}

.benefit-icon {
    font-size: 2rem;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 15px;
}

.benefit-details {
    flex: 1;
}

.benefit-name {
    color: #fff;
    font-weight: 600;
    margin-bottom: 5px;
}

.benefit-value {
    color: #FFD700;
    font-weight: 500;
    font-size: 0.8rem;
}

.no-benefits {
    text-align: center;
    padding: 60px 20px;
    color: rgba(255, 255, 255, 0.6);
}

.no-benefits p {
    font-size: 1.1rem;
    margin: 0;
}

/* Levels Overview */
.levels-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.level-card {
    background: var(--ci-gray-medium);
    border-radius: 15px;
    padding: 25px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
}

.level-card.current {
    border-color: #FFD700;
    background: rgba(255, 215, 0, 0.1);
}

.level-card.unlocked {
    background: rgba(76, 175, 80, 0.05);
}

.level-card.locked {
    opacity: 0.6;
    border-color: rgba(255, 255, 255, 0.1);
}

.level-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.level-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
    position: relative;
}

.level-symbol-container {
    position: relative;
}

.level-symbol-small {
    width: 75px;
    height: 75px;
    border-radius: 15px;
}

.locked-overlay {
    position: absolute;
    top: 10px;
    left: 11px;
    margin:auto;
    width: 50px;
    height: 50px;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.level-title {
    flex: 1;
}

.level-title h4 {
    color: #fff;
    font-size: 1.2rem;
    font-weight: 500;
    margin: 0 0 3px 0;
}

.level-title span {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.current-badge {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #000;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.level-requirement {
    background: rgba(255, 255, 255, 0.05);
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    color: #FFD700;
    font-weight: 500;
    text-align: center;
}

.level-benefits {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.mini-benefit {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    font-size: 0.85rem;
    color: #fff;
}

.mini-icon {
    font-size: 1rem;
}

/* Rewards History */
.rewards-history {
    max-height: 500px;
    overflow-y: auto;
}

.rewards-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.rewards-header h3 {
    color: #fff;
    font-size: 1.2rem;
    font-weight: 500;
    margin: 0;
}

.total-earned {
    display: flex;
    flex-direction: column;
    align-items: end;
    gap: 3px;
}

.earned-label {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.earned-value {
    color: #4CAF50;
    font-weight: 500;
    font-size: 1.1rem;
}

.rewards-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.reward-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.reward-item:hover {
    transform: translateX(5px);
    border-color: rgba(255, 215, 0, 0.3);
}

.reward-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.reward-details {
    flex: 1;
}

.reward-name {
    color: #fff;
    font-weight: 500;
    margin-bottom: 3px;
}

.reward-date {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
}

.reward-amount {
    text-align: right;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.amount {
    color: #4CAF50;
    font-weight: 500;
    font-size: 1.2rem;
}

.type {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
    text-transform: uppercase;
}

.no-rewards {
    padding: 40px 20px;
}

.empty-state {
    text-align: center;
    color: rgba(255, 255, 255, 0.6);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h4 {
    color: #fff;
    font-size: 1.3rem;
    margin: 0 0 10px 0;
}

.empty-state p {
    margin: 0;
    font-size: 1rem;
}

/* VIP Tips */
.vip-tips-section {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 15px;
    padding: 30px;
}

.tips-header {
    text-align: center;
    margin-bottom: 30px;
}

.tips-header h3 {
    color: #fff;
    font-size: 1.4rem;
    font-weight: 500;
    margin: 0;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.tip-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.tip-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.3);
}

.tip-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.tip-card h4 {
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    margin: 0 0 10px 0;
}

.tip-card p {
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .vip-container {
        padding: 15px;
    }
    
    .vip-hero-section {
        flex-direction: column;
        text-align: center;
        gap: 25px;
        padding: 30px 20px;
    }
    
    .vip-hero-title {
        font-size: 2.2rem;
    }
    
    .vip-hero-subtitle {
        font-size: 1.1rem;
    }
    
    .current-level-card {
        min-width: auto;
        width: 100%;
    }
    
    .progress-header {
        flex-direction: row;
        gap: 15px;
    }
    
    .progress-arrow {
        transform: rotate(90deg);
    }
    
    .progress-requirements {
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    .benefits-tabs {
        flex-wrap: wrap;
    }
    
    .levels-overview {
        grid-template-columns: 1fr;
    }
    
    .level-benefits {
        grid-template-columns: 1fr;
    }
    
    .tips-grid {
        grid-template-columns: 1fr;
    }
    
    .rewards-header {
        flex-direction: column;
        align-items: center;
        gap: 15px;
        text-align: center;
    }
}

.reward-slot {
    width: 200px;
    padding: 15px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    flex-direction: column;
    margin-left:auto;
    margin-right:auto;
    align-items: center;
    text-align: center;
    transition: all 0.3s ease;
}

.reward-slot:hover {
    transform: translateY(-5px);
    border-color: rgba(255, 215, 0, 0.3);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}  
  
.reward-img {
    width: 80px;
    height: 80px;
    margin-left:auto;
    margin-right:auto;
    object-fit: cover;
    border-radius: 15px;
    margin-bottom: 10px;
}
  
.benefit-value.comum {
  background-color: #cccccc33;
  color: #ccc;
  padding: 4px 8px;
  border-radius: 25px;
}

.benefit-value.raro {
  background-color: #3498db4d;
  color: #3498db;
  padding: 4px 8px;
  border-radius: 25px;
}

.benefit-value.epico {
  background-color: #9c27b033;
  color: #9c27b0;
  padding: 4px 8px;
  border-radius: 25px;
}

.benefit-value.lendario {
  background-color: #ff980033;
  color: #ff9800;
  padding: 4px 8px;
  border-radius: 25px;
}
  
  
@media (max-width: 480px) {
    .vip-hero-title {
        font-size: 1.8rem;
    }
    
    .vip-hero-subtitle {
        font-size: 1rem;
    }
    
    .points-value {
        font-size: 2rem;
    }
    
    .level-badge {
        flex-direction: column;
        gap: 10px;
    }
    
    .level-symbol {
        width: 90px;
        height: 90px;
    }
    
    .benefit-tab {
        padding: 12px 15px;
        font-size: 0.9rem;
    }
    
    .reward-item {
        padding: 15px;
    }
    
    .reward-icon {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
}
</style>