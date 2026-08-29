<template>
    <div class="spribe-crash w-full max-w-[800px] mx-auto bg-[#0f1923] rounded-xl overflow-hidden shadow-2xl font-sans select-none relative flex flex-col" style="min-height: 620px;">

        <!-- 🟢 HEADER (Histórico + Saldo) -->
        <div class="relative z-30 flex flex-col bg-[#002966]/80 backdrop-blur-md border-b border-[#003d99]">
            <!-- Linha Superior: Saldo e Status -->
            <div class="flex justify-between items-center px-4 py-2">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full" :class="isConnected ? 'bg-green-500 shadow-[0_0_10px_#00ff00]' : 'bg-red-500'"></div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ isConnected ? 'Online' : 'Offline' }}</span>
                </div>

                <!-- Saldo -->
                <div class="bg-[#001f4d] px-4 py-1 rounded-full border border-[#003d99] flex items-center gap-2">
                    <span class="text-xs text-gray-400 font-bold uppercase">Saldo</span>
                    <span class="text-sm text-white font-medium">{{ (currentBalance || 0).toFixed(2) }}</span>
                    <span class="text-[10px] text-gray-500">BRL</span>
                </div>
            </div>

            <!-- Linha Inferior: Histórico (Bolinhas) -->
            <div class="flex items-center gap-1 px-2 py-1 overflow-x-auto no-scrollbar bg-[#001433]/50 h-10">
                <div v-for="(h, i) in history" :key="i" 
                     class="shrink-0 px-2 py-0.5 rounded text-[10px] font-bold min-w-[40px] text-center border border-white/10"
                     :class="h >= 2.00 ? 'bg-[#00e701]/20 text-[#00e701]' : 'bg-slate-700/50 text-gray-400'">
                    {{ h.toFixed(2) }}x
                </div>
            </div>
        </div>

        <!-- 🟠 ÁREA DO JOGO (CANVAS) -->
        <div class="relative z-10 flex-1 bg-[#0f1923] overflow-hidden cursor-crosshair flex items-center justify-center" ref="gameArea">

            <!-- Background Grid (Linhas finas) -->
            <div class="absolute inset-0 opacity-10 pointer-events-none" 
                 style="background-image: linear-gradient(#4f5b66 1px, transparent 1px), linear-gradient(90deg, #4f5b66 1px, transparent 1px); background-size: 50px 50px;">
            </div>

            <!-- O Canvas onde desenhamos a linha -->
            <canvas ref="crashCanvas" class="absolute inset-0 w-full h-full z-10"></canvas>

                        <!-- Overlay de Informações -->
            <div class="absolute z-20 flex flex-col items-center justify-center pointer-events-none w-full">

                <!-- FASE DE APOSTA (Contagem) -->
                <div v-if="gameState === 'betting'" class="text-center w-full px-10">
                    <div class="text-2xl font-black text-white uppercase mb-2 tracking-widest animate-pulse">
                        Apostar Agora
                    </div>
                    <div class="text-6xl font-black text-[#00e701] tabular-nums mb-4">
                        {{ currentBettingTime.toFixed(1) }}s
                    </div>
                    <!-- Barra de Progresso -->
                    <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-[#00e701] transition-all duration-100 ease-linear" 
                             :style="{ width: (currentBettingTime / 10 * 100) + '%' }"></div>
                    </div>
                </div>

                <!-- FASE DE JOGO (Voando) -->
                <div v-else-if="gameState === 'playing'" class="text-center">
                    <div class="text-6xl sm:text-8xl font-black text-white drop-shadow-[0_0_20px_rgba(255,255,255,0.3)] tabular-nums tracking-tighter">
                        {{ currentMultiplier.toFixed(2) }}x
                    </div>
                    <div v-if="playerInRound && !userCashedOut" class="text-sm text-[#00e701] font-bold uppercase mt-2 tracking-widest animate-pulse">
                        Lucro: {{ (betAmount * currentMultiplier).toFixed(2) }}
                    </div>
                </div>

                <!-- FASE DE CRASH -->
                <div v-else-if="gameState === 'crashed'" class="text-center animate-bounce-in">
                    <div class="text-sm text-[#ff4d4d] font-bold uppercase mb-1 tracking-widest">CRASHED @</div>
                    <div class="text-5xl sm:text-7xl font-black text-[#ff4d4d] drop-shadow-[0_0_30px_rgba(255,0,0,0.5)] tabular-nums">
                        {{ currentMultiplier.toFixed(2) }}x
                    </div>
                </div>

                <!-- Notificação de Vitória -->
                <div v-if="userCashedOut" class="mt-4 bg-[#00e701]/20 border border-[#00e701] px-4 py-2 rounded-lg backdrop-blur-sm animate-fade-in-up">
                    <div class="text-xs text-[#00e701] font-bold uppercase">Você sacou!</div>
                    <div class="text-xl font-black text-white">+ {{ userWinAmount.toFixed(2) }}</div>
                </div>
            </div>

        </div>

        <!-- 🔵 BARRA DE CONTROLE INFERIOR -->
        <div class="relative z-20 bg-[#0f1923] p-3 border-t border-[#003d99] flex flex-col sm:flex-row items-center gap-3 shadow-[0_-5px_20px_rgba(0,0,0,0.3)]">

            <!-- 1. Input de Aposta -->
            <div class="flex items-center bg-[#001433] rounded-full border border-[#003d99] p-1 w-full sm:w-auto">
                <button 
                    @click="decreaseBet" 
                    :disabled="gameState !== 'idle' && gameState !== 'crashed'" 
                    class="w-10 h-10 rounded-full bg-[#002966] hover:bg-[#003380] disabled:opacity-50 text-gray-300 font-bold text-lg flex items-center justify-center transition"
                >
                    -
                </button>

                <div class="flex-1 px-4 text-center">
                    <span class="text-xs text-gray-400 block font-bold uppercase">Aposta</span>
                    <input 
                        type="number" 
                        v-model.number="betAmount" 
                        :disabled="gameState !== 'idle' && gameState !== 'crashed'"
                        class="bg-transparent text-white font-bold text-lg w-24 text-center focus:outline-none"
                    >
                </div>

                <button 
                    @click="increaseBet" 
                    :disabled="gameState !== 'idle' && gameState !== 'crashed'" 
                    class="w-10 h-10 rounded-full bg-[#002966] hover:bg-[#003380] disabled:opacity-50 text-gray-300 font-bold text-lg flex items-center justify-center transition"
                >
                    +
                </button>
            </div>

                        <!-- Botão de Ação -->
            <div class="w-full sm:flex-1">

                <!-- Botão APOSTAR (Verde) -->
                <!-- Aparece se: Está no tempo de aposta OU se o jogo está rodando mas eu não entrei -->
                <button 
                    v-if="!playerInRound || gameState === 'betting'"
                    @click="handleBetClick" 
                    :disabled="isLoading"
                    class="w-full h-12 text-white font-bold text-sm rounded-full shadow-[0_4px_0_rgba(0,0,0,0.3)] active:shadow-none active:translate-y-[4px] transition-all uppercase tracking-wider flex flex-row items-center justify-center gap-2 leading-tight"
                    :class="nextRoundBet ? 'bg-red-500 shadow-[0_4px_0_#990000]' : 'btngreen shadow-[0_4px_0_#003d00]'"
                >
                    <span v-if="isLoading" class="animate-spin">↻</span>
                    <i v-else class="fa-solid fa-rocket"></i>

                    <!-- Texto muda dependendo do estado -->
                    <span v-if="gameState === 'betting'">Apostar ({{ currentBettingTime.toFixed(0) }}s)</span>
                    <span v-else-if="nextRoundBet">Cancelar Aposta</span>
                    <span v-else>Apostar na Próxima</span>
                </button>

                <!-- Botão CASHOUT (Vermelho) -->
                <!-- Só aparece se eu ESTOU na rodada E o jogo está rodando -->
                <button 
                    v-else
                    @click="cashout" 
                    :disabled="userCashedOut || gameState === 'crashed'"
                    class="w-full h-12 btnred text-white font-bold text-sm rounded-full shadow-[0_4px_0_#a13e00] active:shadow-none active:translate-y-[4px] transition-all uppercase tracking-wider flex flex-col items-center justify-center leading-tight"
                    :class="{'opacity-50 cursor-not-allowed': userCashedOut || gameState === 'crashed'}"
                >
                    <div class="flex items-center gap-2">
                        <span>{{ userCashedOut ? 'SACADO' : 'CASHOUT' }}</span>
                        <span v-if="!userCashedOut" class="bg-black/20 px-2 rounded text-xs">
                            {{ (betAmount * currentMultiplier).toFixed(2) }}
                        </span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import HttpApi from "@/Services/HttpApi.js";

export default {
    name: "CrashGame",
    props: ['gameId'],
    data() {
        return {
            isLoading: false,
            isConnected: true,

            // Estados do Jogo: 'betting' (tempo de aposta), 'playing' (voando), 'crashed' (resultado)
            gameState: 'betting', 

            // Controle de Tempo
            bettingTime: 10, // Segundos para apostar
            currentBettingTime: 10,

            // Dados da Rodada
            currentMultiplier: 1.00,
            targetCrashPoint: 0, // Definido pelo backend ou simulado se ninguém jogar
            startTime: 0,
            animationFrame: null,

            // Dados do Jogador
            betAmount: 1.00,
            nextRoundBet: false, // Se o jogador clicou em apostar para a próxima
            playerInRound: false, // Se o jogador está efetivamente na rodada atual
            userCashedOut: false,
            userWinAmount: 0,
            orderId: null,

            // Histórico e Saldo
            history: [],
            currentBalance: 0,

            // Canvas
            canvas: null,
            ctx: null,
            width: 0,
            height: 0,
        };
    },
    mounted() {
        this.fetchBalance();
        this.initCanvas();
        window.addEventListener('resize', this.resizeCanvas);

        // INICIA O LOOP ETERNO DO JOGO
        this.startBettingPhase();
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.resizeCanvas);
        cancelAnimationFrame(this.animationFrame);
    },
    methods: {
        async fetchBalance() {
            try {
                const response = await HttpApi.get('profile/wallet');
                this.currentBalance = parseFloat(response.data.wallet.balance) + 
                                      parseFloat(response.data.wallet.balance_bonus) + 
                                      parseFloat(response.data.wallet.balance_withdrawal);
            } catch (e) { console.error(e); }
        },

        // --- FASE 1: TEMPO DE APOSTA (Contagem Regressiva) ---
        startBettingPhase() {
            this.gameState = 'betting';
            this.currentMultiplier = 1.00;
            this.currentBettingTime = 10; // 10 segundos para apostar
            this.playerInRound = false;
            this.userCashedOut = false;
            this.userWinAmount = 0;
            this.drawGraph(0); // Limpa o gráfico

            // Se o jogador marcou para apostar na próxima (durante a rodada anterior)
            if (this.nextRoundBet) {
                this.placeBet();
                this.nextRoundBet = false; // Reseta flag
            }

            // Timer de contagem regressiva
            const timer = setInterval(() => {
                this.currentBettingTime -= 0.1;

                // Atualiza visualmente (opcional, barra de progresso)

                if (this.currentBettingTime <= 0) {
                    clearInterval(timer);
                    this.startFlyingPhase();
                }
            }, 100);
        },

        // Ação do Botão "Apostar"
        handleBetClick() {
            if (this.gameState === 'betting') {
                // Se está no tempo de aposta, aposta agora
                this.placeBet();
            } else {
                // Se o jogo já está rodando, agenda para a próxima
                this.nextRoundBet = !this.nextRoundBet;
            }
        },

        async placeBet() {
            if (this.betAmount <= 0 || this.playerInRound) return;

            this.isLoading = true;
            try {
                // Chama o backend para registrar a aposta
                const response = await HttpApi.post('games/crash/play', { amount: this.betAmount });

                this.orderId = response.data.order_id;
                this.targetCrashPoint = parseFloat(response.data.crash_point); // O backend diz onde vai parar
                this.currentBalance = response.data.balance;
                this.playerInRound = true; // Jogador entrou na rodada!

            } catch (error) {
                console.error(error);
                if(error.response?.data?.error) alert(error.response.data.error);
                this.nextRoundBet = false; // Cancela se der erro
            } finally {
                this.isLoading = false;
            }
        },

        // --- FASE 2: VOANDO (O Jogo Acontece) ---
        async startFlyingPhase() {
            this.gameState = 'playing';
            this.startTime = Date.now();

            // Se o jogador NÃO apostou, precisamos simular um resultado para o gráfico
            // Chamamos o backend apenas para pegar um "resultado simulado" ou geramos localmente
            if (!this.playerInRound) {
                // Gera um crash point local para quem está só assistindo
                // (Ou você pode criar uma rota na API 'games/crash/simulate' para ser mais seguro)
                this.targetCrashPoint = this.generateSimulatedCrash();
            }

            this.loop();
        },

        loop() {
            if (this.gameState !== 'playing') return;

            const now = Date.now();
            const elapsed = (now - this.startTime) / 1000; 

            // Velocidade da subida
            this.currentMultiplier = Math.pow(Math.E, 0.06 * elapsed * 2); 

            // Desenha
            const visualProgress = elapsed / 8; 
            this.drawGraph(visualProgress);

            // Verifica Crash
            if (this.currentMultiplier >= this.targetCrashPoint) {
                this.crash();
            } else {
                this.animationFrame = requestAnimationFrame(this.loop);
            }
        },

        // --- FASE 3: CRASH (Resultado) ---
        crash() {
            this.gameState = 'crashed';
            this.currentMultiplier = this.targetCrashPoint;
            cancelAnimationFrame(this.animationFrame);

            // Adiciona ao histórico
            this.history.unshift(this.targetCrashPoint);
            if(this.history.length > 10) this.history.pop();

            // Finaliza no backend se o jogador estava jogando e perdeu
            if (this.playerInRound && !this.userCashedOut) {
                HttpApi.post('games/crash/finish', { order_id: this.orderId });
            }

            // Espera 3 segundos e começa nova rodada
            setTimeout(() => {
                this.startBettingPhase();
            }, 3000);
        },

        async cashout() {
            if (this.gameState !== 'playing' || !this.playerInRound || this.userCashedOut) return;

            this.userCashedOut = true;
            const cashoutMultiplier = this.currentMultiplier;

            try {
                const response = await HttpApi.post('games/crash/cashout', {
                    order_id: this.orderId,
                    multiplier: cashoutMultiplier
                });

                this.userWinAmount = response.data.amount;
                this.currentBalance = response.data.balance;
            } catch (error) {
                console.error("Erro no cashout", error);
                this.userCashedOut = false; 
            }
        },

        // --- Utilitários ---
        generateSimulatedCrash() {
            // Mesma lógica simples do backend para espectadores
            const chance = Math.random() * 100;
            if (chance <= 15) return 1.00;
            if (chance <= 50) return (Math.random() * (1.50 - 1.01) + 1.01);
            if (chance <= 80) return (Math.random() * (3.00 - 1.51) + 1.51);
            return (Math.random() * (10.00 - 3.01) + 3.01);
        },

        // Canvas (Mantido igual)
        initCanvas() {
            this.canvas = this.$refs.crashCanvas;
            this.ctx = this.canvas.getContext('2d');
            this.resizeCanvas();
        },
        resizeCanvas() {
            const parent = this.$refs.gameArea;
            if(parent) {
                this.width = parent.clientWidth;
                this.height = parent.clientHeight;
                this.canvas.width = this.width;
                this.canvas.height = this.height;
                if(this.gameState === 'betting') this.drawGraph(0);
            }
        },
        drawGraph(progress) {
            this.ctx.clearRect(0, 0, this.width, this.height);
            const startX = 50;
            const startY = this.height - 50;
            this.ctx.beginPath();
            this.ctx.moveTo(startX, startY);
            const endX = startX + (this.width * 0.8) * Math.min(progress, 1); 
            const endY = startY - (this.height * 0.8) * Math.pow(Math.min(progress, 1), 2);
            this.ctx.lineWidth = 5;
            this.ctx.strokeStyle = '#ff4d4d';
            this.ctx.lineCap = 'round';
            this.ctx.quadraticCurveTo(startX + (endX - startX) / 2, endY, endX, endY);
            this.ctx.stroke();
            this.ctx.lineTo(endX, startY);
            this.ctx.lineTo(startX, startY);
            const gradient = this.ctx.createLinearGradient(0, 0, 0, this.height);
            gradient.addColorStop(0, 'rgba(255, 77, 77, 0.5)');
            gradient.addColorStop(1, 'rgba(255, 77, 77, 0)');
            this.ctx.fillStyle = gradient;
            this.ctx.fill();
        },
        increaseBet() { this.betAmount = parseFloat((this.betAmount + 1).toFixed(2)); },
        decreaseBet() { if(this.betAmount > 1) this.betAmount = parseFloat((this.betAmount - 1).toFixed(2)); }
    }
};
</script>

<style scoped>
.btngreen { background-image: radial-gradient(circle at 50% 50%,#61a503,#2d7500 94%); }
.btnred { background-image: radial-gradient(44% 44% at 49.36% 52%,#dba355 0%,#c4872e 100%); }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
