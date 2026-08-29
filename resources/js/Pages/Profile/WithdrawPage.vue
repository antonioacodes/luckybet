<template>
  <BaseLayout>
    <div v-if="setting && wallet && !isLoading" class="flex flex-col shadow-lg mt-8 mb-8 rounded mx-auto max-w-[678px] sm:max-w-[690px]  lg:max-w-[678px]" style="margin-top:15px;">
              <header class="PAItV" style="margin-top:15px;">
          <div class="smUTk">
            <button class="_8s2Sx" @click="goBack">
              <svg width="1em" height="1em" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"/></svg>
            </button>
            <h1 class="hFWlQ">Solicitar Saque</h1>
          </div>
        </header>
      
      
      <form style="margin-bottom:45px;border-radius: 12px;" class="p-6 pb-6 mt-2 bg-[var(--ci-gray-medium)]" @submit.prevent="submitWithdraw" v-if="wallet.currency === 'BRL'">
        <!-- Nome do titular (somente leitura) -->
        <div class="gap-4 flex flex-row justify-start">
         <div class="pay">
          <img class="h-4 w-auto" src="https://bucket.ellovault.com/files/x2WqerxGtQOSRA1nU07LcZQmg7-NlanBO-3HcBQQGAcjhTXKya5UDLGDGQknTg-93lyCdLfz1tAVpEla--mEbKJGCksjPB3iGyTTKulGpXItx-8YpWfnX_GtaEgJ3lV-wQEiVQT5jlRomyWRi24ecw">
         </div>
          <div class="pay">
          <img class="h-4 w-auto" src="https://bspay.co/wp-content/uploads/2025/02/Logo.png">
         </div>
        </div>
        <div class="mt-5">
          <label class="text-sm font-semibold dark:text-gray-400 mb-1">Nome do titular da conta</label>
          <b><input
            type="text"
            class="appearance-none rounded-md bg-transparent border-none w-full py-2 md:text-md text-base"
            style="background-color: var(--ci-gray-over);"
            v-model="withdraw.name"
            readonly
                    /></b>
        </div>

        <!-- Valor do saque com formatação dinâmica -->
        <div class="mt-5">
          <label class="text-sm font-semibold dark:text-gray-400 mb-1">Valor do saque:</label>
          <input
            type="text"
            class="appearance-none border border-gray-300 rounded-md bg-transparent border-none w-full py-2 md:text-md text-base"
            style="background-color: var(--ci-gray-over); margin-bottom:2px;"
            v-model="withdraw.amount"
            @input="formatWithdrawAmount"
            placeholder="R$ 0,00"
            required
          />
        </div>

        <!-- Exibe o saldo disponível formatado -->
        <div class="flex text-xs mb-3 mt-2">
          <p>Disponível para saque:</p>
          <p class="ml-1" :style="{ color: 'var(--ci-primary-color)' }">
            {{ state.currencyFormat(parseFloat(wallet.balance_withdrawal), wallet.currency) }}
          </p>
        </div>

        <!-- Chave Pix (somente leitura) -->
        <div class="mt-5">
          <label class="text-sm font-semibold dark:text-gray-400 mb-1">CPF</label>
          <b><input
            type="text"
            style="background-color: var(--ci-gray-over); margin-bottom:2px;"
            class="appearance-none rounded-md bg-transparent border-none w-full py-2 md:text-md text-base"
            v-model="withdraw.pix_key"
            readonly
                 /></b>
        </div>
        <p class="mt-2 text-xs text-[#ff9f43]">O Pix cadastrado deve ser próprio CPF.<br> Não serão pagos prêmios em Pix de outras titularidades.</p>
        <button type="submit" class="ui-button-blue w-full py-6 mt-4">
          <span class="uppercase font-semibold text-md" style="color:var(--ci-gray-medium);">SACAR</span>
        </button>
      </form>
    </div>

    <div v-if="isLoading" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
      <i class="fa-duotone fa-spinner-third fa-spin" style="font-size:45px; --fa-primary-color:var(--ci-primary-color)"></i>
      <span class="sr-only">Carregando...</span>
    </div>
  </BaseLayout>
