<template>
  <div class="dashboard">
    <Header />
    
    <div class="flex bg-gray-100 min-h-screen">
      <!-- Sidebar -->
      <Sidebar :active-menu="'dashboard'" />
      
      <!-- Main Content -->
      <div class="flex-1 p-6">
        <div class="mb-8">
          <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
          <p class="text-gray-600">Bem-vindo, {{ user ? user.name : 'Usuário' }}!</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-green-100 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <div class="text-gray-500 text-sm">Saldo Total</div>
                <div class="text-xl font-bold">${{ formatCurrency(totalBalance) }}</div>
              </div>
            </div>
          </div>
          
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-blue-100 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
              <div>
                <div class="text-gray-500 text-sm">Ativos</div>
                <div class="text-xl font-bold">{{ wallets.length }}</div>
              </div>
            </div>
          </div>
          
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-indigo-100 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <div class="text-gray-500 text-sm">Transações</div>
                <div class="text-xl font-bold">{{ recentTransactions.length }}</div>
              </div>
            </div>
          </div>
          
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-yellow-100 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <div class="text-gray-500 text-sm">Pendentes</div>
                <div class="text-xl font-bold">{{ pendingTransactionsCount }}</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Wallet Balance and Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
          <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Variação de Saldo</h2>
            <BalanceChart :chart-data="chartData" />
          </div>
          
          <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Carteiras</h2>
            <div class="space-y-4">
              <div v-for="wallet in wallets" :key="wallet.id" class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                <div class="w-8 h-8 mr-3 flex-shrink-0">
                  <img v-if="wallet.cryptocurrency.logo" :src="wallet.cryptocurrency.logo" :alt="wallet.cryptocurrency.name" class="w-full h-full object-contain" />
                  <div v-else class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-xs font-medium">{{ getInitials(wallet.cryptocurrency.name) }}</span>
                  </div>
                </div>
                <div class="flex-1">
                  <div class="flex justify-between items-center">
                    <div class="font-medium">{{ wallet.cryptocurrency.name }}</div>
                    <div class="text-gray-600 text-sm">{{ wallet.cryptocurrency.symbol }}</div>
                  </div>
                  <div class="flex justify-between items-center mt-1">
                    <div class="text-gray-700">{{ wallet.balance }} {{ wallet.cryptocurrency.symbol }}</div>
                    <div class="text-gray-700">${{ formatCurrency(wallet.balance * wallet.cryptocurrency.current_price) }}</div>
                  </div>
                </div>
              </div>
              
              <button @click="showAddWalletModal = true" class="w-full py-2 px-3 border border-gray-300 rounded-md text-center text-gray-700 hover:bg-gray-50 transition-colors">
                + Adicionar ativo
              </button>
            </div>
          </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Transações Recentes</h2>
            <router-link to="/transactions" class="text-green-500 hover:text-green-600 text-sm font-medium">
              Ver todas
            </router-link>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Data
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tipo
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ativo
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Quantidade
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="transaction in recentTransactions" :key="transaction.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ formatDate(transaction.created_at) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="getTransactionTypeClasses(transaction.type)">
                      {{ getTransactionTypeLabel(transaction.type) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="w-6 h-6 mr-3 flex-shrink-0">
                        <img v-if="transaction.cryptocurrency && transaction.cryptocurrency.logo" :src="transaction.cryptocurrency.logo" :alt="transaction.cryptocurrency.name" class="w-full h-full object-contain" />
                        <div v-else class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                          <span class="text-xs font-medium">{{ getInitials(transaction.cryptocurrency ? transaction.cryptocurrency.name : 'Unknown') }}</span>
                        </div>
                      </div>
                      <div>{{ transaction.cryptocurrency ? transaction.cryptocurrency.symbol : 'Unknown' }}</div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ transaction.amount }} {{ transaction.cryptocurrency ? transaction.cryptocurrency.symbol : '' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="getStatusClasses(transaction.status)">
                      {{ getStatusLabel(transaction.status) }}
                    </span>
                  </td>
                </tr>
                <tr v-if="recentTransactions.length === 0">
                  <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhuma transação encontrada.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Top Cryptocurrencies -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Criptomoedas em Alta</h2>
            <router-link to="/market" class="text-green-500 hover:text-green-600 text-sm font-medium">
              Ver todas
            </router-link>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nome
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Preço
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Variação 24h
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Market Cap
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Volume 24h
                  </th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ação
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="crypto in topCryptos" :key="crypto.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="w-8 h-8 mr-3 flex-shrink-0">
                        <img v-if="crypto.logo" :src="crypto.logo" :alt="crypto.name" class="w-full h-full object-contain" />
                        <div v-else class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                          <span class="text-xs font-medium">{{ getInitials(crypto.name) }}</span>
                        </div>
                      </div>
                      <div>
                        <div class="font-medium text-gray-900">{{ crypto.name }}</div>
                        <div class="text-gray-500 text-sm">{{ crypto.symbol }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${{ formatCurrency(crypto.current_price) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="crypto.change_24h >= 0 ? 'text-green-600' : 'text-red-600'">
                      {{ crypto.change_24h >= 0 ? '+' : '' }}{{ crypto.change_24h }}%
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${{ formatLargeNumber(crypto.market_cap) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${{ formatLargeNumber(crypto.volume_24h) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                    <button @click="goToCryptoDetail(crypto.id)" class="text-green-500 hover:text-green-600 font-medium">
                      Comprar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Add Wallet Modal -->
    <div v-if="showAddWalletModal" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black opacity-50" @click="showAddWalletModal = false"></div>
      <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium">Adicionar Ativo</h3>
          <button @click="showAddWalletModal = false" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <form @submit.prevent="addWallet">
          <div class="mb-4">
            <label for="cryptocurrency" class="block text-sm font-medium text-gray-700 mb-1">
              Selecione o Ativo
            </label>
            <select id="cryptocurrency" v-model="newWallet.cryptocurrency_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
              <option v-for="crypto in availableCryptos" :key="crypto.id" :value="crypto.id">
                {{ crypto.name }} ({{ crypto.symbol }})
              </option>
            </select>
          </div>
          <div class="flex justify-end">
            <button type="button" @click="showAddWalletModal = false" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-2">
              Cancelar
            </button>
            <button type="submit" :disabled="isLoading" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              <svg v-if="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Adicionar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';
import Header from '../components/layout/Header.vue';
import Sidebar from '../components/layout/Sidebar.vue';
import BalanceChart from '../components/charts/BalanceChart.vue';

export default {
  name: 'DashboardPage',
  components: {
    Header,
    Sidebar,
    BalanceChart
  },
  data() {
    return {
      isLoading: false,
      wallets: [],
      totalBalance: 0,
      recentTransactions: [],
      topCryptos: [],
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Saldo Total (USD)',
            data: [],
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderWidth: 2,
            pointBackgroundColor: '#10B981',
            pointRadius: 3,
            pointHoverRadius: 5,
            tension: 0.4,
            fill: true
          }
        ]
      },
      showAddWalletModal: false,
      newWallet: {
        cryptocurrency_id: null
      },
      availableCryptos: []
    }
  },
  computed: {
    ...mapState(['user']),
    pendingTransactionsCount() {
      return this.recentTransactions.filter(t => t.status === 'pending').length;
    }
  },
  created() {
    this.fetchDashboardData();
  },
  methods: {
    async fetchDashboardData() {
      this.isLoading = true;
      try {
        const response = await axios.get('/api/dashboard');
        this.wallets = response.data.wallets || [];
        this.totalBalance = response.data.total_balance || 0;
        this.recentTransactions = response.data.recent_transactions || [];
        this.topCryptos = response.data.top_cryptos || [];
        
        // Generate sample chart data
        this.generateChartData();
        
        // Fetch all cryptocurrencies for the modal
        this.fetchAvailableCryptos();
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      } finally {
        this.isLoading = false;
      }
    },
    async fetchAvailableCryptos() {
      try {
        const response = await axios.get('/api/cryptocurrencies');
        this.availableCryptos = response.data.cryptocurrencies.filter(crypto => {
          // Filter out cryptos that user already has wallets for
          return !this.wallets.some(wallet => wallet.cryptocurrency_id === crypto.id);
        });
      } catch (error) {
        console.error('Error fetching cryptocurrencies:', error);
      }
    },
    async addWallet() {
      if (!this.newWallet.cryptocurrency_id) return;
      
      this.isLoading = true;
      try {
        const response = await axios.post('/api/wallets', this.newWallet);
        this.wallets.push(response.data.wallet);
        this.showAddWalletModal = false;
        this.newWallet.cryptocurrency_id = null;
        this.fetchAvailableCryptos(); // Refresh available cryptos
      } catch (error) {
        console.error('Error adding wallet:', error);
        alert(error.response?.data?.message || 'Erro ao adicionar carteira');
      } finally {
        this.isLoading = false;
      }
    },
    generateChartData() {
      const days = 30;
      const labels = [];
      const data = [];
      const today = new Date();
      
      for (let i = days; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(date.getDate() - i);
        
        labels.push(this.formatChartDate(date));
        
        // Simulate balance changes
        const balanceVariation = 1 + (Math.random() * 0.1 - 0.03); // -3% to +7% variation
        const prevBalance = i === days ? this.totalBalance / balanceVariation : data[days - i - 1];
        data.push(Number((prevBalance * balanceVariation).toFixed(2)));
      }
      
      this.chartData.labels = labels;
      this.chartData.datasets[0].data = data;
    },
    formatChartDate(date) {
      return date.toLocaleDateString('pt-BR', { day: 'numeric', month: 'short' });
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' +
             date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    },
    formatCurrency(value) {
      return Number(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    formatLargeNumber(value) {
      if (!value) return '0';
      
      if (value >= 1e9) {
        return (value / 1e9).toFixed(2) + ' B';
      }
      if (value >= 1e6) {
        return (value / 1e6).toFixed(2) + ' M';
      }
      if (value >= 1e3) {
        return (value / 1e3).toFixed(2) + ' K';
      }
      
      return value.toLocaleString('pt-BR');
    },
    getInitials(name) {
      if (!name) return '?';
      return name.split(' ').map(n => n[0]).join('').toUpperCase();
    },
    getTransactionTypeLabel(type) {
      const labels = {
        deposit: 'Depósito',
        withdrawal: 'Saque',
        transfer: 'Transferência',
        buy: 'Compra',
        sell: 'Venda'
      };
      return labels[type] || type;
    },
    getTransactionTypeClasses(type) {
      const classes = {
        deposit: 'px-2 py-1 text-xs rounded-full bg-green-100 text-green-800',
        withdrawal: 'px-2 py-1 text-xs rounded-full bg-red-100 text-red-800',
        transfer: 'px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800',
        buy: 'px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800',
        sell: 'px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800'
      };
      return classes[type] || '';
    },
    getStatusLabel(status) {
      const labels = {
        pending: 'Pendente',
        completed: 'Concluído',
        failed: 'Falhou',
        cancelled: 'Cancelado'
      };
      return labels[status] || status;
    },
    getStatusClasses(status) {
      const classes = {
        pending: 'px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800',
        completed: 'px-2 py-1 text-xs rounded-full bg-green-100 text-green-800',
        failed: 'px-2 py-1 text-xs rounded-full bg-red-100 text-red-800',
        cancelled: 'px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800'
      };
      return classes[status] || '';
    },
    goToCryptoDetail(id) {
      this.$router.push(`/market/${id}`);
    }
  }
}
</script>