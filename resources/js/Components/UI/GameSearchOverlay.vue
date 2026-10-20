<template>
    <Teleport to="body">
        <Transition name="game-search">
            <div
                v-if="isOpen"
                class="game-search-backdrop"
                role="presentation"
                @click.self="close"
            >
                <section
                    class="game-search-panel"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="game-search-title"
                    @click.stop
                >
                    <div class="game-search-toolbar">
                        <div class="game-search-input-wrap">
                            <svg aria-hidden="true" viewBox="0 0 24 24" class="game-search-icon">
                                <circle cx="10.8" cy="10.8" r="6.8" />
                                <path d="m16 16 5 5" />
                            </svg>
                            <input
                                ref="searchInput"
                                v-model="searchTerm"
                                type="search"
                                autocomplete="off"
                                autocapitalize="off"
                                spellcheck="false"
                                aria-label="Pesquisar jogos"
                                placeholder="Pesquise jogos de cassino"
                                @input="onSearchInput"
                            >
                            <button
                                v-if="searchTerm"
                                type="button"
                                class="game-search-clear"
                                @click="clearSearch"
                            >
                                Limpar
                            </button>
                        </div>
                        <button
                            type="button"
                            class="game-search-close"
                            aria-label="Fechar pesquisa"
                            @click="close"
                        >
                            <svg aria-hidden="true" viewBox="0 0 24 24">
                                <path d="m6 6 12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>

                    <div class="game-search-tabs">
                        <span class="game-search-tab game-search-tab-active">Cassino</span>
                    </div>

                    <div class="game-search-content">
                        <div class="game-search-heading">
                            <h2 id="game-search-title">
                                {{ searchTerm.trim().length >= minimumCharacters
                                    ? 'Resultados da busca'
                                    : 'Jogos para você' }}
                            </h2>
                            <span v-if="searching || (loadingSuggestions && searchTerm.trim().length < minimumCharacters)" class="game-search-loading-label" aria-live="polite">
                                {{ searching ? 'Buscando...' : 'Carregando sugestões...' }}
                            </span>
                        </div>

                        <p v-if="searchTerm.trim().length < minimumCharacters" class="game-search-hint">
                            Digite pelo menos 3 caracteres para pesquisar.
                        </p>

                        <div
                            v-if="searching || (loadingSuggestions && searchTerm.trim().length < minimumCharacters)"
                            class="game-search-grid"
                            aria-label="Carregando jogos"
                            aria-busy="true"
                        >
                            <div v-for="n in 12" :key="'skeleton-' + n" class="game-search-skeleton">
                                <div class="game-search-skeleton-cover"></div>
                                <div class="game-search-skeleton-line"></div>
                            </div>
                        </div>

                        <div v-else-if="visibleGames.length" class="game-search-grid">
                            <div
                                v-for="(game, index) in visibleGames"
                                :key="game.id || game.game_code || index"
                                class="game-search-card"
                                @click="close"
                            >
                                <CassinoGameCard :index="index" :game="game" />
                                <p class="game-search-game-name">{{ game.game_name }}</p>
                            </div>
                        </div>

                        <div v-else-if="searchTerm.trim().length >= minimumCharacters" class="game-search-empty" role="status">
                            <p v-if="searchError">{{ searchError }}</p>
                            <p v-else>Nenhum jogo encontrado para esta busca.</p>
                        </div>

                        <div v-else class="game-search-empty game-search-empty-muted">
                            Nenhum jogo sugerido no momento.
                        </div>
                    </div>
                </section>
            </div>
        </Transition>
    </Teleport>
</template>

<script>
import HttpApi from "@/Services/HttpApi.js";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
import { searchGameStore } from "@/Stores/SearchGameStore.js";

