<template>
  <div class="market">
    <Header />
    
    <div class="flex bg-gray-100 min-h-screen">
      <!-- Sidebar -->
      <Sidebar :active-menu="'market'" />
      
      <!-- Main Content -->
      <div class="flex-1 p-6">
        <div class="mb-6 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Mercado</h1>
          <div class="flex space-x-2">
            <div class="relative">
              <input
                type="text"
                placeholder="Pesquisar..."
                v-model="searchQuery"
                class="w-64 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              />
              <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
        </div>
        
        <!-- Market Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex justify-between items-center mb-2">
              <div class="text-gray-500 text-sm">Market Cap Total</div>
              <div class="text-xs text-green-500 flex items-center">
                +1.2%
                <svg class="h-3 w-3 ml-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
              </div>
            </div>
            <div class="text-xl font-bold">$2.43T</div>
          </div>
          
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex justify-between items-center mb-2">
              <div class="text-gray-500 text-sm">Volume 24h</div>
              <div class="text-xs text-red-500 flex items-center">
                -3.8%
                <svg class="h-3 w-3 ml-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            <div class="text-xl font-bold">$82.5B</div>
          </div>
          
          <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex justify-between items-center mb-2">
              <div class="text-gray-500 text-sm">Ativos Ativos</div>
              <div class="text-xs text-green-500 flex items-center">
                +5
                <svg class="h-3 w-3 ml-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
              </div>
            </div>
            <div class="text-xl font-bold">{{ cryptocurrencies.length }}</div>
          </div>
        </div>
        
        <!-- Cryptocurrencies Table -->
        <div class="bg-white rounded-lg shadow">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th @click="sortBy('rank')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    #
                    <span v-if="sortColumn === 'rank'" class="ml-1">
                      <span v-if="sortDirection === 'asc'">▲</span>
                      <span v-else>▼</span>
                    </span>
                  </th>
                  <th @click="sortBy('name')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Nome
                    <span v-if="sortColumn === 'name'" class="ml-1">
                      <span v-if="sortDirection === 'asc'">▲</span>
                      <span v-else>▼</span>
                    </span>
                  </th>
                  <th @click="sortBy('current_price')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Preço
                    <span v-if="sortColumn === 'current_price'" class="ml-1">
                      <span v-if="sortDirection === 'asc'">▲</span>
                      <span v-else>▼</span>
                    </span>
                  </th>
                  <th @click="sortBy('change_24h')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Variação 24h
                    <span v-if="sortColumn === 'change_24h'" class="ml-1">
                      <span v-if="sortDirection === 'asc'">▲</span>
                      <span v-else>▼</span>
                    </span>
                  </th>
                  <th @click="sortBy('market_cap')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Market Cap
                    <span v-if="sortColumn === 'market_cap'" class="ml-1">
                      <span v-if="sortDirection === 'asc'">▲</span>
                      <span v-else>▼</span>
                    </span>
                  </th>
                  <th @click="sortBy('volume_24h')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Volume (24h)
                    <span v-if="sortColumn === 'volume_24h'" class="ml-1">
                      <span v-if="sortDirection === 'asc'">▲</span>
                      <span v-else>▼</span>
                    </span>
                  </th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ações
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="crypto in filteredCryptocurrencies" :key="crypto.id" @click="goToCryptoDetail(crypto.id)" class="hover:bg-gray-50 cursor-pointer">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ crypto.rank || '-' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img v-if="crypto.logo" :src="crypto.logo" :alt="crypto.name" class="h-10 w-10 rounded-full" />
                        <div v-else class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                          <span class="text-sm font-medium">{{ getInitials(crypto.name) }}</span>
                        </div>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ crypto.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                          {{ crypto.symbol }}
                        </div>
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
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button @click.stop="goToCryptoDetail(crypto.id)" class="text-green-600 hover:text-green-900">
                      Comprar
                    </button>
                  </td>
                </tr>
                <tr v-if="filteredCryptocurrencies.length === 0">
                  <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhuma criptomoeda encontrada.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Header from '../components/layout/Header.vue';
import Sidebar from '../components/layout/Sidebar.vue';

export default {
  name: 'MarketPage',
  components: {
    Header,
    Sidebar
  },
  data() {
    return {
      cryptocurrencies: [],
      isLoading: false,
      searchQuery: '',
      sortColumn: 'rank',
      sortDirection: 'asc'
    }
  },
  computed: {
    filteredCryptocurrencies() {
      let filtered = this.cryptocurrencies;
      
      // Apply search filter
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(crypto => 
          crypto.name.toLowerCase().includes(query) || 
          crypto.symbol.toLowerCase().includes(query)
        );
      }
      
      // Apply sorting
      filtered = [...filtered].sort((a, b) => {
        let aValue = a[this.sortColumn];
        let bValue = b[this.sortColumn];
        
        // Handle null values
        if (aValue === null || aValue === undefined) aValue = this.sortColumn === 'rank' ? Infinity : 0;
        if (bValue === null || bValue === undefined) bValue = this.sortColumn === 'rank' ? Infinity : 0;
        
        if (this.sortDirection === 'asc') {
          return aValue > bValue ? 1 : -1;
        } else {
          return aValue < bValue ? 1 : -1;
        }
      });
      
      return filtered;
    }
  },
  created() {
    this.fetchCryptocurrencies();
  },
  methods: {
    async fetchCryptocurrencies() {
      this.isLoading = true;
      try {
        const response = await axios.get('/api/cryptocurrencies');
        this.cryptocurrencies = response.data.cryptocurrencies || [];
      } catch (error) {
        console.error('Error fetching cryptocurrencies:', error);
      } finally {
        this.isLoading = false;
      }
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
    sortBy(column) {
      if (this.sortColumn === column) {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortColumn = column;
        this.sortDirection = 'asc';
      }
    },
    goToCryptoDetail(id) {
      this.$router.push(`/market/${id}`);
    }
  }
}
</script>