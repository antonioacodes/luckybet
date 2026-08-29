<template>
    <div class="spribe-mines w-full max-w-[800px] mx-auto bg-[#0f1923] rounded-xl overflow-hidden shadow-2xl font-sans select-none relative flex flex-col" style="min-height: 620px;">

        <!-- Fundo Azul Degradê -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#0052cc] to-[#003d99] z-0"></div>

        <!-- Elementos de Fundo (Estrelas/Bombas transparentes) -->
        <div class="absolute left-[-20px] top-[10%] text-white opacity-5 text-[200px] font-black rotate-12 pointer-events-none">💎</div>
        <div class="absolute right-[-20px] bottom-[20%] text-white opacity-5 text-[150px] font-black -rotate-12 pointer-events-none">💣</div>

        <!-- 🟢 HEADER -->
        <!-- Mudei de z-10 para z-30 para garantir que o menu fique POR CIMA do jogo -->
        <div class="relative z-30 flex justify-between items-center px-4 py-3 bg-[#002966]/80 backdrop-blur-md border-b border-[#003d99]">
            <div class="flex items-center gap-3">

                <!-- Dropdown de Minas (Agora com Clique) -->
                <div class="relative">
                    <!-- Botão que abre/fecha -->
                    <button 
                        @click="showMinesMenu = !showMinesMenu"
                        :disabled="gameActive"
                        class="bg-[#001f4d] hover:bg-[#002966] text-white text-xs font-bold px-4 py-2 rounded-full border border-[#003d99] cursor-pointer flex items-center gap-2 transition-all disabled:opacity-50"
                    >
                        <span>Minas: {{ minesCount }}</span>
                        <span class="text-[10px] opacity-70">▼</span>
                    </button>

                    <!-- Menu Dropdown -->
                    <!-- Removi o 'hidden group-hover:grid' e usei v-if direto -->
                    <div 
                        v-if="showMinesMenu && !gameActive" 
                        class="absolute top-full left-0 mt-1 w-[220px] bg-[#001f4d] border border-[#003d99] rounded-lg shadow-xl p-2 grid grid-cols-4 gap-2 z-50"
                    >
                        <button 
                            v-for="n in 24" 
                            :key="n" 
                            @click="minesCount = n; showMinesMenu = false" 
                            class="text-sm font-bold text-gray-300 hover:bg-[#0052cc] hover:text-white p-2 rounded transition bg-[#001433] border border-[#002966]"
                        >
                            {{ n }}
                        </button>
                    </div>

                    <!-- Overlay invisível para fechar ao clicar fora (Opcional, mas ajuda na UX) -->
                    <div v-if="showMinesMenu" @click="showMinesMenu = false" class="fixed inset-0 z-40 bg-transparent cursor-default"></div>
                </div>

                <button 
                    @click="showHelpModal = true"
                    class="bg-[#f9a119] hover:bg-[#fbab2f] gap-2 text-white text-xs font-bold px-4 py-2 rounded-full shadow-sm transition hidden sm:block"
                ><i class="fa-regular fa-circle-question"></i>
                    Como Jogar?
                </button>
            </div>

            <!-- Saldo -->
            <div class="bg-[#001f4d] px-4 py-2 rounded-full border border-[#003d99] flex items-center gap-2">
                <span class="text-xs text-gray-400 font-bold uppercase">Saldo</span>
                <span class="text-sm text-white font-medium">{{ (currentBalance || 0).toFixed(2) }}</span>
                <span class="text-[10px] text-gray-500">BRL</span>
            </div>
        </div>

        <!-- 🟠 ÁREA DO JOGO (GRID) -->
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center p-4">

            <!-- Barra de Status (Next Reward) -->
            <div v-if="gameActive" class="mb-2 flex items-center gap-4 animate-fade-in">
                <div class="bg-[#001f4d] px-4 py-1 rounded-full border border-[#003d99] text-xs text-gray-300">
                    Minas: <span class="text-white font-bold">{{ minesCount }}</span>
                </div>
                <div class="bg-[#ffb800] text-[#3d2900] px-6 py-1 rounded-full font-black text-sm shadow-[0_0_15px_rgba(255,184,0,0.4)]">
                    Próximo: {{ nextMultiplier }}x
                </div>
            </div>

            <!-- O GRID 5x5 -->
            <div class="grid grid-cols-5 gap-2 sm:gap-3 w-full max-w-[400px] aspect-square bg-[#001f4d]/30 p-3 rounded-xl border border-[#003d99]/30 backdrop-blur-sm">
                <div 
                    v-for="(tile, index) in grid" 
                    :key="index"
                    @click="clickTile(index)"
                    :class="[
                        'tile relative rounded-lg cursor-pointer transition-all duration-100 flex items-center justify-center select-none overflow-hidden',
                        tile.revealed 
                            ? (tile.type === 'gem' ? 'bg-[#e69e22] shadow-inner' : 'bg-[#001433] border border-red-500/50') 
                            : 'bg-[#003380] hover:bg-[#0040a0] shadow-[0_4px_0_#001f4d] active:shadow-none active:translate-y-[4px] active:bg-[#002966]',
                        gameActive && !tile.revealed ? 'cursor-pointer' : '',
                        !gameActive && !tile.revealed ? 'opacity-80 cursor-default' : ''
                    ]"
                    style="aspect-ratio: 1/1;"
                >
                    <!-- Detalhe do botão fechado -->
                    <div v-if="!tile.revealed" class="w-5 h-5 rounded-full bg-[#002255] shadow-inner opacity-30"></div>

                    <transition name="pop">
                        <div v-if="tile.revealed" class="absolute inset-0 flex items-center justify-center">
                            <!-- Estrela
                            <svg v-if="tile.type === 'gem'" viewBox="0 0 512 512" class="w-[70%] h-[70%] text-white drop-shadow-md filter">
                                <path fill="#fff" d="M256 38.013c-7.667 0-14.653 4.629-17.333 11.493l-56.587 144.64H48.853c-11.307 0-19.093 11.413-15.04 23.893-4.053 12.48 1.493 26.027 12.8 31.947l113.12 69.92-46.24 135.36c-3.627 10.613-.693 22.4 7.467 29.867 8.16 7.467 20.693 8.373 29.653 2.133L256 411.893l105.387 75.36c8.96 6.24 21.493 5.333 29.653-2.133 8.16-7.467 11.093-19.253 7.467-29.867l-46.24-135.36 113.12-69.92c11.307-5.92 16.853-19.467 12.8-31.947-4.053-12.48-11.84-23.893-23.147-23.893h-133.12l-56.587-144.64c-2.68-6.864-9.667-11.493-17.333-11.493z"/>
                            </svg>-->
                          	<i v-if="tile.type === 'gem'" class="fa-solid fa-gem text-3xl text-white drop-shadow-md filter"></i>
                            <!-- Bomba -->
                            <span v-else-if="tile.type === 'mine'" class="text-4xl drop-shadow-lg filter grayscale-[0.2]">💣</span>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        <!-- 🔵 BARRA DE CONTROLE INFERIOR -->
        <div class="relative z-20 bg-[#0f1923] p-3 border-t border-[#003d99] flex flex-col sm:flex-row items-center gap-3 shadow-[0_-5px_20px_rgba(0,0,0,0.3)]">

            <!-- 1. Input de Aposta -->
            <div class="flex items-center bg-[#001433] rounded-full border border-[#003d99] p-1 w-full sm:w-auto">

                <!-- Botão Menos -->
                <button 
                    @click="decreaseBet" 
                    :disabled="gameActive || currentBetIndex === 0" 
                    class="w-10 h-10 rounded-full bg-[#002966] hover:bg-[#003380] disabled:opacity-50 disabled:cursor-not-allowed text-gray-300 font-bold text-lg flex items-center justify-center transition"
                >
                    -
                </button>

                <div class="flex flex-col items-center w-[100px]">
                    <span class="text-[10px] text-gray-500 font-bold uppercase leading-none mt-1">Aposta</span>
                    <!-- Input com .number e step="0.01" -->
                    <input 
                        type="number" 
                        v-model.number="betAmount" 
                        :disabled="gameActive" 
                        step="0.10"
                        class="bg-transparent text-center text-white font-bold w-full border-none focus:ring-0 h-6 p-0 appearance-none"
                    >
                </div>

                <!-- Botão Mais -->
                <button 
                    @click="increaseBet" 
                    :disabled="gameActive || currentBetIndex === betValues.length - 1" 
                    class="w-10 h-10 rounded-full bg-[#002966] hover:bg-[#003380] disabled:opacity-50 disabled:cursor-not-allowed text-gray-300 font-bold text-lg flex items-center justify-center transition"
                >
                    +
                </button>
            </div>

            <!-- 2. Container Flex para Botões -->
            <div class="flex items-center gap-3 w-full sm:flex-1">

                <!-- Botão Random -->
                <button 
                    @click="clickRandomTile" 
                    :disabled="!gameActive" 
                    class="px-6 btnblue text-white font-medium rounded-full shadow-[0_4px_0_#001433] active:shadow-none active:translate-y-[4px] transition-all uppercase tracking-wider flex items-center justify-center shrink-0
                           w-12 h-12 p-0 text-lg
                           sm:flex-1 sm:w-auto sm:h-12 sm:text-sm sm:gap-2"
                >
                    <i class="fa-solid fa-dice"></i>
                    <span class="hidden sm:block">Aleatório</span>
                </button>

                <!-- Botão de Ação (Apostar/Cashout) -->
                <div class="flex-1 w-full">
                    <button 
                        v-if="!gameActive"
                        @click="startGame" 
                        :disabled="isLoading"
                        class="px-6 w-full h-12 btngreen text-white font-medium text-sm rounded-full shadow-[0_4px_0_#003d00] active:shadow-none active:translate-y-[4px] transition-all uppercase tracking-wider flex flex-row items-center justify-center gap-2 leading-tight"
                    >
                        <span v-if="isLoading" class="animate-spin">↻</span>
                        <i v-else class="fa-solid fa-play"></i>
                        <span>Apostar</span>
                    </button>

                    <button 
                        v-else
                        @click="cashout" 
                        :disabled="isLoading || revealedTiles.length === 0"
                        class="px-6 w-full h-12 btnred text-white font-medium text-sm rounded-full shadow-[0_4px_0_#a13e00] active:shadow-none active:translate-y-[4px] transition-all uppercase tracking-wider flex flex-col items-center justify-center leading-tight"
                    >
                        <div class="flex items-center gap-2">
                            <span>Cashout</span>
                            <span class="bg-black/20 px-2 rounded text-xs">{{ currentProfit.toFixed(2) }}</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>


        <!-- Overlay de Game Over / Win -->
        <transition name="fade">
            <div v-if="gameOver" class="absolute inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                <div class="bg-[#002966] p-1 rounded-2xl shadow-2xl transform scale-110 border border-[#0052cc] max-w-[300px] w-full mx-4">
                    <div class="bg-[#001f4d] rounded-xl p-6 text-center">
                        <div v-if="winState">
                            <div class="w-20 h-20 bg-[#00e701] rounded-full flex items-center justify-center mx-auto mb-4 shadow-[0_0_30px_rgba(0,231,1,0.4)] animate-bounce">
                                <span class="text-4xl">🤑</span>
                            </div>
                            <h2 class="text-3xl font-black text-white mb-1 uppercase italic">Você Venceu!</h2>
                            <p class="text-[#00e701] text-2xl font-bold mb-6">{{ finalWinAmount.toFixed(2) }} <span class="text-sm">BRL</span></p>
                        </div>
                        <div v-else>
                            <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-[0_0_30px_rgba(239,68,68,0.4)]">
                                <span class="text-4xl">💥</span>
                            </div>
                            <h2 class="text-3xl font-black text-white mb-2 uppercase italic">Game Over</h2>
                        </div>
                        <button @click="resetGrid" class="w-full bg-[#0052cc] hover:bg-[#0066ff] text-white font-bold py-3 px-6 rounded-lg shadow-lg transition uppercase text-sm">
                            Jogar Novamente
                        </button>
                    </div>
                </div>
            </div>
                  <!-- 📘 MODAL COMO JOGAR -->
        <transition name="fade">
            <div v-if="showHelpModal" class="absolute inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                <div class="bg-[#0f1923] w-full max-w-md rounded-2xl border border-[#003d99] shadow-2xl overflow-hidden flex flex-col max-h-[90%]">

                    <!-- Cabeçalho do Modal -->
                    <div class="bg-[#002966] p-4 flex justify-between items-center border-b border-[#003d99]">
                        <h3 class="text-white font-bold text-lg flex items-center gap-2">
                            <span class="text-xl"></span> Como Jogar?
                        </h3>
                        <button @click="showHelpModal = false" class="text-gray-400 hover:text-white transition text-2xl leading-none">&times;</button>
                    </div>

                    <!-- Conteúdo com Scroll -->
                    <div class="p-6 overflow-y-auto text-gray-300 text-xs space-y-2">

                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#0052cc] flex items-center justify-center text-white font-bold shrink-0"><i class="fa-solid fa-message"></i></div>
                            <div>
                                <p class="font-bold text-white mb-1">Cada peça esconde um diamante ou uma mina.</p>
                                <p>

Encontre o número total de diamantes para ter maiores chances e ganhar prêmios melhores. Você pode sacar o dinheiro após cada rodada ou tentar aumentar seus ganhos.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rodapé -->
                    <div class="p-4 bg-[#001433] border-t border-[#003d99]">
                        <button @click="showHelpModal = false" class="w-full bg-[#0052cc] hover:bg-[#0066ff] text-white font-bold py-3 rounded-xl transition uppercase">
                            Vamos jogar!
                        </button>
                    </div>

                </div>
            </div>
        </transition>
        </transition>

    </div>
</template>

<script>
import HttpApi from "@/Services/HttpApi.js";

export default {
    name: "MinesGame",
    props: ['gameId'],
    data() {
        return {
          	showHelpModal: false,
            showMinesMenu: false,
            betValues: [0.40, 0.80, 1.20, 2.40, 4.80, 10.00, 20.00, 50.00, 100.00, 500.00],
            currentBetIndex: 0, 
            betAmount: 0.40,
            minesCount: 3,
            gameActive: false,
            isLoading: false,
            orderId: null,
            grid: [],
            revealedTiles: [],
            currentMultiplier: 1.00,
            currentProfit: 0,
            gameOver: false,
            winState: false,
            finalWinAmount: 0,
            currentBalance: 0,
        };
    },
    computed: {
        nextMultiplier() {
            const totalTiles = 25;
            const revealed = this.revealedTiles.length;
            const remaining = totalTiles - revealed;
            const safeRemaining = remaining - this.minesCount;
            if (safeRemaining <= 0) return "MAX";
            let next = this.currentMultiplier * (remaining / safeRemaining) * 0.97;
            return next.toFixed(2);
        }
    },
    watch: {
        // Sincroniza o índice se o valor mudar (ex: digitando manualmente)
        betAmount(newVal) {
            const val = parseFloat(newVal);
            const index = this.betValues.indexOf(val);
            if (index !== -1) {
                this.currentBetIndex = index;
            }
        }
    },
    created() {
        this.resetGrid();
        this.fetchBalance();
    },
    methods: {
        // --- LÓGICA CORRETA DA ESCADA DE APOSTAS ---
        increaseBet() {
            if (this.currentBetIndex < this.betValues.length - 1) {
                this.currentBetIndex++;
                this.betAmount = this.betValues[this.currentBetIndex];
            }
        },
        decreaseBet() {
            if (this.currentBetIndex > 0) {
                this.currentBetIndex--;
                this.betAmount = this.betValues[this.currentBetIndex];
            }
        },
        // ---------------------------------------------

        async fetchBalance() {
            try {
                const response = await HttpApi.get('profile/wallet');
                // Soma os 3 saldos conforme ajustamos no backend
                this.currentBalance = parseFloat(response.data.wallet.balance) + 
                                    parseFloat(response.data.wallet.balance_bonus) + 
                                    parseFloat(response.data.wallet.balance_withdrawal);
            } catch (e) {
                console.error("Erro ao buscar saldo", e);
            }
        },
        resetGrid() {
            this.grid = Array.from({ length: 25 }, (_, i) => ({
                id: i,
                revealed: false,
                type: null
            }));
            this.gameOver = false;
            this.revealedTiles = [];
            this.currentMultiplier = 1.00;
            this.currentProfit = 0;
        },
        async startGame() {
            if (this.betAmount <= 0) return;
            this.isLoading = true;
            this.resetGrid();
            try {
                const response = await HttpApi.post('games/mines/play', {
                    amount: this.betAmount,
                    mines: this.minesCount
                });
                this.orderId = response.data.order_id;
                this.gameActive = true;
                this.currentProfit = this.betAmount;
                this.currentBalance = response.data.balance;
            } catch (error) {
                console.error(error);
                if(error.response?.data?.error) alert(error.response.data.error);
            } finally {
                this.isLoading = false;
            }
        },
        async clickTile(index) {
            if (!this.gameActive || this.grid[index].revealed || this.isLoading) return;
            this.isLoading = true;
            try {
                const response = await HttpApi.post('games/mines/reveal', {
                    order_id: this.orderId,
                    tile: index
                });
                const data = response.data;
                this.grid[index].revealed = true;
                if (data.status === 'game_over') {
                    this.grid[index].type = 'mine';
                    this.handleGameOver(false, 0, data.mines);
                } else {
                    this.grid[index].type = 'gem';
                    this.currentMultiplier = data.multiplier;
                    this.currentProfit = data.current_payout;
                    this.revealedTiles.push(index);
                }
            } catch (error) {
                console.error('Erro no reveal:', error);
                if (error.response && error.response.status === 400) {
                    alert('Erro: ' + JSON.stringify(error.response.data));
                }
            } finally {
                this.isLoading = false;
            }
        },
        clickRandomTile() {
            if (!this.gameActive || this.isLoading) return;
            const unrevealed = this.grid.filter(t => !t.revealed).map(t => t.id);
            if (unrevealed.length > 0) {
                const randomId = unrevealed[Math.floor(Math.random() * unrevealed.length)];
                this.clickTile(randomId);
            }
        },
        async cashout() {
            if (!this.gameActive || this.isLoading) return;
            this.isLoading = true;
            try {
                const response = await HttpApi.post('games/mines/cashout', { order_id: this.orderId });
                const data = response.data;
                this.handleGameOver(true, data.amount, data.mines);
                this.currentBalance = data.balance;
            } catch (error) {
                console.error(error);
            } finally {
                this.isLoading = false;
            }
        },
        handleGameOver(win, amount, allMines) {
            this.gameActive = false;
            this.gameOver = true;
            this.winState = win;
            this.finalWinAmount = amount;
            allMines.forEach(mineIndex => {
                if (!this.grid[mineIndex].revealed) {
                    this.grid[mineIndex].revealed = true;
                    this.grid[mineIndex].type = 'mine';
                }
            });
            this.grid.forEach(tile => {
                if (!tile.revealed) {
                    tile.revealed = true;
                    tile.type = 'gem';
                    tile.opacity = 0.5;
                }
            });
        }
    }
};
</script>


<style scoped>
.pop-enter-active {
  animation: pop-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
@keyframes pop-in {
  0% { transform: scale(0.5); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.tile {
    box-shadow: 0 4px 0 #001f4d;
}
.tile:active {
    box-shadow: none;
    transform: translateY(4px);
}
.tile.revealed {
    box-shadow: inset 0 0 10px rgba(0,0,0,0.3);
    transform: none;
}
  
.btngreen {
  background-image: radial-gradient(circle at 50% 50%,#61a503,#2d7500 94%);
  }
  
.btnred {
  background-image: radial-gradient(44% 44% at 49.36% 52%,#dba355 0%,#c4872e 100%);
  }
  
.btnblue {
  background-image: radial-gradient(44% 44% at 49.36% 52%, #234f92, #002966);
  }
</style>
