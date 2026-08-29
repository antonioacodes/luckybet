<style>
  /* CSS COMPLETO - ADICIONE ESTE BLOCO INTEIRO NO SEU ARQUIVO DE ESTILOS */

/* Estilos originais que você já tem */
html {
    font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
}
body {
    font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
}
.gray-scale-menu {
    color: #fdffffb3;
    display: flex;
    font-size: .875rem;
    font-weight: 600;
    filter: grayscale(100%);
    filter: gray; /* IE6-9 */
    -webkit-filter: grayscale(100%);
}
.filter-gray-hover {
    transition: 0ms;
}
.filter-gray-hover:hover {
    filter: grayscale(100%) brightness(180%);
    transition: 0ms;
    color: white;
    -webkit-filter: grayscale(100%) brightness(180%);
    -moz-filter: grayscale(100%) brightness(180%);
}
.texto-categoria:hover {
    color: white;
}
.opacidade-hover:hover {
    opacity: .9;
}
.opacidade-1-texto-menu {
    color: #A8BEBE;
}
.opacidade-1-texto-menu:hover {
    color: white;
    opacity: 1;
}

/* Shimmer effect (que você já tem) */
.shimmer {
    margin: 0 auto;
    margin-bottom: 10px;
    margin-top: 10px;
    position: relative;
    overflow: hidden;
    padding: 20px;
    max-width: 80%;
    border-radius: 20px;
}

.shimmer::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
    animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
    0% {
        left: -100%;
    }
    100% {
        left: 100%;
    }
}

/* Configuração base dos cards */
.card-with-glow {
    position: relative !important;
    overflow: hidden !important;
}

/* Efeito principal - INTENSIDADE EQUILIBRADA */
.card-with-glow::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 6px; /* Voltei para 6px */
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
    animation: slide-glow-intense 1.8s infinite ease-in-out; /* Um pouco mais lento */
    z-index: 10;
    pointer-events: none;
    opacity: 1;
    filter: brightness(1.6) saturate(1.3); /* Menos intenso */
}

/* Cores específicas para cada card - MAIS INTENSAS */
/* Cores específicas para cada card - ATUALIZADAS */
.card-affiliate::before {
    background: linear-gradient(90deg, linear-gradient(90deg, transparent 0%, rgb(54 169 77 / 20%) 20%, rgb(54 169 63 / 80%) 40%, rgb(54 169 72) 50%, rgb(54 169 87 / 80%) 60%, rgb(54 169 68 / 20%) 80%, transparent 100%));
    box-shadow: 0 0 25px rgba(54, 169, 120, 0.7);
    filter: brightness(1.8) saturate(1.5);
}

.card-torneios::before,
.card-clube-vip::before {
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(236, 112, 0, 0.2) 20%, 
        rgba(236, 112, 0, 0.8) 40%,
        rgba(236, 112, 0, 1) 50%,
        rgba(236, 112, 0, 0.8) 60%,
        rgba(236, 112, 0, 0.2) 80%, 
        transparent 100%
    );
    box-shadow: 0 0 25px rgba(236, 112, 0, 0.7);
    filter: brightness(1.8) saturate(1.5);
}

  
.card-natal::before {
    background: linear-gradient(to right, #ababab00, rgba(175, 175, 175, 0.2) 20%, rgba(169, 169, 169, 0.8) 40%, rgb(167, 167, 167), rgba(166, 166, 166, 0.8) 60.08%, rgba(166, 166, 166, 0.2) 80%, rgba(170, 170, 170, 0));
    box-shadow: 0 0 25px #b9b9b9b3;
    filter: brightness(1.8) saturate(1.5);
}

  
  .card-missoes::before {
    background: linear-gradient(90deg, transparent 0%, rgb(145 34 191 / 20%) 20%, rgb(160 34 191 / 80%) 40%, rgb(162 34 191) 50%, rgb(151 34 191 / 80%) 60%, rgb(151 34 191 / 20%) 80%, transparent 100%);
    box-shadow: 0 0 25px rgba(160, 34, 191, 0.7);
    filter: brightness(1.8) saturate(1.5);
}

.card-suporte::before {
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(0, 3, 171, 0.2) 20%, 
        rgba(0, 3, 171, 0.8) 40%,
        rgba(0, 3, 171, 1) 50%,
        rgba(0, 3, 171, 0.8) 60%,
        rgba(0, 3, 171, 0.2) 80%, 
        transparent 100%
    );
    box-shadow: 0 0 25px rgba(64, 197, 214, 0.7);
    filter: brightness(1.8) saturate(1.5);
}

/* Animação mais intensa e contínua */
@keyframes slide-glow-intense {
    0% { 
        left: -100%; 
        opacity: 0;
        transform: scaleX(0.8);
    }
    20% {
        opacity: 0.7;
        transform: scaleX(1.1);
    }
    50% { 
        left: 0%; 
        opacity: 0.9; /* Menos opaco no centro */
        transform: scaleX(1.3); /* Menos largo */
    }
    80% {
        opacity: 0.7;
        transform: scaleX(1.1);
    }
    100% { 
        left: 100%; 
        opacity: 0;
        transform: scaleX(0.8);
    }
}

/* Efeito no hover - EQUILIBRADO */
.card-with-glow:hover::before {
    animation-duration: 1.2s; /* Um pouco mais rápido, mas não muito */
    height: 9px; /* Só um pouco maior */
    box-shadow: 0 0 35px rgba(255, 255, 255, 0.8); /* Glow mais suave */
    filter: brightness(2.2) saturate(2); /* Menos intenso */
    transform: scaleY(1.1); /* Cresce menos */
}

/* Para versão desktop - equilibrado */
@media (min-width: 769px) {
    .card-with-glow::before {
        height: 7px; /* Um pouco menor */
        animation-duration: 1.8s; /* Um pouco mais lento */
    }
}

@media (max-width: 769px) {
    .sidefix {
       padding-top:75px;
    }
}

/* Para mobile - um pouco menor mas ainda visível */
@media (max-width: 768px) {
    .card-with-glow::before {
        height: 4px;
        animation-duration: 2.2s;
    }
    
    .card-with-glow:hover::before {
        height: 6px;
    }
}

/* Aplicação direta nos cards específicos - CORES ATUALIZADAS */
.card-affiliate {
    position: relative !important;
    overflow: hidden !important;
}

.card-affiliate::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, transparent, #36A978, transparent);
    animation: slide-glow-intense 1.8s infinite;
    z-index: 10;
    box-shadow: 0 0 25px #36A978;
    filter: brightness(1.3);
}

.card-torneios,
.card-clube-vip {
    position: relative !important;
    overflow: hidden !important;
}

.card-torneios::after,
.card-clube-vip::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, transparent, #EC7000, transparent);
    animation: slide-glow-intense 1.8s infinite;
    z-index: 10;
    box-shadow: 0 0 25px #EC7000;
    filter: brightness(1.3);
}

.card-missoes {
    position: relative !important;
    overflow: hidden !important;
}

  
.card-natal {
    position: relative !important;
    overflow: hidden !important;
}
  
.card-missoes::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, transparent, #a822bf, transparent);
    animation: slide-glow-intense 1.8s infinite;
    z-index: 10;
    box-shadow: 0 0 25px #a822bf;
    filter: brightness(1.3);
}
  
.card-natal::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 6px;
    background: linear-gradient(to right, rgba(157, 157, 157, 0), #a1a1a1, rgba(161, 161, 161, 0));
    animation: slide-glow-intense 1.8s infinite;
    z-index: 10;
    box-shadow: 0 0 25px #a38c00;
    filter: brightness(1.3);
}

.card-suporte {
    position: relative !important;
    overflow: hidden !important;
}

.card-suporte::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, transparent, #0003AB, transparent);
    animation: slide-glow-intense 1.8s infinite;
    z-index: 10;
    box-shadow: 0 0 25px #0003AB;
    filter: brightness(1.3);
}

/* Versão super intensa para teste */
.glow-test {
    position: relative !important;
    overflow: hidden !important;
}

.glow-test::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: -100%;
    width: 100%;
    height: 10px;
    background: linear-gradient(90deg, transparent, #00ff00, transparent);
    animation: slide-fast 1s infinite;
    z-index: 999;
    box-shadow: 0 0 50px #00ff00;
}

@keyframes slide-fast {
    0% { left: -100%; }
    100% { left: 100%; }
}
  .no-top-padding {
    padding-top: 40px !important;
}

