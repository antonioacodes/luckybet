<template>
  <div class="bets-table-wrapper" style="max-height:350px;">
    <div class="bets-table-header">
      <div class="header-wrapper" >
        <div class="bets-table-tab selected">APOSTAS DE CASSINO</div>
        <div class="live-badge">
          <span class="live-dot"></span>
          <span>LIVE</span>
        </div>
      </div>
      <div class="real-time-info">Atualização em tempo real</div>
    </div>
    <div class="bets-list-container">
      <div class="bet-item" v-for="(aposta, index) in apostasAtuais" :key="index" 
          :class="{ 'new-item': index === 0 && atualizacaoRecente }">
        <div class="bet-left">
          <div class="game-image-container">
            <img :src="aposta.imagemJogo" :alt="aposta.jogo" class="game-image">
          </div>
        </div>
        <div class="bet-content">
          <div class="bet-user-info">
            <span class="user-name">{{ aposta.usuario }}</span>
            <span class="bet-action">Apostou</span>
            <span class="bet-amount">{{ formatarMoeda(aposta.aposta) }}</span>
          </div>
          <div class="bet-multiplier-info">
            <span class="multiplier-label">Multiplicador {{ aposta.multiplicadorTexto }}:</span>
            <span :class="getLucroClass(aposta.lucro)" class="bet-profit">{{ formatarMoeda(aposta.lucro, true) }}</span>
          </div>
        </div>
        <div class="bet-time">
          <span class="time-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
          </span>
          <span>{{ aposta.hora }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CasinoBetsTable',
  data() {
    return {
      jogos: [
        { nome: 'Big Bass Splash', img: '/storage/PlayFiver/Pragmatic/vs10txbigbass.png' },
        { nome: 'Mines', img: '/storage/01JJ4CQYP9FND6GG60WAP30Y4Z.webp' },
        { nome: 'Mines', img: '/storage/01JJ4CQYP9FND6GG60WAP30Y4Z.webp' },
        { nome: 'Mines', img: '/storage/01JJ4CQYP9FND6GG60WAP30Y4Z.webp' },
        { nome: 'Mines', img: '/storage/01JJ4CQYP9FND6GG60WAP30Y4Z.webp' },
        { nome: 'Fortune Rabbit', img: '/storage/PlayFiver/Pgsoft/1543462.png' },
        { nome: 'Fortune Rabbit', img: '/storage/PlayFiver/Pgsoft/1543462.png' },
        { nome: 'Fortune Rabbit', img: '/storage/PlayFiver/Pgsoft/1543462.png' },
        { nome: 'Aviator', img: '/storage/PlayFiver/Spribe/Aviator.png' },
        { nome: 'Aviator', img: '/storage/PlayFiver/Spribe/Aviator.png' },
        { nome: 'Aviator', img: '/storage/PlayFiver/Spribe/Aviator.png' },
        { nome: 'Aviator', img: '/storage/PlayFiver/Spribe/Aviator.png' },
        { nome: 'Gates Of Olympus', img: '/storage/PlayFiver/Pragmatic/vs20olympgate.png' },
        { nome: 'Gates Of Olympus', img: '/storage/PlayFiver/Pragmatic/vs20olympgate.png' },
        { nome: 'Gates Of Olympus', img: '/storage/PlayFiver/Pragmatic/vs20olympgate.png' },
        { nome: 'Gates Of Olympus', img: '/storage/PlayFiver/Pragmatic/vs20olympgate.png' },
        { nome: 'Sweet Bonanza', img: '/storage/PlayFiver/Pragmatic/vs20fruitsw.png' },
        { nome: 'Sweet Bonanza', img: '/storage/PlayFiver/Pragmatic/vs20fruitsw.png' },
        { nome: 'Fortune Tiger', img: '/storage/PlayFiver/Pgsoft/126.png' },
        { nome: 'Fortune Tiger', img: '/storage/PlayFiver/Pgsoft/126.png' },
        { nome: 'Fortune Tiger', img: '/storage/PlayFiver/Pgsoft/126.png' },
        { nome: 'Fortune Tiger', img: '/storage/PlayFiver/Pgsoft/126.png' },
        { nome: 'The Dog House', img: '/storage/PlayFiver/Pragmatic/vs20doghouse.png' },
        { nome: 'The Dog House', img: '/storage/PlayFiver/Pragmatic/vs20doghouse.png' },
        { nome: 'Wild West Gold', img: '/storage/PlayFiver/Pragmatic/vs40wildwest.png' },
        { nome: 'Buffalo King', img: '/storage/PlayFiver/Pragmatic/vs4096bufking.png' },
        { nome: 'Release the Kraken', img: '/storage/PlayFiver/Pragmatic/vs20kraken.png' },
        { nome: 'Bigger Bass Bonanza', img: '/storage/PlayFiver/Pragmatic/vs12bbb.png' },
        { nome: 'Big Bass Bonanza', img: '/storage/PlayFiver/Pragmatic/vs10bbbonanza.png' },
        { nome: 'Tigre Sortudo', img: '/storage/01JJABKB49TGTDFYPWTMTRMHM8.png' },
        { nome: 'Tigre Sortudo', img: '/storage/01JJABKB49TGTDFYPWTMTRMHM8.png' },
        { nome: 'Tigre Sortudo', img: '/storage/01JJABKB49TGTDFYPWTMTRMHM8.png' },
        { nome: 'Fortune Ox', img: '/storage/PlayFiver/Pgsoft/98.png' },
        { nome: 'Fortune Ox', img: '/storage/PlayFiver/Pgsoft/98.png' },
        { nome: 'Fortune Ox', img: '/storage/PlayFiver/Pgsoft/98.png' },
        { nome: 'The Hand of Midas', img: '/storage/PlayFiver/Pragmatic/vs20midas.png' }
      ],
      usuarios: [
        "Rodr*****", "Edua*****", "Ange*****", "Jard*****", 
        "Thia*****", "Andr*****", "Agna*****", "Carl*****", 
        "Mila*****", "Cesa*****", "Luiz*****", "Mari*****", 
        "Joao*****", "Rafa*****", "Dani*****", "Luca*****", 
        "Brun*****", "Feli*****", "Clau*****", "Aman*****", 
        "Robe*****", "Andr*****", "Pedr*****", "Paul*****", 
        "Elen*****", "Camila****", "Alex*****", "Cloves****", 
        "Icaro*****", "Gust*****", "Vane*****", "Vini*****", 
        "Vict*****", "Juli*****", "Jame*****", "José*****", 
        "Geor*****", "Manu*****", "Zeca*****", "Alin*****"
      ],
      apostasAtuais: [],
      atualizacaoRecente: false,
      intervaloAtualizacao: null
    }
  },
  methods: {
    formatarMoeda(valor, mostrarSinal = false) {
      const valorAbs = Math.abs(valor);
      const formatado = 'R$ ' + valorAbs.toFixed(2).replace('.', ',');
      
      if (mostrarSinal && valor < 0) {
        return '-' + formatado;
      }
      
      return formatado;
    },
    getLucroClass(lucro) {
      if (lucro > 0) {
        return 'positive-profit';
      } else if (lucro < 0) {
        return 'negative-profit';
      } else {
        return 'neutral-profit';
      }
    },
    gerarAposta() {
      const valores = [0.80, 1.00, 3.00, 3.20, 4.00, 10.00, 16.00, 25.00, 50.00];
      return valores[Math.floor(Math.random() * valores.length)];
    },
    gerarMultiplicador() {
      const multiplicadores = [
        { valor: 2, texto: '2x' },
        { valor: 6, texto: '6x' },
        { valor: 7, texto: '7x' },
        { valor: 13, texto: '13x' },
        { valor: 20, texto: '20x' },
        { valor: 21, texto: '21x' },
        { valor: 22, texto: '22x' },
        { valor: 50, texto: '50x' }
      ];
      
      return multiplicadores[Math.floor(Math.random() * multiplicadores.length)];
    },
    obterHoraAtual() {
      const agora = new Date();
      const horas = agora.getHours().toString().padStart(2, '0');
      const minutos = agora.getMinutes().toString().padStart(2, '0');
      return `${horas}:${minutos}`;
    },
    gerarLinhaAposta() {
      // Seleciona um jogo aleatório do array de jogos
      const jogoSelecionado = this.jogos[Math.floor(Math.random() * this.jogos.length)];
      const usuario = this.usuarios[Math.floor(Math.random() * this.usuarios.length)];
      const hora = this.obterHoraAtual();
      const aposta = this.gerarAposta();
      const multiplicador = this.gerarMultiplicador();
      
      // Calcula o lucro baseado na aposta e multiplicador
      const lucro = aposta * multiplicador.valor;
      
      return {
        jogo: jogoSelecionado.nome,
        imagemJogo: jogoSelecionado.img,
        usuario: usuario,
        hora: hora,
        aposta: aposta,
        multiplicadorTexto: multiplicador.texto,
        multiplicadorValor: multiplicador.valor,
        lucro: lucro
      };
    },
    preencherTabela(numLinhas = 10) {
      this.apostasAtuais = [];
      
      for (let i = 0; i < numLinhas; i++) {
        const aposta = this.gerarLinhaAposta();
        this.apostasAtuais.push(aposta);
      }
    },
    atualizarTabelaComRolagem() {
      // Cria uma nova aposta
      const novaAposta = this.gerarLinhaAposta();
      
      // Remove a última aposta e adiciona a nova no início
      this.apostasAtuais.pop();
      this.apostasAtuais.unshift(novaAposta);
      
      // Marca como atualização recente para animação
      this.atualizacaoRecente = true;
      
      // Remove a classe de animação após a animação terminar
      setTimeout(() => {
        this.atualizacaoRecente = false;
      }, 1000);
    },
    iniciarAtualizacaoAutomatica() {
      this.intervaloAtualizacao = setInterval(() => {
        this.atualizarTabelaComRolagem();
      }, 2000 + Math.random() * 3000);
    },
    pararAtualizacaoAutomatica() {
      if (this.intervaloAtualizacao) {
        clearInterval(this.intervaloAtualizacao);
      }
    }
  },
  mounted() {
    // Preenche a tabela inicialmente
    this.preencherTabela();
    
    // Inicia a atualização automática
    this.iniciarAtualizacaoAutomatica();
  },
  beforeUnmount() {
    // Garante que o intervalo seja limpo quando o componente for desmontado
    this.pararAtualizacaoAutomatica();
  }
}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Arial', sans-serif;
}

