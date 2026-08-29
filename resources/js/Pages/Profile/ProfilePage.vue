<template>
  <BaseLayout>
    <!-- CONTAINER PRINCIPAL: Centralizado, com largura máxima e espaçamento entre os blocos -->
    <div
      v-if="userData"
      class="flex flex-col mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px] padding-wallet space-y-6 pb-8"
    >
      <!-- 🔹 BLOCO 1 — DADOS DO PERFIL E ESTATÍSTICAS DE TRANSAÇÕES -->
      <div class="mt-6 rounded-lg shadow-md"> <!-- Ajustado mt-12 para mt-6 -->
        <!-- Header -->
        <header class="PAItV">
          <div class="smUTk">
            <button class="_8s2Sx" @click="goBack">
              <svg width="1em" height="1em" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"/></svg>
            </button>
            <h1 class="hFWlQ">Dados da Conta</h1>
          </div>
        </header>
        <!-- Main flex container for profile and stats -->
        <!-- Em telas pequenas (col), os itens se empilham e centralizam. Em telas médias (md) e maiores (row), ficam lado a lado, alinhados ao topo e justificados entre si. -->
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
          <!-- Lado Esquerdo: Avatar + informações básicas + VIP -->
          <!-- Em telas pequenas, ocupa a largura total e centraliza o texto. Em telas médias+, ocupa metade da largura e alinha o texto à esquerda. -->
          <div class="card-info flex flex-col md:flex-row items-center gap-5 text-center md:text-left w-full md:w-1/2">
            <img
              :src="userData.avatar || 'https://i.imgur.com/HgiEtYX.jpeg'"
              alt="Avatar do Usuário"
              class="w-24 h-24 rounded-full border-2 border-[var(--ci-primary-color)] object-cover"
            />
            <div class="flex flex-col text-[#aaba9f] leading-6">
              <h2 class="text-2xl font-bold text-white mb-1">{{ userData.name }}</h2>
              <p class="text-sm opacity-80 mb-2">{{ userData.email }}</p>

              <!-- BLOCO DO VIP (nome + ícone + progresso) -->
              <div v-if="vipData.currentLevel" class="flex flex-col items-center md:items-start gap-2 mt-2">
                <div class="flex items-center gap-2">
                  <img
                    :src="`/storage/${vipData.currentLevel.bet_symbol}`"
                    :alt="vipData.currentLevel.vip_name"
                    class="w-8 h-8 object-contain"
                  />
                  <strong class="text-white text-lg">{{ vipData.currentLevel.vip_name }}</strong>
                </div>
                <!-- Informação de progresso para o próximo nível -->
                <p v-if="vipData.nextLevel" class="text-sm opacity-70">
                  Progresso para {{ vipData.nextLevel.vip_name }}: {{ vipData.userVipPoints }} / {{ vipData.nextLevel.bet_required }} pontos
                </p>
                <p v-else class="text-sm opacity-70">Você está no nível máximo!</p>

                <!-- Barra de Progresso VIP -->
                <div class="w-full bg-gray-700 rounded-full h-2.5 mt-1">
                  <div
                    class="h-2.5 rounded-full transition-all duration-500 ease-out"
                    :style="{ width: vipProgress + '%', backgroundColor: 'var(--ci-primary-color)' }"
                  ></div>
                </div>
              </div>
              <!-- Membro desde -->
              <div class="flex items-center gap-1 mt-4">
                <span class="text-gray-400 font-medium text-sm">Membro desde: </span>
                <span class="font-semibold text-sm">{{ formatDate(userData.created_at) }}</span>
              </div>
            </div>
          </div>

          <!-- Lado Direito: BLOCO DAS ESTATÍSTICAS DE TRANSAÇÕES -->
          <!-- Em telas pequenas, ocupa a largura total e centraliza os itens. Em telas médias+, ocupa metade da largura e alinha os itens à direita. -->
          <div class="card-info flex flex-col items-center md:items-end gap-3 text-white text-sm w-full md:w-1/2 mt-6 md:mt-0">
            <div class="flex justify-between items-center w-full p-3 mt-6 bg-input-dark rounded-md">
              <span class="text-gray-400 font-medium">Apostas:</span>
              <span class="font-semibold">{{ formatCurrency(totalBets) }}</span>
            </div>
            <div class="flex justify-between items-center w-full p-3 bg-input-dark rounded-md">
              <span class="text-gray-400 font-medium">Depósitos:</span>
              <span class="font-semibold">{{ formatCurrency(totalDepositAmount) }}</span>
            </div>
            <div class="flex justify-between items-center w-full p-3 bg-input-dark rounded-md">
              <span class="text-gray-400 font-medium">Saques:</span>
              <span class="font-semibold">{{ formatCurrency(totalWithdrawAmount) }}</span>
            </div>
            <!-- Novos itens de funcionalidade com hover de expansão -->
            <div class="flex flex-row gap-4 justify-center items-center mt-6 ml-auto mr-auto">
              <a href="/vip" class="app-feature-common app1">
                <span class="app-icon"><i class="fa-solid fa-crown"></i></span>
                <span class="app-text">Clube VIP</span>
              </a>
              <a href="/missions" class="app-feature-common app2">
                <span class="app-icon"><i class="fa-solid fa-gift"></i></span>
                <span class="app-text">Missões</span>
              </a>
              <a href="/profile/affiliate" class="app-feature-common app3">
                <span class="app-icon"><i class="fa-solid fa-user"></i></span>
                <span class="app-text">Afiliados</span>
              </a>
              <a href="/casino/provider/category" class="app-feature-common app4 ring-1 ring-[#aaba9f7f]">
                <span class="app-icon"><i class="fa-solid fa-dice"></i></span>
                <span class="app-text">Jogos</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- 🔹 BLOCO 2 — INFORMAÇÕES PESSOAIS -->
      <div class="card-info p-6 rounded-lg shadow-md"> <!-- Removido bg-card-dark redundante -->
        <h2 class="text-xl font-semibold text-white mb-5">Informações Pessoais</h2>
        <!-- Layout em grade: 1 coluna em telas pequenas, 2 colunas em telas médias e maiores -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
          <div class="flex flex-col">
            <span class="text-sm text-gray-400 mb-1">ID:</span>
            <span class="profile-value">#{{ userData.id }}</span>
          </div>
          <div class="flex flex-col">
            <span class="text-sm text-gray-400 mb-1">Telefone:</span>
            <span class="profile-value">{{ userData.phone || 'N/A' }}</span>
          </div>
          <div class="flex flex-col">
            <span class="text-sm text-gray-400 mb-1">CPF:</span>
            <span class="profile-value">{{ userData.cpf || 'N/A' }}</span>
          </div>
          <div class="flex flex-col">
            <span class="text-sm text-gray-400 mb-1">Senha:</span>
            <span class="profile-value">****************</span>
          </div>
          <!--
          <div class="flex flex-col">
            <span class="text-sm text-gray-400 mb-1">Data de Nascimento:</span>
            <span class="profile-value">{{ userData.nascimento || 'N/A' }}</span>
          </div>
          -->
          <div class="flex flex-col">
            <span class="text-sm text-gray-400 mb-1">Código de Afiliado:</span>
            <span class="profile-value">{{ userData.inviter_code }}</span>
          </div>
        </div>
      </div>

      <!-- Slot para conteúdo adicional, se houver -->
      <slot />
    </div>
  </BaseLayout>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "@/Stores/Auth";
