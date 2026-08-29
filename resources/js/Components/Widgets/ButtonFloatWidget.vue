<template>
  <div class="floating-button-container" v-show="visivel">
    <button id="divInstallAppPopup" class="floating-button" @click="navegarOuFechar">
      <div class="close-icon" @click.stop="fecharBotao">
        <span class="nuxt-icon nuxt-icon--fill">
          <svg height="1em" viewBox="0 0 320 512" width="1em" xmlns="http://www.w3.org/2000/svg">
            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" fill="currentColor"></path>
          </svg>
        </span>
      </div>
      
      <div class="app-logo">
        <img alt="LuckyBet" class="logo-img" src="https://i.imgur.com/Ae909Uv.png" />
      </div>
      
      <div class="button-content">
        <h4>Instale a LuckyBet grátis</h4>
        <p>
          Receba promoções exclusivas!
          <img class="gift-icon pulse" src="https://static.donald.bet.br/deploy-b1bc65dd2f6e2d6b6d106265a03d5eb0c803325f-17189736ac55c8fbbf5c/assets/images/gift.png" alt="Gift" />
        </p>
      </div>
      
      <span class="nuxt-icon nuxt-icon--fill arrow-icon bounce">
        <svg height="1em" viewBox="0 0 320 512" width="1em" xmlns="http://www.w3.org/2000/svg">
          <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" fill="currentColor"></path>
        </svg>
      </span>
    </button>
  </div>
</template>

<script>
export default {
  name: 'FloatingAppButton',
  data() {
    return {
      visivel: true
    }
  },
  methods: {
    fecharBotao(e) {
      e.preventDefault();
      this.visivel = false;
    },
    navegarOuFechar() {
      window.location.href = 'https://ajuda.luckybet777.com.br/';
    }
  }
}
</script>

<style scoped>
.floating-button-container {
  position: fixed;
  bottom: 0px;
  right: 20px;
  z-index: 999;
  max-width: 360px;
  padding: 0 10px;
}

.floating-button {
  display: flex;
  align-items: center;
  width: 100%;
  background-color: #090720;
  bottom:75px;
  border: 1px solid #3a4468;
  border-radius: 12px;
  padding: 12px 16px;
  color: white;
  position: relative;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease;
}

.floating-button:hover {
  background-color: #16123f;
  border-color: #00ff5a;
  box-shadow: 0 4px 12px rgba(0, 230, 118, 0.2);
}

.close-icon {
  position: absolute;
  top: -8px;
  left: -8px;
  background-color: #090720;
  border: 1px solid #3a4468;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #8a94a6;
  font-size: 13px;
  z-index: 2;
}

.close-icon:hover {
  color: white;
  background-color: #1e2640;
}

.app-logo {
  margin-right: 12px;
  flex-shrink: 0;
}

.logo-img {
  height: 24px;
  max-width: 80px;
  object-fit: contain;
}

.button-content {
  flex-grow: 1;
  text-align: left;
}

.button-content h4 {
  font-size: 12px;
  font-weight: bold;
  margin: 0;
  color: white;
}

.button-content p {
  font-size: 12px;
  margin: -2px 0 0 0;
  color: #8a94a6;
  display: flex;
  align-items: center;
}

.gift-icon {
  width: 16px;
  height: 16px;
  margin-left: 4px;
}

.arrow-icon {
  color: #00ff5a;
  margin-left: 12px;
  font-size: 16px;
}

/* Animações */
.pulse {
  background-color: #ffffff00;
  box-shadow: 0 4px 12px rgba(255, 255, 255, 0);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

.bounce {
  animation: bounce 1.5s infinite;
}

@keyframes bounce {
  0%, 100% {
    transform: translateX(0);
  }
  50% {
    transform: translateX(3px);
  }
}

/* Responsividade para mobile */
@media screen and (max-width: 767px) {
  .floating-button-container {
    bottom: 8px;
    left: 50%;
    right: auto;
    transform: translateX(-50%);
    max-width: calc(100% - 40px);
    width: calc(100% - 40px);
  }
}

@media screen and (max-width: 480px) {
  .floating-button-container {
    bottom: 8px;
  }
  
  .button-content h4 {
    font-size: 12px;
  }
  
  .button-content p {
    font-size: 11px;
  }
}
</style>