export default {
    name: "GameSearchOverlay",
    components: { CassinoGameCard },
    props: {
    },
    data() {
        return {
            minimumCharacters: 3,
            searchTerm: "",
            results: [],
            suggestedGames: [],
            loadingSuggestions: false,
            suggestionsLoaded: false,
            searching: false,
            searchError: "",
            debounceTimer: null,
            requestSequence: 0,
            previousBodyOverflow: "",
        };
    },
    computed: {
        searchStore() {
            return searchGameStore();
        },
        isOpen() {
            return this.searchStore.searchgameStatus;
        },
        visibleGames() {
            return this.searchTerm.trim().length >= this.minimumCharacters
                ? this.results
                : this.suggestedGames;
        },
    },
    watch: {
        isOpen(open) {
            if (open) {
                this.previousBodyOverflow = document.body.style.overflow;
                document.body.style.overflow = "hidden";
                document.addEventListener("keydown", this.onGlobalKeydown);
                this.$nextTick(() => this.$refs.searchInput?.focus());
                if (!this.suggestionsLoaded) this.loadSuggestions();
            } else {
                this.restorePageScroll();
                this.resetSearch();
            }
        },
    },
    beforeUnmount() {
        document.removeEventListener("keydown", this.onGlobalKeydown);
        this.restorePageScroll();
        clearTimeout(this.debounceTimer);
        if (this.searchStore.searchgameStatus) {
            this.searchStore.closeSearch();
        }
    },
    methods: {
        async loadSuggestions() {
            this.loadingSuggestions = true;

            try {
                const response = await HttpApi.get("games/all");
                const providers = response.data?.providers ?? [];
                const seen = new Set();

                this.suggestedGames = providers
                    .flatMap((provider) => provider.games ?? [])
                    .filter((game) => {
                        const id = String(game.id ?? game.game_code ?? "");
                        if (!game.status || !id || seen.has(id)) return false;
                        seen.add(id);
                        return true;
                    })
                    .slice(0, 14);
            } catch (error) {
                this.suggestedGames = [];
            } finally {
                this.suggestionsLoaded = true;
                this.loadingSuggestions = false;
            }
        },
        onGlobalKeydown(event) {
            if (event.key === "Escape") this.close();
        },
        restorePageScroll() {
            document.body.style.overflow = this.previousBodyOverflow;
        },
        resetSearch() {
            clearTimeout(this.debounceTimer);
            this.requestSequence += 1;
            this.searchTerm = "";
            this.results = [];
            this.searching = false;
            this.searchError = "";
        },
        close() {
            this.searchStore.closeSearch();
        },
        clearSearch() {
            this.searchTerm = "";
            this.onSearchInput();
            this.$refs.searchInput?.focus();
        },
        onSearchInput() {
            clearTimeout(this.debounceTimer);
            const term = this.searchTerm.trim();
            const requestSequence = ++this.requestSequence;
            this.searchError = "";
            this.results = [];

            if (term.length < this.minimumCharacters) {
                this.searching = false;
                return;
            }

            this.searching = true;
            this.debounceTimer = setTimeout(() => this.fetchGames(term, requestSequence), 300);
        },
        async fetchGames(term, requestSequence) {
            try {
                const response = await HttpApi.get("games/search", {
                    params: { q: term },
                });

                if (requestSequence !== this.requestSequence) return;
                this.results = response.data?.games ?? [];
            } catch (error) {
                if (requestSequence !== this.requestSequence) return;
                this.searchError = "Não foi possível carregar os jogos. Tente novamente.";
                this.results = [];
            } finally {
                if (requestSequence === this.requestSequence) {
                    this.searching = false;
                }
            }
        },
    },
};
</script>

