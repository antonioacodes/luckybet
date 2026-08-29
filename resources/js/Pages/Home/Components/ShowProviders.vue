<style>
@media(max-width:600px) {
.celular-providers-setas {
    display: none;
}
}
.providersNames {
    color: white;
    font-weight: 550;
    font-size: 18px;
    padding-left: 10px;
    font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
}
</style>
<template>
    <div :key="index" class="game-list flex flex-col relative">
        <div class="w-full flex justify-between px-2 md:mt-6" style="border-radius:0.6rem; background: linear-gradient(90deg,var(--card-color-dark), rgba(255, 255, 255, 0) 100%);">
            <div class="flex items-center">
                <h2 class="text-lg providersNames" >{{ $t(provider.name) }}</h2>
                <button @click.prevent="ckCarousel.prev()" class="item-game px-1 py-1 rounded-lg text-[12px] celular-providers-setas disabled:opacity-75">
                    <svg height="1rem" viewBox="0 0 320 512" width="1rem" xmlns="http://www.w3.org/2000/svg" class="c0rV3 zB6RE"><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"></path></svg>
                </button>
                <button @click.prevent="ckCarousel.next()" class="item-game px-1 py-1 rounded-lg text-[12px] celular-providers-setas">
                    <svg height="1rem" viewBox="0 0 320 512" width="1rem" xmlns="http://www.w3.org/2000/svg" class="c0rV3"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" fill="currentColor"></path></svg>
                </button>
            </div>
            <div class="flex items-center">
                <RouterLink 
                    :to="{ name: 'casinosAll', params: { provider: provider.id, category: 'all' } }"
                    class="">
                    <p style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);font-size: 10px;padding: 0px 5px;border-radius: 10px;">Ver todos</p>
                </RouterLink>
            </div>
        </div>

        <Carousel class="item-sombra2" ref="ckCarousel"
                  v-bind="settingsGames"
                  :breakpoints="breakpointsGames"
                  @init="onCarouselInit(index)"
                  @slide-start="onSlideStart(index)"
        >
            <Slide v-if="isLoading" v-for="(i, iloading) in 10" :index="iloading">
                <div  role="status" class="w-full flex items-center justify-center h-48 mr-6 max-w-sm bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700 text-4xl">
                    <i class="fa-duotone fa-gamepad-modern"></i>
                </div>
            </Slide>

            <Slide v-if="provider.games && !isLoading" v-for="(game, providerId) in provider.games" :index="providerId" class="p-2">
                <CassinoGameCard
                    :index="providerId"
                    :title="game.game_name"
                    :cover="game.cover"
                    :gamecode="game.game_code"
                    :type="game.distribution"
                    :game="game"
                />
            </Slide>
        </Carousel>
    </div>
</template>


<script>

import { Carousel, Navigation, Slide } from 'vue3-carousel';
import {onMounted, ref} from "vue";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";

export default {
    props: ['provider', 'index'],
    components: {CassinoGameCard, Carousel, Navigation, Slide },
    data() {
        return {
            isLoading: false,
            settingsGames: {
                itemsToShow: 2.5,
                snapAlign: 'start',
            },
            breakpointsGames: {
                700: {
                    itemsToShow: 3.5,
                    snapAlign: 'center',
                },
                1024: {
                    itemsToShow: 6,
                    snapAlign: 'start',
                },
            },
        }
    },
    setup(props) {
        const ckCarousel = ref(null)

        onMounted(() => {

        });

        return {
            ckCarousel
        };
    },
    computed: {

    },
    mounted() {

    },
    methods: {
        onCarouselInit(index) {

        },
        onSlideStart(index) {

        },
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