import HttpApi from "@/Services/HttpApi";

export default {
  name: "ProfilePage",
  components: { BaseLayout },
  methods: {
    goBack() {
      window.history.back();
    },
  },
  setup() {
    const authStore = useAuthStore();
    const userData = ref(authStore.user || {});

    // -----------------------------
    // 🔹 Variáveis do VIP
    // -----------------------------
    const vipData = ref({
      levels: [],
      currentLevel: null,
      nextLevel: null,
      userVipPoints: 0, // Pontos VIP do usuário, virá da API /profile
    });

    // -----------------------------
    // 🔹 Carteiras e Estatísticas
    // -----------------------------
    const totalDeposits = ref(0);
    const totalWithdraws = ref(0);
    const totalDepositAmount = ref(0);
    const totalWithdrawAmount = ref(0);
    const isLoading = ref(false);
    const totalBets = ref(0); // Total de apostas, virá da API /profile

    // -----------------------------
    // 🔹 Função: buscar dados do perfil (total_bet e vip_points)
    // -----------------------------
    async function fetchProfileAndVipPoints() {
      try {
        const res = await HttpApi.get("/profile");
        if (res?.data?.wallet) {
          totalBets.value = res.data.wallet.total_bet || 0;
          vipData.value.userVipPoints = res.data.wallet.vip_points || 0;
          // Se userData.value.created_at não estiver preenchido, pegamos do perfil
          if (!userData.value.created_at && res.data.created_at) {
            userData.value.created_at = res.data.created_at;
          }
        }
      } catch (err) {
        console.error("❌ Erro ao buscar dados do perfil:", err);
      }
    }

    // -----------------------------
    // 🔹 Função: buscar níveis VIP (currentLevel e nextLevel)
    // -----------------------------
    async function fetchVipLevels() {
      try {
        const res = await HttpApi.get("/profile/vip/");
        const data = res?.data || {};
        vipData.value.levels = data.nivelMonthly || [];
        vipData.value.currentLevel = data.currentLevel || null;
        vipData.value.nextLevel = data.nextLevel || null;
      } catch (err) {
        console.error("❌ Erro ao buscar VIP:", err);
      }
    }

    // -----------------------------
    // 🔹 Função: buscar depósitos e saques
    // -----------------------------
    async function fetchDepositsAndWithdraws() {
      try {
        isLoading.value = true;
        const [depRes, witRes] = await Promise.all([
          HttpApi.get("/wallet/deposit"),
          HttpApi.get("/wallet/withdraw"),
        ]);

        const depList = Array.isArray(depRes?.data?.deposits?.data)
          ? depRes.data.deposits.data
          : [];
        const witList = Array.isArray(witRes?.data?.withdrawals?.data)
          ? witRes.data.withdrawals.data
          : [];

        totalDeposits.value = depList.length;
        totalWithdraws.value = witList.length;
        totalDepositAmount.value = depList.reduce(
          (sum, i) => sum + Number(i.amount || 0),
          0
        );
        totalWithdrawAmount.value = witList.reduce(
          (sum, i) => sum + Number(i.amount || 0),
          0
        );
      } catch (err) {
        console.error("❌ Erro ao carregar depósitos/saques:", err);
      } finally {
        isLoading.value = false;
      }
    }

    // -----------------------------
    // 🔹 Formatar valores monetários
    // -----------------------------
    function formatCurrency(val) {
      return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(val || 0);
    }

    // -----------------------------
    // 🔹 Formatar data para DD/MM/YYYY
    // -----------------------------
    function formatDate(dateString) {
      if (!dateString) return 'N/A';
      try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) {
          const parts = dateString.split('-');
          if (parts.length === 3) {
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
          }
          return dateString;
        }
        return new Intl.DateTimeFormat('pt-BR', {
          day: '2-digit',
          month: '2-digit',
          year: 'numeric'
        }).format(date);
      } catch (e) {
        console.error("Erro ao formatar data:", e);
        return dateString;
      }
    }

    // -----------------------------
    // 🔹 Computed: progresso VIP real (percentual)
    // -----------------------------
    const vipProgress = computed(() => {
      const points = vipData.value.userVipPoints;
      const current = vipData.value.currentLevel;
      const next = vipData.value.nextLevel;

      if (!current) return 0;
      if (!next) return 100;

      const currentReq = Number(current.bet_required || 0);
      const nextReq = Number(next.bet_required || 0);

      const relativePoints = points - currentReq;
      const totalRange = nextReq - currentReq;

      const percent = totalRange > 0 ? (relativePoints / totalRange) * 100 : 0;
      return Math.min(Math.max(percent, 0), 100).toFixed(1);
    });

    // -----------------------------
    // 🔹 Lifecycle
    // -----------------------------
    onMounted(async () => {
      await Promise.all([
        fetchProfileAndVipPoints(),
        fetchVipLevels(),
        fetchDepositsAndWithdraws(),
      ]);
    });

    // -----------------------------
    // 🔹 Expor para o template
    // -----------------------------
    return {
      userData,
      vipData,
      totalBets,
      totalDeposits,
      totalWithdraws,
      totalDepositAmount,
      totalWithdrawAmount,
      isLoading,
      vipProgress,
      formatCurrency,
      formatDate,
    };
  },
};
</script>

