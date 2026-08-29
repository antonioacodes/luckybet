<template>
  <div>
    <BaseLayout>
      <LoadingComponent :isLoading="isLoading">
        <div class="text-center">
          <span>Carregando missões...</span>
        </div>
      </LoadingComponent>

      <div v-if="!isLoading" class="Au03f">
        <div class="UrrmK">
          <div class="_6klzZ" style="margin-left: 8px;margin-right: 10px;padding-top: 15px;">
            <div class="EVx0-">
              <!-- Header -->
              <header class="PAItV">
                <div class="smUTk">
                  <button class="_8s2Sx" @click="goBack">
                    <svg width="1em" height="1em" viewBox="0 0 448 512" xmlns="http://www.w.org/2000/svg"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"/></svg>
                  </button>
                  <h1 class="hFWlQ">Missões</h1>
                  <div class="_0UgdA">
                    <button @click="refreshMissions" :disabled="refreshing">
                      <svg width="1em" height="1em" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" :class="{ 'rotating': refreshing }"><path d="M449.9 39.96l-48.5 48.53C362.5 53.19 311.4 32 256 32C161.5 32 78.59 92.34 49.58 182.2c-5.438 16.81 3.797 34.88 20.61 40.28c16.97 5.5 34.86-3.812 40.3-20.59C130.9 138.5 189.4 96 256 96c37.96 0 73 14.18 100.2 37.8L311.1 178C295.1 194.8 306.8 223.4 330.4 224h146.9C487.7 223.7 496 215.3 496 204.9V59.04C496 34.99 466.9 22.95 449.9 39.96z" fill="currentColor"/><path d="M462.4 329.8C433.4 419.7 350.4 480 255.1 480c-55.41 0-106.5-21.19-145.4-56.49l-48.5 48.53C45.07 489 16 477 16 452.1V307.1C16 296.7 24.32 288.3 34.66 288h146.9c23.57 .5781 35.26 29.15 18.43 46l-44.18 44.2C183 401.8 218 416 256 416c66.58 0 125.1-42.53 145.5-105.8c5.422-16.78 23.36-26.03 40.3-20.59C458.6 294.1 467.9 313 462.4 329.8z" fill="currentColor" opacity="0.4"/></svg>
                    </button>
                  </div>
                </div>
              </header>

              <!-- Missão em Destaque (CARD SIMPLIFICADO) -->
              <div v-if="featuredMission" class="Ma4oh fwzjA">
                <div class="defaultItemBox featuredMission glow-border">
                  <div v-if="featuredMission.status === 'upcoming'" class="tagBox upcoming">
                    <span>Em breve</span>
                  </div>
                  <div class="imgWrap">
                    <img :src="getGameImage(featuredMission)" :alt="featuredMission.title" />
                  </div>
                  <div class="defaultBoxContent">
                    <div v-if="featuredMission.status === 'upcoming'" class="timerBox upcoming">
                      Começa em: <span>{{ formatTimer(featuredMission.time_to_start) }}</span>
                    </div>
                    <div v-else-if="featuredMission.status === 'active'" class="timerBox">
                      Tempo restante: <span>{{ formatTimer(featuredMission.time_to_end) }}</span>
                    </div>
                    <div class="titleBox">{{ featuredMission.title }}</div>
                    <div v-if="featuredMission.description" class="missionDescription">
                      {{ featuredMission.description }}
                    </div>
                    <div class="priceBox">{{ featuredMission.reward_display || featuredMission.reward }}</div>
                    
                    <!-- BOTÃO AGORA ABRE O MODAL -->
                    <div v-if="featuredMission.user_progress?.participated && !featuredMission.user_progress?.completed" class="progressBox">
                    <div class="progressLabel">
                        Progresso: {{ Math.min(featuredMission.user_progress.progress, featuredMission.target).toFixed(0) }} / {{ featuredMission.target }}
                    </div>
                    <div class="progressBar">
                        <div 
                        class="progressBarFill" 
                        :style="{ width: Math.min((featuredMission.user_progress.progress / featuredMission.target) * 100, 100) + '%' }"
                        ></div>
                    </div>
                    </div>

                    <div class="actionBox">
                    <!-- Botão RESGATAR -->
                    <button 
                        v-if="featuredMission.user_progress?.completed && !featuredMission.user_progress?.claimed" 
                        @click="claimReward(featuredMission.id)" 
                        class="claim-btn"
                    >
                        🎁 Resgatar Recompensa!
                    </button>

                    <!-- Botão RESGATADO -->
                    <button 
                        v-else-if="featuredMission.user_progress?.claimed" 
                        class="claimed-btn" 
                        disabled
                    >
                        ✅ Resgatado
                    </button>

                    <!-- Botão CONTINUAR -->
                    <button 
                        v-else-if="featuredMission.user_progress?.participated && !featuredMission.user_progress?.completed" 
                        @click="openMissionModal(featuredMission)" 
                        class="play-btn"
                    >
                        🎮 Continuar
                    </button>

                    <!-- Botão PARTICIPAR -->
                    <button 
                        v-else-if="featuredMission.status === 'active'" 
                        @click="openMissionModal(featuredMission)" 
                        class="play-btn"
                    >
                        Participar Agora!
                    </button>

                    <!-- Botão SABER MAIS -->
                    <button 
                        v-else-if="featuredMission.status === 'upcoming'" 
                        @click="openMissionModal(featuredMission)" 
                        class="upcoming-btn"
                    >
                        Saber Mais
                    </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Lista de Missões Normais (CARDS SIMPLIFICADOS) -->
              <div v-if="missions.length > 0" class="Ma4oh">
                <div v-for="mission in missions" :key="mission.id" class="defaultItemBox">
                  <div v-if="mission.status === 'upcoming'" class="tagBox upcoming">
                    <span>Em breve</span>
                  </div>
                  <div class="imgWrap">
                    <img :src="getGameImage(mission)" :alt="mission.title" />
                  </div>
                  <div class="defaultBoxContent">
                    <div v-if="mission.status === 'upcoming'" class="timerBox upcoming">
                      Começa em: <span>{{ formatTimer(mission.time_to_start) }}</span>
                    </div>
                    <div v-else-if="mission.status === 'active'" class="timerBox">
                      Tempo restante: <span>{{ formatTimer(mission.time_to_end) }}</span>
                    </div>
                    <div class="titleBox smaller">{{ mission.title }}</div>
                    <div v-if="mission.description" class="missionDescription">
                      {{ mission.description }}
                    </div>
                    <div class="priceBox inlined">{{ mission.reward_display || mission.reward }}</div>
                    
                    <!-- BOTÃO AGORA ABRE O MODAL -->
                    <div v-if="mission.user_progress?.participated && !mission.user_progress?.completed" class="progressBox">
                    <div class="progressLabel">
                        {{ Math.min(mission.user_progress.progress, mission.target).toFixed(0) }} / {{ mission.target }}
                    </div>
                    <div class="progressBar">
                        <div 
                        class="progressBarFill" 
                        :style="{ width: Math.min((mission.user_progress.progress / mission.target) * 100, 100) + '%' }"
                        ></div>
                    </div>
                    </div>

                    <div class="actionBox">
                    <button 
                        v-if="mission.user_progress?.completed && !mission.user_progress?.claimed" 
                        @click="claimReward(mission.id)" 
                        class="claim-btn"
                    >
                        🎁 Resgatar
                    </button>

                    <button 
                        v-else-if="mission.user_progress?.claimed" 
                        class="claimed-btn" 
                        disabled
                    >
                        ✅ Resgatado
                    </button>

                    <button 
                        v-else-if="mission.user_progress?.participated && !mission.user_progress?.completed" 
                        @click="openMissionModal(mission)" 
                        class="play-btn"
                    >
                        🎮 Continuar
                    </button>

                    <button 
                        v-else-if="mission.status === 'active'" 
                        @click="openMissionModal(mission)" 
                        class="play-btn"
                    >
                        Participar Agora!
                    </button>

                    <button 
                        v-else-if="mission.status === 'upcoming'" 
                        @click="openMissionModal(mission)" 
                        class="upcoming-btn"
                    >
                        Saber Mais
                    </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Estado Vazio -->
              <div v-if="!featuredMission && missions.length === 0" class="empty-state">
                <div class="empty-icon">🎯</div>
                <h3>Nenhuma missão disponível</h3>
                <p>Novas missões em breve!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- MODAL DE CONFIRMAÇÃO -->
