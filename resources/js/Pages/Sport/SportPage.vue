<template>
    <BaseLayout>
    <div class="maintenance-container">
      <!-- Logo do cassino com glow -->
      <img
        src="https://static.7k.bet.br/deploy-b571d93300fe1387e469cb73c04498571017bebf-cfcd66d1ec6d46e4cd46/assets/images/svg/quit.svg"
        alt="Logo Cassino"
        class="casino-logo"
      />

      <!-- Mensagem de manutenção -->
      <h1>{{ $t('Esportes em Manutenção') }}</h1>
      <p>{{ $t('Desculpe a interrupção! Estamos ajustando as melhores odds para você. Volte em breve.') }}</p>

      <!-- Frames flutuantes decorativos -->
      <div class="floating-frames">
        <div class="frame frame-1"></div>
        <div class="frame frame-2"></div>
        <div class="frame frame-3"></div>
        <div class="frame frame-4"></div>
      </div>
    </div>
    </BaseLayout>
</template>


<script>
import { RouterLink } from "vue-router";
import { Carousel, Navigation, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import BaseLayout from "@/Layouts/BaseLayout.vue";
import SportCard from "@/Pages/Sport/Components/SportCard.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import BettingBulletinComponent from "@/Components/UI/BettingBulletinComponent.vue";
import HeaderNav from "@/Pages/Sport/Components/HeaderNav.vue";
import HeaderOptions from "@/Pages/Sport/Components/HeaderOptions.vue";
import {useToast} from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import SportCardLive from "@/Pages/Sport/Components/SportCardLive.vue";
import {useSettingStore} from "@/Stores/SettingStore.js";
import SportIframe from "@/Pages/Sport/Components/SportIframe.vue";

export default {
    props: [],
    components: {
        SportCardLive,
        HeaderOptions,
        RouterLink,
        HeaderNav,
        BettingBulletinComponent,
        LoadingComponent,
        SportCard,
        BaseLayout,
        Carousel,
        Slide,
        Navigation,
      	SportIframe,
    },
    data() {
        return {
            isLoading: true,
            isLoadingCategories: true,
            isLoadingSports: true,
            leagues: null,
            sports: [],
            settings: {
                itemsToShow: 1,
                snapAlign: 'start',
            },
            breakpoints: {
                700: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                },
                1024: {
                    itemsToShow: 3.1,
                    snapAlign: 'start',
                },
            },
            events: null,
            nextevents: null,
            liveevents: null,
            selectedLeague: 'all',
            intervalId: null,
        }
    },
    setup(props) {

    },
    computed: {
        setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        }
    },
    mounted() {

    },
    beforeDestroy() {
        this.stopInterval();
    },
    methods: {
        setCategory: async function(league) {
            this.isLoadingCategories = true;
            this.selectedLeague = league;
            await this.getFixtures();

            this.isLoadingCategories = false;
        },
        getLeagues: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('sports/football/leagues/')
                .then(response => {
                    _this.leagues = response.data.leagues;
                    _this.isLoadingCategories = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });

                    _this.isLoadingCategories = false;
                });
        },
        getFixtures: async function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('sports/football/events?category='+this.selectedLeague)
                .then(response => {
                    _this.events = response.data.events;

                    _this.isLoadingSports = false;
                    _this.isLoading = false;
                })
                .catch(error => {
                    // Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    //     _toast.error(`${value}`);
                    // });

                    _this.isLoadingSports = false;
                    _this.isLoading = false;
                });
        },
      
        getNextFixtures: async function() {
            const _this = this;
            HttpApi.get('sports/football/nextevents?category='+this.selectedLeague)
                .then(response => {
                    _this.nextevents = response.data.nextevents;
                })
                .catch(error => console.error);
        },
        getLiveFixtures: async function() {
            const _this = this;
            HttpApi.get('sports/football/liveevents')
                .then(response => {
                    _this.liveevents = response.data.liveevents;
                })
                .catch(error => console.error);
        },
        updateEvents: async function() {
            await this.getLiveFixtures();
            await this.getFixtures();
        },
        stopInterval() {
            clearInterval(this.intervalId);
        },
    },
    created() {
        this.getLeagues();
        this.getNextFixtures();
        this.getLiveFixtures();
        this.getFixtures();

        this.intervalId = setInterval(this.updateEvents, 60000);
    },
    watch: {

    },
};
</script>

<style scoped>
/* Container principal com leve gradiente */
.maintenance-container {
  position: relative;
  min-height: calc(100vh - 80px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  color: #fff;
  overflow: hidden;
  text-align: center;
}

/* Animação de glow na logo */
.casino-logo {
  width: 160px;
  margin-bottom: 1.5rem;
  animation: glow 2.5s ease-in-out infinite;
   transition: transform 1.3s ease-in-out;
}
.casino-logo:hover {
  transform: scale(1.2);
}
@keyframes glow {
  0%, 100% {
    filter: drop-shadow(0 0 4px rgba(255,255,255,0.2));
  }
  50% {
    filter: drop-shadow(0 0 20px rgba(255,255,255,0.6));
  }
}

/* Títulos e texto */
h1 {
  font-size: 2.4rem;
  margin-bottom: 0.8rem;
  letter-spacing: 1px;
  text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}
p {
  font-size: 1.1rem;
  opacity: 0.85;
  max-width: 360px;
  line-height: 1.4;
}
/* Frames flutuantes (glassmorphism) */
.floating-frames {
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  pointer-events: none;
}
.frame {
  position: absolute;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.5);
  backdrop-filter: blur(4px);
  animation: float 6s ease-in-out infinite;
}
.frame-1 {
  width: 120px; height: 80px;
  top: 10%; left: 12%;
  animation-duration: 5s;
}
.frame-2 {
  width: 160px; height: 100px;
  bottom: 18%; right: 14%;
  animation-duration: 7s;
  animation-delay: 1s;
}
.frame-3 {
  width: 100px; height: 140px;
  top: 28%; right: 18%;
  animation-duration: 6.5s;
  animation-delay: 0.5s;
}
.frame-4 {
  width: 140px; height: 90px;
  bottom: 22%; left: 22%;
  animation-duration: 8s;
  animation-delay: 1.5s;
}

@media (max-width: 768px) {
.frame-2 {
  bottom: -3%; right: 1%;
}
.frame-3 {
right: 1%;
  top:18%;
}
.frame-4 {
left: -8%;
    bottom: 2%;
}
  }
/* Movimento suave dos frames */
@keyframes float {
  0%, 100% {
    transform: translateY(0) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(2deg);
  }
}
</style>