<style scoped>
/* Definição de variáveis CSS para cores consistentes com o padrão do cassino */
:root {
  --card-background-color: #323637; /* Cor de fundo dos blocos, como nas suas imagens */
  --input-background-color: #2C2D3E; /* Cor de fundo para campos de input/valor, mais escura */
  --ci-gray-medium: #4a4e50; /* Adicionado para consistência com o seu CSS original */
  /* As variáveis --ci-primary-color e --sidebar-color são assumidas como definidas globalmente
     e representam o verde vibrante e o fundo principal do site, respectivamente. */
}

/* Classes Tailwind personalizadas usando as variáveis CSS */
.bg-card-dark {
  background-color: var(--card-background-color);
}

.bg-input-dark {
  background-color: var(--input-background-color);
}

/* Estilo para os valores das informações pessoais, substituindo .profileinfo */
.profile-value {
  color: white;
  font-size: 0.95rem; /* Um pouco maior para melhor legibilidade */
  font-weight: 500; /* Semibold */
  background-color: var(--input-background-color);
  border-radius: 7px;
  padding: 10px 14px; /* Padding ajustado para um visual mais moderno */
  display: block; /* Garante que ocupe a largura total */
  width: 100%;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3); /* Sutil sombra interna para profundidade */
  line-height: 1.5; /* Espaçamento de linha para melhor leitura */
}

/* Mantém o padding original do container principal */
.padding-wallet {
  padding: 0 4%;
}

