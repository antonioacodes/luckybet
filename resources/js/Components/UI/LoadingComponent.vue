<template>
  <div
    v-if="isLoading"
    class="is-loading-component dar:bg-[var(--carousel-banners-dark)] bg-[var(--carousel-banners)]"
  >
    <div role="status" class="grid gap-2 text-center justify-items-center">
      <div class="spring-spinner">
        <div class="spring-spinner-part top">
          <div class="spring-spinner-rotator"></div>
        </div>
        <div class="spring-spinner-part bottom">
          <div class="spring-spinner-rotator"></div>
        </div>
      </div>

      <div v-if="isImageAvailable" class="mt-5">
        <img
          :src="`/storage/${setting.software_loading}`"
          class="mx-auto max-w-[280px]"
          alt="Loading..."
        />
      </div>
    </div>
  </div>

  <slot></slot>
</template>

<script>
import { useSettingStore } from "@/Stores/SettingStore.js";

export default {
  props: ['isLoading'],
  setup() {
    const { setting } = useSettingStore();
    return { setting };
  },
  computed: {
    setting() {
      const settingStore = useSettingStore();
      return settingStore.setting;
    },
    isImageAvailable() {
      return this.setting.software_loading && this.setting.software_loading.trim() !== '';
    }
  },
  methods: {
    getSetting() {
      const settingStore = useSettingStore();
      this.setting = settingStore.setting;
    },
  },
  created() {
    this.getSetting();
  },
};
</script>

<style scoped>
.is-loading-component {
  position: fixed;
  inset: 0; /* cobre toda a viewport */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999; /* garante que sempre fique acima de outros elementos */
}

.spring-spinner,
.spring-spinner * {
  box-sizing: border-box;
}

.spring-spinner {
  height: 60px;
  width: 60px;
}

.spring-spinner .spring-spinner-part {
  overflow: hidden;
  height: calc(60px / 2);
  width: 60px;
}

.spring-spinner .spring-spinner-part.bottom {
  transform: rotate(180deg) scale(-1, 1);
}

.spring-spinner .spring-spinner-rotator {
  width: 60px;
  height: 60px;
  border: calc(60px / 7) solid transparent;
  border-right-color: var(--ci-primary-color);
  border-top-color: var(--ci-primary-color);
  border-radius: 50%;
  box-sizing: border-box;
  animation: spring-spinner-animation 3s ease-in-out infinite;
  transform: rotate(-200deg);
}

@keyframes spring-spinner-animation {
  0% {
    border-width: calc(60px / 7);
  }
  25% {
    border-width: calc(60px / 23.33);
  }
  50% {
    transform: rotate(115deg);
    border-width: calc(60px / 7);
  }
  75% {
    border-width: calc(60px / 23.33);
  }
  100% {
    border-width: calc(60px / 7);
  }
}
</style>