<div class="prize-modal-overlay" v-if="confirmPrizeModal" @click="confirmPrizeModal = false">
  <div class="prize-modal" @click.stop>
    <div class="modal-header">
      <h2>🎉 Parabéns!</h2>
      <button class="close-btn" @click="confirmPrizeModal = false">Voltar</button>
    </div>
    <div class="modal-body">
      <div class="prize-showcase">
        <div class="prize-image-large emoji-only">
          <h2>🎁</h2>
        </div>
        <h3>Seu prêmio já está disponível!</h3>
        <p class="prize-message text-lg">
          Parabéns, seu prêmio já está em <strong>Seus Benefícios Atuais</strong> no <strong>Clube VIP</strong>!
        </p>
      </div>
    </div>
    <div class="modal-footer">
      <button class="claim-prize-btn" @click="confirmPrizeModal = false">
        OK
      </button>
    </div>
  </div>
</div>

    </BaseLayout>

    <!-- O MODAL SENDO USADO AQUI -->
    <MissionDetailsModal 
      :mission="selectedMission" 
      :is-featured="selectedMission?.id === featuredMission?.id"
      :visible="isModalVisible"
      @close="closeMissionModal"
      @play="playGame"
      @claim="claimReward"
    />
  </div>
</template>

<script>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import LoadingComponent from '@/Components/UI/LoadingComponent.vue';
import MissionDetailsModal from '@/Pages/Home/Components/MissionDetailsModal.vue'; // 1. Importar o novo modal
import axios from 'axios';