</style>

<template>
          <aside 
              style=" padding-top: 75px;"  
              :class="[
                  sidebar === true ? 'translate-x-0 lg:w-[65px] w-[100%]' : '-translate-x-full lg:translate-x-0 lg:w-[280px] w-[100%]',

                  // ✅ AQUI ESTÁ A MÁGICA:
                  // Adiciona a classe 'no-top-padding' APENAS se a prop for true
                  { 'no-top-padding': removeTopPadding } 
              ]" 
              class="sidebar-color sidefix fixed left-0 z-20 top-0 pt-16 overflow-auto h-screen transition-transform" 
              aria-label="Sidebar"
          >
        <div v-if="!sidebar" class="h-full pb-4 overflow-y-auto pb-4 tirar-cedo" >
            <div class="px-4">
                              <!-- Card 4 - Natal 
                <button @click.prevent="$router.push('/profile/deposit')"
                class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-natal" 
                style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 30px;background: #0003ab; background: linear-gradient(to right, #dc2670, #f57eae, #dc2670);">
                    <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                        <p style="font-size: 12px;">Aproveite a Páscoa!</p>
                        <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Deposite e Resgate</h1>
                    </div>
                    <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">🐰</span>
                </button>
              -->
                <!-- Card 1 - Afiliado (padronizado) -->
                <button @click.prevent="$router.push('/profile/affiliate')"
                class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-affiliate" 
                style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 30px;background: #249B00;background: linear-gradient(90deg,rgba(36, 155, 0, 1) 0%, rgba(94, 184, 66, 1) 50%, rgba(36, 155, 0, 1) 100%);">
                    <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                        <p style="font-size: 12px;">Ganhe até</p>
                        <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">R$ 100 grátis Indicando</h1>
                    </div>
                    <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">💸</span>
                </button>
              
              
                <!-- Card 3 - Missões -->
                <button @click.prevent="$router.push('/missions')"
                class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-missoes" 
                style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 10px;background: #8600c4;background: linear-gradient(90deg,rgba(134, 0, 196, 1) 0%, rgba(185, 90, 230, 1) 50%, rgba(134, 0, 196, 1) 100%);">
                    <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                        <p style="font-size: 12px;">Participe das</p>
                        <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Missões e dos Prêmios</h1>
                    </div>
                    <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">🏆</span>
                </button>
              
              
                <!-- Card 2 - Vip -->
                <button @click.prevent="$router.push('/vip')"
                class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-clube-vip" 
                style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 10px;background: #EC7000;background: linear-gradient(90deg,rgba(236, 112, 0, 1) 0%, rgba(255, 156, 69, 1) 50%, rgba(236, 112, 0, 1) 100%);">
                    <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                        <p style="font-size: 12px;">Conheça o nosso</p>
                        <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Clube VIP e Vantagens</h1>
                    </div>
                    <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">👑</span>
                </button>
           
          
          		<!-- Card 3 - Rodadas -->
                <button @click.prevent="$router.push('/dailyroulette')"
                class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-suporte" 
                style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 10px;background: #0003ab; background: linear-gradient(90deg,rgba(0, 3, 171, 1) 0%, rgba(74, 77, 224, 1) 50%, rgba(0, 3, 171, 1) 100%);">
                    <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                        <p style="font-size: 12px;">Aproveite agora</p>
                        <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Bônus e Rodadas Grátis</h1>
                    </div>
                    <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">💰</span>
                </button>
              
              

            </div>
  
            <div style="width: 100%;height: 0.1rem;margin-top: 20px;"></div>
          
           
    <div v-if="loading">
      <!-- Aplicar o efeito shimmer enquanto os dados estão carregando -->
      <div v-if="loading" class="shimmer" v-for="n in 13" :key="n" style="height: 20px; margin-bottom: 10px;"></div>
    </div>
    <div v-else>
      <!-- Exibir categorias quando os dados estiverem carregados -->
      <ul class="space-y-2 font-medium py-2 px-4 ml-3">
                <li v-for="(category, index) in categories" :key="index">
                    <RouterLink
                        v-if="!category.url"
                        :to="{ name: 'casinosAll', params: { provider: 'all', category: category.slug }}"
                        active-class="category-active"
                        class="flex flex-row items-center py-2 texto-categoria opacidade-1-texto-menu gray-scale-menu filter-gray-hover">
                        <img :src="`/storage/`+category.image" alt="" width="21" class="mr-3">
                        <span class="">{{ $t(category.name) }}</span>
                    </RouterLink>
                    <a
                        v-else
                        :href="category.url"
                        active-class="category-active"
                        class="flex flex-row items-center py-2 texto-categoria opacidade-1-texto-menu gray-scale-menu filter-gray-hover">
                        <img :src="`/storage/`+category.image" alt="" width="21" class="mr-3">
                        <span class="">{{ $t(category.name) }}</span>
                    </a>

                </li>

            </ul>
    </div>


            <div style="width: 100%;height: 0.1rem;background-color: #27292A;margin-top: 20px;margin-bottom: 20px"></div>

            <ul v-if="custom.telegram" class="font-medium mt-2 mb-[200px] px-3">
                <li class="px-3 py-1">
                        <a :href="custom.telegram"
                            class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu">
                            <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 496 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z" fill="currentColor"></path></svg>
                            <span class="ml-3" style="font-weight: bold;font-size: 14px;">{{ $t('Canal do Telegram') }}</span>
                        </a>
                    </li>

                    <li class="px-3 py-1">
                    <a @click.prevent="$router.push('/profile/affiliate')" href="#"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                        <svg data-v-b7b4c0c9="" fill="currentColor" height="20px" viewBox="0 0 448 448.5" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M209,.5c49.67-3.92,87.5,15.08,113.5,57,16.47,33.39,17.8,67.39,4,102-24.64,47.41-63.81,68.91-117.5,64.5-54.17-10.17-86.33-42.33-96.5-96.5-4.41-49.68,14.42-87.51,56.5-113.5,12.72-6.67,26.06-11.17,40-13.5ZM223,40.5c3.06.3,5.56,1.63,7.5,4,1.11,3.59,1.61,7.25,1.5,11,18.12,5.29,25.96,17.29,23.5,36-3.19,3.5-6.69,3.84-10.5,1-2.17-5.61-4.33-11.27-6.5-17-9.67-9.33-19.33-9.33-29,0-6.61,12.48-3.78,21.98,8.5,28.5,18.14-.2,30.64,7.97,37.5,24.5,3.59,14.9-.58,27.07-12.5,36.5-3.23,2.57-6.89,4.07-11,4.5.32,4.25-.51,8.25-2.5,12-3.67,2.67-7.33,2.67-11,0-1.99-3.75-2.82-7.75-2.5-12-18.12-5.29-25.96-17.29-23.5-36,3.19-3.51,6.69-3.84,10.5-1,2.17,5.6,4.34,11.27,6.5,17,8.15,8.16,16.99,9,26.5,2.5,8-9.33,8-18.67,0-28-6.26-3.16-12.92-4.82-20-5-18.1-6.03-26.26-18.53-24.5-37.5,2.57-14.07,10.74-22.73,24.5-26-.11-3.75.39-7.41,1.5-11,1.5-1.97,3.33-3.3,5.5-4Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M246,239.5c2.43.02,4.76.52,7,1.5l26.5,26.5c.67,3,.67,6,0,9-9.53,9.86-19.36,19.36-29.5,28.5-9.91.37-13.07-4.13-9.5-13.5l10.5-10.5c-26.33-.33-52.67-.67-79-1-1.83-.5-3-1.67-3.5-3.5-.67-2.67-.67-5.33,0-8,.5-1.83,1.67-3,3.5-3.5,26.67-.33,53.33-.67,80-1l-11.5-11.5c-1.9-6.16-.07-10.49,5.5-13Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path><path d="M198,303.5c9.36.52,12.53,5.19,9.5,14l-10.5,10.5c26.33.33,52.67.67,79,1,1.83.5,3,1.67,3.5,3.5.67,2.67.67,5.33,0,8-.5,1.83-1.67,3-3.5,3.5-26.67.33-53.33.67-80,1,3.83,3.83,7.67,7.67,11.5,11.5,1.81,10.53-2.36,14.36-12.5,11.5-8.83-8.83-17.67-17.67-26.5-26.5-.67-3-.67-6,0-9,9.73-9.9,19.56-19.56,29.5-29Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path><path d="M73,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M45,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path><path d="M353,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M325,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path></svg>
                        <span style="font-weight: bold;font-size: 14px;" class="ml-3 gray-scale-menu" >{{ $t('Seja um Afiliado') }}</span>
                    </a>
                </li>

                <li v-if="custom.Suporte" class="px-3 py-1">
                    <a  :href="custom.Suporte"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                        <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 640 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M640 191.1v191.1c0 35.25-28.75 63.1-64 63.1h-32v54.24c0 7.998-9.125 12.62-15.5 7.873l-82.75-62.12L319.1 447.1C284.7 447.1 256 419.2 256 383.1v-31.98l96-.002c52.88 0 96-43.12 96-95.99V128h128C611.3 128 640 156.7 640 191.1z" fill="currentColor"></path><path d="M352 0H64C28.75 0 0 28.75 0 63.1V256C0 291.2 28.75 320 64 320l32 .0098v54.25c0 7.998 9.125 12.62 15.5 7.875l82.75-62.12L352 319.9c35.25 .125 64-28.68 64-63.92V63.1C416 28.75 387.3 0 352 0z" fill="currentColor" opacity="0.4"></path></svg>
                        <span style="font-weight: bold;font-size: 14px;" class="ml-3 gray-scale-menu" >{{ $t('Suporte Ao Vivo') }}</span>
                    </a>
                </li>

                <li v-if="custom.ajuda" class="px-3 py-1">
                    <a :href="custom.ajuda"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                         
                        <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 512 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M342.5 214.7C342.6 214.6 342.4 214.8 342.5 214.7l128.1-128.1c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0L297.3 169.5c-.0742 .0742 .0742-.0762 0 0C317.1 178.1 333 194.9 342.5 214.7zM169.5 297.3C169.4 297.4 169.6 297.2 169.5 297.3l-128.1 128.1c-12.5 12.5-12.5 32.75 0 45.25C47.63 476.9 55.81 480 64 480s16.38-3.125 22.62-9.375l128.1-128.1c.0742-.0742-.0742 .0762 0 0C194.9 333 178.1 317.1 169.5 297.3zM342.5 297.3C342.4 297.2 342.6 297.4 342.5 297.3c-9.463 19.78-25.43 35.74-45.21 45.21c.0742 .0762-.0742-.0742 0 0l128.1 128.1C431.6 476.9 439.8 480 448 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L342.5 297.3zM86.63 41.38c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L169.5 214.7c.0742 .0742-.0762-.0742 0 0c9.463-19.78 25.43-35.74 45.21-45.21c-.0742-.0762 .0742 .0742 0 0L86.63 41.38z" fill="currentColor"></path><path d="M214.7 169.5C227.2 163.5 241.2 160 256 160s28.76 3.51 41.29 9.502c.0742-.0762-.0742 .0742 0 0l115.5-115.6C369.5 20.26 315.2 0 256 0S142.5 20.26 99.2 53.95L214.7 169.5C214.8 169.6 214.6 169.4 214.7 169.5zM169.5 297.3C163.5 284.8 160 270.8 160 256s3.51-28.76 9.502-41.29c-.0762-.0742 .0742 .0742 0 0L53.95 99.2C20.26 142.5 0 196.8 0 256s20.26 113.5 53.95 156.8L169.5 297.3C169.6 297.2 169.4 297.4 169.5 297.3zM458.1 99.2l-115.6 115.5c-.0742 .0742 .0762-.0742 0 0C348.5 227.2 352 241.2 352 256s-3.51 28.76-9.502 41.29c.0762 .0742-.0742-.0742 0 0l115.6 115.5C491.7 369.5 512 315.2 512 256S491.7 142.5 458.1 99.2zM297.3 342.5C284.8 348.5 270.8 352 256 352s-28.76-3.51-41.29-9.502c-.0742 .0762 .0742-.0742 0 0l-115.5 115.6C142.5 491.7 196.8 512 256 512s113.5-20.26 156.8-53.95L297.3 342.5C297.2 342.4 297.4 342.6 297.3 342.5z" fill="currentColor" opacity="0.4"></path></svg>
                        <span style="font-weight: bold;font-size: 14px;" class="ml-3 gray-scale-menu" >{{ $t('Central de Ajuda') }}</span>
                    </a>
                </li>

                <li class="px-3 py-1">
                    <a @click.prevent="$router.push('/profile/affiliate')" href="#"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                       <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 512 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M320 96C328.8 96 336 103.2 336 112C336 120.8 328.8 128 320 128H192C183.2 128 176 120.8 176 112C176 103.2 183.2 96 192 96H320zM276.1 230.3C282.7 231.5 292.7 233.5 297.1 234.7C307.8 237.5 314.2 248.5 311.3 259.1C308.5 269.8 297.5 276.2 286.9 273.3C283 272.3 269.5 269.7 265.1 268.1C252.9 267.1 242.1 268.7 236.5 271.6C230.2 274.4 228.7 277.7 228.3 279.7C227.7 283.1 228.3 284.3 228.5 284.7C228.7 285.2 229.5 286.4 232.1 288.2C238.2 292.4 247.8 295.4 261.1 299.7L262.8 299.9C274.9 303.6 291.1 308.4 303.2 317.3C309.9 322.1 316.2 328.7 320.1 337.7C324.1 346.8 324.9 356.8 323.1 367.2C319.8 386.2 307.2 399.2 291.4 405.9C286.6 407.1 281.4 409.5 276.1 410.5V416C276.1 427.1 267.1 436.1 255.1 436.1C244.9 436.1 235.9 427.1 235.9 416V409.6C226.4 407.4 213.1 403.2 206.1 400.5C204.4 399.9 202.9 399.4 201.7 398.1C191.2 395.5 185.5 384.2 189 373.7C192.5 363.2 203.8 357.5 214.3 361C216.3 361.7 218.5 362.4 220.7 363.2C230.2 366.4 240.9 370 246.9 371C259.7 373 269.6 371.7 275.7 369.1C281.2 366.8 283.1 363.8 283.7 360.3C284.4 356.3 283.8 354.5 283.4 353.7C283.1 352.8 282.2 351.4 279.7 349.6C273.8 345.3 264.4 342.2 250.4 337.9L248.2 337.3C236.5 333.8 221.2 329.2 209.6 321.3C203 316.8 196.5 310.6 192.3 301.8C188.1 292.9 187.1 283 188.9 272.8C192.1 254.5 205.1 241.9 220 235.1C224.1 232.9 230.3 231.2 235.9 230V223.1C235.9 212.9 244.9 203.9 256 203.9C267.1 203.9 276.1 212.9 276.1 223.1L276.1 230.3z" fill="currentColor"></path><path d="M144.6 24.88C137.5 14.24 145.1 0 157.9 0H354.1C366.9 0 374.5 14.24 367.4 24.88L320 96H192L144.6 24.88zM332.1 136.4C389.7 172.7 512 250.9 512 416C512 469 469 512 416 512H96C42.98 512 0 469 0 416C0 250.9 122.3 172.7 179 136.4C183.9 133.3 188.2 130.5 192 128H320C323.8 130.5 328.1 133.3 332.1 136.4V136.4zM235.9 224V230C230.3 231.2 224.1 232.9 220 235.1C205.1 241.9 192.1 254.5 188.9 272.8C187.1 283 188.1 292.9 192.3 301.8C196.5 310.6 203 316.8 209.6 321.3C221.2 329.2 236.5 333.8 248.2 337.3L250.4 337.9C264.4 342.2 273.8 345.3 279.7 349.6C282.2 351.4 283.1 352.8 283.4 353.7C283.8 354.5 284.4 356.3 283.7 360.3C283.1 363.8 281.2 366.8 275.7 369.1C269.6 371.7 259.7 373 246.9 371C240.9 370 230.2 366.4 220.7 363.2C218.5 362.4 216.3 361.7 214.3 361C203.8 357.5 192.5 363.2 189 373.7C185.5 384.2 191.2 395.5 201.7 398.1C202.9 399.4 204.4 399.9 206.1 400.5C213.1 403.2 226.4 407.4 235.9 409.6V416C235.9 427.1 244.9 436.1 255.1 436.1C267.1 436.1 276.1 427.1 276.1 416V410.5C281.4 409.5 286.6 407.1 291.4 405.9C307.2 399.2 319.8 386.2 323.1 367.2C324.9 356.8 324.1 346.8 320.1 337.7C316.2 328.7 309.9 322.1 303.2 317.3C291.1 308.4 274.9 303.6 262.8 299.9L261.1 299.7C247.8 295.4 238.2 292.4 232.1 288.2C229.5 286.4 228.7 285.2 228.5 284.7C228.3 284.3 227.7 283.1 228.3 279.7C228.7 277.7 230.2 274.4 236.5 271.6C242.1 268.7 252.9 267.1 265.1 268.1C269.5 269.7 283 272.3 286.9 273.3C297.5 276.2 308.5 269.8 311.3 259.1C314.2 248.5 307.8 237.5 297.1 234.7C292.7 233.5 282.7 231.5 276.1 230.3V224C276.1 212.9 267.1 203.9 255.1 203.9C244.9 203.9 235.9 212.9 235.9 224L235.9 224z" fill="currentColor" opacity="0.4"></path></svg>
                        <span style="font-weight: bold;font-size: 14px;" class="ml-3 gray-scale-menu" >{{ $t('Indique um Amigo') }}</span>
                    </a>
                </li>

          
             
             
            </ul>
        </div>
        <div v-else>

        <div class="sidebar-color h-[100vh] overflow-auto flex-col justify-between px-2 py-2 hidden lg:flex tirar-cedo" style="padding-top: 30px;">
            <ul>
               <!--<li class="mb-3" title="Natal">
                    <div @click.prevent="$router.push('/profile/deposit')" style="background: #0003ab; background: linear-gradient(to right, #dc2670, #f57eae, #dc2670);" class="flex items-center justify-center hover:bg-gray-600 py-2 rounded-[3px] text-center cursor-pointer card-with-glow card-natal">
                        <span class="text-[20px]">🐰</span>
                    </div>
                </li>-->
              
                <li class="mb-3" title="Ganhe até R$ 100 grátis">
                    <div @click.prevent="$router.push('/profile/affiliate')" style="background: #249B00;background: linear-gradient(90deg,rgba(36, 155, 0, 1) 0%, rgba(94, 184, 66, 1) 50%, rgba(36, 155, 0, 1) 100%);" class="flex items-center justify-center hover:bg-gray-600 py-2 rounded-[3px] text-center cursor-pointer card-with-glow card-affiliate">
                        <span class="text-[20px]">💸</span>
                    </div>
                </li>

                <li class="mb-3" title="Missões">
                    <div @click.prevent="$router.push('/missions')" style="background: #8600c4;background: linear-gradient(90deg,rgba(134, 0, 196, 1) 0%, rgba(185, 90, 230, 1) 50%, rgba(134, 0, 196, 1) 100%);" class="flex items-center justify-center hover:bg-gray-600 py-2 rounded-[3px] text-center cursor-pointer card-with-glow card-missoes">
                        <span class="text-[20px]">🏆</span>
                    </div>
                </li>
              
              
                <li class="mb-3" title="Torneios">
                    <div @click.prevent="$router.push('/vip')" style="background: #EC7000;background: linear-gradient(90deg,rgba(236, 112, 0, 1) 0%, rgba(255, 156, 69, 1) 50%, rgba(236, 112, 0, 1) 100%);" class="flex items-center justify-center hover:bg-gray-600 py-2 rounded-[3px] text-center cursor-pointer card-with-glow card-clube-vip">
                        <span class="text-[20px]">👑</span>
                    </div>
                </li>


                  
                <li class="mb-3" title="Roleta">
                    <div @click.prevent="$router.push('/dailyroulette')" style="background: #0003ab; background: linear-gradient(90deg,rgba(0, 3, 171, 1) 0%, rgba(74, 77, 224, 1) 50%, rgba(0, 3, 171, 1) 100%);" class="flex items-center justify-center hover:bg-gray-600 py-2 rounded-[3px] text-center cursor-pointer card-with-glow card-suporte">
                        <span class="text-[20px]">💰</span>
                    </div>
                </li>
              

                  
                    <li v-for="(category, index) in categories" :key="index" :title="$t(category.name)" class="mb-3">
                        <RouterLink
                            v-if="!category.url"
                            :to="{ name: 'casinosAll', params: { provider: 'all', category: category.slug }}"
                            active-class="category-active"
                            class="card-sidebar-recolhido flex items-center justify-center hover:bg-gray-600 rounded-[3px] py-3 text-center">
                            <img class="gray-scale-menu" :src="`/storage/`+category.image" alt="" width="26">
                        </RouterLink>
                        <a
                            v-else
                            :href="category.url"
                            active-class="category-active"
                            class="card-sidebar-recolhido flex items-center justify-center hover:bg-gray-600 rounded-[3px] py-3 text-center" card-sidebar-recolhido >
                            <img class="gray-scale-menu" :src="`/storage/`+category.image" alt="" width="26">
                        </a>
                    </li>
                    
                </ul>

                <ul>
                    <li v-if="custom.telegram" class="mb-3">
                        <a :href="custom.telegram" :title="$t('Canal do Telegram')">
                        <div class="card-sidebar-recolhido flex items-center justify-center p-3 rounded-[3px] text-center" >
                          
                                <svg data-v-b7b4c0c9="" height="1.5em" viewBox="0 0 496 512" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z" fill="currentColor"></path></svg>
                            
                        </div>
                    </a>
                    </li>
                    <li class="mb-3">
                        <a @click="$router.push('/profile/affiliate')" href="#" :title="$t('Seja um Afiliado')">
                        <div class="card-sidebar-recolhido flex items-center justify-center p-3 rounded-[3px] text-center" >
                            
                                <svg data-v-b7b4c0c9="" fill="currentColor" height="1.5em" viewBox="0 0 448 448.5" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M209,.5c49.67-3.92,87.5,15.08,113.5,57,16.47,33.39,17.8,67.39,4,102-24.64,47.41-63.81,68.91-117.5,64.5-54.17-10.17-86.33-42.33-96.5-96.5-4.41-49.68,14.42-87.51,56.5-113.5,12.72-6.67,26.06-11.17,40-13.5ZM223,40.5c3.06.3,5.56,1.63,7.5,4,1.11,3.59,1.61,7.25,1.5,11,18.12,5.29,25.96,17.29,23.5,36-3.19,3.5-6.69,3.84-10.5,1-2.17-5.61-4.33-11.27-6.5-17-9.67-9.33-19.33-9.33-29,0-6.61,12.48-3.78,21.98,8.5,28.5,18.14-.2,30.64,7.97,37.5,24.5,3.59,14.9-.58,27.07-12.5,36.5-3.23,2.57-6.89,4.07-11,4.5.32,4.25-.51,8.25-2.5,12-3.67,2.67-7.33,2.67-11,0-1.99-3.75-2.82-7.75-2.5-12-18.12-5.29-25.96-17.29-23.5-36,3.19-3.51,6.69-3.84,10.5-1,2.17,5.6,4.34,11.27,6.5,17,8.15,8.16,16.99,9,26.5,2.5,8-9.33,8-18.67,0-28-6.26-3.16-12.92-4.82-20-5-18.1-6.03-26.26-18.53-24.5-37.5,2.57-14.07,10.74-22.73,24.5-26-.11-3.75.39-7.41,1.5-11,1.5-1.97,3.33-3.3,5.5-4Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M246,239.5c2.43.02,4.76.52,7,1.5l26.5,26.5c.67,3,.67,6,0,9-9.53,9.86-19.36,19.36-29.5,28.5-9.91.37-13.07-4.13-9.5-13.5l10.5-10.5c-26.33-.33-52.67-.67-79-1-1.83-.5-3-1.67-3.5-3.5-.67-2.67-.67-5.33,0-8,.5-1.83,1.67-3,3.5-3.5,26.67-.33,53.33-.67,80-1l-11.5-11.5c-1.9-6.16-.07-10.49,5.5-13Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path><path d="M198,303.5c9.36.52,12.53,5.19,9.5,14l-10.5,10.5c26.33.33,52.67.67,79,1,1.83.5,3,1.67,3.5,3.5.67,2.67.67,5.33,0,8-.5,1.83-1.67,3-3.5,3.5-26.67.33-53.33.67-80,1,3.83,3.83,7.67,7.67,11.5,11.5,1.81,10.53-2.36,14.36-12.5,11.5-8.83-8.83-17.67-17.67-26.5-26.5-.67-3-.67-6,0-9,9.73-9.9,19.56-19.56,29.5-29Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path><path d="M73,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M45,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path><path d="M353,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M325,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path></svg>
                            
                        </div>
                          </a>
                    </li>
                    <li class="mb-3">
                        <a :href="custom.Suporte" :title="$t('Support')">
                        <div v-if="custom.Suporte" class="card-sidebar-recolhido flex items-center justify-center p-3 rounded-[3px] text-center">
                            
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.2 13.6V14.024C15.1937 14.3381 15.0645 14.6372 14.8402 14.857C14.6158 15.0769 14.3141 15.2001 14 15.2H10V16H14C14.5304 16 15.0391 15.7893 15.4142 15.4142C15.7893 15.0391 16 14.5304 16 14V12.8C15.7748 13.1052 15.5052 13.3748 15.2 13.6Z"
                                        fill="#414952"></path>
                                    <path
                                        d="M0 10.5839C0.049109 9.80103 0.327312 9.04988 0.8 8.42389V8.30389C0.289133 8.88313 0.00499042 9.62758 0 10.3999C0 10.4639 0 10.5199 0 10.5839Z"
                                        fill="#414952"></path>
                                    <path
                                        d="M8 0C5.87827 0 3.84344 0.842855 2.34315 2.34315C0.842855 3.84344 0 5.87827 0 8H0C0.244633 7.6957 0.529976 7.42651 0.848 7.2C1.05156 5.44594 1.89262 3.82784 3.21126 2.65338C4.5299 1.47892 6.23417 0.829998 8 0.829998C9.76583 0.829998 11.4701 1.47892 12.7887 2.65338C14.1074 3.82784 14.9484 5.44594 15.152 7.2C15.47 7.42651 15.7554 7.6957 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 0 8 0V0Z"
                                        fill="#414952"></path>
                                    <path
                                        d="M3.2 7.20001C2.35131 7.20001 1.53737 7.53715 0.937258 8.13727C0.337142 8.73739 0 9.55132 0 10.4C0 11.2487 0.337142 12.0626 0.937258 12.6628C1.53737 13.2629 2.35131 13.6 3.2 13.6V7.20001Z"
                                        fill="#8C9099"></path>
                                    <path
                                        d="M12.8 13.6C13.6487 13.6 14.4626 13.2629 15.0627 12.6628C15.6628 12.0626 16 11.2487 16 10.4C16 9.55132 15.6628 8.73739 15.0627 8.13727C14.4626 7.53715 13.6487 7.20001 12.8 7.20001V13.6Z"
                                        fill="#8C9099"></path>
                                    <path
                                        d="M3.20001 7.20001H4.00001C4.21219 7.20001 4.41567 7.2843 4.5657 7.43433C4.71573 7.58436 4.80001 7.78784 4.80001 8.00001V12.8C4.80001 13.0122 4.71573 13.2157 4.5657 13.3657C4.41567 13.5157 4.21219 13.6 4.00001 13.6H3.20001V7.20001Z"
                                        fill="#414952"></path>
                                    <path
                                        d="M12 7.20001H12.8V13.6H12C11.7878 13.6 11.5844 13.5157 11.4343 13.3657C11.2843 13.2157 11.2 13.0122 11.2 12.8V8.00001C11.2 7.78784 11.2843 7.58436 11.4343 7.43433C11.5844 7.2843 11.7878 7.20001 12 7.20001Z"
                                        fill="#414952"></path>
                                    <path
                                        d="M6.8 14H9.2C9.41217 14 9.61566 14.0843 9.76569 14.2343C9.91571 14.3843 10 14.5878 10 14.8V16H6.8C6.58783 16 6.38434 15.9157 6.23431 15.7657C6.08429 15.6157 6 15.4122 6 15.2V14.8C6 14.5878 6.08429 14.3843 6.23431 14.2343C6.38434 14.0843 6.58783 14 6.8 14Z"
                                        fill="#8C9099"></path>
                                </svg>
                            
                        </div>
                    </a>
                    </li>
                    
                    <li v-if="custom.ajuda" class="mb-3">
                        <a :href="custom.ajuda" :title="$t('Central de Ajuda')">
                        <div class="card-sidebar-recolhido flex items-center justify-center p-3 rounded-[3px] text-center">
                            
                            <svg data-v-b7b4c0c9="" height="1.5em" viewBox="0 0 512 512" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M342.5 214.7C342.6 214.6 342.4 214.8 342.5 214.7l128.1-128.1c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0L297.3 169.5c-.0742 .0742 .0742-.0762 0 0C317.1 178.1 333 194.9 342.5 214.7zM169.5 297.3C169.4 297.4 169.6 297.2 169.5 297.3l-128.1 128.1c-12.5 12.5-12.5 32.75 0 45.25C47.63 476.9 55.81 480 64 480s16.38-3.125 22.62-9.375l128.1-128.1c.0742-.0742-.0742 .0762 0 0C194.9 333 178.1 317.1 169.5 297.3zM342.5 297.3C342.4 297.2 342.6 297.4 342.5 297.3c-9.463 19.78-25.43 35.74-45.21 45.21c.0742 .0762-.0742-.0742 0 0l128.1 128.1C431.6 476.9 439.8 480 448 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L342.5 297.3zM86.63 41.38c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L169.5 214.7c.0742 .0742-.0762-.0742 0 0c9.463-19.78 25.43-35.74 45.21-45.21c-.0742-.0762 .0742 .0742 0 0L86.63 41.38z" fill="currentColor"></path><path d="M214.7 169.5C227.2 163.5 241.2 160 256 160s28.76 3.51 41.29 9.502c.0742-.0762-.0742 .0742 0 0l115.5-115.6C369.5 20.26 315.2 0 256 0S142.5 20.26 99.2 53.95L214.7 169.5C214.8 169.6 214.6 169.4 214.7 169.5zM169.5 297.3C163.5 284.8 160 270.8 160 256s3.51-28.76 9.502-41.29c-.0762-.0742 .0742 .0742 0 0L53.95 99.2C20.26 142.5 0 196.8 0 256s20.26 113.5 53.95 156.8L169.5 297.3C169.6 297.2 169.4 297.4 169.5 297.3zM458.1 99.2l-115.6 115.5c-.0742 .0742 .0762-.0742 0 0C348.5 227.2 352 241.2 352 256s-3.51 28.76-9.502 41.29c.0762 .0742-.0742-.0742 0 0l115.6 115.5C491.7 369.5 512 315.2 512 256S491.7 142.5 458.1 99.2zM297.3 342.5C284.8 348.5 270.8 352 256 352s-28.76-3.51-41.29-9.502c-.0742 .0762 .0742-.0742 0 0l-115.5 115.6C142.5 491.7 196.8 512 256 512s113.5-20.26 156.8-53.95L297.3 342.5C297.2 342.4 297.4 342.6 297.3 342.5z" fill="currentColor" opacity="0.4"></path></svg>
                            
                        </div>
                          </a>
                    </li>

                    <li class="mb-3">
                        <a @click="$router.push('/profile/affiliate')" href="#" :title="$t('Indique um Amigo')">
                        <div class="card-sidebar-recolhido flex items-center justify-center p-3 rounded-[3px] text-center">
                            
                          <svg data-v-b7b4c0c9="" height="1.5em" viewBox="0 0 512 512" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M320 96C328.8 96 336 103.2 336 112C336 120.8 328.8 128 320 128H192C183.2 128 176 120.8 176 112C176 103.2 183.2 96 192 96H320zM276.1 230.3C282.7 231.5 292.7 233.5 297.1 234.7C307.8 237.5 314.2 248.5 311.3 259.1C308.5 269.8 297.5 276.2 286.9 273.3C283 272.3 269.5 269.7 265.1 268.1C252.9 267.1 242.1 268.7 236.5 271.6C230.2 274.4 228.7 277.7 228.3 279.7C227.7 283.1 228.3 284.3 228.5 284.7C228.7 285.2 229.5 286.4 232.1 288.2C238.2 292.4 247.8 295.4 261.1 299.7L262.8 299.9C274.9 303.6 291.1 308.4 303.2 317.3C309.9 322.1 316.2 328.7 320.1 337.7C324.1 346.8 324.9 356.8 323.1 367.2C319.8 386.2 307.2 399.2 291.4 405.9C286.6 407.1 281.4 409.5 276.1 410.5V416C276.1 427.1 267.1 436.1 255.1 436.1C244.9 436.1 235.9 427.1 235.9 416V409.6C226.4 407.4 213.1 403.2 206.1 400.5C204.4 399.9 202.9 399.4 201.7 398.1C191.2 395.5 185.5 384.2 189 373.7C192.5 363.2 203.8 357.5 214.3 361C216.3 361.7 218.5 362.4 220.7 363.2C230.2 366.4 240.9 370 246.9 371C259.7 373 269.6 371.7 275.7 369.1C281.2 366.8 283.1 363.8 283.7 360.3C284.4 356.3 283.8 354.5 283.4 353.7C283.1 352.8 282.2 351.4 279.7 349.6C273.8 345.3 264.4 342.2 250.4 337.9L248.2 337.3C236.5 333.8 221.2 329.2 209.6 321.3C203 316.8 196.5 310.6 192.3 301.8C188.1 292.9 187.1 283 188.9 272.8C192.1 254.5 205.1 241.9 220 235.1C224.1 232.9 230.3 231.2 235.9 230V223.1C235.9 212.9 244.9 203.9 256 203.9C267.1 203.9 276.1 212.9 276.1 223.1L276.1 230.3z" fill="currentColor"></path><path d="M144.6 24.88C137.5 14.24 145.1 0 157.9 0H354.1C366.9 0 374.5 14.24 367.4 24.88L320 96H192L144.6 24.88zM332.1 136.4C389.7 172.7 512 250.9 512 416C512 469 469 512 416 512H96C42.98 512 0 469 0 416C0 250.9 122.3 172.7 179 136.4C183.9 133.3 188.2 130.5 192 128H320C323.8 130.5 328.1 133.3 332.1 136.4V136.4zM235.9 224V230C230.3 231.2 224.1 232.9 220 235.1C205.1 241.9 192.1 254.5 188.9 272.8C187.1 283 188.1 292.9 192.3 301.8C196.5 310.6 203 316.8 209.6 321.3C221.2 329.2 236.5 333.8 248.2 337.3L250.4 337.9C264.4 342.2 273.8 345.3 279.7 349.6C282.2 351.4 283.1 352.8 283.4 353.7C283.8 354.5 284.4 356.3 283.7 360.3C283.1 363.8 281.2 366.8 275.7 369.1C269.6 371.7 259.7 373 246.9 371C240.9 370 230.2 366.4 220.7 363.2C218.5 362.4 216.3 361.7 214.3 361C203.8 357.5 192.5 363.2 189 373.7C185.5 384.2 191.2 395.5 201.7 398.1C202.9 399.4 204.4 399.9 206.1 400.5C213.1 403.2 226.4 407.4 235.9 409.6V416C235.9 427.1 244.9 436.1 255.1 436.1C267.1 436.1 276.1 427.1 276.1 416V410.5C281.4 409.5 286.6 407.1 291.4 405.9C307.2 399.2 319.8 386.2 323.1 367.2C324.9 356.8 324.1 346.8 320.1 337.7C316.2 328.7 309.9 322.1 303.2 317.3C291.1 308.4 274.9 303.6 262.8 299.9L261.1 299.7C247.8 295.4 238.2 292.4 232.1 288.2C229.5 286.4 228.7 285.2 228.5 284.7C228.3 284.3 227.7 283.1 228.3 279.7C228.7 277.7 230.2 274.4 236.5 271.6C242.1 268.7 252.9 267.1 265.1 268.1C269.5 269.7 283 272.3 286.9 273.3C297.5 276.2 308.5 269.8 311.3 259.1C314.2 248.5 307.8 237.5 297.1 234.7C292.7 233.5 282.7 231.5 276.1 230.3V224C276.1 212.9 267.1 203.9 255.1 203.9C244.9 203.9 235.9 212.9 235.9 224L235.9 224z" fill="currentColor" opacity="0.4"></path></svg>
                            
                        </div>
                          </a>
                    </li>
                </ul>

            </div>
      

            <div class="sidebar-color h-full pb-4 overflow-y-auto pb-4 lg:hidden block"  style="padding-top: 30px;margin-top: -100px;">

                <div style="display: flex;padding: 0px 4%;align-items: center;justify-content: space-between;padding-bottom: 20px;">
                    <div>
                <a v-if="setting" href="/" class="flex lg:ml-2 ml:1 lg:mr-24">
                        <img style="max-width: 90px;" :src="`/storage/`+setting.software_logo_black" alt="" class="h-8 block dark:hidden " />
                        <img style="max-width: 90px;" :src="`/storage/`+setting.software_logo_white" alt=""  class="lg:max-h-[35px] max-h-[30px] hidden dark:block" />
                    </a>
                </div>
                <div>
                <button @click.prevent="toggleMenu" class="btn" style="border-radius: 50%;padding: 5px;background-color: #3F4142">
                    <svg data-v-b7b4c0c9="" height="1em" viewBox="0 0 320 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" fill="currentColor"></path></svg>
            </button>
        </div>
        </div>

        <div class="px-4">
                              <!-- Card 4 - Natal
                <button @click.prevent="$router.push('/profile/deposit')"
                class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-natal" 
                style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 50px;background: #0003ab; background: #0003ab; background: linear-gradient(to right, #dc2670, #f57eae, #dc2670);">
                    <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                        <p style="font-size: 12px;">Aproveite a Páscoa!</p>
                        <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Deposite e Resgate</h1>
                    </div>
                    <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">🐰</span>
                </button> -->
          
            <!-- Card 1 - Afiliado (padronizado) -->
            <RouterLink :to="{ name: 'profileAffiliate' }"
            class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-affiliate" 
            style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 50px;background: #14a63d;background: #249B00;background: linear-gradient(90deg,rgba(36, 155, 0, 1) 0%, rgba(94, 184, 66, 1) 50%, rgba(36, 155, 0, 1) 100%);">
                <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                    <p style="font-size: 12px;">Ganhe até</p>
                    <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">R$ 100 grátis Indicando</h1>
                </div>
                <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">💸</span>
            </RouterLink>

            <!-- Card 3 - Missões -->
            <button @click.prevent="$router.push('/missions')"
            class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-missoes" 
            style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 10px;background: #8600c4;background: linear-gradient(90deg,rgba(134, 0, 196, 1) 0%, rgba(185, 90, 230, 1) 50%, rgba(134, 0, 196, 1) 100%);">
                <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                    <p style="font-size: 12px;">Participe das</p>
                    <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Missões e dos Prêmios</h1>
                </div>
                <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">🏆</span>
            </button>
          
            <!-- Card 2 - Torneios -->
            <button @click.prevent="$router.push('/vip')"
            class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-torneios" 
            style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 10px;background: #EC7000;background: linear-gradient(90deg,rgba(236, 112, 0, 1) 0%, rgba(255, 156, 69, 1) 50%, rgba(236, 112, 0, 1) 100%);">
                <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                    <p style="font-size: 12px;">Conheça o nosso</p>
                    <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Clube VIP e Vantagens</h1>
                </div>
                <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">👑</span>
            </button>

          
                    <!-- Card 3 - Missões -->
            <button @click.prevent="$router.push('/dailyroulette')"
            class="opacidade-hover rounded-[3px] flex w-full items-center h-auto card-with-glow card-suporte" 
            style="justify-content: space-between;padding: 6px 20px;padding-right: 25px;margin-top: 10px;background: #0003ab; background: linear-gradient(90deg,rgba(0, 3, 171, 1) 0%, rgba(74, 77, 224, 1) 50%, rgba(0, 3, 171, 1) 100%);">
                <div class="flex flex-col items-start gap-1" style="line-height: 13px;">
                    <p style="font-size: 12px;">Aproveite agora</p>
                    <h1 class="" style="font-size: .900rem;font-weight: bold;color: white;">Bônus e Rodadas Grátis</h1>
                </div>
                <span style="max-width: 20px;margin-left: -10px;" class="text-[25px]">💰</span>
            </button>
        </div>
              
                <div style="width: 100%;height: 1px;background-color: #27292A;margin-top: 20px;margin-bottom: 20px;"></div>

                <ul class="space-y-2 font-medium py-2 ml-2" >
                    <li v-for="(category, index) in categories" :key="index">
                        <RouterLink
                            v-if="!category.url"
                            :to="{ name: 'casinosAll', params: { provider: 'all', category: category.slug }}"
                            active-class="category-active"
                            class="flex flex-row items-center py-2 px-4 filter-gray-hover gray-scale-menu">
                            <img :src="`/storage/`+category.image" alt="" width="21" class="mr-3">
                            <span style="font-size: 12px;" class="">{{ $t(category.name) }}</span>
                        </RouterLink>
                        <a
                            v-else
                            :href="category.url"
                            :to="{ name: 'casinosAll', params: { provider: 'all', category: category.slug }}"
                            active-class="category-active"
                            class="flex flex-row items-center py-2 px-4 filter-gray-hover gray-scale-menu" >
                            <img :src="`/storage/`+category.image" alt="" width="21" class="mr-3">
                            <span style="font-size: 12px" class="">{{ $t(category.name) }}</span>
                        </a>
                    </li>

                </ul>

                <div style="height: 1px;background-color:  var(--sidebar-color);width: 100%;margin-top: 20px;margin-bottom: 20px"></div>

                <ul v-if="custom.telegram" class="font-medium mt-2 mb-[200px] ml-2">
                    <li class="px-3">
                        <a :href="custom.telegram"
                            class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu">
                            <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 496 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z" fill="currentColor"></path></svg>
                            <span class="ml-3" style="font-weight: bold;font-size: 12px;">{{ $t('Canal do Telegram') }}</span>
                        </a>
                    </li>

                    <li class="px-3">
                    <a @click.prevent="$router.push('/profile/affiliate')" href="#"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                        <svg data-v-b7b4c0c9="" fill="currentColor" height="20px" viewBox="0 0 448 448.5" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M209,.5c49.67-3.92,87.5,15.08,113.5,57,16.47,33.39,17.8,67.39,4,102-24.64,47.41-63.81,68.91-117.5,64.5-54.17-10.17-86.33-42.33-96.5-96.5-4.41-49.68,14.42-87.51,56.5-113.5,12.72-6.67,26.06-11.17,40-13.5ZM223,40.5c3.06.3,5.56,1.63,7.5,4,1.11,3.59,1.61,7.25,1.5,11,18.12,5.29,25.96,17.29,23.5,36-3.19,3.5-6.69,3.84-10.5,1-2.17-5.61-4.33-11.27-6.5-17-9.67-9.33-19.33-9.33-29,0-6.61,12.48-3.78,21.98,8.5,28.5,18.14-.2,30.64,7.97,37.5,24.5,3.59,14.9-.58,27.07-12.5,36.5-3.23,2.57-6.89,4.07-11,4.5.32,4.25-.51,8.25-2.5,12-3.67,2.67-7.33,2.67-11,0-1.99-3.75-2.82-7.75-2.5-12-18.12-5.29-25.96-17.29-23.5-36,3.19-3.51,6.69-3.84,10.5-1,2.17,5.6,4.34,11.27,6.5,17,8.15,8.16,16.99,9,26.5,2.5,8-9.33,8-18.67,0-28-6.26-3.16-12.92-4.82-20-5-18.1-6.03-26.26-18.53-24.5-37.5,2.57-14.07,10.74-22.73,24.5-26-.11-3.75.39-7.41,1.5-11,1.5-1.97,3.33-3.3,5.5-4Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M246,239.5c2.43.02,4.76.52,7,1.5l26.5,26.5c.67,3,.67,6,0,9-9.53,9.86-19.36,19.36-29.5,28.5-9.91.37-13.07-4.13-9.5-13.5l10.5-10.5c-26.33-.33-52.67-.67-79-1-1.83-.5-3-1.67-3.5-3.5-.67-2.67-.67-5.33,0-8,.5-1.83,1.67-3,3.5-3.5,26.67-.33,53.33-.67,80-1l-11.5-11.5c-1.9-6.16-.07-10.49,5.5-13Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path><path d="M198,303.5c9.36.52,12.53,5.19,9.5,14l-10.5,10.5c26.33.33,52.67.67,79,1,1.83.5,3,1.67,3.5,3.5.67,2.67.67,5.33,0,8-.5,1.83-1.67,3-3.5,3.5-26.67.33-53.33.67-80,1,3.83,3.83,7.67,7.67,11.5,11.5,1.81,10.53-2.36,14.36-12.5,11.5-8.83-8.83-17.67-17.67-26.5-26.5-.67-3-.67-6,0-9,9.73-9.9,19.56-19.56,29.5-29Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path><path d="M73,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M45,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path><path d="M353,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path><path d="M325,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z" style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path></svg>
                        <span style="font-weight: bold;font-size: 12px;" class="ml-3 gray-scale-menu" >{{ $t('Seja um Afiliado') }}</span>
                    </a>
                </li>

                <li v-if="custom.Suporte" class="px-3">
                    <a :href="custom.Suporte"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                        <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 640 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M640 191.1v191.1c0 35.25-28.75 63.1-64 63.1h-32v54.24c0 7.998-9.125 12.62-15.5 7.873l-82.75-62.12L319.1 447.1C284.7 447.1 256 419.2 256 383.1v-31.98l96-.002c52.88 0 96-43.12 96-95.99V128h128C611.3 128 640 156.7 640 191.1z" fill="currentColor"></path><path d="M352 0H64C28.75 0 0 28.75 0 63.1V256C0 291.2 28.75 320 64 320l32 .0098v54.25c0 7.998 9.125 12.62 15.5 7.875l82.75-62.12L352 319.9c35.25 .125 64-28.68 64-63.92V63.1C416 28.75 387.3 0 352 0z" fill="currentColor" opacity="0.4"></path></svg>
                        <span style="font-weight: bold;font-size: 12px;" class="ml-3 gray-scale-menu" >{{ $t('Suporte Ao Vivo') }}</span>
                    </a>
                </li>

                <li v-if="custom.ajuda" class="px-3">
                    <a :href="custom.ajuda"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                         
                        <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 512 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M342.5 214.7C342.6 214.6 342.4 214.8 342.5 214.7l128.1-128.1c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0L297.3 169.5c-.0742 .0742 .0742-.0762 0 0C317.1 178.1 333 194.9 342.5 214.7zM169.5 297.3C169.4 297.4 169.6 297.2 169.5 297.3l-128.1 128.1c-12.5 12.5-12.5 32.75 0 45.25C47.63 476.9 55.81 480 64 480s16.38-3.125 22.62-9.375l128.1-128.1c.0742-.0742-.0742 .0762 0 0C194.9 333 178.1 317.1 169.5 297.3zM342.5 297.3C342.4 297.2 342.6 297.4 342.5 297.3c-9.463 19.78-25.43 35.74-45.21 45.21c.0742 .0762-.0742-.0742 0 0l128.1 128.1C431.6 476.9 439.8 480 448 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L342.5 297.3zM86.63 41.38c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L169.5 214.7c.0742 .0742-.0762-.0742 0 0c9.463-19.78 25.43-35.74 45.21-45.21c-.0742-.0762 .0742 .0742 0 0L86.63 41.38z" fill="currentColor"></path><path d="M214.7 169.5C227.2 163.5 241.2 160 256 160s28.76 3.51 41.29 9.502c.0742-.0762-.0742 .0742 0 0l115.5-115.6C369.5 20.26 315.2 0 256 0S142.5 20.26 99.2 53.95L214.7 169.5C214.8 169.6 214.6 169.4 214.7 169.5zM169.5 297.3C163.5 284.8 160 270.8 160 256s3.51-28.76 9.502-41.29c-.0762-.0742 .0742 .0742 0 0L53.95 99.2C20.26 142.5 0 196.8 0 256s20.26 113.5 53.95 156.8L169.5 297.3C169.6 297.2 169.4 297.4 169.5 297.3zM458.1 99.2l-115.6 115.5c-.0742 .0742 .0762-.0742 0 0C348.5 227.2 352 241.2 352 256s-3.51 28.76-9.502 41.29c.0762 .0742-.0742-.0742 0 0l115.6 115.5C491.7 369.5 512 315.2 512 256S491.7 142.5 458.1 99.2zM297.3 342.5C284.8 348.5 270.8 352 256 352s-28.76-3.51-41.29-9.502c-.0742 .0762 .0742-.0742 0 0l-115.5 115.6C142.5 491.7 196.8 512 256 512s113.5-20.26 156.8-53.95L297.3 342.5C297.2 342.4 297.4 342.6 297.3 342.5z" fill="currentColor" opacity="0.4"></path></svg>
                        <span style="font-weight: bold;font-size: 12px;" class="ml-3 gray-scale-menu" >{{ $t('Central de Ajuda') }}</span>
                    </a>
                </li>

                <li class="px-3">
                    <a @click.prevent="$router.push('/profile/affiliate')" href="#"
                        class="l-5 flex items-center w-full p-2 text-gray-700 font-normal rounded-lg group dark:text-gray-400 dark:hover:text-white gray-scale-menu" >
                       <svg data-v-b7b4c0c9="" height="20px" viewBox="0 0 512 512" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="M320 96C328.8 96 336 103.2 336 112C336 120.8 328.8 128 320 128H192C183.2 128 176 120.8 176 112C176 103.2 183.2 96 192 96H320zM276.1 230.3C282.7 231.5 292.7 233.5 297.1 234.7C307.8 237.5 314.2 248.5 311.3 259.1C308.5 269.8 297.5 276.2 286.9 273.3C283 272.3 269.5 269.7 265.1 268.1C252.9 267.1 242.1 268.7 236.5 271.6C230.2 274.4 228.7 277.7 228.3 279.7C227.7 283.1 228.3 284.3 228.5 284.7C228.7 285.2 229.5 286.4 232.1 288.2C238.2 292.4 247.8 295.4 261.1 299.7L262.8 299.9C274.9 303.6 291.1 308.4 303.2 317.3C309.9 322.1 316.2 328.7 320.1 337.7C324.1 346.8 324.9 356.8 323.1 367.2C319.8 386.2 307.2 399.2 291.4 405.9C286.6 407.1 281.4 409.5 276.1 410.5V416C276.1 427.1 267.1 436.1 255.1 436.1C244.9 436.1 235.9 427.1 235.9 416V409.6C226.4 407.4 213.1 403.2 206.1 400.5C204.4 399.9 202.9 399.4 201.7 398.1C191.2 395.5 185.5 384.2 189 373.7C192.5 363.2 203.8 357.5 214.3 361C216.3 361.7 218.5 362.4 220.7 363.2C230.2 366.4 240.9 370 246.9 371C259.7 373 269.6 371.7 275.7 369.1C281.2 366.8 283.1 363.8 283.7 360.3C284.4 356.3 283.8 354.5 283.4 353.7C283.1 352.8 282.2 351.4 279.7 349.6C273.8 345.3 264.4 342.2 250.4 337.9L248.2 337.3C236.5 333.8 221.2 329.2 209.6 321.3C203 316.8 196.5 310.6 192.3 301.8C188.1 292.9 187.1 283 188.9 272.8C192.1 254.5 205.1 241.9 220 235.1C224.1 232.9 230.3 231.2 235.9 230V223.1C235.9 212.9 244.9 203.9 256 203.9C267.1 203.9 276.1 212.9 276.1 223.1L276.1 230.3z" fill="currentColor"></path><path d="M144.6 24.88C137.5 14.24 145.1 0 157.9 0H354.1C366.9 0 374.5 14.24 367.4 24.88L320 96H192L144.6 24.88zM332.1 136.4C389.7 172.7 512 250.9 512 416C512 469 469 512 416 512H96C42.98 512 0 469 0 416C0 250.9 122.3 172.7 179 136.4C183.9 133.3 188.2 130.5 192 128H320C323.8 130.5 328.1 133.3 332.1 136.4V136.4zM235.9 224V230C230.3 231.2 224.1 232.9 220 235.1C205.1 241.9 192.1 254.5 188.9 272.8C187.1 283 188.1 292.9 192.3 301.8C196.5 310.6 203 316.8 209.6 321.3C221.2 329.2 236.5 333.8 248.2 337.3L250.4 337.9C264.4 342.2 273.8 345.3 279.7 349.6C282.2 351.4 283.1 352.8 283.4 353.7C283.8 354.5 284.4 356.3 283.7 360.3C283.1 363.8 281.2 366.8 275.7 369.1C269.6 371.7 259.7 373 246.9 371C240.9 370 230.2 366.4 220.7 363.2C218.5 362.4 216.3 361.7 214.3 361C203.8 357.5 192.5 363.2 189 373.7C185.5 384.2 191.2 395.5 201.7 398.1C202.9 399.4 204.4 399.9 206.1 400.5C213.1 403.2 226.4 407.4 235.9 409.6V416C235.9 427.1 244.9 436.1 255.1 436.1C267.1 436.1 276.1 427.1 276.1 416V410.5C281.4 409.5 286.6 407.1 291.4 405.9C307.2 399.2 319.8 386.2 323.1 367.2C324.9 356.8 324.1 346.8 320.1 337.7C316.2 328.7 309.9 322.1 303.2 317.3C291.1 308.4 274.9 303.6 262.8 299.9L261.1 299.7C247.8 295.4 238.2 292.4 232.1 288.2C229.5 286.4 228.7 285.2 228.5 284.7C228.3 284.3 227.7 283.1 228.3 279.7C228.7 277.7 230.2 274.4 236.5 271.6C242.1 268.7 252.9 267.1 265.1 268.1C269.5 269.7 283 272.3 286.9 273.3C297.5 276.2 308.5 269.8 311.3 259.1C314.2 248.5 307.8 237.5 297.1 234.7C292.7 233.5 282.7 231.5 276.1 230.3V224C276.1 212.9 267.1 203.9 255.1 203.9C244.9 203.9 235.9 212.9 235.9 224L235.9 224z" fill="currentColor" opacity="0.4"></path></svg>
                        <span style="font-weight: bold;font-size: 12px;" class="ml-3 gray-scale-menu" >{{ $t('Indique um Amigo') }}</span>
                    </a>
                </li>
                 
                </ul>
            </div>
            
        </div>
    </aside>
