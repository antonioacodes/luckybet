<template>
  <div v-if="provider && provider.games && provider.games.length" class="related-games mt-10">
    <div class="w-full flex justify-between items-center mb-3 px-2 md:px-0"
      style="border-radius: 0.6rem; background: linear-gradient(90deg,var(--card-color-dark), rgba(255, 255, 255, 0) 100%);">
      <h2 class="providersNames">
        Outros jogos de {{ provider.name }}
      </h2>
      <RouterLink :to="{ name: 'casinosAll', params: { provider: provider.id, category: 'all' } }">
        <p class="bg-[var(--ci-primary-opacity-color)] text-[var(--ci-primary-color)] text-xs px-3 py-1 rounded-full">
          Ver todos
        </p>
      </RouterLink>
    </div>
    <Carousel v-bind="settingsGames" :breakpoints="breakpointsGames" ref="carousel" class="mt-2 item-sombra2">
      <!-- 🌀 Loading / placeholders -->
      <Slide v-if="isLoading" v-for="n in 6" :key="n" class="px-1 sm:px-2">
        <div class="h-48 bg-gray-700 rounded-lg animate-pulse flex items-center justify-center text-gray-500 text-3xl">
          <i class="fa-duotone fa-gamepad-modern"></i>
        </div>
      </Slide>
      <!-- 🎮 Jogos do provedor -->
      <Slide v-else v-for="(game, idx) in provider.games" :key="game.id" :index="idx" class="px-1 sm:px-2">
        <CassinoGameCard :index="idx" :title="game.game_name" :cover="game.cover" :gamecode="game.game_code"
          :type="game.distribution" :game="game" />
      </Slide>
    </Carousel>
  </div>
</template>

<script>
import { Carousel, Slide } from "vue3-carousel";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
import HttpApi from "@/Services/HttpApi.js";

export default {
  components: { CassinoGameCard, Carousel, Slide },
  props: ["providerId"],
  data() {
    return {
      provider: null,
      isLoading: true,
      requestSequence: 0,
      settingsGames: {
        itemsToShow: 2.5,
        snapAlign: "start",
      },
      breakpointsGames: {
        700: { itemsToShow: 3.5, snapAlign: "center" },
        1024: { itemsToShow: 6, snapAlign: "start" },
      },
    };
  },
  watch: {
    providerId: {
      immediate: true,
      handler(newProviderId) {
        this.fetchProviderGames(newProviderId);
      },
    },
  },
  methods: {
    async fetchProviderGames(providerId = this.providerId) {
      const requestId = ++this.requestSequence;
      if (!providerId) {
        this.provider = null;
        this.isLoading = false;
        return;
      }

      this.isLoading = true;
      try {
        const response = await HttpApi.get(`providers/${providerId}/games`);
        if (requestId === this.requestSequence) {
          this.provider = response.data?.provider ?? null;
        }
      } catch (error) {
        if (requestId === this.requestSequence) {
          console.error("Erro ao carregar os jogos do provedor:", error);
          this.provider = null;
        }
      } finally {
        if (requestId === this.requestSequence) {
          this.isLoading = false;
        }
      }
    },
  },
};
</script>

<style scoped>
.providersNames {
  color: white;
  font-weight: 600;
  font-size: 18px;
  font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
}

.related-games {
  width: 100%;
}

/* 💡 gap entre os slides (garante espaçamento consistente em telas diferentes) */
.vue3-carousel__track>* {
  margin-right: 0.5rem;
  /* ~8px */
}

@media (min-width: 768px) {
  .vue3-carousel__track>* {
    margin-right: 1rem;
    /* ~16px */
  }
}

/* Responsividade */
@media (max-width: 600px) {
  .celular-providers-setas {
    display: none;
  }
    .providersNames {
  font-size: 14px;
}
}
</style>