export default {
  name: 'MissionsPage',
  components: {
    BaseLayout,
    LoadingComponent,
    MissionDetailsModal // 2. Registrar o componente
  },
  data() {
    return {
      isLoading: true,
      refreshing: false,
      featuredMission: null,
      missions: [],
      timerInterval: null,
      confirmPrizeModal: false,
      isModalVisible: false,
      selectedMission: null
    };
  },
  mounted() {
    this.fetchMissions();
    this.startTimers();
  },
  beforeUnmount() {
    this.stopTimers();
  },
  methods: {
    // 4. Adicionar métodos para abrir/fechar o modal
    openMissionModal(mission) {
      console.log('CLICOU! Tentando abrir o modal para a missão:', mission);
      this.selectedMission = mission;
      this.isModalVisible = true;
      console.log('Estado do modal atualizado:', this.isModalVisible);

    },
    closeMissionModal() {
      this.isModalVisible = false;
      // Opcional: resetar a missão selecionada após a animação de fechar
      setTimeout(() => {
        this.selectedMission = null;
      }, 300);
    },
async fetchMissions() {
  try {
    this.isLoading = true;

    // ✅ TOKEN SERÁ ENVIADO AUTOMATICAMENTE
    const response = await axios.get('/api/missions');

    if (response.data.status) {
      this.featuredMission = response.data.featured || null;
      this.missions = response.data.missions || [];
    }
  } catch (error) {
    console.error('Erro ao buscar missões:', error);
  } finally {
    this.isLoading = false;
  }
},
    async refreshMissions() {
      this.refreshing = true;
      await this.fetchMissions();
      setTimeout(() => {
        this.refreshing = false;
      }, 1000);
    },
    goBack() {
      window.history.back();
    },
    getGameImage(mission) {
      return mission.image || mission.custom_image || mission.game_image || '/images/placeholder.png';
    },
    getProviderName(mission) {
      return mission.provider_name || 'Provedor';
    },
    getGameName(mission) {
      if (mission.game_code) {
        const parts = mission.game_code.split('/');
        return parts[2] || 'Game';
      }
      return 'Game';
    },
    formatTimer(seconds) {
      if (!seconds || seconds <= 0) return '0S';
      const days = Math.floor(seconds / 86400);
      const hours = Math.floor((seconds % 86400) / 3600);
      const minutes = Math.floor((seconds % 3600) / 60);
      const secs = seconds % 60;
      const h = String(hours).padStart(2, '0');
      const m = String(minutes).padStart(2, '0');
      const s = String(secs).padStart(2, '0');
      if (days > 0) return `${days}d : ${h}h : ${m}m : ${s}s`;
      if (hours > 0) return `${h}h : ${m}m : ${s}s`;
      if (minutes > 0) return `${m}m : ${s}s`;
      return `${s}s`;
    },
    async playGame(mission) {
      try {
        console.log('Participando da missão:', mission);

        // Mostrar loading ou algo do tipo
        // this.loading = true;

        // Chamar API para participar
        const response = await axios.post(`/api/missions/${mission.id}/participate`);

        if (response.data.status) {
          console.log('✅ Participação confirmada!', response.data);

          // Fechar o modal
          this.closeMissionModal();

          // Redirecionar para o jogo
          if (response.data.game_url) {
            // Pequeno delay para o modal fechar suavemente
            setTimeout(() => {
              window.location.href = response.data.game_url;
            }, 300);
          } else {
            alert('Erro: URL do jogo não encontrada');
          }
        } else {
          alert(response.data.error || 'Erro ao participar da missão');
        }
      } catch (error) {
        console.error('❌ Erro ao participar:', error);

        if (error.response?.status === 401) {
          alert('Você precisa fazer login primeiro!');
          // Redirecionar para login se necessário
          // window.location.href = '/login';
        } else {
          alert(error.response?.data?.error || 'Erro ao participar da missão');
        }
      } finally {
        // this.loading = false;
      }
    },
    async claimReward(missionId) {
      try {
        const token = localStorage.getItem('token');
        if (!token) {
          alert('Você precisa estar logado para resgatar');
          return;
        }
        const config = {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        };
        console.log('Resgatando missão:', missionId);
        console.log('Token:', token);
        const response = await axios.post(`/api/missions/${missionId}/claim`, {}, config);
        console.log('Resposta:', response.data);

        if (response.data.status) { // ✅ CORRIGIDO AQUI!
          this.confirmPrizeModal = true;
          setTimeout(async () => {
            await this.fetchMissions();
          }, 2000);
        } else {
          alert(response.data.error || 'Erro ao resgatar');
        }
      } catch (error) {
        console.error('Erro ao resgatar recompensa:', error);
        console.error('Detalhes:', error.response);
        alert(error.response?.data?.error || 'Erro ao resgatar recompensa');
      }
    },


    startTimers() {
      this.timerInterval = setInterval(() => {
        if (this.featuredMission) {
          if (this.featuredMission.status === 'upcoming' && this.featuredMission.time_to_start > 0) {
            this.featuredMission.time_to_start--;
          } else if (this.featuredMission.status === 'active' && this.featuredMission.time_to_end > 0) {
            this.featuredMission.time_to_end--;
          }
        }
        this.missions.forEach(mission => {
          if (mission.status === 'upcoming' && mission.time_to_start > 0) {
            mission.time_to_start--;
          } else if (mission.status === 'active' && mission.time_to_end > 0) {
            mission.time_to_end--;
          }
        });
      }, 1000);
    },
    stopTimers() {
      if (this.timerInterval) {
        clearInterval(this.timerInterval);
      }
    }
  }
};
</script>

