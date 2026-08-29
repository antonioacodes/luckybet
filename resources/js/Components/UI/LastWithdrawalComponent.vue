<template>
  <div class="container">
    <div class="md:mb-2 mb-1 w-full" style="z-index: -1;">
      <div class="flex items-center mb-1 mt-2 md:hidden block" style="font-size: 12px;font-weight: bold;z-index: -1;">
        <svg style="padding-right: 3px;" height="1rem" viewBox="0 0 512 512" width="1rem" xmlns="http://www.w3.org/2000/svg">
          <path d="M232 392V268.8L146.7 211.1C135.7 204.6 132.7 189.7 140 178.7C147.4 167.7 162.3 164.7 173.3 172L269.3 236C275.1 240.5 280 247.1 280 256V392C280 405.3 269.3 416 255.1 416C242.7 416 231.1 405.3 231.1 392L232 392z" fill="currentColor"></path>
          <path d="M256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM280 256C280 247.1 275.1 240.5 269.3 236L173.3 172C162.3 164.7 147.4 167.7 140 178.7C132.7 189.7 135.7 204.6 146.7 211.1L232 268.8V392C232 405.3 242.7 416 256 416C269.3 416 280 405.3 280 392L280 256z" fill="currentColor" opacity="0.4"></path>
        </svg>
        <p style="padding-right: 20px;color: gray;">Últimos Saques:</p>
      </div>
      <div class="withdrawal-slider-container" style="z-index: -1;">
        <div class="withdrawal-section" style="max-width: 200px;z-index: -1;">
          <div class="icon-pix ml-4"><img style="max-width: 50px;max-height: 50px;" src="https://i.imgur.com/Mulr661.png" alt="PIX"></div>
          <div class="title-withdrawal">
            <h1 style="font-size: 15px;font-weight: 550;">SAQUES <br> RECENTES</h1>
          </div>
        </div>
        <div class="withdrawal-con">
          <div class="withdrawal-slider">
            <div class="logos-slide">
              <div class="slide-withdrawal" v-for="(withdrawal, index) in withdrawals" :key="index">
                <img class="profile-icon" src="https://i.imgur.com/tmp57ua.png">
                <div class="status-withdrawal">
                  <p class="player">{{ withdrawal.player }}</p>
                  <p class="valor">{{ withdrawal.amount }}</p>
                  <p class="method">via {{ withdrawal.method }}</p>
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
      withdrawals: [
        { player: 'Lucas M****', amount: 'R$ 250,00', method: 'PIX' },
        { player: 'Carla S****', amount: 'R$ 75,90', method: 'PIX' },
        { player: 'Roberto F****', amount: 'R$ 201,00', method: 'PIX' },
        { player: 'Ana L****', amount: 'R$ 92,30', method: 'PIX' },
        { player: 'Eduardo T****', amount: 'R$ 220,00', method: 'PIX' },
        { player: 'Fernanda P****', amount: 'R$ 60,50', method: 'PIX' },
        { player: 'Gabriel R****', amount: 'R$ 91,00', method: 'PIX' },
        { player: 'Mariana C****', amount: 'R$ 55,75', method: 'PIX' },
        { player: 'Carlos S****', amount: 'R$ 200,00', method: 'PIX' },
        { player: 'Mariana O****', amount: 'R$ 170,50' , method: 'PIX' },
        { player: 'João P****', amount: 'R$ 500,00' , method: 'PIX' },
        { player: 'Fernanda L****', amount: 'R$ 50,00' , method: 'PIX' },
        { player: 'Ricardo D****', amount: 'R$ 320,00' , method: 'PIX' },
        { player: 'Tatiane A****', amount: 'R$ 80,75' , method: 'PIX' },
        { player: 'Leonardo G****', amount: 'R$ 62,00' , method: 'PIX' },
        { player: 'Bianca M****', amount: 'R$ 415,00' , method: 'PIX' },
        { player: 'Gustavo T****', amount: 'R$ 115,30' , method: 'PIX' },
        { player: 'Ana C****', amount: 'R$ 82,00' , method: 'PIX' },
        { player: 'Rodrigo F****', amount: 'R$ 145,00' , method: 'PIX' },
        { player: 'Juliana P****', amount: 'R$ 50,75' , method: 'PIX' },
        { player: 'Thiago B****', amount: 'R$ 61,00', method: 'PIX' },
        { player: 'Vanessa L****', amount: 'R$ 59,00', method: 'PIX'},
        { player: 'Eduardo R****', amount: 'R$ 73,40' , method: 'PIX' },
        { player: 'Camila S****', amount: 'R$ 100,90' , method: 'PIX' },
        { player: 'Felipe D****', amount: 'R$ 85,00' , method: 'PIX' },
        { player: 'Renata O****', amount: 'R$ 93,00' , method: 'PIX' },
        { player: 'Bruno T****', amount: 'R$ 135,50' , method: 'PIX' },
        { player: 'Patrícia K****', amount: 'R$ 265,00' , method: 'PIX' },
        { player: 'Márcio V****', amount: 'R$ 180,25', method: 'PIX' },
        { player: 'Amanda R****', amount: 'R$ 95,00', method: 'PIX' },
        { player: 'Diego N****', amount: 'R$ 300,50', method: 'PIX' },
        { player: 'Paula H****', amount: 'R$ 110,75', method: 'PIX' },
        { player: 'Victor Z****', amount: 'R$ 63,90', method: 'PIX' },
        { player: 'Débora K****', amount: 'R$ 205,00', method: 'PIX' },
        { player: 'Henrique B****', amount: 'R$ 150,25', method: 'PIX' },
        { player: 'Natália S****', amount: 'R$ 80,00', method: 'PIX' },
        { player: 'André L****', amount: 'R$ 175,50', method: 'PIX' },
        { player: 'Luciana M****', amount: 'R$ 129,90', method: 'PIX' },
        { player: 'Fábio T****', amount: 'R$ 490,00', method: 'PIX' },
        { player: 'Beatriz A****', amount: 'R$ 87,50', method: 'PIX' },
        { player: 'Marcelo C****', amount: 'R$ 230,00', method: 'PIX' },
        { player: 'Giovanna P****', amount: 'R$ 115,25', method: 'PIX' },
        { player: 'José R****', amount: 'R$ 350,00', method: 'PIX' },
        { player: 'Daniela V****', amount: 'R$ 72,80', method: 'PIX' },
        { player: 'Rafael W****', amount: 'R$ 195,00', method: 'PIX' },
        { player: 'Carolina F****', amount: 'R$ 88,75', method: 'PIX' },
        { player: 'Alex S****', amount: 'R$ 141,30', method: 'PIX' },
        { player: 'Isabela D****', amount: 'R$ 67,50', method: 'PIX' },
        { player: 'Sérgio Q****', amount: 'R$ 290,00', method: 'PIX' },
        { player: 'Michele Z****', amount: 'R$ 105,00', method: 'PIX' },
        { player: 'Leandro J****', amount: 'R$ 187,60', method: 'PIX' },
        { player: 'Cristina Y****', amount: 'R$ 79,90', method: 'PIX' },
        { player: 'Vinícius U****', amount: 'R$ 215,75', method: 'PIX' },
        { player: 'Larissa G****', amount: 'R$ 123,45', method: 'PIX' },
        { player: 'Marcos E****', amount: 'R$ 273,00', method: 'PIX' },
        { player: 'Elaine N****', amount: 'R$ 69,99', method: 'PIX' },
        { player: 'Pedro X****', amount: 'R$ 380,00', method: 'PIX' },
        { player: 'Sara B****', amount: 'R$ 97,50', method: 'PIX' },
        { player: 'Hugo M****', amount: 'R$ 225,00', method: 'PIX' },
        { player: 'Mônica T****', amount: 'R$ 134,25', method: 'PIX' },
        { player: 'Caio L****', amount: 'R$ 163,80', method: 'PIX' },
        { player: 'Simone H****', amount: 'R$ 98,45', method: 'PIX' },
        { player: 'Otávio G****', amount: 'R$ 310,00', method: 'PIX' },
        { player: 'Priscila K****', amount: 'R$ 85,70', method: 'PIX' },
        { player: 'Tiago R****', amount: 'R$ 252,50', method: 'PIX' },
        { player: 'Roberta D****', amount: 'R$ 147,90', method: 'PIX' },
        { player: 'Nelson W****', amount: 'R$ 190,00', method: 'PIX' },
        { player: 'Cláudia C****', amount: 'R$ 77,75', method: 'PIX' },
        { player: 'Maurício V****', amount: 'R$ 268,30', method: 'PIX' },
        { player: 'Aline F****', amount: 'R$ 91,25', method: 'PIX' }
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
.withdrawal-slider-container {
  width: 100%;
  max-width: 1200px;
  display: flex;
  justify-content: space-between;
}
.withdrawal-section {
  width: 190px;
  height: 90px;
  background: linear-gradient(90deg, rgba(0, 150, 136, 0.4) 0%, rgba(0, 172, 75, 0) 100%);
  display: flex;
  align-items: center;
  gap: 15px;
  border-radius: 12px;
}
.icon-pix img {
  width: 90px;
}
.withdrawal-con {
  width: calc(100% - 190px);
  overflow: hidden;
}
.withdrawal-slider {
  overflow: hidden;
  white-space: nowrap;
  position: relative;
  display: flex;
  max-height: 90px;
}
.logos-slide {
  display: flex;
  animation: slide 400s infinite linear;
}
  
.profile-icon {
   height: 100%;
    padding-right: 5px;
}
.slide-withdrawal {
  background-color: #ffffff0a;
  margin-right: 15px;
  width: 200px;
  overflow: hidden;
  border-radius: 10px;
  padding: 12px;
  display: flex;
  align-items: stretch;
  justify-content: flex-start;
  flex-direction: row;
  height: 100%;
}
  
.slide-withdrawal .player {
  font-family: Arial, sans-serif;
  color: #fff;
  font-weight: 500;
  font-size: 12px;
}
.slide-withdrawal .valor {
  padding-top:13px;
  font-size: 15px;
  color: #00ff99;
}
.slide-withdrawal .method {
  font-size: 10px;
  color: gray;
}
@keyframes slide {
  0% {
    transform: translate(0);
  }
  to {
    transform: translate(-100%);
  }
}
</style>