/* Estilo para os cards principais (blocos de informação) */
.card-info {
  background-color: var(--ci-gray-medium); /* Usando a variável para consistência */
  color: #aaba9f;
  min-height: 35vh;
  padding: 12px;
  width: 100%;
  border-radius: 12px;
  transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out, border 0.3s ease-in-out;
}

.card-info:hover {
  transform: scale(1.02); /* Efeito de escala no hover */
  background-color: calc(var(--ci-gray-medium)/80); /* Um hover mais sutil */
  border: solid 1px #aaba9f7f;
}

/* -------------------------------------------------------------------------- */
/*                 Estilos Comuns para Itens de Funcionalidade                */
/* -------------------------------------------------------------------------- */

.app-feature-common {
  width: 40px; /* Largura inicial */
  height: 40px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center; /* Centraliza o ícone inicialmente */
  overflow: hidden; /* Esconde o texto que excede a largura */
  white-space: nowrap; /* Impede que o texto quebre linha */
  transition: width 0.3s ease, background-color 0.3s ease, color 0.3s ease; /* Transições suaves */
  cursor: pointer;
  text-decoration: none; /* Remove sublinhado do link */
  font-size: 0.875rem; /* Tamanho de fonte para o texto */
  font-weight: 500; /* Peso da fonte */
  position: relative; /* Necessário para posicionar o texto absolutamente */
}

.app-feature-common .app-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 1; /* Ícone visível por padrão */
  transition: opacity 0.3s ease;
  width: 100%; /* Ocupa a largura total do item pai */
  height: 100%;
}

.app-feature-common .app-text {
  opacity: 0; /* Texto invisível por padrão */
  position: absolute; /* Posiciona o texto sobre o ícone */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  align-items: center;
  justify-content: center; /* Centraliza o texto */
  color: var(--ci-gray-medium); /* Cor do texto no hover (pode ser sobrescrita por item específico) */
  transition: opacity 0.3s ease;
  pointer-events: none; /* Impede interação com o texto quando invisível */
  padding: 0 5px; /* Pequeno padding para o texto */
}

/* Efeito de hover para todos os itens de funcionalidade */
.app-feature-common:hover {
  width: 120px; /* Largura expandida no hover */
  color: white; /* Cor do ícone/texto no hover */
}

.app-feature-common:hover .app-icon {
  opacity: 0; /* Esconde o ícone no hover */
  pointer-events: none;
}

.app-feature-common:hover .app-text {
  opacity: 1; /* Mostra o texto no hover */
  pointer-events: auto; /* Permite interação com o texto no hover */
}

/* -------------------------------------------------------------------------- */
/*                   Estilos de Cores para Cada Item de Funcionalidade        */
/* -------------------------------------------------------------------------- */

.app1 { /* Clube VIP */
  background-color: #ec7000; /* Cor base laranja */
  color: white; /* Cor do ícone padrão */
}
.app1:hover {
  background-color: #ff9c45; /* Laranja mais claro no hover */
}

.app2 { /* Missões */
  background-color: #8600c4; /* Cor base azul */
  color: white;
}
.app2:hover {
  background-color: #b95ae6; /* Azul mais claro no hover */
}

.app3 { /* Afiliados */
  background-color: #28a745; /* Cor base vermelho */
  color: white;
}
.app3:hover {
  background-color: #66cc7a; /* Vermelho/rosa mais claro no hover */
}

.app4 { /* Jogos */
  background-color: var(--ci-gray-medium); /* Cor base verde */
  color: white;
}
.app4:hover {
  background-color: var(--ci-primary-color); /* Verde mais claro no hover */
}

/* -------------------------------------------------------------------------- */
/*                           Ajustes Responsivos                              */
/* -------------------------------------------------------------------------- */

@media (max-width: 768px) {
  /* Centraliza o avatar e as informações de texto no topo em telas pequenas */
  .flex-col.md\:flex-row.items-center.md\:items-start.justify-between.gap-6 > div:first-child {
    align-items: center;
    text-align: center;
  }
  /* Centraliza as estatísticas de transação em telas pequenas */
  .flex-col.md\:flex-row.items-center.md\:items-start.justify-between.gap-6 > div:last-child {
    align-items: center;
  }
  .profile-value {
    text-align: left; /* Garante alinhamento à esquerda nos campos de valor */
  }
}

/* -------------------------------------------------------------------------- */
/*                               Estilos do Header                            */
/* -------------------------------------------------------------------------- */

.PAItV { margin-bottom: 1rem; }
.smUTk { display: flex; align-items: center; margin-top: 30px; justify-content: space-between; gap: 0.5rem; }
._8s2Sx, ._0UgdA button { background: var(--ci-gray-medium); border: none; width: 30px; height: 30px; border-radius: 0.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #fff; transition: all 0.3s; }
.hFWlQ { flex: 1; text-align: start; color: #aaba9f; font-size: 1.2rem; font-weight: 600; margin: 0; }
</style>

