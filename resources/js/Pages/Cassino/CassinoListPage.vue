<template>
  <BaseLayout>
    <!-- --------------------------------------------------------------
         Loading (spinner) – aparece só na primeira chamada
    -------------------------------------------------------------- -->
    <LoadingComponent :isLoading="isLoading">
      <div class="text-center"><span>Carregando os jogos</span></div>
    </LoadingComponent>

    <!-- --------------------------------------------------------------
         Banners Carousel (mantido como antes)
    -------------------------------------------------------------- -->
    <div class="carousel-banners">
      <div class="mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px] padding-mobile-banner">
        <div class="mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]"
             style="position:fixed;bottom:0;z-index:2;pointer-events:auto;height:0px;">
          <button class="btn-scroll-top" @click="scrollToTop" style="pointer-events:auto;">
            <div>
              <svg height="1em" viewBox="0 0 384 512" width="1em"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"
                      fill="currentColor"></path>
              </svg>
            </div>
            <div>De volta ao topo</div>
          </button>
        </div>

        <Carousel v-bind="settings" :breakpoints="breakpoints" ref="carouselBanner">
          <Slide v-for="(banner, i) in banners" :key="i">
            <div class="carousel__item rounded w-full">
              <a :href="banner.link" class="w-full h-full bg-blue-800 rounded"></a>
            </div>
          </Slide>

          <template #addons>
            <navigation>
              <template #next><i class="fa-solid fa-chevron-right text-white font-arrows"></i></template>
              <template #prev><i class="fa-solid fa-chevron-left text-white font-arrows"></i></template>
            </navigation>
            <Pagination />
          </template>
        </Carousel>
      </div>
    </div>

    <!-- --------------------------------------------------------------
         Conteúdo principal (busca, título, grid de jogos)
    -------------------------------------------------------------- -->
    <div v-if="!isLoading" class="mx-auto">
      <div class="px-4">
        <HeaderComponent>
          <template #header></template>
        </HeaderComponent>

        <!-- ---------- Busca + título ---------- -->
        <form class="sm:max-w-[1110px] lg:max-w-[1110px] mx-auto w-full">
          <div class="flex"></div>

          <div class="flex justify-between mx-auto items-center md:mt-[30px] mb-[25px] mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]">
            <div class="flex items-center">
              <a style="margin-right:10px;" href="/casino">
                <svg height="1em" viewBox="0 0 448 512" width="1em"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l-160 160z"
                        fill="currentColor"></path>
                </svg>
              </a>
              <p class="text-2xl flex items-center justify-center"
                 style="font-size:14px;font-weight:700;color:white;">
                {{ $t('Todos os Jogos') }}
              </p>
            </div>

            <!-- Busca desktop -->
            <div class="md:block hidden">
              <input
                style="background-color:var(--input-primary);padding:0 55px 0 25px;border-radius:3px;font-size:14px;height:32px;"
                v-model="searchTerm"
                @input="searchGames"
                type="search"
                id="search"
                class="block relative w-full"
                :placeholder="$t('Pesquise um jogo...')"
                required>
            </div>

            <!-- Ícones de busca/limpar mobile -->
            <div class="flex items-center gap-4 md:hidden block">
              <svg height="1rem" width="1rem"
                   viewBox="0 0 512 512"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M505 41L320 225.93V488c0 19.51-22 30.71-37.76 19.66l-80-56A24 24 0 0 1 192 432V226L7 41C-8 25.87 2.69 0 24 0h464c21.33 0 32 25.9 17 41z"
                      fill="currentColor" opacity="0.4"></path>
              </svg>
              <svg height="1rem" width="1rem"
                   viewBox="0 0 512 512"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1a12 12 0 0 1 0 17L338 377.6a12 12 0 0 1-17 0L256 312l-65.1 65.6a12 12 0 0 1-17 0L134.4 338a12 12 0 0 1 0-17l65.6-65-65.6-65.1a12 12 0 0 1 0-17l39.6-39.6a12 12 0 0 1 17 0l65 65.7 65.1-65.6a12 12 0 0 1 17 0l39.6 39.6a12 12 0 0 1 0 17L312 256z"
                      fill="currentColor" opacity="0.4"></path>
                <path d="M377.6 321.1a12 12 0 0 1 0 17L338 377.6a12 12 0 0 1-17 0L256 312l-65.1 65.6a12 12 0 0 1-17 0L134.4 338a12 12 0 0 1 0-17l65.6-65-65.6-65.1a12 12 0 0 1 0-17l39.6-39.6a12 12 0 0 1 17 0l65 65.7 65.1-65.6a12 12 0 0 1 17 0l39.6 39.6a12 12 0 0 1 0 17L312 256z"
                      fill="currentColor"></path>
              </svg>
            </div>
          </div>
        </form>

        <!-- Busca mobile (full‑width) -->
        <div class="md:hidden block w-full">
          <input
            style="width:100%;background-color:var(--input-primary);padding:0 55px 0 25px;border-radius:3px;font-size:12px;height:30px;"
            v-model="searchTerm"
            @input="searchGames"
            type="search"
            id="search"
            class="block relative w-full"
            :placeholder="$t('Pesquise um jogo...')"
            required>
        </div>

        <!-- --------------------------------------------------------------
             Grid de jogos + sentinel (infinite scroll)
        -------------------------------------------------------------- -->
        <div v-if="games && games.total > 0">
          <div class="relative w-full sm:max-w-[690px] lg:max-w-[1110px] mx-auto md:mt-10 mt-6">
            <div class="grid grid-cols-3 md:grid-cols-6 gap-4 mb-5">
              <CassinoGameCard
                v-for="(game, i) in games.data"
                :key="game.id"
                :index="i"
                :title="game.game_name"
                :cover="game.cover"
                :gamecode="game.game_code"
                :type="game.distribution"
                :game="game"
              />
            </div>

            <!-- Sentinel – só aparece enquanto houver mais páginas -->
            <div
              v-if="hasMorePages"
              ref="loadMoreSentinel"
              class="h-1">
            </div>

            <!-- Spinner pequeno enquanto carrega o próximo lote -->
            <div v-if="loadingMore" class="text-center py-2 text-sm text-gray-400">
              Carregando mais jogos…
            </div>
          </div>
        </div>

        <!-- Mensagem “sem dados” -->
        <div v-else class="empty-data flex flex-col justify-center items-center text-center mt-[50px] mb-[30px] sm:max-w-[690px] lg:max-w-[1110px] mx-auto w-full">
          <div class="flex justify-center p-2 w-full"
               style="background-color:#383028;border-radius:5px;">
            <h3 style="color:#FF9F43;font-size:.75rem;">{{ $t('No data to show') }}</h3>
          </div>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import HttpApi from "@/Services/HttpApi.js";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
