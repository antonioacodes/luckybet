<template>
    <div>
      <h1>Contagem Regressiva</h1>
      <div>{{ formattedTime }}</div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        seconds: 300, // 5 minutos em segundos
      };
    },
    computed: {
      formattedTime() {
        const mins = Math.floor(this.seconds / 60);
        const secs = this.seconds % 60;
        return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
      }
    },
    created() {
      this.startCountdown();
    },
    methods: {
      startCountdown() {
        this.interval = setInterval(() => {
          if (this.seconds > 0) {
            this.seconds -= 1;
          } else {
            clearInterval(this.interval);
          }
        }, 1000);
      }
    },
    beforeDestroy() {
      clearInterval(this.interval);
    }
  };
  </script>
  
  <style scoped>
  /* Adicione estilos se necessário */
  </style>