</template>

<script>
    import {
        onMounted
    } from "vue";
    import {
        sidebarStore
    } from "@/Stores/SideBarStore.js"; 
    import {
        RouterLink
    } from "vue-router";
    import HttpApi from "@/Services/HttpApi.js";
    import {
        useToast
    } from "vue-toastification";
    import {
        useAuthStore
    } from "@/Stores/Auth.js";
    import {
        useSettingStore
    } from "@/Stores/SettingStore.js";
    import {
        missionStore
    } from "@/Stores/MissionStore.js";
    
        export default {
            props: {
                removeTopPadding: {
                    type: Boolean,
                    default: false // Por padrão, o padding não é removido
                }
            },
        components: {
            RouterLink
        },
        data() {
            return {
                sidebar: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? false : (localStorage.getItem('sidebarStatus') ? JSON.parse(localStorage.getItem('sidebarStatus')) : false),
                isLoading: true,
                loading: true,
                categories: [],
                sportsCategories: [],
                modalMission: null,
                setting: null,
                expanded: false, 
                custom: null,
            }
        },
        setup(props) {
            onMounted(() => {
                // Código de inicialização aqui se necessário
            });
            return {};
        },
        computed: {
            sidebarMenuStore() {
                return sidebarStore()
            },
            sidebarMenu() {
                const sidebar = sidebarStore()
                return sidebar.getSidebarStatus;
            },
            isAuthenticated() {
                const authStore = useAuthStore();
                return authStore.isAuth;
            },
            setting() {
                const authStore = useSettingStore();
                return authStore.setting;
            }
        },
        mounted() {
            window.scrollTo(0, 0);
        },
        methods: {
            /**
             * Obtém as configurações do sistema
             */
            getSetting: function() {
                const _this = this;
                const settingStore = useSettingStore();
                const settingData = settingStore.setting;
                if(settingData) {
                    _this.setting = settingData;
                }
            },
            
            /**
             * Alterna o estado do menu sidebar
             */
            toggleMenu() {
                this.sidebarMenuStore.setSidebarToogle();
            },
            
            /**
             * Alterna o modal de missões
             */
            toggleMissionModal: function () {
                const missionDataStore = missionStore();
                missionDataStore.setMissionToogle();
            },
            
            /**
             * Busca as categorias de casino da API
             */
            getCasinoCategories: function () {
                const _this = this;
                const _toast = useToast();
                _this.isLoading = true;
                _this.loading = true;
                
                HttpApi.get('categories')
                    .then(response => {
                        _this.categories = response.data.categories;
                        _this.isLoading = false;
                        _this.loading = false;
                    })
                    .catch(error => {
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                            _toast.error(`${value}`);
                        });
                        _this.isLoading = false;
                        _this.loading = false;
                    });
            }
        },
        created() {
            this.custom = custom;
            this.getCasinoCategories();
            this.getSetting();
        },
        watch: {
            sidebarMenu(newVal, oldVal) {
                this.sidebar = newVal;
            }
        },
    };
</script>

