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
  // REMOVA o mounted() daqui, pois o watcher com immediate: true fará a chamada inicial
  // async mounted() {
  //   await this.fetchProviderGames();
  // },
  watch: {
    // Adicione este watcher para reagir a mudanças na prop providerId
    providerId: {
      immediate: true, // Garante que a função seja executada na montagem inicial
      handler(newProviderId, oldProviderId) {
        // Só busca os detalhes se o providerId realmente mudou
        if (newProviderId && newProviderId !== oldProviderId) {
          console.log(`[ProvidersRelatedGames] Provider ID mudou de ${oldProviderId} para ${newProviderId}. Recarregando jogos.`);
          this.fetchProviderGames();
        } else if (newProviderId && !oldProviderId) {
          // Caso de primeira montagem onde newProviderId é válido e oldProviderId é undefined
          this.fetchProviderGames();
        } else if (!newProviderId) {
          // Se o providerId se tornar nulo ou indefinido, podemos limpar os dados
          this.provider = null;
          this.isLoading = false;
        }
      },
    },
  },
  methods: {
    async fetchProviderGames() {
      if (!this.providerId) {
        this.provider = null; // Limpa dados anteriores se não houver providerId
        this.isLoading = false;
        return;
      }
      this.isLoading = true;
      try {
        const response = await HttpApi.get(`providers/${this.providerId}/games`);
        this.provider = response.data.provider || {};
      } catch (err) {
        console.error("❌ Erro ao carregar os jogos do provedor:", err);
        this.provider = null; // Limpa o provedor em caso de erro
      } finally {
        this.isLoading = false;
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