body {
  background-color: #09071f;
}

.bets-table-wrapper {
  max-width: 1536px;
  margin:auto;
  background-color: #16ae5f59;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.bets-table-header {
  padding: 15px;
  background: linear-gradient(90deg, #083d32, #00ff5a);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.header-wrapper {
  display: flex;
  align-items: center;
  gap: 15px;
}

.bets-table-tab {
  display: inline-block;
  font-weight: bold;
  color: #fff;
  overflow:hidden;
  font-size: 16px;
  position: relative;
  padding-bottom: 5px;
}

.bets-table-tab::after {
  content: '';
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 100%;
  height: 2px;
  background-color: white;
}

.live-badge {
  display: flex;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.3);
  border-radius: 4px;
  padding: 3px 6px;
  font-size: 11px;
  font-weight: bold;
  color: #fff;
  gap: 5px;
}

.live-dot {
  width: 6px;
  height: 6px;
  background-color: #ff3e4e;
  border-radius: 50%;
  display: inline-block;
  animation: pulseDot 1.5s infinite;
}

.real-time-info {
  font-size: 10px;
  color: white;
  margin-top: 4px;
  margin-left: 2px;
}

@keyframes pulseDot {
  0% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0.6;
    transform: scale(0.8);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.bets-list-container {
  padding: 5px 0;
  max-height: 600px;
  overflow: hidden;
  position: relative;
}

.bets-list-container::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100px;
  background: linear-gradient(to bottom, rgba(13, 13, 34, 0) 0%, rgba(13, 13, 34, 0.9) 80%, var(--navtop-color-dark) 100%);
  pointer-events: none;
}

