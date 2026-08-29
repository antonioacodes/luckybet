<template>
  <div v-if="gameUrl">
    <iframe :src="gameUrl" class="w-full h-[800px] rounded-xl overflow-hidden border-none"></iframe>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import HttpApi from '@/Services/HttpApi.js';

export default {
  name: 'SportIframe',
  setup() {
    const gameUrl = ref(null);

    const launchGame = async () => {
      try {
        const response = await HttpApi.post('/games/sport/launch');
        gameUrl.value = response.data.gameUrl;
      } catch (error) {
        console.error('Erro ao carregar jogo de esportes:', error);
      }
    };

    onMounted(() => {
      launchGame();
    });

    return {
      gameUrl
    };
  }
};
</script>

<style scoped>
iframe {
  border: none;
}
</style>
