<template>
  <section class="yz7U6 dm-sans item-sombra2">
    <!-- ---------- Título + setas ---------- -->
    <h2 class="section-title">
      💰 Pagando Muito
      
    </h2>

    <!-- ---------- Cards (gerados dinamicamente) ---------- -->
    <div class="wtPU- no-scrollbar" ref="scrollContainer" @scroll="checkScroll">
      <a v-for="(game, idx) in featuredGames"
         :key="game.id"
         :href="`/games/play/${game.id}/${game.game_id}`"
         class="v2Vvu dm-sans"
         draggable="false"
         style="-webkit-user-drag: none;">

        <!-- Badge de ranking (círculo amarelo) -->
        <div class="rank-badge">
          <span>{{ idx + 1 }}</span>
        </div>

        <div class="oNVRM">
          <!-- Nome e valor (valor em amarelo puro) -->
          <div class="wPNhi">
            <div class="reJOl">{{ game.game_name }}</div>
            <div class="aWjga">R$ {{ formatValue(game.payout) }}</div>
          </div>
        </div>

        <!-- Capa do jogo (wrapper) -->
        <div class="cover-wrapper"
             :style="{ backgroundImage: `url('${game.cover}')` }"
             :title="game.game_name">
        </div>

        <!-- Botão JOGAR -->
        <button class="b619O"
                @click.stop="playGame(game.slug)">
          <span class="relative dm-sans z-10">JOGAR</span>
        </button>
      </a>
    </div>
  </section>
</template>


<style>
  /* ---------- ESTILOS GLOBAIS ---------- */
body * {
  font-family: var(--font-text);
  word-spacing: 1px;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  touch-action: auto !important;
}
a, button { opacity: 1; outline: 2px solid transparent; outline-offset: 2px; }
a { color: inherit; text-decoration: inherit; }

/* ---------- TÍTULO ---------- */
.QPS3e {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: .5rem;
  background: linear-gradient(90deg, var(--card-color-dark), rgba(255,255,255,0) 100%);
  border-radius: .6rem;
  margin: 1.2rem 0 1rem 0;
  padding: .8rem 1rem;
  font-size: 18px;
  font-weight: 600;
  color: #fff;
}

/* ---------- SETAS DE NAVEGAÇÃO ---------- */
.nav-arrow {
  background: rgba(255,255,255,.1);
  border: none;
  border-radius: .375rem;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all .2s;
  color: #fff;
}
.nav-arrow:hover { background: rgba(188,213,13,.3); }
.nav-arrow:disabled { opacity: .3; cursor: not-allowed; }

/* ---------- CONTAINER DE SCROLL ---------- */
.wtPU- {
  display: flex;
  gap: .75rem;
  overflow-x: auto;
  padding-top: 0.5rem;
  padding-right: 1rem;
  padding-bottom: 0.5rem;
  -ms-overflow-style: none !important;   /* IE/Edge */
  scrollbar-width: none !important;      /* Firefox */
}
.wtPU-::-webkit-scrollbar { height: 6px; }
.wtPU-::-webkit-scrollbar-track { background: transparent; }
.wtPU-::-webkit-scrollbar-thumb {
  background: rgba(188,213,13,.3);
  border-radius: 3px;
}
.wtPU-::-webkit-scrollbar-thumb:hover { background: rgba(188,213,13,.5); }

/* ---------- CARD (estrutura principal) ---------- */
.v2Vvu,
.v2Vvu .oNVRM { position: relative; }

.v2Vvu {
  border: 1px solid var(--ci-primary-color);   /* #D6ED16 */
  border-radius: .25rem;
  background: url('https://i.imgur.com/yOQruil.png');
  background-size: contain;
  width: 176px;
  height: 112px;
  flex-shrink: 0;
  padding: .5rem;
  overflow: hidden;
  display: block;
}

/* ---------- Badge de ranking (círculo) ---------- */
.rank-badge {
  position: absolute;
  top: 3px;
  left: 6px;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.25rem;
  color: var(--ci-primary-color);          /* amarelo puro, como na imagem */
  z-index: 10;
}

/* ---------- Nome do jogo ---------- */
.reJOl {
  margin-left:54px;
  font-weight: 400;        /* bold, conforme a captura */
  font-size: .525rem;
  color: #fff;
  white-space: nowrap;     /* Impede que o texto quebre a linha */
  overflow: hidden;        /* Esconde o conteúdo que ultrapassa o limite */
  text-overflow: ellipsis; /* Adiciona as reticências (...) ao texto cortado */
  max-width: 100px;        /* Defina uma largura máxima para o nome do jogo, ajuste conforme necessário */
}


/* ---------- Valor do payout (amarelo brilhante) ---------- */
.aWjga {
  text-align: center;
  margin-left:42px;
  font-weight: 700;
  font-size: .775rem;
  color: var(--ci-primary-color);          /* amarelo puro */
}