<style scoped>
/* Seus estilos originais permanecem aqui... */
/* ... */
/* Cole todo o seu CSS original aqui. Ele já está bem estruturado e não precisa de grandes mudanças. */
/* ... */
.Au03f { min-height: 100vh; padding: 0.5rem 0; }
.UrrmK { max-width: 668px; margin: 0 auto; padding: 0 0.5rem; }
.PAItV { margin-bottom: 1rem; }
.smUTk { display: flex; align-items: center; margin-top: 30px; justify-content: space-between; gap: 0.5rem; }
._8s2Sx, ._0UgdA button { background: var(--ci-gray-medium); border: none; width: 30px; height: 30px; border-radius: 0.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #fff; transition: all 0.3s; }
._8s2Sx:hover, ._0UgdA button:hover:not(:disabled) { background: rgba(255, 255, 255, 0.2); }
.hFWlQ { flex: 1; text-align: start; color: #aaba9f; font-size: 1.2rem; font-weight: 600; margin: 0; }
.rotating { animation: rotate 1s linear infinite; }
@keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.Ma4oh { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
.Ma4oh.fwzjA { grid-template-columns: 1fr; margin-bottom: 1.5rem; }
.defaultItemBox { background: var(--ci-gray-medium); color: #aaba9f; border-radius: 12px; overflow: hidden; position: relative; transition: transform 0.3s, box-shadow 0.3s; }
.tagBox { position: absolute; top: 10px; right: 10px; z-index: 10; background: rgba(0, 255, 90, 0.9); color: #000; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; }
.tagBox.upcoming { background: rgba(255, 215, 0, 0.9); }
.imgWrap { width: 100%; height: 180px; overflow: hidden; position: relative; }
.featuredMission .imgWrap { height: 220px; }
.imgWrap img { width: 100%; height: 100%; object-fit: cover; }
.imgWrap::after { content: ""; position: absolute; inset: 0; background: linear-gradient(to top,var(--ci-gray-medium) 0%,transparent 45%,transparent 70%,transparent 100%); pointer-events: none; z-index: 2; }
.defaultBoxContent { padding: 1rem; position: relative; z-index: 3; }
.featuredMission .defaultBoxContent { padding: 1.2rem; }
.timerBox { background: rgba(0, 255, 90, 0.2); color: #00ff5a; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; margin-bottom: 0.75rem; text-align: center; }
.timerBox.upcoming { background: rgba(255, 215, 0, 0.2); color: #ffd700; }
.timerBox span { font-weight: 700; font-size: 0.85rem; }
.titleBox { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
.titleBox.smaller { font-size: 0.9rem; }
.missionDescription { color: rgba(255, 255, 255, 0.8); font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.75rem; }
.gameInfo { display: flex; flex-direction: column; gap: 2px; margin-bottom: 0.75rem; font-size: 0.75rem; }
.providerName { font-size: 0.7rem; }
.gameName { font-weight: 600; }
.priceBox { background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%); color: #000; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.75rem; display: inline-block; }
.priceBox.inlined { display: inline-flex; align-items: center; gap: 5px; }
.missionRules { background: var(--ci-gray-light); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.75rem; }
.missionRules p { color: #aaba9f; margin: 0; line-height: 1.4; }
.progressBox { width: 100%; margin-bottom: 0.75rem; }
.progressLabel { color: #00ff5a; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; }
.progressBar { height: 8px; background: var(--ci-gray-light); border-radius: 4px; overflow: hidden; }
.progressBarFill { height: 100%; background: var(--ci-primary-color); border-radius: 4px; transition: width 0.3s ease; }
.actionBox { width: 100%; margin-top: 0.5rem; } /* Adicionei um margin-top para separar do prêmio */
.actionBox button { background: linear-gradient(135deg, #00ff5a 0%, #00cc47 100%); color: #000; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; width: 100%; font-size: 0.85rem; }
.actionBox button:disabled { opacity: 0.6; cursor: not-allowed; }
.actionBox button.upcoming-btn { background: rgba(255, 215, 0, 0.2); color: #ffd700; }
.actionBox button.claim-btn { background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%); color: #000; animation: pulse 2s infinite; }
@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
.actionBox button.claimed-btn { background: rgba(0, 255, 90, 0.2); color: #00ff5a; }
.actionBox button.play-btn { background: var(--ci-primary-color); color: var(--ci-gray-medium); font-weight:700; }
.empty-state { text-align: center; padding: 60px 20px; color: #fff; }
.empty-icon { font-size: 4rem; margin-bottom: 20px; opacity: 0.5; }
.empty-state h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 10px; }
.empty-state p { color: rgba(255, 255, 255, 0.6); }
@media (max-width: 768px) { .Ma4oh { grid-template-columns: 1fr; gap: 1rem; } .imgWrap { height: 150px; } .featuredMission .imgWrap { height: 180px; } .titleBox { font-size: 0.9rem; } .missionDescription { font-size: 0.75rem; } }
@media (max-width: 480px) { .hFWlQ { font-size: 1.1rem; } ._8s2Sx, ._0UgdA button { width: 30px; height: 30px; } .defaultBoxContent { padding: 0.75rem; } }
.glow-border { position: relative; background: var(--ci-gray-medium); border-radius: 12px; overflow: hidden; }
.glow-border::before { content: ""; position: absolute; inset: 0; z-index: 10; border-radius: inherit; padding: 2px; background: linear-gradient( 90deg, #f0c42500, #e6ba0d, #ff00ff00 ); background-size: 200% 200%; -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: destination-out; mask-composite: exclude; animation: moveBorder 3s linear infinite; pointer-events: none;}
@keyframes moveBorder { 0% { background-position: 0% 0; } 50% { background-position: 100% 0; } 100% { background-position: 0% 0; } }
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
  z-index: 100000;
  backdrop-filter: blur(10px);
}

.prize-modal {
  background: linear-gradient(135deg, var(--footer-color-dark) 0%, var(--footer-color-dark-gradient) 100%);
  border-radius: 20px;
  width: 90%;
  max-width: 450px;
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
  padding: 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  color: #FFD700;
  font-size: 1.4rem;
  margin: 0;
}

.close-btn {
  background: none;
  border: none;
  color: rgba(255, 255, 255, 0.6);
  font-size: 1.2rem;
  cursor: pointer;
  transition: color 0.3s;
}

.close-btn:hover {
  color: #fff;
}

.modal-body {
  padding: 15px 25px;
}

.prize-showcase {
  text-align: center;
}

.prize-image-large {
  font-size: 5rem;
  margin-bottom: 20px;
  animation: bounce 1s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.prize-showcase h3 {
  color: #fff;
  font-size: 1.2rem;
  margin-bottom: 15px;
}

.prize-message {
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.6;
  font-size: 0.8rem;
}

.prize-message strong {
  color: #FFD700;
}

.modal-footer {
  padding: 20px 25px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.claim-prize-btn {
  width: 100%;
  padding: 15px;
  background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
  border: none;
  border-radius: 10px;
  color: #000;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.claim-prize-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(255, 215, 0, 0.3);
}

</style>
