
<style>
.mecher-mobile2 {
    font-size: 12px;
    font-weight: 500;
    opacity: .3;
}

.mecher-mobile1 {
    font-size: 14px;
}
.ui-button-blue3 {
    font-size: .775rem;
    font-weight: 700;
    line-height: 1.25rem;
    border-radius: 3px;
    color: white;
    width: auto;
    background-color: var(--ci-gray-medium);
    color: var(--ci-primary-color);
    padding: 9px;
    -webkit-flex: none;
    -ms-flex: none;
    flex: none;
}
.ui-button-blue3:hover {
    opacity: .9;
}


@media (max-width: 600px) {
.mecher-mobile1 {
    font-size: 12px;
}
.mecher-mobile2 {
    font-size: 10px;
}
    .ui-button-blue3 {
    font-size: .675rem;
    font-weight: 700;
    line-height: 1.25rem;
    
    padding: 5px ;
   
}
    .margin-teste {
        margin-left: 8px;
    }
}

</style>
<template>
    <button v-if="wallet?.total_balance === undefined || isLoadingWallet" disabled type="button" class="flex justify-center items-center">
    
        {{ $t('Loading') }}...
    </button>
    <button v-else type="button" class="flex justify-center items-center ml-3 margin-teste md:py-[6px] md:px-[20px] py-[5px] px-[13px] md:text-base text-xs" style="background-color: var(--input-primary);box-sizing: border-box;box-shadow: rgb(0, 255, 90, 50%) 0px 0px 10px 1px; border-radius: 30px;padding: -20px -35px;margin-top: -1px;"> 
        <div class="">
          
        </div>
        
        <div style="display: flex;justify-content: center;align-items: center;gap: 5px;" class="opacidade-hover">
            
            <button @click="updateBalance">
            <svg  class="icon"
      :class="{ 'rotate': isRotating }"
      @click="rotateIcon" data-v-f0101099="" height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M449.9 39.96l-48.5 48.53C362.5 53.19 311.4 32 256 32C161.5 32 78.59 92.34 49.58 182.2c-5.438 16.81 3.797 34.88 20.61 40.28c16.97 5.5 34.86-3.812 40.3-20.59C130.9 138.5 189.4 96 256 96c37.96 0 73 14.18 100.2 37.8L311.1 178C295.1 194.8 306.8 223.4 330.4 224h146.9C487.7 223.7 496 215.3 496 204.9V59.04C496 34.99 466.9 22.95 449.9 39.96z" fill="currentColor"></path><path d="M462.4 329.8C433.4 419.7 350.4 480 255.1 480c-55.41 0-106.5-21.19-145.4-56.49l-48.5 48.53C45.07 489 16 477 16 452.1V307.1C16 296.7 24.32 288.3 34.66 288h146.9c23.57 .5781 35.26 29.15 18.43 46l-44.18 44.2C183 401.8 218 416 256 416c66.58 0 125.1-42.53 145.5-105.8c5.422-16.78 23.36-26.03 40.3-20.59C458.6 294.1 467.9 313 462.4 329.8z" fill="currentColor" opacity="0.4"></path></svg>
    </button>
    <strong @click="$router.push('/profile/wallet')" class="md:text-base text-xs" style="color: var(--ci-primary-color);">{{ state.currencyFormat(wallet?.total_balance, wallet?.currency) }}</strong>
        </div>
<!--        <div class="ml-2 text-sm">-->
<!--            <i class="fa-solid fa-chevron-down"></i>-->
<!--        </div>-->
    </button>
</template>

<script>
    import HttpApi from "@/Services/HttpApi.js";
    import {onMounted, ref, watch, watchEffect} from "vue";
    import {useRoute} from "vue-router";

    export default {
        props: [],
        components: {},
        data() {
            return {
                isRotating: false, //
                isLoadingWallet: true,
                wallet: null,
                processInterval: null,
            }
        },
        setup(props) {
            const route = useRoute();
            const isCasinoPlayPage = ref(false);

            watchEffect(() => {
                checkRoute();
            });

            onMounted(() => {
                checkRoute();
            });

            function checkRoute() {
                // Verifique se a rota atual é 'casinoPlayPage'
                isCasinoPlayPage.value = route.name === 'casinoPlayPage';
            }

            return {
                isCasinoPlayPage
            };
        },
        computed: {

        },
        beforeUnmount() {
            clearInterval(this.processInterval);
        },
        mounted() {
            window.scrollTo(0, 0);
        },
        methods: {
            rotateIcon() {
      // Define a rotação como verdadeira
      this.isRotating = true;
      
      // Remove a classe de rotação após a animação completar
      // O tempo da animação deve ser igual ao tempo definido em CSS
      setTimeout(() => {
        this.isRotating = false;
      }, 1000); // Ajuste este tempo para corresponder à duração da animação CSS
    },
            async getWallet() {
      try {
        // Simula uma chamada API ou outra lógica para obter os dados da carteira
        // Substitua o URL abaixo pelo endpoint real da sua API
        const response = await fetch('/api/wallet');
        const data = await response.json();
        this.wallet = data;
      } catch (error) {
        console.error('Erro ao obter a carteira:', error);
      }
    },
    async updateBalance() {
      // Chama a função para obter os dados atualizados da carteira
      await this.getWallet();
    },
            getWallet: async function() {
                const _this = this;

                await HttpApi.get('profile/wallet')
                    .then(response => {
                        _this.wallet = response.data.wallet;
                        _this.isLoadingWallet = false;
                    })
                    .catch(error => {
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                            if(value == 'unauthenticated') {
                                localStorage. clear();
                                clearInterval(this.processInterval);
                            }
                        });

                        _this.isLoadingWallet = false;
                    });
            },
        },
        async created() {

            if(this.isCasinoPlayPage) {
                this.processInterval = setInterval(async  () => {
                    await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método
                }, 5000);
            }

            await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método

        },
        watch: {

        },
    };
</script>

<style scoped>
.icon {
  display: inline-block;
  cursor: pointer;
}

/* Classe para aplicar a rotação */
.rotate {
  animation: spin 1s forwards; /* Define a animação e a direção */
}

/* Define a animação */
@keyframes spin {
  from {
    transform: rotate(0deg); /* Começa na posição inicial */
  }
  to {
    transform: rotate(360deg); /* Gira 360 graus no sentido horário */
  }
}
</style>