</template>

<script>
import { useToast } from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { useSettingStore } from "@/Stores/SettingStore.js";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";

export default {
  components: { BaseLayout, WalletSideMenu },

  data() {
    return {
      isLoading: false,
      setting: null,
      wallet: null,
      withdraw: {
        name: "",
        pix_key: "",
        amount: "",
        pix_type: "cpf",
        type: "pix",
        currency: "",
        symbol: "",
        accept_terms: true
      }
    };
  },

  created() {
    this.getSetting();
    this.getWallet();
    this.fetchUser();
  },

  methods: {
        goBack() {
      window.history.back();
    },
    // 1) Busca o usuário logado e pré-enche nome e CPF
    fetchUser() {
      const toast = useToast();
      HttpApi.get("auth/verify")
        .then(({ data }) => {
          this.withdraw.name = data.name;
          this.withdraw.pix_key = data.cpf;
        })
        .catch(() => {
          toast.error("Não foi possível carregar os dados do usuário.");
        });
    },

    // 2) Formata o valor conforme digita, da direita para a esquerda
    formatWithdrawAmount(e) {
      // Remove tudo que não for dígito
      let digits = e.target.value.replace(/\D/g, "");
      // Garante pelo menos 3 dígitos para não estourar slice
      digits = digits.padStart(3, "0");
      const intPart = digits.slice(0, -2);
      const decPart = digits.slice(-2);
      const number = Number(intPart + "." + decPart);
      // Atualiza com R$ 0.00
      this.withdraw.amount = number.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL"
      });
    },

    getSetting() {
      const settingStore = useSettingStore();
      if (settingStore.setting) {
        this.setting = settingStore.setting;
      }
    },

    getWallet() {
      const toast = useToast();
      this.isLoading = true;
      HttpApi.get("profile/wallet")
        .then(({ data }) => {
          this.wallet = data.wallet;
          this.withdraw.currency = data.wallet.currency;
          this.withdraw.symbol = data.wallet.symbol;
          this.isLoading = false;
        })
        .catch(() => {
          toast.error("Falha ao carregar dados da carteira.");
          this.isLoading = false;
        });
    },

    submitWithdraw() {
      const toast = useToast();
      this.isLoading = true;

      // Antes de enviar, converta para número correto (ex: "R$ 1.234,56" → 1234.56)
      const raw = this.withdraw.amount.replace(/\D/g, "");
      const valueToSend = Number(raw) / 100;
      const payload = {
        ...this.withdraw,
        amount: valueToSend
      };

      HttpApi.post("wallet/withdraw/request", payload)
        .then(({ data }) => {
          toast.success(data.message);
         this.$router.push({ name: "profileTransactions" });
        })
        .catch((err) => {
          Object.values(JSON.parse(err.request.responseText))
            .forEach(msg => toast.error(msg));
        })
        .finally(() => {
          this.isLoading = false;
        });
    }
  }
};
</script>

<style scoped>
  .PAItV { margin-bottom: 1rem; }
.smUTk { display: flex; align-items: center; margin-top: 30px; justify-content: space-between; gap: 0.5rem; }
._8s2Sx, ._0UgdA button { background: var(--ci-gray-medium); border: none; width: 30px; height: 30px; border-radius: 0.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #fff; transition: all 0.3s; }
.hFWlQ { flex: 1; text-align: start; color: #aaba9f; font-size: 1.2rem; font-weight: 600; margin: 0; }
.pay{
  width:100px;
  align-items: center;
  justify-content: center;
  background-color: var(--ci-gray-medium);
  border: 1px solid #fff1c021;
  height: 40px;
  border-radius: 8px;
}
  .pay img{
margin: auto;
    margin-top: 10px;
}
</style>