.bet-item {
  display: flex;
  align-items: center;
  padding: 10px 15px;
  border-bottom: 1px solid rgba(30, 39, 56, 0.2);
  background-color: var(--navtop-color-dark);
  transition: background-color 0.3s;
}

.bet-item:hover {
  background-color: rgba(41, 50, 65, 0.4);
}

.bet-left {
  margin-right: 12px;
}

.game-image-container {
  width: 40px;
  height: 45px;
  flex-shrink: 0;
  overflow: hidden;
  border-radius: 6px;
  background-color: #121e33;
}

.game-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.bet-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.bet-user-info {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-bottom: 3px;
}

.user-name {
  color: #fff;
  font-size: 14px;
  font-weight: 500;
}

.bet-action {
  color: #8a94a6;
  font-size: 13px;
}

.bet-amount {
  color: #fff;
  font-size: 13px;
}

.bet-multiplier-info {
  display: flex;
  align-items: center;
  gap: 5px;
}

.multiplier-label {
  color: #8a94a6;
  font-size: 13px;
}

.bet-profit {
  font-size: 13px;
  font-weight: 500;
}

.neutral-profit {
  color: #8a94a6;
}

.positive-profit {
  color: #0ecb81;
}

.negative-profit {
  color: #ff3e4e;
}

.bet-time {
  display: flex;
  align-items: center;
  color: #8a94a6;
  font-size: 12px;
  gap: 4px;
  margin-left: 5px;
}

.time-icon {
  display: flex;
  align-items: center;
  color: #8a94a6;
}

.new-item {
  animation: fadeIn 0.8s ease-in-out;
  background-color: rgba(0, 88, 102, 0.2);
}

@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(-5px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive styles */
@media screen and (max-width: 480px) {
  .bets-table-wrapper {
    border-radius: 6px;
  }
  
  .bet-item {
    padding: 8px 12px;
  }
  
  .game-image-container {
    width: 40px;
    height: 45px;
  }
  
  .user-name, .bet-amount {
    font-size: 12px;
  }
  
  .bet-action, .multiplier-label, .bet-profit {
    font-size: 11px;
  }
  
  .bet-time {
    font-size: 10px;
  }
}
</style>