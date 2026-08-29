<template>
  <div class="crypto-detail">
    <Header />
    
    <div class="flex bg-gray-100 min-h-screen">
      <!-- Sidebar -->
      <Sidebar :active-menu="'market'" />
      
      <!-- Main Content -->
      <div class="flex-1 p-6">
        <div v-if="isLoading" class="flex justify-center items-center h-64">
          <svg class="animate-spin h-10 w-10 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </div>
        
        <template v-else-if="crypto">
          <!-- Cryptocurrency Header -->
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="flex items-center mb-4 md:mb-0">
              <button @click="$router.go(-1)" class="mr-3 p-1 rounded-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
              </button>
              <div class="flex items-center">
                <div class="h-12 w-12 rounded-full mr-4 overflow-hidden bg-gray-200 flex-shrink-0">
                  <img v-if="crypto.logo" :src="crypto.logo" :alt="crypto.name" class="h-full w-full object-cover" />
                  <div v-else class="h-full w-full flex items-center justify-center">
                    <span class="text-lg font-bold">{{ getInitials(crypto.name) }}</span>
                  </div>
                </div>
                <div>
                  <h1 class="text-2xl font-bold text-gray-900">{{ crypto.name }}</h1>
                  <div class="text-gray-500">{{ crypto.symbol }}</div>
                </div>
              </div>
            </div>
            
            <div class="flex flex-col">
              <div class="text-3xl font-bold">${{ formatCurrency(crypto.current_price) }}</div>
              <div class="flex items-center mt-1">
                <span :class="crypto.change_24h >= 0 ? 'text-green-600' : 'text-red-600'" class="text-lg font-medium">
                  {{ crypto.change_24h >= 0 ? '+' : '' }}{{ crypto.change_24h }}%
                </span>
                <span class="text-gray-500 ml-2">(24h)</span>
              </div>
            </div>
          </div>
          
          <!-- Price Chart and Order Form -->
          <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Price Chart -->
            <div class="lg:col-span-3 bg-white rounded-lg shadow p-4">
              <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Gráfico de Preço</h2>
                <div class="flex">
                  <button 
                    v-for="interval in intervals" 
                    :key="interval.value"
                    @click="changeInterval(interval.value)"
                    :class="[
                      'px-2 py-1 text-sm rounded mr-1',
                      selectedInterval === interval.value 
                        ? 'bg-green-500 text-white' 
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    ]"
                  >
                    {{ interval.label }}
                  </button>
                </div>
              </div>
              
              <CandlestickChart 
                :data="candlestickData" 
                :height="400"
              />
            </div>
            
            <!-- Order Form -->
            <div class="bg-white rounded-lg shadow p-4">
              <div class="mb-4">
                <div class="flex mb-2">
                  <button 
                    @click="orderType = 'buy'"
                    :class="[
                      'w-1/2 py-2 text-center rounded-l',
                      orderType === 'buy' 
                        ? 'bg-green-500 text-white' 
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    ]"
                  >
                    Comprar
                  </button>
                  <button 
                    @click="orderType = 'sell'"
                    :class="[
                      'w-1/2 py-2 text-center rounded-r',
                      orderType === 'sell' 
                        ? 'bg-red-500 text-white' 
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    ]"
                  >
                    Vender
                  </button>
                </div>
              </div>
              
              <form @submit.prevent="placeOrder">
                <div class="mb-4">
                  <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                    Quantidade
                  </label>
                  <div class="relative rounded-md shadow-sm">
                    <input
                      id="amount"
                      type="number"
                      step="0.00000001"
                      min="0.00000001"
                      v-model="orderAmount"
                      class="block w-full pr-12 border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 sm:text-sm"
                      placeholder="0.00"
                      required
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">{{ crypto.symbol }}</span>
                    </div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                    Preço
                  </label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input
                      id="price"
                      type="number"
                      step="0.01"
                      min="0.01"
                      v-model="orderPrice"
                      class="block w-full pl-7 pr-12 border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 sm:text-sm"
                      placeholder="0.00"
                      required
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">USD</span>
                    </div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Total
                  </label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input
                      type="text"
                      :value="formatCurrency(orderTotal)"
                      class="block w-full pl-7 pr-12 border-gray-300 rounded-md bg-gray-50 sm:text-sm"
                      readonly
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">USD</span>
                    </div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Taxa (0.2%)
                  </label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input
                      type="text"
                      :value="formatCurrency(orderFee)"
                      class="block w-full pl-7 pr-12 border-gray-300 rounded-md bg-gray-50 sm:text-sm"
                      readonly
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">USD</span>
                    </div>
                  </div>
                </div>