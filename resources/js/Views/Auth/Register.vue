<template>
  <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <router-link to="/">
        <img src="../../assets/logo.svg" alt="Logo" class="h-12 mx-auto" />
      </router-link>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Criar uma nova conta
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Ou
        <router-link to="/login" class="font-medium text-green-500 hover:text-green-400">
          acesse sua conta
        </router-link>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <div v-if="errorMessage" class="mb-4 bg-red-50 p-4 rounded-md">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                {{ errorMessage }}
              </h3>
              <div class="mt-2 text-sm text-red-700">
                <ul v-if="validationErrors" class="list-disc pl-5 space-y-1">
                  <li v-for="(error, field) in validationErrors" :key="field">
                    {{ error[0] }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <form class="space-y-6" @submit.prevent="register">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
              Nome completo
            </label>
            <div class="mt-1">
              <input id="name" name="name" type="text" required
                     v-model="form.name"
                     class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" />
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <div class="mt-1">
              <input id="email" name="email" type="email" autocomplete="email" required
                     v-model="form.email"
                     class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
              Senha
            </label>
            <div class="mt-1">
              <input id="password" name="password" type="password" required
                     v-model="form.password"
                     class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" />
            </div>
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
              Confirmar Senha
            </label>
            <div class="mt-1">
              <input id="password_confirmation" name="password_confirmation" type="password" required
                     v-model="form.password_confirmation"
                     class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" />
            </div>
          </div>

          <div class="flex items-center">
            <input id="terms" name="terms" type="checkbox" required
                   v-model="form.terms"
                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" />
            <label for="terms" class="ml-2 block text-sm text-gray-900">
              Eu concordo com os 
              <a href="#" class="font-medium text-green-500 hover:text-green-400">Termos de Serviço</a>
              e
              <a href="#" class="font-medium text-green-500 hover:text-green-400">Política de Privacidade</a>
            </label>
          </div>

          <div>
            <button type="submit" :disabled="isLoading"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              <svg v-if="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isLoading ? 'Criando conta...' : 'Criar conta' }}
            </button>
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">
                Ou continue com
              </span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-2 gap-3">
            <div>
              <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>

            <div>
              <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'RegisterPage',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms: false
      },
      isLoading: false,
      errorMessage: null,
      validationErrors: null
    }
  },
  methods: {
    async register() {
      this.isLoading = true;
      this.errorMessage = null;
      this.validationErrors = null;
      
      try {
        const response = await axios.post('/api/register', this.form);
        
        // Salvar token no localStorage
        localStorage.setItem('token', response.data.access_token);
        
        // Configurar headers padrão para todas as requisições
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
        
        // Guardar usuário no Vuex store
        this.$store.commit('setUser', response.data.user);
        
        // Redirecionar para dashboard
        this.$router.push('/dashboard');
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            this.validationErrors = error.response.data.errors;
            this.errorMessage = 'Por favor, corrija os erros abaixo.';
          } else {
            this.errorMessage = error.response.data.message || 'Ocorreu um erro ao criar sua conta.';
          }
        } else {
          this.errorMessage = 'Ocorreu um erro ao criar sua conta. Por favor, tente novamente mais tarde.';
        }
      } finally {
        this.isLoading = false;
      }
    }
  }
}
</script>