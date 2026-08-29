<template>
    <div class="container">
      <div class="md: mb-2 mb-1 w-full" style="z-index: -1;">
        <div class="flex items-center mb-1 mt-2 md:hidden block" style="font-size: 12px;font-weight: bold;z-index: -1;">
          <svg style="padding-right: 3px;" height="1rem" viewBox="0 0 512 512" width="1rem" xmlns="http://www.w3.org/2000/svg">
  <path d="M232 392V268.8L146.7 211.1C135.7 204.6 132.7 189.7 140 178.7C147.4 167.7 162.3 164.7 173.3 172L269.3 236C275.1 240.5 280 247.1 280 256V392C280 405.3 269.3 416 255.1 416C242.7 416 231.1 405.3 231.1 392L232 392z" fill="currentColor"></path>
  <path d="M256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM280 256C280 247.1 275.1 240.5 269.3 236L173.3 172C162.3 164.7 147.4 167.7 140 178.7C132.7 189.7 135.7 204.6 146.7 211.1L232 268.8V392C232 405.3 242.7 416 256 416C269.3 416 280 405.3 280 392L280 256z" fill="currentColor" opacity="0.4"></path>
</svg> <p style="padding-right: 20px;color: gray;">Período:  </p><p style="color: white;border-bottom: 2px solid var(--ci-primary-color);padding-left: 6px;padding-right: 6px;cursor: pointer;">Hoje</p><p style="padding-right: 10px;padding-left: 10px;color: gray;">3 dias</p><p style="padding-right: 10px;color: gray;">7 dias</p><p style="padding-right: 10px;color: gray;">15 dias</p><p style="padding-right: 10px;color: gray;">30 dias</p>
                </div>
        <div class="gains-slider-container" style="z-index: -1;">
          
          <div class="gains-section" style="max-width: 200px;z-index: -1;">
            <div class="icon-trofeu md:ml-4 md:block hidden"><img style="max-width: 50px;max-height: 50px;" src="/assets/images/trofeu.webp" alt=""></div>

            <div class="flex flex-col items-center justify-center">
            <div class="icon-trofeu ml-4 md:hidden block"><img style="max-width: 30px;max-height: 30px;" src="/assets/images/trofeu.webp" alt=""></div>
            <h3 class="md:hidden block flex flex-col items-center justify-center pt-1" style="font-size: 10px;font-weight: 550;text-align: center;margin-right: -17px;line-height: 10px;">TOP <br> GANHOS</h3>
            </div>  

            <div class="title-gains" style="max-width: 150px;">
              <h1 class="md:block hidden" style="font-size: 15px;font-weight: 550;">MAIORES <br> GANHOS <br>DE HOJE</h1>
            </div>
          </div>
          <div class="gains-con">
            <div class="gains-slider">
              <div class="logos-slide">
          
                <div class="slide-gains" v-for="(gain, index) in gains" :key="index">
                  <img :src="gain.image" :alt="gain.game">
                  <div class="status-gains">
                    <p class="player">{{ gain.player }}</p>
                    <p class="game">{{ gain.game }}</p>
                    <p class="valor">{{ gain.amount }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        gains: [
          { player: 'Camila B****', game: 'Fortune Tiger', amount: 'R$ 878,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/a21ef120-befe-4dc5-01f3-cc2f520cb000/public'},
          { player: 'Guilherme S****', game: 'Big Bass Bonanza', amount: 'R$ 1.281,50', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/7d590604-35ff-489e-f976-0a9e61210b00/ipad'},
          { player: 'Rafaela O****', game: 'The Dog House', amount: 'R$ 589,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/27d9a33f-b22f-448c-1e5e-1c00c0e56600/ipad'},
          { player: 'Hugo L****', game: 'Ganesha Gold', amount: 'R$ 2.827,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/2106ca4b-8fe4-4418-e3a1-30dc414cab00/mobile'},
          { player: 'Roberta R****', game: 'Prosperity Fortune Tree', amount: 'R$ 473,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/20bd4cda-92b3-49a1-3f65-c936899cf100/ipad'},
          { player: 'Fernando P****', game: 'Fruit Party', amount: 'R$ 5.925,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/53e800e3-fc02-4138-973b-fd4d4fd91800/ipad'},
          { player: 'Isabela F****', game: 'Ganesha Fortune', amount: 'R$ 1.124,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/005bca7d-ac64-4b82-972b-944615120d00/ipad'},
          { player: 'Gabriela R****', game: 'Gates of Olympus', amount: 'R$ 4.217,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/854119bf-1af1-493a-56ba-2114a5554d00/ipad'},
          { player: 'Camila R****', game: 'Fortune Tiger', amount: 'R$ 2.263,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/a21ef120-befe-4dc5-01f3-cc2f520cb000/public'},
          { player: 'Thales C****', game: 'Fortune OX', amount: 'R$ 2.017,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/d497611a-a2d4-4459-b4ac-c7998dafb400/public'},
          { player: 'Maria A****', game: 'Ganesha Gold', amount: 'R$ 628,50', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/2106ca4b-8fe4-4418-e3a1-30dc414cab00/mobile'},
          { player: 'Vitor L****', game: 'Sugar Rush', amount: 'R$ 231,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/5527e6f0-38c1-4736-d0c5-7bae6b5a1b00/ipad' },
          { player: 'Vinícius M****', game: 'The Dog House', amount: 'R$ 3.727,77', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/27d9a33f-b22f-448c-1e5e-1c00c0e56600/ipad'},
          { player: 'Aline S****', game: 'Fortune Tiger', amount: 'R$ 927,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/a21ef120-befe-4dc5-01f3-cc2f520cb000/public'},
          { player: 'Alice L****', game: 'Ganesha Gold', amount: 'R$ 827,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/2106ca4b-8fe4-4418-e3a1-30dc414cab00/mobile'},
          { player: 'Sabrina R****', game: 'Prosperity Fortune Tree', amount: 'R$ 473,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/20bd4cda-92b3-49a1-3f65-c936899cf100/ipad'},
          { player: 'Kaio P****', game: 'Fruit Party', amount: 'R$ 625,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/53e800e3-fc02-4138-973b-fd4d4fd91800/ipad'},
          { player: 'Geraldo A****', game: 'Gates of Olympus', amount: 'R$ 1.271,05', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/854119bf-1af1-493a-56ba-2114a5554d00/ipad'},
          { player: 'Santos A****', game: 'Ganesha Gold', amount: 'R$ 877,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/2106ca4b-8fe4-4418-e3a1-30dc414cab00/mobile'},
          { player: 'Elisa D****', game: 'Prosperity Fortune Tree', amount: 'R$ 1.961,01', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/20bd4cda-92b3-49a1-3f65-c936899cf100/ipad'},
          { player: 'Priscila L****', game: 'Big Bass Bonanza', amount: 'R$ 826,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/7d590604-35ff-489e-f976-0a9e61210b00/ipad'},
          { player: 'Fernanda A****', game: 'Fortune Rabbit', amount: 'R$ 3.829,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/db67fda5-1884-432e-7c5d-dfd608c7b800/ipad'},
          { player: 'Hugo L****', game: 'Fortune Mouse', amount: 'R$ 4.281,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/1baadf89-53c7-4ec8-b58c-1f3abf0fe200/ipad'},
          { player: 'Mariana C****', game: 'Big Bass Bonanza', amount: 'R$ 1.819,99', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/7d590604-35ff-489e-f976-0a9e61210b00/ipad'},
          { player: 'Rodrigo O****', game: 'Fruit Party', amount: 'R$ 2.192,77', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/53e800e3-fc02-4138-973b-fd4d4fd91800/ipad'},
          { player: 'Carla S****', game: 'The Dog House', amount: 'R$ 3.619,33', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/27d9a33f-b22f-448c-1e5e-1c00c0e56600/ipad'},
          { player: 'Renato A****', game: 'Gates of Olympus', amount: 'R$ 6.281,45', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/854119bf-1af1-493a-56ba-2114a5554d00/ipad'},
          { player: 'Fernanda A****', game: 'Ganesha Gold', amount: 'R$ 2.827,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/2106ca4b-8fe4-4418-e3a1-30dc414cab00/mobile'},
          { player: 'Eduardo S****', game: 'Prosperity Fortune Tree', amount: 'R$ 926,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/20bd4cda-92b3-49a1-3f65-c936899cf100/ipad'},
          { player: 'Carla S****', game: 'Fortune OX', amount: 'R$ 1.654,00', image: 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/d497611a-a2d4-4459-b4ac-c7998dafb400/public'},
        ]
      };
    }
  };
  </script>
  
 
<style scoped>
.container {
  display: flex;
  justify-content: center;
}

.gains-slider-container {
  width: 100%;
  max-width: 1200px; /* Defina a largura máxima do container */
  height: auto;
  display: flex;
  justify-content: space-between;
}

.gains-section {
  width: 190px;
  height: 90px;
  background: linear-gradient(90deg, rgba(255, 215, 0, 0.4) 0%, rgba(255, 172, 75, 0) 100%);
  z-index: 1;
  display: flex;
  align-items: center;
  gap: 15px;
  border-radius: 12px;
}

.icon-trofeu img {
  width: 90px;
}

.title-gains h1 {
  color: #fff;
  font-weight: 800;
  font-size: 25px;
}

.gains-con {
  width: calc(100% - 190px);
  overflow: hidden;
}

.gains-slider {
  overflow: hidden;
  padding-left: 30px;
  white-space: nowrap;
  position: relative;
  display: flex;
  max-height: 90px;
}

.gains-slider:before,
.gains-slider:after {
  position: absolute;
  top: 0;
  width: 250px;
  height: 100%;
  content: "";
  z-index: 2;
}

.gains-slider:before {
  left: 0;
}

.gains-slider:after {
  right: 0;
}

.gains-slider:hover .logos-slide {
  animation-play-state: paused;
}

.logos-slide {
  display: flex;
  animation: slide 185s infinite linear;
}

.slide-gains {
  background-color: #0d0d22;
  margin-right: 15px;
  width: 200px;
  overflow: hidden;
  border-radius: 6px;
  display: flex;
  align-items: center;
  gap: 10px;
  height: 100%;
}

.slide-gains .player {
  font-family: Arial, sans-serif;
  color: #fff;
  font-weight: 500;
  font-size: 12px;
}

.slide-gains .game {
  font-family: Arial, sans-serif;
  color: #fff;
  font-size: 10px;
  margin: 0;
}

.slide-gains img {
  height: 100%;
  padding: 4%;
  border-radius: 12px;
}

.slide-gains .valor {
  font-size: 15px;
  color: #ff0;
}

.logos-slide img {
  height: 100%;
  padding: 4%;
  border-radius: 12px;
}

@keyframes slide {
  0% {
    transform: translate(0);
  }
  to {
    transform: translate(-100%);
  }
}

@media only screen and (max-width: 600px) {
  .gains-section {
    width: 65px;
    height: 70px;
    border-radius: 8px;
  }

  .icon-trofeu img {
    width: 60px;
  }

  .title-gains h1 {
    font-size: 14px;
  }

  .gains-slider {
    padding-left: 100px;
  }

  .slide-gains {
    height: 70px;
  }

  .gains-con {
    width: calc(100% - 65px);
    overflow: hidden;
  }
}
</style>
  