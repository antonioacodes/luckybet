<style>
.game-cover {
  transition: transform 2.5s ease-in-out, opacity 0.3s ease-in-out;
}
/* 2️⃣ Quando o mouse passa sobre o *wrapper* (.game-card) */
.game-card:hover .game-cover,
.game-card .game-cover:hover {          
  transform: scale(1.15);               
  opacity: .6;                          
}
@media (hover: none) {
  .game-card .game-cover {
    /* nada – o efeito só aparece em desktop */
  }
}
#imagem-jogo:hover {
  transform: scale(1.3);
  transition: .3s;
  opacity: .6;
}
#texto-margin-name {
  margin-top: -50px;
  color: white;
  padding-left: 10px;
  font-size: 12px;
}
#texto-size-game {
  color: white;
  padding-left: 10px;
  font-size: 10px;
}
@media (max-width:600px) {
  #texto-margin-name {
  margin-top: -37px;
  color: white;
  font-size: 9px;
  padding-left: 5px;
}
#texto-size-game {
  color: white;
  padding-left: 5px;
  font-size: 8px
}
}
</style>

<template>
    <!-- 
      TRAVA DE SEGURANÇA:
      O v-if aqui garante que este bloco SÓ existe se distribution for 'igamingplay'.
      Qualquer outro valor vindo do backend fará com que este componente não renderize nada.
    -->
    <RouterLink 
        v-if="game.distribution === 'igamingplay' || game.distribution === 'source'" 
        :to="getRouterLink()" 
        class="h-full"
    >
        <div class="overflow-hidden relative rounded-lg text-gray-700 w-full h-full mr-4 cursor-pointer relative" @mouseover="showGameInfo = true" @mouseleave="showGameInfo = false">

            <!-- Como já filtramos no pai, não precisamos de v-if/v-else internos para checar 'ig' -->
            <img :src="game.cover" alt="" class="game-cover object-cover h-full w-full" :style="{ opacity: showGameInfo ? '0.5' : '1' }">

            <div class="">
                <div class="flex flex-col justify-start items-start">
                </div>
            </div>

            <div v-if="showGameInfo" class="absolute inset-0 flex justify-center items-center bg-opacity-40 backdrop-opacity-60 px-3 py-2 aplicar-transition">
                <div class="text-center text-white max-w-[90%]">
                    <button type="button" class="px-2 py-2 text-white rounded mx-auto flex items-center gap-2" style="background-color: var(--ci-primary-color);">
                        <svg style="color: var(--title-color);" height="12px" viewBox="0 0 384 512" width="12px" xmlns="http://www.w3.org/2000/svg"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" fill="currentColor"></path></svg> <p style="font-size: 12px;font-weight: 600;">JOGAR</p>
                    </button>
                </div>
            </div>
        </div>
    </RouterLink>
</template>

<script>
import { RouterLink } from "vue-router";

export default {
    props: ['index', 'game'],
    components: { RouterLink },
    data() {
        return {
            isLoading: false,
            modalGame: null,
            showGameInfo: false
        }
    },
    setup(props) {
        return {};
    },
    computed: {
        randomNumber() {
            if(this.game.is_featured){
                return Math.floor(Math.random() * (1100 - 600 + 1)) + 600;
            }else{
                return Math.floor(Math.random() * (850 - 250 + 1)) + 250;
            }
        }
    },
    mounted() {
        // window.scrollTo(0, 0); // Removido pois scrollar ao montar cada card pode causar "pulos" na tela
    },
    methods: {
        getRouterLink() {
            // Lógica simplificada: Como o template já bloqueia tudo que não é 'igamingplay',
            // não precisamos mais verificar 'kagaming' ou outros aqui.
            return { 
                name: 'casinoPlayPage', 
                params: { 
                    id: this.game.id, 
                    slug: this.game.game_code 
                }
            };
        }
    }
};
</script>

<style scoped>
</style>