/* ---------- Capa do jogo (wrapper) ---------- */
.cover-wrapper {
  width: 50px;            /* 144 × 80 px = proporção 1.8, similar ao mock */
  height: 50px;    /* centraliza verticalmente dentro do card */
  border-radius: .25rem;
  background-size: cover;
  margin-top: 0.5rem;
  background-position: center;
  position: relative;
  overflow: hidden;
}
.cover-overlay {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

/* ---------- Botão JOGAR ---------- */
.b619O {
  position: absolute;
  right: 7px;
  bottom: 12px;
  background: linear-gradient(135deg, var(--ci-primary-opacity-color), var(--ci-primary-color));
  border: none;
  border-radius: .2rem;
  width: 82px;
  height: 30px;
  font-weight: 600;
  font-size: .575rem;
  color: #fff;
  cursor: pointer;
  text-transform: uppercase;
  box-shadow: 0 4px 12px rgba(34,197,94,.3);
  transition: all .2s;
}
.b619O:hover {
  transform: scale(1.02);           /* efeito sutil como na referência */
}
.b619O:active { transform: scale(.98); }

/* ---------- RESPONSIVO ---------- */
@media (max-width: 768px) {
  .v2Vvu { width: 150px; height: 96px; }
  .b619O { width:62px; height: 30px; }
  .aWjga { font-size: 0.5rem; }
  .nav-arrow { display: none; }
}

@media (max-width: 1024px) {
    .dark .item-sombra2:after {
        content: "";
        background: linear-gradient(to right, rgb(33 36 37 / 0%), var(--carousel-banners-dark));
        z-index: 5;
    }
}
</style>

<script>
export default {
  name: "PagandoMuitoSection",
  data() {
    return {
      featuredGames: []   // lista já embaralhada (uma vez por dia)
    };
  },
  methods: {
    /* ---------------------------------------------------------
     * 1️⃣ Carrega os games featured e garante ordem diária
     * --------------------------------------------------------- */
    async loadFeaturedGames() {
      try {
        const resp = await fetch(
          "https://luckybet777.com.br/api/featured/games"
        );
        const data = await resp.json();

        // Apenas os que têm is_featured = 1
        const featured = data.featured_games.filter(
          g => g.is_featured === 1
        );

        const today = new Date().toISOString().slice(0, 10);
        const cached = localStorage.getItem("featuredOrder");

        let ordered;
        if (cached) {
          const parsed = JSON.parse(cached);
          if (parsed.date === today && parsed.ids?.length === featured.length) {
            ordered = parsed.ids
              .map(id => featured.find(g => g.id === id))
              .filter(Boolean);
          }
        }

        if (!ordered) {
          ordered = this.shuffleArray(featured);
          const ids = ordered.map(g => g.id);
          localStorage.setItem(
            "featuredOrder",
            JSON.stringify({ date: today, ids })
          );
        }

        this.featuredGames = ordered;
      } catch (e) {
        console.error("Erro ao carregar featured games:", e);
      }
    },

    /* ---------------------------------------------------------
     * 2️⃣ Embaralha (Fisher‑Yates)
     * --------------------------------------------------------- */
    shuffleArray(arr) {
      const copy = arr.slice();
      for (let i = copy.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [copy[i], copy[j]] = [copy[j], copy[i]];
      }
      return copy;
    },

    /* ---------------------------------------------------------
     * 3️⃣ Formata o valor monetário (R$ 4.036.311,92)
     * --------------------------------------------------------- */
    formatValue(value) {
      if (value === null || value === undefined) return "0,00";
      const num = typeof value === "string" ? parseFloat(value) : value;
      return num
        .toLocaleString("pt-BR", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
        .replace(".", ".")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    /* ---------------------------------------------------------
     * 4️⃣ Navegação com setas
     * --------------------------------------------------------- */
    scrollLeft() {
      const c = this.$refs.scrollContainer;
      c.scrollBy({ left: -300, behavior: "smooth" });
    },
    scrollRight() {
      const c = this.$refs.scrollContainer;
      c.scrollBy({ left: 300, behavior: "smooth" });
    },
    checkScroll() {
      const c = this.$refs.scrollContainer;
      const leftBtn = this.$refs.leftArrow;
      const rightBtn = this.$refs.rightArrow;
      if (c && leftBtn && rightBtn) {
        leftBtn.disabled = c.scrollLeft <= 0;
        rightBtn.disabled =
          c.scrollLeft >= c.scrollWidth - c.clientWidth - 1;
      }
    },

    /* ---------------------------------------------------------
     * 5️⃣ Ações do usuário
     * --------------------------------------------------------- */
    openGame(slug) {
      console.log("Abrindo jogo:", slug);
      // Implementar a navegação para o jogo (router.push, window.open, etc.)
    },
    playGame(slug) {
      console.log("Jogando:", slug);
      // Implementar a lógica de iniciar a partida
    }
  },

  mounted() {
    this.loadFeaturedGames();
    this.$nextTick(() => this.checkScroll());
  }
};
</script>

