<!-- src/Components/MissionDetailModal.vue -->
<template>
  <div v-if="mission && visible" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <button class="close-button" @click="closeModal">&times;</button>
      
      <!-- Conteúdo detalhado da missão (movido do card original) -->
      <div class="defaultItemBox modal-view" :class="{ 'featured-modal': isFeatured }">
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
          <div class="titleBox">{{ mission.title }}</div>
          <div v-if="mission.description" class="missionDescription">
            {{ mission.description }}
          </div>
          <div class="gameInfo">
            <span class="providerName">{{ getProviderName(mission) }}</span>
            <span class="gameName">{{ mission.game_name || getGameName(mission) }}</span>
          </div>
          <div class="priceBox">{{ mission.reward_display || mission.reward }}</div>
          <div v-if="mission.rules" class="missionRules">
            <strong>Regras :</strong>
            <p>{{ mission.rules }}</p>
          </div>
          <div v-if="mission.user_mission && mission.status === 'active'" class="progressBox withLabel">
            <div class="progressLabel">Progresso: {{ mission.user_mission.progress_display }}</div>
            <div class="progressBar">
              <div class="progressBarFill" :style="{ width: mission.user_mission.progress_percentage + '%' }"></div>
            </div>
          </div>
          <div class="actionBox">
            <button v-if="mission.status === 'upcoming'" class="upcoming-btn" disabled>
              Em breve
            </button>
            <button v-else-if="mission.user_mission?.status === 'completed' && !mission.user_mission?.rewarded" 
                    @click="emitClaim" 
                    class="claim-btn">
              🎁 Resgatar Recompensa
            </button>
            <button v-else-if="mission.user_mission?.status === 'completed' && mission.user_mission?.rewarded" 
                    class="claimed-btn" 
                    disabled>
              ✓ Recompensa Resgatada
            </button>
            <button v-else-if="mission.status === 'active'" 
                    @click="emitPlay" 
                    class="play-btn">
              {{ mission.user_mission ? 'Missão Iniciada' : 'Participar' }}
            </button>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MissionDetailModal',
  props: {
      isFeatured: { // <-- ADICIONE ESTA PROP
      type: Boolean,
      default: false
    },
    mission: {
      type: Object,
      default: null
    },
    visible: {
      type: Boolean,
      default: false
    }
  },
  emits: ['close', 'play', 'claim'], // Declarando os eventos que o componente pode emitir
  methods: {
    closeModal() {
      this.$emit('close');
    },
    emitPlay() {
      this.$emit('play', this.mission);
    },
    emitClaim() {
      this.$emit('claim', this.mission.id);
    },
    // Funções auxiliares (copiadas da página principal para manter o componente independente)
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
    }
  }
};
</script>

<style scoped>
  /* Estilos para a Variação do Modal de Destaque */
.defaultItemBox.modal-view.featured-modal {
  /* Adicionamos a borda brilhante, igual ao card */
  position: relative; /* Necessário para o pseudo-elemento */
  overflow: hidden;   /* Corta a animação fora do canto arredondado */
}

.defaultItemBox.modal-view.featured-modal::before {
  content: "";
  position: absolute;
  inset: 0;    
  z-index: 5; /* z-index mais baixo que o conteúdo para não atrapalhar */
  border-radius: inherit;
  padding: 2px;
  background: linear-gradient(
    90deg,
    #f0c42500,
    #e6ba0d,
    #ff00ff00
  );
  background-size: 200% 200%;
  -webkit-mask: 
    linear-gradient(#fff 0 0) content-box, 
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: destination-out;
  mask-composite: exclude;
  animation: moveBorder 3s linear infinite;
  pointer-events: none; /* Importante para não bloquear cliques */
}

/* Animação da borda (pode omitir se já tiver no mesmo arquivo) */
@keyframes moveBorder {
  0%   { background-position: 0% 0; }
  50%  { background-position: 100% 0; }
  100% { background-position: 0% 0; }
}

/* Estilos para o Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  backdrop-filter: blur(5px);
}

.modal-content {
  position: relative;
  max-width: 400px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
}

.close-button {
     position: absolute;
    top: -2px;
    right: -2px;
    background: var(--ci-gray-medium);
    /* border: 2px solid #fff; */
    color: #aaba9f;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 1.5rem;
    line-height: 26px;
    text-align: center;
    cursor: pointer;
  z-index: 10010;
}
  


/* Reutilizando e adaptando estilos do seu CSS original */
.defaultItemBox.modal-view {
  background: var(--ci-gray-medium);
  color: #aaba9f;
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  width: 100%;
}
.imgWrap { width: 100%; height: 180px; overflow: hidden; position: relative; }
.imgWrap::after { content: ""; position: absolute; inset: 0; background: linear-gradient(to top,var(--ci-gray-medium) 0%,transparent 45%,transparent 70%,transparent 100%); pointer-events: none; z-index: 2; }
.imgWrap img { width: 100%; height: 100%; object-fit: cover; }
.defaultBoxContent { padding: 1rem; position: relative; z-index: 3; }
.tagBox { position: absolute; top: 10px; right: 10px; z-index: 10; background: rgba(0, 255, 90, 0.9); color: #000; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; }
.tagBox.upcoming { background: rgba(255, 215, 0, 0.9); }
.timerBox { background: rgba(0, 255, 90, 0.2); color: #00ff5a; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; margin-bottom: 0.75rem; text-align: center; }
.timerBox.upcoming { background: rgba(255, 215, 0, 0.2); color: #ffd700; }
.timerBox span { font-weight: 700; font-size: 0.85rem; }
.titleBox { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
.missionDescription { color: rgba(255, 255, 255, 0.8); font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.75rem; }
.gameInfo { display: flex; flex-direction: column; gap: 2px; margin-bottom: 0.75rem; font-size: 0.75rem; }
.providerName { font-size: 0.7rem; }
.gameName { font-weight: 600; }
.priceBox { background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%); color: #000; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.75rem; display: inline-block; }
.missionRules { background: var(--ci-gray-light); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.75rem; }
.missionRules p { color: #aaba9f; margin: 0; line-height: 1.4; }
.progressBox { width: 100%; margin-bottom: 0.75rem; }
.progressLabel { color: #00ff5a; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; }
.progressBar { height: 8px; background: var(--ci-gray-light); border-radius: 4px; overflow: hidden; }
.progressBarFill { height: 100%; background: var(--ci-primary-color); border-radius: 4px; transition: width 0.3s ease; }
.actionBox { width: 100%; }
.actionBox button { background: linear-gradient(135deg, #00ff5a 0%, #00cc47 100%); color: #000; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; width: 100%; font-size: 0.85rem; }
.actionBox button:disabled { opacity: 0.6; cursor: not-allowed; }
.actionBox button.upcoming-btn { background: rgba(255, 215, 0, 0.2); color: #ffd700; }
.actionBox button.claim-btn { background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%); color: #000; animation: pulse 2s infinite; }
@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
.actionBox button.claimed-btn { background: rgba(0, 255, 90, 0.2); color: #00ff5a; }
.actionBox button.play-btn { background: var(--ci-primary-color); color: var(--ci-gray-medium); font-weight:700;}
</style>