import CustomPagination from "@/Components/UI/CustomPagination.vue";
import { useRoute } from "vue-router";
import { ref, onMounted, onBeforeUnmount, nextTick } from "vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderComponent from "@/Components/UI/HeaderComponent.vue";

export default {
  name: "GamesPage",

  components: {
    BaseLayout,
    HeaderComponent,
    LoadingComponent,
    CustomPagination,
    CassinoGameCard
  },

  data() {
    return {
      /* ---------- BANNERS ---------- */
      settings: {
        itemsToShow: 1,
        snapAlign: "center",
        autoplay: 6000,
        wrapAround: true
      },
      breakpoints: {
        700: { itemsToShow: 1, snapAlign: "center" },
        1024: { itemsToShow: 1, snapAlign: "center" }
      },
      banners: null,
      bannersHome: null,

      /* ---------- JOGOS ---------- */
      isLoading: false,          // spinner da primeira carga
      loadingMore: false,        // spinner pequeno durante o scroll
      games: null,               // { data: [], total, last_page, … }
      searchTerm: "",
      /* ---------- INFINITE SCROLL ---------- */
      currentPage: 1,            // página já carregada
      perPage: 12,               // quantidade a ser acrescentada a cada scroll
      initialLoadCount: 24,      // quantidade na primeira carga
      observer: null,            // IntersectionObserver instance

      // Se a API usa outro nome para o filtro de provider, altere aqui:
      providerParam: "provider", // ex.: "provider_id" ou "provider"
      // Nome do parâmetro de paginação (algumas APIs usam `limit`):
      paginationParam: "per_page"
    };
  },

  // -----------------------------------------------------------------
  // 1️⃣ Setup – apenas para obter a rota (mantém o que já tinha)
  // -----------------------------------------------------------------
  setup() {
    const route = useRoute();
    return { route };
  },

  // -----------------------------------------------------------------
  // 2️⃣ Métodos (banners, busca, fetch, infinite‑scroll)
  // -----------------------------------------------------------------
  methods: {
    /* ---------- BANNERS ---------- */
    async getBanners() {
      try {
        const response = await HttpApi.get("settings/banners");
        const all = response.data.banners;
        this.banners = all.filter(b => b.type === "carousel");
        this.bannersHome = all.filter(b => b.type === "home");
      } catch (e) {
        console.error("[BANNERS] →", e);
      }
    },

    async initializeMethods() {
      await this.getBanners();
    },

    /* ---------- BUSCA ---------- */
    async searchGames() {
      // Sempre volta à página 1 ao buscar
      await this.getGameData(1, false, false);
    },

    /* ---------- FETCH DE JOGOS ----------
       page   – número da página
       loading – true → spinner da tela inteira (primeira carga)
       append – true → concatena ao array existente
    */
    async getGameData(page = 1, loading = true, append = false) {
      this.isLoading = loading && !append;
      this.loadingMore = !loading && append;

      // ----------- PARÂMETROS DA ROTA -----------
      const provider = this.route.params.provider || "";
      let category = this.route.params.category || "";
      // Se a rota traz "all", omitimos o parâmetro (a API entende como "sem filtro")
      if (category === "all") category = "";

      // ----------- MONTAGEM DA QUERY ----------
      const query =
        `/casinos/games?page=${page}` +
        `&${this.paginationParam}=${append ? this.perPage : this.initialLoadCount}` +
        `&searchTerm=${encodeURIComponent(this.searchTerm)}` +
        (provider ? `&${this.providerParam}=${provider}` : "") +
        (category ? `&category=${category}` : "");

      try {
        const response = await HttpApi.get(query);
        const payload = response.data.games; // { data: [], total, last_page?, … }

        // Caso a API não retorne `last_page`, calculamos a partir de `total`
        if (!payload.last_page) {
          const total = payload.total || 0;
          const itemsPer = append ? this.perPage : this.initialLoadCount;
          payload.last_page = Math.ceil(total / itemsPer);
        }

        // ---------- Atualiza a lista ----------
        if (append) {
          this.games = {
            ...payload,
            data: [...(this.games?.data || []), ...payload.data]
          };
        } else {
          this.games = payload;
        }

        this.currentPage = page;

        // ---------- OBSERVER ----------
        await nextTick();           // garante que o DOM já está atualizado
        this.attachObserver();      // re‑anexa ao sentinel (se ele mudou)
      } catch (e) {
        console.error("[GET GAMES] →", e);
      } finally {
        this.isLoading = false;
        this.loadingMore = false;
      }
    },

    /* ---------- INFINITE SCROLL ----------
       Salva a posição atual e a restaura depois de inserir novos itens
    */
    async loadMore() {
      if (this.loadingMore) return;
      if (!this.hasMorePages) return;

      const previousY = window.scrollY; // guarda posição antes da chamada

      console.log("[INFINITE SCROLL] → página", this.currentPage + 1);
      await this.getGameData(this.currentPage + 1, false, true);

      // restaura a posição exatamente onde o usuário estava
      window.scrollTo(0, previousY);
    },

    /* ---------- SCROLL TO TOP ---------- */
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },

    /* ---------- OBSERVER ----------
       Cria (ou reutiliza) o IntersectionObserver e garante que ele
       esteja observando o elemento `loadMoreSentinel`.
    */
    attachObserver() {
      const sentinel = this.$refs.loadMoreSentinel;
      if (!sentinel) return; // ainda não há sentinel

      if (!this.observer) {
        this.observer = new IntersectionObserver(
          entries => {
            entries.forEach(entry => {
              if (entry.isIntersecting) this.loadMore();
            });
          },
          { rootMargin: "200px" } // dispara um pouco antes do fim
        );
      }

      // Remove observação anterior (caso o sentinel tenha sido recriado)
      this.observer.disconnect();
      this.observer.observe(sentinel);
    }
  },

  // -----------------------------------------------------------------
  // 3️⃣ Computed – auxiliares de paginação
  // -----------------------------------------------------------------
  computed: {
    /** true enquanto ainda existir página seguinte */
    hasMorePages() {
      if (!this.games) return false;
      const last = this.games.last_page ??
        Math.ceil((this.games.total || 0) / this.perPage);
      return this.currentPage < last;
    }
  },

  // -----------------------------------------------------------------
  // 4️⃣ Ciclo de vida (cria / destrói o observer)
  // -----------------------------------------------------------------
  async created() {
    await this.initializeMethods();
    // Primeiro carregamento = 24 itens
    await this.getGameData(1, false, false);
  },

  mounted() {
    // O sentinel só aparece depois da primeira requisição;
    // `attachObserver` será chamado novamente em `getGameData` (nextTick)
    // mas chamamos aqui para garantir o caso de carregamento rápido.
    this.attachObserver();
  },

  beforeUnmount() {
    if (this.observer) this.observer.disconnect();
  },

  // -----------------------------------------------------------------
  // 5️⃣ Watch – recarrega a lista ao mudar provider ou category
  // -----------------------------------------------------------------
  watch: {
    "route.params.provider"() {
      this.getGameData(1, true, false);
    },
    "route.params.category"() {
      this.getGameData(1, true, false);
    }
  }
};
</script>

<style scoped>
/* Nenhum estilo especial é necessário para o infinite‑scroll.
   O sentinel tem 1 px de altura e é invisível. Caso queira vê‑lo
   ao testar, descomente a cor abaixo. */
.load-more-sentinel {
  height: 1px;
  /* background: rgba(255,0,0,0.2); */
}
</style>
