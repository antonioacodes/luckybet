<template>
    <!-- Adicionei um ID para facilitar a inspeção e removi classes do Tailwind para garantir -->
    <div id="snow-overlay" class="snow-container" aria-hidden="true">
        <div v-for="i in snowflakesCount" :key="i" class="snowflake" :style="getSnowflakeStyle(i)">
            ❄
        </div>
    </div>
</template>

<script>
export default {
    name: 'SnowEffect',
    data() {
        return {
            snowflakesCount: 50
        }
    },
    methods: {
        getSnowflakeStyle(i) {
            const randomLeft = Math.floor(Math.random() * 100);
            const randomDuration = (Math.random() * 3 + 2).toFixed(2);
            const randomDelay = (Math.random() * 5).toFixed(2);
            const randomOpacity = (Math.random() * 0.5 + 0.5).toFixed(2); // Aumentei a opacidade mínima
            const randomSize = (Math.floor(Math.random() * 15) + 10) + 'px'; // Aumentei um pouco o tamanho

            return {
                left: `${randomLeft}%`,
                animationDuration: `${randomDuration}s`,
                animationDelay: `${randomDelay}s`,
                opacity: randomOpacity,
                fontSize: randomSize
            };
        }
    }
}
</script>

<style scoped>
/* Usando CSS puro para garantir que nada do Tailwind interfira */
.snow-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    pointer-events: none; /* O clique passa através */
    z-index: 999999; /* Z-index absurdo para garantir que fique em cima de tudo */
    overflow: hidden;
    display: block;
}

.snowflake {
    position: absolute;
    top: -50px; /* Começa fora da tela */
    color: #ffffff !important; /* Força a cor branca */
    text-shadow: 0 0 5px rgba(0,0,0,0.5);
    user-select: none;
    animation-name: fall;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
}

@keyframes fall {
    0% {
        transform: translateY(-10vh) translateX(0px) rotate(0deg);
    }
    100% {
        transform: translateY(110vh) translateX(20px) rotate(360deg);
    }
}
</style>
