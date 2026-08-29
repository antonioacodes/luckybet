<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>Carregando roleta...</span>
            </div>
        </LoadingComponent>
        
        <div v-if="!isLoading" class="roulette-container sm:max-w-[690px] mx-auto w-full">
            <!-- Test Mode Banner -->
            <div v-if="testMode" class="test-mode-banner">
                <div class="test-banner-content">
                    <span class="test-icon">🧪</span>
                    <div class="test-info">
                        <strong>MODO TESTE ATIVO</strong>
                        <span>Roleta sempre disponível para testes</span>
                    </div>
                    <span class="test-warning">Altere testMode para false em produção</span>
                </div>
            </div>
            
            <!-- Hero Section -->
            <div class="roulette-hero">
                <div class="hero-content">
                    <div class="roulette-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#FFD700" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="6" stroke="#FFD700" stroke-width="1" fill="none"/>
                            <circle cx="12" cy="12" r="2" fill="#FFD700"/>
                            <path d="M12 2L13 6L12 10L11 6L12 2Z" fill="#FFD700"/>
                            <path d="M22 12L18 13L14 12L18 11L22 12Z" fill="#FFD700"/>
                            <path d="M12 22L11 18L12 14L13 18L12 22Z" fill="#FFD700"/>
                            <path d="M2 12L6 11L10 12L6 13L2 12Z" fill="#FFD700"/>
                        </svg>
                    </div>
                    <h1 class="hero-title">Roleta da Sorte</h1>
                    <p class="hero-subtitle">Gire uma vez por dia e ganhe prêmios incríveis!</p>
                </div>
                
                <!-- User Status -->
                <div class="user-status-card">
                    <div class="user-info">
                        <div class="user-rank" :class="userRankClass">
                            <img v-if="userRankIcon" :src="userRankIcon" :alt="userRankName" class="rank-icon" />
                            <div class="rank-details">
                                <div class="user-name">{{ user?.name || 'Jogador' }}</div>
                                <div class="rank-name">{{ userRankName }} - Nível {{ userLevel }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="level-progress" v-if="nextLevelRequired">
                        <div class="progress-info">
                            <span>Progresso para Nível {{ userLevel + 1 }}</span>
                            <span>{{ userPoints }}/{{ nextLevelRequired }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" :style="{ width: `${progressPercentage}%` }"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spin Status -->
            <div class="spin-status-section">
                <div v-if="showTimer" class="timer-card">
                    <div class="timer-icon">⏰</div>
                    <div class="timer-content">
                        <h4>Próximo Giro Disponível em:</h4>
                        <div class="countdown-timer">{{ formattedTimeRemaining }}</div>
                        <p>Você já girou hoje! Volte amanhã para mais prêmios.</p>
                    </div>
                </div>
                
                <div v-else-if="!hasRecentDeposit" class="requirement-card">
                    <div class="requirement-icon">💳</div>
                    <div class="requirement-content">
                        <h3>Desbloqueie a Roleta!</h3>
                        <p>Faça um depósito ou convide um amigo para girar a roleta</p>
                        <div class="action-buttons">
                            <button class="deposit-btn" @click="openDepositModal">
                                <span class="btn-icon">💰</span>
                                Depositar
                            </button>
                            <button class="refer-btn" @click="openReferModal">
                                <span class="btn-icon">👥</span>
                                Convidar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div v-else-if="spinsAvailable > 0" class="available-card">
                    <div class="available-icon">🎯</div>
                    <div class="available-content">
                        <h3>Roleta Disponível!</h3>
                        <p>Você tem <strong>{{ spinsAvailable }} giro</strong> disponível hoje</p>
                        <button 
                            :class="['spin-button', { 'spinning': spinning }]" 
                            @click="startSpin" 
                            :disabled="spinning"
                        >
                            <span v-if="!spinning" class="btn-icon">🎲</span>
                            <span v-else class="spinning-icon">⚡</span>
                            {{ spinning ? 'Girando...' : 'Girar Roleta' }}
                        </button>
                    </div>
                </div>
                
                <div v-else class="no-spins-card">
                    <div class="no-spins-icon">😴</div>
                    <div class="no-spins-content">
                        <h3>Nenhum Giro Disponível</h3>
                        <p>Complete os requisitos para desbloquear sua roleta diária</p>
                    </div>
                </div>
            </div>

            <!-- Roulette Wheel -->
            <div class="roulette-wheel-section">
                <div class="wheel-container">
                    <!-- Selector Arrow -->
                    <div class="wheel-selector">
                        <div class="selector-arrow"></div>
                    </div>
                    
                    <!-- Spinning Wheel -->
                    <div 
                        :class="['prize-wheel', { 'spinning': spinning }]"
                        :style="{ transform: `rotate(${wheelRotation}deg)` }"
                    >
                        <div 
                            v-for="(prize, index) in prizes" 
                            :key="index"
                            class="wheel-segment"
                            :style="{ 
                                transform: `rotate(${(360 / prizes.length) * index}deg)`,
                                backgroundColor: getSegmentColor(index)
                            }"
                        >
                            <div 
                                class="segment-content"
                                :style="{ transform: `rotate(${360 / prizes.length / 2}deg)` }"
                            >
                                <img :src="prize.image" :alt="prize.name" class="prize-icon" />
                                <span class="prize-name">{{ prize.shortName }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Center Circle -->
                    <div class="wheel-center">
                        <div class="center-logo">
                            <span>🍀</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prizes List -->
            <div class="prizes-list-section">
                <div class="section-header">
                    <h2>Prêmios Disponíveis</h2>
                    <p>Veja todos os prêmios que você pode ganhar</p>
                </div>
                
                <div class="prizes-grid">
                    <div 
                        v-for="(prize, index) in prizes" 
                        :key="index"
                        :class="['prize-card', { 'won': prize.won }]"
                    >
                        <div class="prize-image">
                            <img :src="prize.image" :alt="prize.name" />
                            <div v-if="prize.won" class="won-badge">✓</div>
                        </div>
                        <div class="prize-details">
                            <div class="prize-title">{{ prize.name }}</div>
                            <div class="prize-description">{{ prize.description }}</div>
                            <div class="prize-rarity" :class="prize.rarity">{{ prize.rarity }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Winners -->
            <div class="recent-winners-section">
                <div class="section-header">
                    <h2>🏆 Ganhadores Recentes</h2>
                </div>
                
                <div class="winners-list">
                    <div 
                        v-for="winner in recentWinners" 
                        :key="winner.id"
                        class="winner-item"
                    >
                        <div class="winner-avatar">
                            <img src="https://i.imgur.com/oyF7jMW.png" :alt="winner.name" />
                        </div>
                        <div class="winner-info">
                            <div class="winner-name">{{ winner.name }}</div>
                            <div class="winner-prize">ganhou {{ winner.prize }}</div>
                        </div>
                        <div class="winner-time">{{ formatTimeAgo(winner.time) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prize Modal 
        <div class="prize-modal-overlay" v-if="showPrizeModal" @click="closePrizeModal">
            <div class="prize-modal" @click.stop>
                <div class="modal-header">
                    <h2>🎉 Parabéns!</h2>
                    <button class="close-btn" @click="closePrizeModal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <div class="prize-showcase">
                        <div class="prize-image-large">
                            <img :src="currentPrize?.image" :alt="currentPrize?.name" />
                        </div>
                        <h3>Você ganhou:</h3>
                        <div class="prize-name-large">{{ currentPrize?.name }}</div>
                        <div class="prize-value">{{ currentPrize?.value }}</div>
                        <p class="prize-message">{{ currentPrize?.message }}</p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="claim-prize-btn" @click="claimPrize">
                        <span class="btn-icon">💎</span>
                        Resgatar Prêmio
                    </button>
                </div>
            </div>
        </div>
    
            <div v-if="prizeType" class="text-center mt-4">
                <p>Você ganhou: {{ prizeType.toUpperCase() }}</p>
                <button @click="claimReward(prizeType)" class="btn btn-primary mt-2">
                    Resgatar Prêmio
                </button>
            </div>
            <div class="prize-modal-overlay" v-if="confirmPrizeModal" @click="confirmPrizeModal = false">
                <div class="prize-modal" @click.stop>
                    <div class="modal-header">
                        <h2>🎉 Parabéns!</h2>
                        <button class="close-btn" @click="confirmPrizeModal = false">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="prize-showcase">
                            <div class="prize-image-large emoji-only">
                              <h2>🎁</h2>
                            </div>
                            <h3>Seu prêmio já está disponível!</h3>
                            <p class="prize-message text-lg">Parabéns, seu prêmio já está em <strong>Seus Benefícios Atuais</strong> no <strong>Clube VIP</strong>!</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="claim-prize-btn" @click="confirmPrizeModal = false">
                            OK
                        </button>
                    </div>
                </div>
            </div>-->
      
      <!--modo teste SEM RODADAS GRATIS-->
      		        <div class="prize-modal-overlay" v-if="showPrizeModal" @click="closePrizeModal">
            <div class="prize-modal" @click.stop>
                <div class="modal-header">
                    <h2>❌ Que Pena!</h2>
                    <button class="close-btn" @click="closePrizeModal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <div class="prize-showcase">
                        <div class="prize-image-large">
                            <img :src="currentPrize?.image" :alt="currentPrize?.name" />
                        </div>
                        <h3>Não foi dessa vez!</h3>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="claim-prize-btn" @click="claimPrize">
                        Voltar
                    </button>
                </div>
            </div>
        </div>
    
            <div v-if="prizeType" class="text-center mt-4">
                <p>Não foi dessa vez!</p>
                <button @click="claimReward(prizeType)" class="btn btn-primary mt-2">
                    Voltar
                </button>
            </div>
            <div class="prize-modal-overlay" v-if="confirmPrizeModal" @click="confirmPrizeModal = false">
                <div class="prize-modal" @click.stop>
                    <div class="modal-header">
                        <h2>❌ Tente Novamente!</h2>
                        <button class="close-btn" @click="confirmPrizeModal = false">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="prize-showcase">
                            <div class="prize-image-large emoji-only">
                              <h2>🎁</h2>
                            </div>
                            <h3>Seu Prêmio Não Veio!</h3>
                            <p class="prize-message text-lg">Não desanime, aguarde o tempo e volte para <strong>Girar Outra Vez!</strong>!</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="claim-prize-btn" @click="confirmPrizeModal = false">
                            OK
                        </button>
                    </div>
                </div>
            </div>
<!--modo teste SEM RODADAS GRATIS-->
</BaseLayout>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HttpApi from '@/Services/HttpApi';

export default {
    name: 'DailyRoulette',
    components: { BaseLayout, LoadingComponent },
    data() {
        return {
            isLoading: true,
            
            // CONFIGURAÇÃO DE TESTE - ALTERE PARA PRODUÇÃO
            testMode: false, // true = teste (sempre disponível), false = produção (1x por dia)
            
            // User Data
            user: null,
            userLevel: 1,
            userPoints: 0,
            userRankClass: 'bronze',
            userRankName: 'Bronze',
            userRankIcon: '',
            nextLevelRequired: 100,
            
            // Spin Status
            spinsAvailable: 0,
            hasRecentDeposit: false,
            showTimer: false,
            timeRemaining: 0,
            timerInterval: null,
            lastSpinDate: null,
            
            // Roulette Animation
            spinning: false,
            wheelRotation: 0,
            selectedPrizeIndex: null,
            
            // Prize Modal
            showPrizeModal: false,
            currentPrize: null,
          	confirmPrizeModal: false,

            
            // Prizes Data
            prizes: [
                {
                    name: "5 Giros Grátis",
                    shortName: "5 giros",
                    description: "Giros grátis para slots selecionado",
                    image: "https://d3fwl9ttzumvxe.cloudfront.net/rewards/1e55814e7bcd1e304f1eb06b07d4e421.png",
                    value: "5 Free Spins",
                    message: "Seus giros grátis estão disponíveis nos slots!",
                    rarity: "raro",
                    won: false
                },
                {
                    name: "3 Giros Grátis",
                    shortName: "3 Giros",
                    description: "Giros grátis para slots selecionado",
                    image: "https://d3fwl9ttzumvxe.cloudfront.net/rewards/ead61a79a951af8a20af63abdaaa7ad4.png",
                    value: "3 Free Spins",
                    message: "Seus giros grátis estão disponíveis nos slots!",
                    rarity: "comum",
                    won: false
                },
                {
                    name: "3 Giros Grátis",
                    shortName: "3 Giros",
                    description: "Giros grátis para slots selecionado",
                    image: "https://d3fwl9ttzumvxe.cloudfront.net/rewards/ead61a79a951af8a20af63abdaaa7ad4.png",
                    value: "3 Free Spins",
                    message: "Seus giros grátis estão disponíveis nos slots!",
                    rarity: "comum",
                    won: false
                },
                {
                    name: "10 Giros Grátis",
                    shortName: "10 Giros",
                    description: "Giros grátis para slots selecionado",
                    image: "https://d3fwl9ttzumvxe.cloudfront.net/rewards/c7d83e309e05e4c171302a5717dd8dea.png",
                    value: "10 Free Spins",
                    message: "Seus giros grátis estão disponíveis nos slots!",
                    rarity: "épico",
                    won: false
                },
                {
                    name: "15 Giros Grátis",
                    shortName: "15 Giros",
                    description: "Giros grátis para slots selecionado",
                    image: "https://d3fwl9ttzumvxe.cloudfront.net/rewards/670f08338da843498be373c66dbc6cc4.png",
                    value: "15 Free Spins",
                    message: "Seus giros grátis estão disponíveis nos slots!",
                    rarity: "lendário",
                    won: false
                },
                {
                    name: "3 Giros Grátis",
                    shortName: "3 Giros",
                    description: "Giros grátis para slots selecionado",
                    image: "https://d3fwl9ttzumvxe.cloudfront.net/rewards/ead61a79a951af8a20af63abdaaa7ad4.png",
                    value: "3 Free Spins",
                    message: "Seus giros grátis estão disponíveis nos slots!",
                    rarity: "comum",
                    won: false
                }
            ],
            
            // Recent Winners (Mock Data)
            recentWinners: [
                {
                    id: 1,
                    name: "João***",
                    prize: "R$ 100",
                    avatar: "/images/avatars/default1.png",
                    time: new Date(Date.now() - 300000) // 5 min ago
                },
                {
                    id: 2,
                    name: "Maria***",
                    prize: "50 Giros Grátis",
                    avatar: "/images/avatars/default2.png",
                    time: new Date(Date.now() - 900000) // 15 min ago
                },
                {
                    id: 3,
                    name: "Pedro***",
                    prize: "Cashback 10%",
                    avatar: "/images/avatars/default3.png",
                    time: new Date(Date.now() - 1800000) // 30 min ago
                }
            ]
        }
    },
    
    computed: {
        progressPercentage() {
            if (!this.nextLevelRequired || this.nextLevelRequired <= 0) return 0;
            return Math.min((this.userPoints / this.nextLevelRequired) * 100, 100);
        },
        
        formattedTimeRemaining() {
            const hours = Math.floor(this.timeRemaining / 3600);
            const minutes = Math.floor((this.timeRemaining % 3600) / 60);
            const seconds = this.timeRemaining % 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    },
    
    async created() {
        await this.loadUserData();
        await this.checkSpinAvailability();
        this.isLoading = false;
    },
    
    beforeUnmount() {
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
        }
    },
    
    methods: {
    finishSpin(result) {
        const prizeName = result.label.toLowerCase();
        if (['comum', 'raro', 'épico', 'lendário'].includes(prizeName)) {
            this.prizeType = prizeName;
        } else {
            this.prizeType = null;
        }
    },
    
    async claimReward(type) {
      console.log("Chamando claimReward com tipo:", type);
        try {
            const response = await HttpApi.post('rewards/claim-free-spins', {
                reward_type: type
            });

            if (response.data.status) {
                this.$toast.success(response.data.msg);
            } else {
                this.$toast.error(response.data.msg);
            }
        } catch (error) {
            this.$toast.error('Erro ao ativar rodadas grátis.');
        }
    },

        async loadUserData() {
            try {
                const response = await HttpApi.get('/profile/vip/');
                const { currentLevel, nextLevel, vipPoints, pointsToNextLevel, user } = response.data;
                
                this.user = user || { name: 'Jogador' };
                this.userLevel = currentLevel?.bet_level || 1;
                this.userPoints = vipPoints || 0;
                this.nextLevelRequired = nextLevel?.bet_required || 100;
                
                if (currentLevel) {
                    this.setUserRank(currentLevel.bet_level);
                    if (currentLevel.bet_symbol) {
                        this.userRankIcon = `/storage/${currentLevel.bet_symbol}`;
                    }
                }
            } catch (error) {
                console.error('Erro ao carregar dados do usuário:', error);
            }
        },
        
        setUserRank(level) {
            const ranks = {
                1: { class: 'bronze', name: 'Bronze' },
                2: { class: 'silver', name: 'Prata' },
                3: { class: 'gold', name: 'Ouro' },
                4: { class: 'platinum', name: 'Platina' },
                5: { class: 'diamond', name: 'Diamante' }
            };
            
            const rank = ranks[level] || ranks[1];
            this.userRankClass = rank.class;
            this.userRankName = rank.name;
        },
        
        async checkSpinAvailability() {
            try {
                //MODO TESTE - Remove esta seção em produção
                if (this.testMode) {
                    console.log('🧪 MODO TESTE ATIVO - Roleta sempre disponível');
                    this.hasRecentDeposit = true;
                    this.spinsAvailable = 1;
                    this.showTimer = false;
                    return;
                }
                
                // MODO PRODUÇÃO - Lógica normal
                 //Check for recent deposits (API call)
                this.hasRecentDeposit = await this.checkRecentDeposits();
                
                if (!this.hasRecentDeposit) {
                    this.spinsAvailable = 0;
                    return;
                }
                
                // Check daily spin status
                const lastSpin = localStorage.getItem('lastSpinDate');
                const today = new Date().toDateString();
                
                if (!lastSpin || lastSpin !== today) {
                    this.spinsAvailable = 1;
                    this.showTimer = false;
                } else {
                    this.spinsAvailable = 0;
                    this.setupTimer();
                }
            } catch (error) {
                console.error('Erro ao verificar disponibilidade:', error);
            }
        },

        async checkRecentDeposits() {
            try {
                // Simular chamada da API para verificar depósitos recentes
                // Substitua por sua lógica real de API
                const response = await HttpApi.get('/profile/deposits/recent');
                return response.data.hasRecentDeposit || false;
            } catch (error) {
                console.error('Erro ao verificar depósitos:', error);
                return false; // Assumir false em caso de erro
            }
        },
        
          setupTimer() {
              const now = new Date();

              // Corrigir para horário de Brasília (UTC-3)
              const brasiliaOffset = -3 * 60; // -180 minutos
              const localOffset = now.getTimezoneOffset(); // minutos do UTC local
              const offsetDiff = (brasiliaOffset - localOffset) * 60 * 1000;

              const brasiliaNow = new Date(now.getTime() + offsetDiff);

              const tomorrowBrasilia = new Date(
                  brasiliaNow.getFullYear(),
                  brasiliaNow.getMonth(),
                  brasiliaNow.getDate() + 1,
                  0, 0, 0
              );

              this.timeRemaining = Math.floor((tomorrowBrasilia - brasiliaNow) / 1000);

              if (this.timeRemaining > 0) {
                  this.showTimer = true;
                  this.startTimer();
              }
          },

          //if (this.timeRemaining > 0) {
             // this.timerInterval = setInterval(() => {
                //  this.timeRemaining--;
                //  if (this.timeRemaining <= 0) {
                  //    clearInterval(this.timerInterval);
                  //    this.spinsAvailable = 1;
                //      this.showTimer = false;
                //  } //CORRETO EM TESTES
            //  }, 1000);
          //}
      //},

        startTimer() {
            if (this.timerInterval) clearInterval(this.timerInterval);
            
            this.timerInterval = setInterval(() => {
                this.timeRemaining--;
                if (this.timeRemaining <= 0) {
                    clearInterval(this.timerInterval);
                    this.showTimer = false;
                    this.spinsAvailable = 1;
                }
            }, 1000);
        },
        
        startSpin() {
            if (this.spinning || this.spinsAvailable <= 0) return;
            
            this.spinning = true;
            
            // Em modo teste, não diminuir spinsAvailable para permitir múltiplos testes
            if (!this.testMode) {
                this.spinsAvailable = 0;
                // Save spin date apenas em produção
                localStorage.setItem('lastSpinDate', new Date().toDateString());
            }
            
            // Select random prize
            this.selectedPrizeIndex = Math.floor(Math.random() * this.prizes.length);
            
            // Calculate rotation for correct alignment
            const segmentAngle = 360 / this.prizes.length; // 45 degrees per segment (360/8)
            
            // Calculate the angle for the selected prize
            // The first segment (index 0) starts at 0 degrees
            // We need to account for the fact that the pointer is at the top (12 o'clock position)
            const prizeAngle = this.selectedPrizeIndex * segmentAngle;
            
            // To align the selected segment with the top pointer, we need to rotate
            // so that the CENTER of the selected segment is at the top (0 degrees)
            // We add half a segment angle to center the segment under the pointer
            const targetAngle = -prizeAngle - (segmentAngle / 2);
            
            // Add multiple full rotations for visual effect (5 full spins)
            const fullRotations = 360 * 5;
            const finalRotation = fullRotations + targetAngle;
            
            this.wheelRotation = finalRotation;
            
            // Debug logs
            console.log('🎲 TESTE DA ROLETA:');
            console.log('Prêmio selecionado (índice):', this.selectedPrizeIndex);
            console.log('Prêmio:', this.prizes[this.selectedPrizeIndex].name);
            console.log('Ângulo do segmento:', segmentAngle + '°');
            console.log('Rotação final:', finalRotation + '°');
            console.log('Modo teste ativo:', this.testMode);
            
            // Show result after animation
            setTimeout(() => {
                this.spinning = false;
                this.showPrizeResult();
                
                // Setup timer apenas em modo produção
                if (!this.testMode) {
                    this.setupTimer();
                }
            }, 4000);
        },
        
        showPrizeResult() {
            this.currentPrize = this.prizes[this.selectedPrizeIndex];
            this.showPrizeModal = true;
            this.prizes[this.selectedPrizeIndex].won = true;
        },
        
        async claimPrize() {
            if (this.testMode) {
                this.$toast?.success?.(`Teste: ${this.currentPrize.name} reivindicado!`);

                // Fecha o primeiro modal
                this.showPrizeModal = false;

                // Aguarda 300ms e abre o modal de confirmação com a imagem ainda presente
                setTimeout(() => {
                    this.confirmPrizeModal = true;
                }, 300);
            } else {
                await this.sendPrizeToServer(this.currentPrize);
            }



            
            this.closePrizeModal();
        },
        
        async sendPrizeToServer(prize) {
    try {
        const response = await HttpApi.post('roulette/claim-prize', {
            user_id: this.user?.id,
            prize_index: this.selectedPrizeIndex,
            prize_name: prize.name,
            prize_value: prize.value,
            spin_date: new Date().toISOString()
        });

        if (response.data.success || response.data.status === true) {
            this.$toast?.success?.("🎉 Parabéns, seu prêmio já está em Seus Benefícios Atuais no Clube VIP!");
            this.confirmPrizeModal = true;
        } else {
            this.$toast?.error?.('Erro ao creditar prêmio. Contate o suporte.');
        }
    } catch (error) {
        console.error('Erro ao enviar prêmio para servidor:', error);
        this.$toast?.error?.('Erro de conexão. Tente novamente.');
    }

    // Fecha o modal de roleta após processar
    this.showPrizeModal = false;
},
        
        closePrizeModal() {
            this.showPrizeModal = false;
            this.currentPrize = null;
        },
        
        openDepositModal() {
            window.location.href = '/profile/deposit';
        },
        
        openReferModal() {
            window.location.href = '/profile/affiliate';
        },
        
        getSegmentColor(index) {
            const colors = [
                '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
                '#FFEAA7', '#DDA0DD', '#98D8C8', '#F7DC6F'
            ];
            return colors[index % colors.length];
        },
        
        formatTimeAgo(time) {
            const diff = Date.now() - time.getTime();
            const minutes = Math.floor(diff / 60000);
            
            if (minutes < 60) return `${minutes}m atrás`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours}h atrás`;
            const days = Math.floor(hours / 24);
            return `${days}d atrás`;
        }
    }
};
</script>

<style scoped>
.roulette-container {
    margin: 0 auto;
    padding: 20px;
    min-height: 100vh;
}

/* Test Mode Banner */
.test-mode-banner {
    background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 20px;
    border: 2px solid #FF6347;
    animation: testPulse 2s infinite;
}

@keyframes testPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

.test-banner-content {
    display: flex;
    align-items: center;
    gap: 15px;
    color: #000;
    font-weight: 600;
}

.test-icon {
    font-size: 2rem;
    animation: bounce 1s infinite;
}

.test-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.test-info strong {
    font-size: 1.1rem;
}

.test-info span {
    font-size: 0.9rem;
    opacity: 0.8;
}

.test-warning {
    background: rgba(255, 0, 0, 0.2);
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 0.8rem;
    border: 1px solid rgba(255, 0, 0, 0.3);
}

/* Hero Section */
.roulette-hero {
    background: linear-gradient(135deg, #0a0eb2, #474bde);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    box-shadow: 0 20px 40px rgba(45, 49, 203, 0.3);
    position: relative;
    overflow: hidden;
}

.roulette-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.hero-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 2;
}

.roulette-icon {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: spin 10s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.hero-title {
    font-size: 1.8rem;
    font-weight: 500;
    margin: 0;
}

.hero-subtitle {
    font-size: 0.8rem;
    opacity: 0.9;
    margin: 0;
}

/* User Status Card */
.user-status-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 30px;
    min-width: 300px;
    z-index: 2;
}

.user-rank {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.rank-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
}

.rank-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 3px;
}

.rank-name {
    font-size: 1rem;
    opacity: 0.8;
}

.rank-name.bronze { color: #CD7F32; }
.rank-name.silver { color: #C0C0C0; }
.rank-name.gold { color: #FFD700; }
.rank-name.platinum { color: #E5E4E2; }
.rank-name.diamond { color: #B9F2FF; }

.level-progress {
    margin-top: 15px;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 0.9rem;
    opacity: 0.8;
}

.progress-bar {
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #FFD700 0%, #FFA500 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

/* Spin Status Section */
.spin-status-section {
    margin-bottom: 40px;
}

.timer-card,
.requirement-card,
.available-card,
.no-spins-card {
    background: var(--ci-gray-medium);
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    border: 2px solid;
}

.timer-card {
    border-color: #FF6B6B;
    background: rgba(255, 107, 107, 0.1);
}

.requirement-card {
    border-color: #FFD700;
    background: rgba(255, 215, 0, 0.1);
}

.available-card {
    border-color: #4ECDC4;
    background: rgba(78, 205, 196, 0.1);
}

.no-spins-card {
    border-color: #95A5A6;
    background: rgba(149, 165, 166, 0.1);
}

.timer-icon,
.requirement-icon,
.available-icon,
.no-spins-icon {
    font-size: 2.4rem;
    margin-bottom: 15px;
    display: block;
}

.timer-content h3,
.requirement-content h3,
.available-content h3,
.no-spins-content h3 {
    color: #fff;
    font-size: 1.8rem;
    margin: 0 0 15px 0;
}

.countdown-timer {
    font-size: 2.2rem;
    font-weight: 600;
    color: #FF6B6B;
    margin: 20px 0;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 20px;
}

.deposit-btn,
.refer-btn,
.spin-button {
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top:7px;
    align-items: center;
    gap: 10px;
}

.deposit-btn {
    background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
    color: #fff;
}

.refer-btn {
    background: linear-gradient(135deg, #A8E6CF 0%, #7FCDCD 100%);
    color: #2C3E50;
}

.spin-button {
    background: linear-gradient(135deg, #0a0eb2, #474bde);
    color: #fff;
    font-size: 1.3rem;
    padding: 20px 40px;
}

.spin-button.spinning {
    background: linear-gradient(135deg, #95A5A6 0%, #7F8C8D 100%);
    cursor: not-allowed;
}

.spin-button:hover:not(.spinning) {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(49, 53, 206, 0.4);
}

.spinning-icon {
    animation: spin 1s linear infinite;
}

/* Roulette Wheel */
.roulette-wheel-section {
    margin-bottom: 50px;
    display: flex;
    justify-content: center;
}

.wheel-container {
    position: relative;
    width: 500px;
    height: 500px;
}

.wheel-selector {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.selector-arrow {
    width: 0;
    height: 0;
    border-left: 20px solid transparent;
    border-right: 20px solid transparent;
    border-top: 40px solid #FFD700;
    filter: drop-shadow(0 5px 10px rgba(255, 215, 0, 0.5));
}

.prize-wheel {
    width: 500px;
    height: 500px;
    border-radius: 50%;
    position: relative;
    border: 8px solid #FFD700;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
    transition: transform 4s cubic-bezier(0.23, 1, 0.32, 1);
}

.prize-wheel.spinning {
    animation: wheelGlow 0.5s ease-in-out infinite alternate;
}

@keyframes wheelGlow {
    from { box-shadow: 0 0 30px rgba(255, 215, 0, 0.5); }
    to { box-shadow: 0 0 50px rgba(255, 215, 0, 0.8); }
}

.wheel-segment {
    position: absolute;
    width: 50%;
    height: 50%;
    top: 50%;
    left: 50%;
    transform-origin: 0 0;
    clip-path: polygon(0 0, 86.6% 50%, 0 100%);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.segment-content {
    position: absolute;
    top: 25px;
    left: 60%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
}

.prize-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
}

.prize-name {
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
}

.wheel-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    z-index: 5;
}

.center-logo {
    font-size: 2rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Prizes List */
.prizes-list-section,
.recent-winners-section {
    background: var(--ci-gray-medium);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
}

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

.prizes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.prize-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 20px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 20px;
}

.prize-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.5);
}

.prize-card.won {
    border-color: #4ECDC4;
    background: rgba(78, 205, 196, 0.1);
}

.prize-image {
    position: relative;
    flex-shrink: 0;
}

.prize-image img {
    width: 60px;
    height: 60px;
    border-radius: 10px;
}

.won-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #4ECDC4;
    color: #fff;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: bold;
}

.prize-details {
    flex: 1;
}

.prize-title {
    color: #fff;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.prize-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.prize-rarity {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.prize-rarity.comum {
    background: rgba(149, 165, 166, 0.3);
    color: #95A5A6;
}

.prize-rarity.raro {
    background: rgba(52, 152, 219, 0.3);
    color: #3498DB;
}

.prize-rarity.épico {
    background: rgba(155, 89, 182, 0.3);
    color: #9B59B6;
}

.prize-rarity.lendário {
    background: rgba(241, 196, 15, 0.3);
    color: #F1C40F;
}

/* Recent Winners */
.winners-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-height: 400px;
    overflow-y: auto;
}

.winner-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.winner-item:hover {
    border-color: rgba(78, 205, 196, 0.5);
}

.winner-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: bold;
}

.winner-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.winner-info {
    flex: 1;
}

.winner-name {
    color: #fff;
    font-weight: 600;
    margin-bottom: 3px;
}

.winner-prize {
    color: #4ECDC4;
    font-size: 0.9rem;
}

.winner-time {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.8rem;
}

/* Prize Modal */
.prize-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.prize-modal {
    background: linear-gradient(135deg, #1A1F3A 0%, #2D3561 100%);
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    border: 2px solid #FFD700;
    overflow: hidden;
    animation: modalSlideIn 0.4s ease-out;
}

@keyframes modalSlideIn {
    from { 
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #000;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.close-btn {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #000;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.close-btn:hover {
    background: rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: 40px 30px;
    text-align: center;
}

.prize-showcase {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.prize-image-large {
    width: 120px;
    height: 120px;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #FFD700;
    animation: prize-glow 1.5s ease-in-out infinite alternate;
}

@keyframes prize-glow {
    from { box-shadow: 0 0 20px rgba(255, 215, 0, 0.5); }
    to { box-shadow: 0 0 40px rgba(255, 215, 0, 0.8); }
}

.prize-image-large img {
    width: 80px;
    height: 80px;
    border-radius: 10px;
}

.prize-showcase h3 {
    color: #fff;
    font-size: 1.5rem;
    margin: 0;
}

.prize-name-large {
    color: #FFD700;
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
}

.prize-value {
    color: #4ECDC4;
    font-size: 1.5rem;
    font-weight: 600;
}

.prize-message {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin: 0;
}

.modal-footer {
    padding: 20px 30px 30px;
    text-align: center;
}

.claim-prize-btn {
    background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
    color: #fff;
    border: none;
    padding: 15px 40px;
    border-radius: 15px;
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.claim-prize-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(78, 205, 196, 0.4);
}

.btn-icon {
    font-size: 1.2rem;
}

/* Responsive Design - APENAS A CORREÇÃO PARA MOBILE */
@media (max-width: 768px) {
    .roulette-container {
        padding: 15px;
    }
    
    .roulette-hero {
        flex-direction: column;
        text-align: center;
        gap: 25px;
        padding: 30px 20px;
    }
    
    .hero-title {
        font-size: 1.6rem;
    }
    
    .user-status-card {
        min-width: auto;
        width: 100%;
    }
    
    .wheel-container {
        width: 350px;
        height: 350px;
    }
    
    .prize-wheel {
        width: 350px;
        height: 350px;
    }
    
    .wheel-center {
        width: 60px;
        height: 60px;
    }
    
    .center-logo {
        font-size: 1.5rem;
    }
    
    .segment-content {
        top: 15px;
    }
    
    .prize-icon {
        width: 30px;
        height: 30px;
    }
    
    /* CORREÇÃO: Ocultar textos da roleta no mobile */
    .prize-name {
        display: none;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .prizes-grid {
        grid-template-columns: 1fr;
    }
    
    .prize-card {
        flex-direction: column;
        text-align: center;
    }
    
    .countdown-timer {
        font-size: 2rem;
    }
    
    .prize-modal {
        width: 95%;
        margin: 10px;
    }
    
    .modal-body {
        padding: 30px 20px;
    }
    
    .prize-name-large {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .wheel-container {
        width: 280px;
        height: 280px;
    }
    
    .prize-wheel {
        width: 280px;
        height: 280px;
    }
    
    .spin-button {
        padding: 15px 30px;
        font-size: 1.1rem;
    }
    
    .countdown-timer {
        font-size: 1.5rem;
    }
    
    /* GARANTIR que textos fiquem ocultos em telas muito pequenas */
    .prize-name {
        display: none !important;
    }
}
.prize-image-large.emoji-only {
  font-size: 4rem;
  line-height: 1;
}

</style>