<style>
.game-search-backdrop {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: max(24px, env(safe-area-inset-top)) 20px max(24px, env(safe-area-inset-bottom));
    background: rgba(0, 5, 9, 0.84);
    backdrop-filter: blur(3px);
    overflow-y: auto;
}
.game-search-panel {
    width: min(100%, 1120px);
    max-height: calc(100dvh - 48px);
    margin: auto 0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid var(--ci-gray-dark);
    border-radius: 14px;
    color: var(--title-color);
    background: var(--ci-gray-over);
    box-shadow: 0 24px 80px rgba(0, 0, 0, 0.45);
}
.game-search-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px 10px;
}
.game-search-input-wrap {
    min-width: 0;
    height: 54px;
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 14px;
    border: 1px solid var(--ci-gray-dark);
    border-radius: 9px;
    background: var(--input-primary);
    transition: border-color 160ms ease, box-shadow 160ms ease;
}
.game-search-icon {
    width: 22px;
    height: 22px;
    flex: 0 0 auto;
    fill: none;
    stroke: var(--title-color);
    stroke-width: 2;
}
.game-search-panel .game-search-toolbar .game-search-input-wrap > input[type="search"] {
    all: unset;
    box-sizing: border-box;
    display: block;
    width: 100%;
    min-width: 0;
    flex: 1 1 auto;
    color: var(--title-color);
    caret-color: var(--ci-primary-color);
    font: inherit;
    font-size: 16px;
    line-height: 1.4;
}
.game-search-input-wrap:focus-within {
    border-color: var(--ci-primary-color);
    box-shadow: 0 0 0 2px var(--ci-primary-opacity-color);
}
.game-search-panel .game-search-toolbar .game-search-input-wrap > input[type="search"]::placeholder {
    color: var(--title-color);
    opacity: 1;
}
.game-search-panel .game-search-toolbar .game-search-input-wrap > input[type="search"]::-webkit-search-cancel-button {
    display: none;
}
.game-search-clear,
.game-search-close {
    flex: 0 0 auto;
    border: 0;
    color: var(--title-color);
    background: transparent;
    cursor: pointer;
}
.game-search-close:hover {
    color: var(--ci-primary-color);
}
.game-search-clear {
    padding: 6px 9px;
    border-radius: 5px;
    color: var(--title-color);
    background: var(--ci-primary-opacity-color);
    font-size: 13px;
}
.game-search-close {
    width: 32px;
    height: 40px;
    padding: 4px;
}
.game-search-close svg {
    width: 24px;
    height: 24px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
}
.game-search-tabs {
    padding: 0 20px;
}
.game-search-tab {
    display: inline-flex;
    align-items: center;
    min-height: 42px;
    padding: 0 22px;
    border-radius: 22px;
    color: var(--title-color);
    background: var(--input-primary);
    font-size: 14px;
    font-weight: 600;
}
.game-search-tab-active {
    color: var(--title-color);
    background: var(--ci-primary-opacity-color);
    box-shadow: inset 0 0 0 1px var(--ci-primary-color);
}
.game-search-content {
    min-height: 120px;
    padding: 18px 20px 24px;
    overflow-y: auto;
    overscroll-behavior: contain;
}
.game-search-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
}
.game-search-heading h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
}
.game-search-loading-label,
.game-search-hint,
.game-search-empty {
    color: var(--title-color);
    font-size: 14px;
}
.game-search-hint {
    margin: 0 0 14px;
}
.game-search-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 16px;
}
.game-search-card {
    min-width: 0;
    cursor: pointer;
}
.game-search-card > a,
.game-search-card > a > div {
    display: block;
    width: 100%;
    aspect-ratio: 0.72;
    overflow: hidden;
    border-radius: 8px;
}
.game-search-game-name {
    margin: 7px 2px 0;
    overflow: hidden;
    color: var(--title-color);
    font-size: 12px;
    line-height: 1.35;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.game-search-skeleton {
    min-width: 0;
}
.game-search-skeleton-cover {
    width: 100%;
    aspect-ratio: 0.72;
    border-radius: 8px;
    background: linear-gradient(100deg, var(--ci-gray-dark) 25%, var(--ci-gray-over) 40%, var(--ci-gray-dark) 65%);
    background-size: 200% 100%;
    animation: game-search-shimmer 1.15s ease-in-out infinite;
}
.game-search-skeleton-line {
    width: 72%;
    height: 10px;
    margin: 9px 2px 0;
    border-radius: 6px;
    background: linear-gradient(100deg, var(--ci-gray-dark) 25%, var(--ci-gray-over) 40%, var(--ci-gray-dark) 65%);
    background-size: 200% 100%;
    animation: game-search-shimmer 1.15s ease-in-out infinite;
}
.game-search-empty {
    padding: 28px 8px;
    text-align: center;
}
.game-search-empty-muted {
    padding-top: 14px;
    text-align: left;
}
.game-search-empty p {
    margin: 0;
}
@keyframes game-search-shimmer {
    to { background-position-x: -200%; }
}
.game-search-enter-active,
.game-search-leave-active {
    transition: opacity 160ms ease;
}
.game-search-enter-from,
.game-search-leave-to {
    opacity: 0;
}
@media (max-width: 900px) {
    .game-search-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }
}
@media (max-width: 600px) {
    .game-search-backdrop {
        padding: max(8px, env(safe-area-inset-top)) 8px max(8px, env(safe-area-inset-bottom));
    }
    .game-search-panel {
        max-height: calc(100dvh - 16px);
        margin: 0;
        border-radius: 10px;
    }
    .game-search-toolbar {
        gap: 6px;
        padding: 12px 10px 8px;
    }
    .game-search-input-wrap {
        height: 48px;
        gap: 8px;
        padding: 0 10px;
    }
    .game-search-panel .game-search-toolbar .game-search-input-wrap > input[type="search"] {
        font-size: 15px;
    }
    .game-search-close {
        width: 30px;
    }
    .game-search-tabs {
        padding: 0 10px;
    }
    .game-search-tab {
        min-height: 36px;
        padding: 0 18px;
        font-size: 13px;
    }
    .game-search-content {
        padding: 16px 10px 20px;
    }
    .game-search-heading h2 {
        font-size: 17px;
    }
    .game-search-hint,
    .game-search-loading-label,
    .game-search-empty {
        font-size: 13px;
    }
    .game-search-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px 8px;
    }
    .game-search-game-name {
        margin-top: 5px;
        font-size: 11px;
    }
}
@media (max-width: 380px) {
    .game-search-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>
