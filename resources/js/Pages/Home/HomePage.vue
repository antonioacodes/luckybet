<style>
.principais-ligas-section {
  width: 100%;
  margin-bottom: 2rem;
}
/* Título */
.section-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: linear-gradient(90deg,var(--card-color-dark), rgba(255, 255, 255, 0) 100%);
  border-radius: 0.6rem;
  margin-bottom: 0.4rem;
  margin-top: 1.2rem;
  padding:0.1rem;
  padding-left:10px;
  font-size: 18px;
  font-weight: 550;
  color: #ffffff;
}

/* Container de Scroll Horizontal das Ligas */
.ligas-scroll-container {
  width: 100%;
  overflow-x: auto;
  overflow-y: hidden;
  padding-bottom: 0.5rem;
  padding-top: 0.4rem;
}

.ligas-scroll-container::-webkit-scrollbar {
  height: 6px;
}

.ligas-scroll-container::-webkit-scrollbar-track {
  background: transparent;
}

.ligas-scroll-container::-webkit-scrollbar-thumb {
  background: rgba(188, 213, 13, 0.3);
  border-radius: 3px;
}

.ligas-scroll-container::-webkit-scrollbar-thumb:hover {
  background: rgba(188, 213, 13, 0.5);
}

/* Wrapper das Ligas */
.ligas-wrapper {
  display: flex;
  gap: 1.5rem;
  padding-top: 1rem 0;
  min-width: min-content;
}

/* Item Individual da Liga */
.liga-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  min-width: 80px;
}

/* Botão Circular da Liga */
.liga-circle-button {
  width: 78px;
  height: 78px;
  border-radius: 50%;
  background: linear-gradient(0deg,var(--ci-primary-opacity-color) 0%, rgba(255, 255, 255, 0) 100%);
  border: 2px solid var(--ci-primary-opacity-color);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 20px;
}

.liga-circle-button svg {
  width: 100%;
  height: 100%;
}

.liga-circle-button:hover {
  background: var(--ci-primary-opacity-color)/10;
  border-color: var(--ci-primary-color);
  transform: scale(1.05);
}

/* Label da Liga */
.liga-label {
  font-size: 0.75rem;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.8);
  text-align: center;
  margin: 0;
  max-width: 100px;
  line-height: 1.2;
}

/* Grid de Esportes */
.esportes-grid {
  display:flex;
  overflow-x: auto;
  overflow-y: hidden;
  margin-bottom: 1.5rem;
  gap: 0.75rem;
}

/* Card de Esporte */
.esporte-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem 1.25rem;
  background: linear-gradient(270deg, var(--ci-primary-opacity-color) 0%, rgba(255, 255, 255, 0) 50%);
  border: 1px solid var(--ci-primary-opacity-color);
  border-radius: 0.625rem;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 258px;
  min-height: 38px;
  max-height: 50px;
  position: relative;
  overflow: hidden;
}

.esporte-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url('https://static.7k.bet.br/deploy-06f240ceeffef047dc2f2f1fb5a30d869ba6af85-8812f0b74f0ba22cc1e6/assets/images/major-leagues/bg-button.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  pointer-events: none;
  opacity: 0.8;
}

.esporte-card:hover {
  background: linear-gradient(270deg, var(--ci-primary-opacity-color) 0%, rgba(255, 255, 255, 0) 50%);
  border-color: var(--ci-primary-opacity-color);
}

.esporte-card:hover::before {
  opacity: 1;
}

/* Card Ao Vivo */
.live-card {
  background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(30, 35, 45, 0.9));
  border-color: rgba(239, 68, 68, 0.3);
}

.live-card:hover {
  background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(40, 45, 55, 0.95));
  border-color: rgba(239, 68, 68, 0.5);
}

/* Ícone do Esporte */
.esporte-icon-wrapper {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  z-index: 1;
}

.esporte-icon-wrapper svg {
  width: 100%;
  height: 100%;
}

/* Live Pulse */
.live-pulse {
  width: 10px;
  height: 10px;
  background: #ef4444;
  border-radius: 50%;
  position: relative;
  animation: pulse-animation 2s infinite;
}

@keyframes pulse-animation {
  0% {
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
  }
  50% {
    box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
  }
}

/* Conteúdo do Esporte */
.esporte-content {
  display: flex;
  flex-direction: column;
  text-align:start;
  flex: 1;
  position: relative;
  z-index: 1;
}

.esporte-category {
  font-size: 9px;
  color: var(--ci-primary-color);
  font-weight: 500;
}

.esporte-title-wrapper {
  display: flex;
  align-items: center;
  gap: 0.4rem;
}

.esporte-title {
  font-size: 12px;
  font-weight: 600;
  color: #ffffff;
  margin: 0;
}

/* Responsividade */
@media (max-width: 1200px) {
  .esportes-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: 1rem;
  }

  .liga-circle-button {
    width: 74px;
    height: 74px;
    padding: 14px;
  }

  .liga-label {
    font-size: 0.6875rem;
  }

  .esportes-grid {
    grid-template-columns: 1fr;
  }

  .esporte-card {
    padding: 0.875rem 1rem;
  }

  .esporte-icon-wrapper {
    width: 36px;
    height: 36px;
  }

  .esporte-title {
    font-size: 0.875rem;
  }
}

@media (max-width: 480px) {
  .ligas-wrapper {
    gap: 0.6rem;
  }

  .liga-item {
    min-width: 70px;
  }

  .liga-circle-button {
    width: 64px;
    height: 64px;
    padding: 14px;
  }
}
  
  
  
  
/* Específico para links com a classe .hover-target */
a.hover-target:hover div {
    background-color: #00FF5A !important; /* Fundo verde no hover */
    box-shadow: 0px 0px 15px 1px rgba(0,255,90,0.86);
  	transform: scale(1.1) translate(0px,-3px);
}

a.hover-target:hover svg path {
    fill: #090720 !important; /* Ícone azul escuro no hover */
}

a.hover-target {
    transition: 0.3s ease-in-out;
}


.shimmer {
  margin: 0 auto;
  position: relative;
  overflow: hidden;
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

.shimmer2 {
  margin: 0 auto;
  margin-bottom: 30px;
  margin-top: 10px;
  position: relative;
  overflow: hidden;
  padding: 80px;
  border-radius: 20px;
}

.shimmer2::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
 
  background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
  animation: shimmer 1.5s infinite;
}

.shimmer3 {
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  border-radius: 20px;
}

.shimmer3::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
 
  background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
  animation: shimmer 1.5s infinite;
}

.shimmer4 {
  margin-top: 30px;
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  border-radius: 20px;
}

.shimmer4::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
 
  background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
  animation: shimmer 1.5s infinite;
}

.shimmer-estilos-banner {
    height: 400px;
}

.shimmer-estilos-banner2 {
    margin-top: 30px;
    margin-bottom: 30px;
    height: 90px;
}

@keyframes shimmer {
  0% {
    left: -100%;
  }
  100% {
    left: 100%;
  }
}
  .btn-scroll-top {
    position: relative;
    z-index: 2;
    bottom: 2em;
    display: none;
    align-items: center;
    /* Outras propriedades de estilo aqui */
    background-color: #0000009a;
    border: 1px solid var(--ci-primary-color);
    color: #fff;
    cursor: pointer;
    transition: opacity 0.3s;
    font-size: 13px;
    gap: 0.5em;
    padding: 3px 12px;
    border-radius: 20px;
    margin-top: -30px;
    left: 48.5%;
    transform: translateX(-50%);
  }
  .titleCategories {
    text-align: center;
    font-weight: bold;
    font-size: 14px;
  }
  .categories-margin {
        margin-bottom: 15px;
    }

 .font-arrows {
    font-size: 22px;
 }
 .control-svgWidth {
    width: 2rem;
    height: 2rem;
 }
  .show-btn-scroll-top {
    display: block;
    display: flex;
  }

  /* Centralize verticalmente */
  .btn-scroll-top {
    /* transform: translateY(-50%); */
  }

  /* Centralize horizontalmente */
  .btn-scroll-top {
    
  }
  .search-mobile {
    -webkit-box-shadow: 0px 0px 14px -22px rgba(43,43,43,1);
-moz-box-shadow: 0px 0px 14px -22px rgba(43,43,43,1);
box-shadow: 0px 0px 14px -22px rgba(43,43,43,1);background-color: var(--ci-gray-dark);border-radius: 3px;font-size: 14px;padding-left: 40px;padding-top: 10px;padding-bottom: 10px;
  }
.margin-search {
    margin-top: -6px;
}
.placeholder-search::placeholder {
    color: #ACAFAF;
    font-size: 13px;
}
@media(max-width:1024px) {
    .btn-scroll-top {
        bottom: 6em;
      	left:50%;
        padding: 2px 7px;
    }
    .margin-categorias {
        margin-top: -20px;
    }
}

/* -------------------------------------------------
   1️⃣ Base – sempre presente (fora da media)
   ------------------------------------------------- */
.item-sombra2 {
  position: relative;               /* necessário para ::after */
}

  
  
.padding-mobile-banner {
    padding-top: 40px;
}

@media (min-width:769px) and (max-width:1121px) {
    .shimmer-estilos-banner {
    height: 239px;
}
}

@media (max-width:768px) {
    .shimmer-estilos-banner2 {
    margin-top: 20px;
    margin-bottom: 15px;
    height: 90px;
}
    .shimmer-estilos-banner {
    height: 153px;
}
    .titleCategories {
    font-size: 12px;
    }
    .categories-margin {
    margin-top: 0px;
    }
    .font-arrows {
    font-size: 16px;
    }
    #svg-lupa {
    margin-top: -2px;
    }
    .search-mobile {
    padding-top: 8px;
    padding-bottom: 8px;
    }
    .margin-search {
    margin-top: 0px;
    }
    .padding-mobile-banner {
    padding: 0;
    padding-top: 35px;
    }
}

</style>
<template>
    <BaseLayout>
   

        <div class="">

            <!-- Banners carousel -->
            <div class="carousel-banners">
                <div class="mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px] p-4 padding-mobile-banner"> 
                         <!-- Conteúdo da sua página aqui -->
                         <div class="mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]" style="position: fixed;bottom: 0;z-index: 2;pointer-events: auto;height: 0px;z-index: 1;">
                         <button style="pointer-events: auto;" class="btn-scroll-top" @click="scrollToTop">
                            <div><svg height="1em" viewBox="0 0 384 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" fill="currentColor"></path></svg></div> <div>De volta ao topo</div> 
                            </button>

                        </div>
                        <div v-if="loading">
      <!-- Aplicar o efeito shimmer enquanto os dados estão carregando -->
      <div v-if="loading" class="shimmer shimmer-estilos-banner" v-for="n in 1" :key="n">
       
      </div>
    </div>
    <div v-else>
                    <div class="">
                        <Carousel v-bind="settings" :breakpoints="breakpoints" ref="carouselBanner">
                            <Slide v-for="(banner, index) in banners" :key="index">
                                <div class="carousel__item rounded w-full">
                                    <a :href="banner.link" class="w-full h-full bg-blue-800 rounded">
                                        <img :src="`/storage/`+banner.image" alt="" class="h-full w-full rounded" style="max-height: 413px">
                                    </a>
                                </div>
                            </Slide>
 

                            <template #addons>
                                <navigation>
                                    <template #next>
                                        <i class="fa-solid fa-chevron-right text-white font-arrows"></i>
                                    </template>
                                    <template #prev>
                                        <i class="fa-solid fa-chevron-left text-white font-arrows"></i>
                                    </template>
                                </navigation>
                                <Pagination />
                            </template>
                        </Carousel>
                    </div>
                </div>
            </div>
        </div>

            <div class=" mx-auto p-4 sm:max-w-[690px] lg:max-w-[1110px]">     

    <!-- categories -->
   
    <div v-if="loading">
      <!-- Aplicar o efeito shimmer enquanto os dados estão carregando -->
      <div v-if="loading" class="shimmer3 shimmer-estilos-banner" v-for="n in 1" :key="n" style="height: 40px;">
       
      </div>
    </div>
    <div v-else>
                <div class="mx-auto sm:max-w-[690px] lg:max-w-[1110px] w-full search-margin">
                <!-- Searchbar action -->
                <div class=" cursor-pointer w-full margin-search md:mb-[39px] mb-4" style="background-color: #323637;border-radius: 5px;">
                    <div class="flex" style="border-radius: 5px;">
                        <div class="relative w-full" style="border-radius: 5px;">
                            <button style="border-radius: 5px;" @click="toggleSearch" type="submit" class="absolute top-0 start-0 h-full p-2.5 text-sm font-medium text-white rounded-e-lg">
                                <svg id="svg-lupa" data-v-49f1cded="" height="14px" viewBox="0 0 512 512" width="14px" xmlns="http://www.w3.org/2000/svg" class="text-texts w-5 p-0 m-0" style="width: 20px; height: 16px;"><path d="M500.3 443.7l-119.7-119.7c-15.03 22.3-34.26 41.54-56.57 56.57l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7z" fill="currentColor"></path><path d="M207.1 0C93.12 0-.0002 93.13-.0002 208S93.12 416 207.1 416s208-93.13 208-208S322.9 0 207.1 0zM207.1 336c-70.58 0-128-57.42-128-128c0-70.58 57.42-128 128-128s128 57.42 128 128C335.1 278.6 278.6 336 207.1 336z" fill="currentColor" opacity="0.4"></path></svg>
                                <span class="sr-only">Search</span>
                            </button>
                            <input style="cursor: pointer;background-color: var(--input-primary);border-radius: 5px;" class="w-full placeholder-search p-2.5 lg:p-0 search-mobile" type="search"
                                   readonly
                                   aria-label="Pesquisar jogos"
                                   @click="toggleSearch"
                                   placeholder="Pesquise um jogo de cassino...">
                           
                        </div>
                    </div>
               	</div>
            </div>
		</div>
    
              
              
<div v-if="loading">
      <!-- Aplicar o efeito shimmer enquanto os dados estão carregando -->
      <div v-if="loading" class="shimmer4 shimmer-estilos-banner2" v-for="n in 1" :key="n" >
       
      </div>
    </div>
    <div v-else>
               <!--<div  class="category-list item-sombra2 md:mb-4 mb-4  md:mt-[0] mt-[-10px]">
                    <div class="flex gap-0 md:gap-4" style="max-height: 200px; overflow-x: auto; overflow-y: hidden;margin-left: -10px;">
                        <div class="flex flex-row justify-between items-center w-full gap-0 " style="min-width: 100%; white-space: nowrap;">
 
         
                            <a href="/casino/provider/category"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                    <svg class="control-svgWidth" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><path d="M171.4 174.3C174.4 163.2 185.8 156.6 196.1 159.6L299.9 187.1C325.9 194.1 341.3 220.8 334.4 246.8C327.4 272.8 300.7 288.2 274.7 281.2L265.9 278.9C265.5 278.8 265.1 278.7 264.7 278.6L282.5 309.3L294.5 302.4C301.2 298.5 309.7 300.8 313.5 307.4C317.4 314.1 315.1 322.6 308.4 326.5L260.2 354.3C253.6 358.1 245.1 355.9 241.2 349.2C237.4 342.5 239.6 334 246.3 330.2L258.4 323.2L240.6 292.5C240.5 292.9 240.4 293.3 240.3 293.6L237.9 302.5C230.1 328.5 204.3 343.9 178.3 336.9C152.3 329.1 136.9 303.2 143.8 277.3L171.4 174.3zM220.7 7.468C247.3-7.906 281.4 1.218 296.8 27.85L463.8 317.1C479.1 343.8 470 377.8 443.4 393.2L250.5 504.5C223.9 519.9 189.9 510.8 174.5 484.2L7.468 194.9C-7.906 168.2 1.218 134.2 27.85 118.8L220.7 7.468zM244.7 49.04L51.85 160.4C48.18 162.5 46.92 167.2 49.04 170.9L216.1 460.2C218.2 463.8 222.9 465.1 226.5 462.1L419.4 351.6C423.1 349.5 424.3 344.8 422.2 341.1L255.2 51.85C253.1 48.18 248.4 46.92 244.7 49.04H244.7zM324.1 499L459.4 420.9C501.3 396.7 515.7 343.1 491.5 301.1L354.7 64.25C356.5 64.08 358.2 63.1 360 63.1H584C614.9 63.1 640 89.07 640 119.1V456C640 486.9 614.9 512 584 512H360C346.4 512 333.8 507.1 324.1 498.1L324.1 499zM579.8 135.7C565.8 123.9 545.3 126.2 532.9 138.9L528.1 144.2L523.1 138.9C510.6 126.2 489.9 123.9 476.4 135.7C460.7 149.2 459.9 173.1 473.9 187.6L522.4 237.6C525.4 240.8 530.6 240.8 533.9 237.6L582 187.6C596 173.1 595.3 149.2 579.8 135.7H579.8z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Cassino</p>
                                 
                             </a>

                             
                             <a href="/games/play/1195/mines"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                    <svg class="control-svgWidth" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" lined="true"><path d="M425.68 179.527L332.646 86.496C324.219 78.068 310.555 78.068 302.127 86.496L279.547 109.076C257.207 100.879 233.182 96.176 208 96.176C93.125 96.176 0 189.301 0 304.176S93.125 512.176 208 512.176S416 419.051 416 304.176C416 278.994 411.297 254.967 403.1 232.627L425.68 210.049C434.107 201.621 434.107 187.957 425.68 179.527ZM208 192.176C146.25 192.176 96 242.426 96 304.176C96 313.019 88.844 320.176 80 320.176S64 313.019 64 304.176C64 224.769 128.594 160.176 208 160.176C216.844 160.176 224 167.332 224 176.176S216.844 192.176 208 192.176Z" fill="var(--ci-primary-color)"></path><path d="M380.823 108.576L368 121.399L390.602 144L403.425 131.177C409.669 124.934 409.669 114.82 403.425 108.576S387.067 102.333 380.823 108.576ZM509.056 59.169L469.381 42.625L452.837 2.954C452.025 1.321 449.894 0 448.074 0C446.252 0 444.119 1.321 443.307 2.954L426.763 42.625L387.09 59.169C385.469 59.98 384.148 62.113 384.148 63.933C384.148 65.744 385.469 67.888 387.09 68.7L426.763 85.243L443.307 124.913C444.119 126.546 446.252 127.868 448.074 127.868C449.894 127.868 452.025 126.546 452.837 124.913L469.381 85.243L509.056 68.7C510.679 67.888 512 65.744 512 63.933C512 62.113 510.679 59.98 509.056 59.169Z" fill="var(--ci-primary-color)" opacity="0.4"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Mines</p>
                                 
                             </a>
                             <a href="/games/play/1/126"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;margin-top: 13px">
                                    <svg class="control-svgWidth" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" lined="true"><path d="M256 256C176.625 256 64 378.75 64 456.25C64 491.125 90.75 512 135.75 512C184.625 512 216.875 486.875 256 486.875C295.5 486.875 327.875 512 376.25 512C421.25 512 448 491.125 448 456.25C448 378.75 335.375 256 256 256Z" fill="var(--ci-primary-color)"></path><path d="M193.5 222.625C224.375 214.5 239.875 172.625 228 129.25C221.5 105.375 208 86.25 192 75V0L128 80C113 97.75 107.5 127.75 116 158.75C127.875 202.125 162.5 230.75 193.5 222.625ZM318.5 222.625C349.5 230.75 384.125 202.125 396 158.75C404.5 127.75 399 97.75 384 80L320 0V75C304 86.25 290.5 105.375 284 129.25C272.125 172.625 287.625 214.5 318.5 222.625ZM108.75 243.375C101.5 219.375 83.875 201.5 64 194.875V128L18.5 190.375C6.5 206.875 0 226.75 0 247.125C0 254.001 1.125 261.25 3.25 268.625C13.625 303.25 45.75 325.75 74.875 318.75S119.125 278.001 108.75 243.375ZM493.5 190.375L448 128V195C428.125 201.5 410.5 219.375 403.25 243.375C392.875 278.001 408 311.75 437.125 318.75S498.375 303.25 508.75 268.625C510.875 261.375 512 254.125 512 247.125C512 226.75 505.5 206.875 493.5 190.375Z" fill="var(--ci-primary-color)" opacity="0.4"></path></svg>
                                 </div>
                                 <p class="titleCategories flex flex-col" style="line-height: 15px;padding-top: 5px;">Fortune <p style="font-weight: 550;font-size: 11px;">Tiger</p></p>
                                 
                             </a>

                             <a href="/games/play/397/aviator"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;margin-top: 13px">
                                    <svg class="control-svgWidth" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 .0003C304.1 .0003 336 73.89 336 111.8V153.8L496 253.6C506 259.6 512 269.6 512 281.6V346.5C512 356.5 508 366.5 500 372.5C492 378.4 480.1 380.4 471 377.4L336 334.5V359.5L388 398.4C396 404.4 400 413.4 400 423.4V480.3C400 489.3 396 499.3 388 505.3C380 511.3 370 513.2 360 510.3L256 480.3L152 511.3C143 513.2 133 511.3 125 505.3C117 499.3 112 489.3 112 480.3V423.4C112 413.4 117 404.4 125 398.4L176 359.5V334.5L41 377.4C32 380.4 21 378.4 13 372.5C5 366.5 0 356.5 0 346.5V281.6C0 270.6 7 258.6 16 254.6L176 154.8V112.8C176 73.89 208 0 256 0V.0003zM256 48.93C246 50.93 224 86.87 224 112.8V180.7L48 290.6V324.5L224 269.6V383.4L160 431.4V458.3L256 430.4L352 458.3V431.4L288 383.4V269.6L464 324.5V290.6L288 180.7V112.8C288 85.87 267 49.93 256 48.93V48.93z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Aviator <br>Crash</p>
                             </a>
                     <a href="/games/play/1112/PorROU0000000001"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                    <svg class="control-svgWidth" viewBox="0 0 95 95" xmlns="http://www.w3.org/2000/svg" lined="true"><path d="M59.4,10.9c-3.7-1.2-7.7-1.9-11.9-1.9v11.9c2.9,0,5.6.5,8.2,1.3l3.7-11.3ZM69,31.9l9.6-7c-2.4-3.3-5.2-6.1-8.5-8.5l-7,9.6c2.3,1.6,4.3,3.6,5.9,5.9ZM69,63.1l9.6,7c2.4-3.2,4.2-6.8,5.5-10.7l-11.3-3.7c-.8,2.7-2.1,5.2-3.8,7.4ZM35.6,84.1c3.8,1.2,7.8,1.9,11.9,1.9v-11.9c-2.9,0-5.6-.5-8.2-1.3l-3.7,11.3ZM26,63.1l-9.6,7c2.4,3.3,5.2,6.1,8.5,8.5l7-9.6c-2.3-1.6-4.3-3.6-5.9-5.9ZM20.9,47.5h-11.9c0,4.2.7,8.2,1.9,11.9l11.3-3.7c-.9-2.6-1.3-5.3-1.3-8.2ZM26,31.9l-9.6-7c-2.4,3.2-4.2,6.8-5.5,10.7l11.3,3.7c.9-2.7,2.1-5.2,3.8-7.4ZM39.3,22.2l-3.7-11.3c-3.9,1.3-7.5,3.1-10.7,5.5l7,9.6c2.2-1.7,4.7-2.9,7.4-3.8ZM74.1,47.5h11.9c0-4.2-.7-8.2-1.9-11.9l-11.3,3.7c.9,2.6,1.3,5.3,1.3,8.2ZM55.7,72.8l3.7,11.3c3.9-1.3,7.5-3.1,10.7-5.5l-7-9.6c-2.2,1.7-4.7,2.9-7.4,3.8Z" fill="var(--ci-primary-color)" opacity="0.7"></path><path d="M47.5,0C21.3,0,0,21.3,0,47.5s21.3,47.5,47.5,47.5,47.5-21.3,47.5-47.5S73.7,0,47.5,0ZM47.5,88.7c-22.7,0-41.2-18.5-41.2-41.2S24.8,6.3,47.5,6.3s41.2,18.5,41.2,41.2-18.5,41.2-41.2,41.2ZM23.6,47.5c0,13.2,10.7,23.9,23.9,23.9s23.9-10.7,23.9-23.9-10.7-23.9-23.9-23.9-23.9,10.7-23.9,23.9ZM34,44.6c.6,0,1.1.2,1.5.4,1.4.9,3.1,1.1,4.8,1.1h1.6c.5-2.1,2.1-3.7,4.2-4.2v-1.6c0-1.7-.3-3.4-1.1-4.8-.3-.4-.4-1-.4-1.5,0-1.6,1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9-.2,1.1-.4,1.5c-.9,1.4-1.1,3.1-1.1,4.8v1.6c2.1.5,3.7,2.1,4.2,4.2h1.6c1.7,0,3.4-.3,4.8-1.1.4-.3,1-.4,1.5-.4,1.6,0,2.9,1.3,2.9,2.9s-1.3,2.9-2.9,2.9-1.1-.2-1.5-.4c-1.4-.9-3.1-1.1-4.8-1.1h-1.6c-.5,2.1-2.1,3.7-4.2,4.2v1.6c0,1.7.3,3.4,1.1,4.8.3.4.4,1,.4,1.5,0,1.6-1.3,2.9-2.9,2.9s-2.9-1.3-2.9-2.9.2-1.1.4-1.5c.9-1.4,1.1-3.1,1.1-4.8v-1.6c-2.1-.5-3.7-2.1-4.2-4.2h-1.6c-1.7,0-3.4.3-4.8,1.1-.4.3-1,.4-1.5.4-1.6,0-2.9-1.3-2.9-2.9s1.3-2.9,2.9-2.9Z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Roleta</p>
                                 
                             </a>
                             <a href="/games/play/811/spacemanyxe123nh"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                    <svg class="control-svgWidth" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M408 143.1C408 166.1 390.1 183.1 368 183.1C345.9 183.1 328 166.1 328 143.1C328 121.9 345.9 103.1 368 103.1C390.1 103.1 408 121.9 408 143.1zM384 312.1V394.2C384 419.7 370.6 443.2 348.7 456.2L260.2 508.6C252.8 513 243.6 513.1 236.1 508.9C228.6 504.6 224 496.6 224 488V373.3C224 350.6 215 328.1 199 312.1C183 296.1 161.4 288 138.7 288H24C15.38 288 7.414 283.4 3.146 275.9C-1.123 268.4-1.042 259.2 3.357 251.8L55.83 163.3C68.79 141.4 92.33 127.1 117.8 127.1H199.9C281.7-3.798 408.8-8.546 483.9 5.272C495.6 7.411 504.6 16.45 506.7 28.07C520.5 103.2 515.8 230.3 384 312.1V312.1zM197.9 253.9C210.8 260.2 222.6 268.7 232.1 279C243.3 289.4 251.8 301.2 258.1 314.1C363.9 284.1 414.8 234.5 439.7 188C464.7 141.3 466.1 90.47 461.7 50.33C421.5 45.02 370.7 47.34 323.1 72.33C277.5 97.16 227.9 148.1 197.9 253.9H197.9zM41.98 345.5C76.37 311.1 132.1 311.1 166.5 345.5C200.9 379.9 200.9 435.6 166.5 470C117 519.5 .4765 511.5 .4765 511.5C.4765 511.5-7.516 394.1 41.98 345.5V345.5zM64.58 447.4C64.58 447.4 103.3 450.1 119.8 433.6C131.2 422.2 131.2 403.6 119.8 392.2C108.3 380.8 89.81 380.8 78.38 392.2C61.92 408.7 64.58 447.4 64.58 447.4z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Spaceman</p>
                                 
                             </a>

                             <a href="/games/play/427/12492"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                    <svg class="control-svgWidth" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M175 141.2C184.4 131.8 199.6 131.8 208.1 141.2L291.3 223.5C313.2 245.4 313.2 280.8 291.3 302.7C269.5 324.6 234 324.6 212.1 302.7L208.1 299.5C208.7 299.2 208.3 298.9 207.1 298.6V335.1H223.1C232.8 335.1 239.1 343.2 239.1 351.1C239.1 360.8 232.8 367.1 223.1 367.1H159.1C151.2 367.1 143.1 360.8 143.1 351.1C143.1 343.2 151.2 335.1 159.1 335.1H175.1V298.6C175.7 298.9 175.3 299.2 175 299.5L171.9 302.7C149.1 324.6 114.5 324.6 92.67 302.7C70.8 280.8 70.8 245.4 92.67 223.5L175 141.2zM0 64C0 28.65 28.65 0 64 0H320C355.3 0 384 28.65 384 64V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM48 64V448C48 456.8 55.16 464 64 464H320C328.8 464 336 456.8 336 448V64C336 55.16 328.8 48 320 48H64C55.16 48 48 55.16 48 64z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Blackjack</p>
                                 
                             </a>

                            <a href="/casino/provider/18/category/all"

                                   class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                       <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;margin-top: 13px">
                                          <svg class="control-svgWidth" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><path d="M575.1 192h-102.2c3.551 10.11 5.748 20.73 5.748 31.77c0 25.64-9.984 49.75-28.12 67.89L320 423.2v24.84C320 483.3 348.7 512 383.1 512h191.1c35.35 0 63.1-28.65 63.1-63.1v-191.1C639.1 220.7 611.3 192 575.1 192zM479.1 376c-13.25 0-23.1-10.75-23.1-23.1c0-13.26 10.75-23.1 23.1-23.1s23.1 10.74 23.1 23.1C503.1 365.3 493.3 376 479.1 376zM447.5 223.8c0-16.38-6.249-32.76-18.75-45.26L269 18.73C256.5 6.238 240.3 0 223.1 0S191 6.238 178.5 18.73l-159.8 159.8C6.235 191-.0011 207.6-.0011 223.1s6.236 32.57 18.73 45.06l159.8 159.8c12.5 12.5 28.88 18.74 45.26 18.74s32.76-6.248 45.25-18.74l159.8-159.8C441.3 256.5 447.5 240.1 447.5 223.8zM394.9 235.1l-159.8 159.8c-4.076 4.076-8.838 4.686-11.31 4.686c-2.477 0-7.238-.6094-11.31-4.686L52.67 235.1C48.59 231 47.99 226.2 47.99 223.8s.6074-7.236 4.686-11.31l159.8-159.8c4.082-4.08 8.844-4.689 11.32-4.689s7.234 .6094 11.31 4.687l159.8 159.8c4.078 4.078 4.687 8.84 4.687 11.31S398.9 231 394.9 235.1zM223.8 301.6c-12.79 0-23.1 10.29-23.1 23.1c0 13.76 11.25 23.1 23.1 23.1c13.73 0 24-11.22 24-23.1C247.8 312.8 237.5 301.6 223.8 301.6zM223.8 199.8c-13.76 0-23.1 11.25-23.1 23.1c0 12.84 10.34 23.1 23.1 23.1c13.71 0 24-11.21 24-23.1C247.8 210.1 237.5 199.8 223.8 199.8zM121.9 199.8c-13.76 0-24 11.25-24 23.1c0 12.79 10.29 23.1 24 23.1c13.71 0 23.1-11.2 23.1-23.1C145.9 210.1 135.7 199.8 121.9 199.8zM325.6 199.8c-13.76 0-24 11.25-24 23.1c0 12.79 10.29 23.1 24 23.1c13.71 0 24-11.21 24-23.1C349.6 210.1 339.3 199.8 325.6 199.8zM223.8 97.94c-12.79 0-23.1 10.29-23.1 23.1c0 13.76 11.25 23.1 23.1 23.1c13.73 0 24-11.22 24-23.1C247.8 109.1 237.5 97.94 223.8 97.94z" fill="var(--ci-primary-color)"></path></svg>
                                       </div>
                                       <p class="titleCategories flex flex-col" style="line-height: 15px;padding-top: 5px;">Cassino<p style="font-weight: 550;font-size: 11px;">Ao Vivo</p></p>

                                   </a>

                                   <a href="/games/play/6023/8357"

                                   class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center p-4">
                                       <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                          <svg class="control-svgWidth" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><path d="M639.1 357.2c0-6.198-.4631-12.49-1.421-18.83l-27.5-181.3C603.5 107.4 581.8 32 319.1 32C57.05 32 36.44 106.9 28.83 157.1l-27.37 181.3C.4734 344.8 0 351.1 0 357.4C0 423.9 53.35 480 121.2 480c46.12-.125 88.37-26.5 108.6-68L243.6 384h152.7l13.75 28c20.25 41.5 62.25 67.88 108.4 68C586.5 480 639.1 423.8 639.1 357.2zM591.1 357.2c0 17.99-6.413 35.55-18.26 49.46c-13.66 16.14-33.73 25.38-54.82 25.38c-.1417 0-.2834-.0004-.4252-.0013c-27.75 0-52.75-15.75-65.25-41.13l-18.32-37.05C429.5 342.9 418.4 336 406.2 336H233.7c-12.17 0-23.29 6.907-28.69 17.82l-18.32 37.05c-4.671 9.482-23.54 41.13-65.92 41.13c-21.09 0-41.04-9.357-54.58-25.38c-11.85-13.91-18.26-31.47-18.26-49.46c0-3.839 .292-7.697 .8855-11.54l27.5-181.3C81.2 132.5 104.1 107.5 134.8 100.6C195.8 86.88 257.9 80 319.1 80s124.2 6.875 185.1 20.62c30.75 6.875 53.62 31.88 58.5 63.75l27.5 181.3C591.7 349.5 591.1 353.3 591.1 357.2zM399.1 240c-17.62 0-31.1 14.38-31.1 32s14.37 32 31.1 32s31.1-14.38 31.1-32S417.6 240 399.1 240zM247.1 200l-31.96-.011L215.1 168c0-13.2-10.78-24-23.98-24C178.8 144 167.1 154.8 167.1 168l.0367 31.99L135.1 200c-13.2 0-23.98 10.8-23.98 24c0 13.2 10.77 24 23.98 24l32.04-.0098L167.1 280c0 13.2 10.82 24 24.02 24c13.2 0 23.98-10.8 23.98-24l.0368-32.01L247.1 248c13.2 0 24.02-10.8 24.02-24C271.1 210.8 261.2 200 247.1 200zM463.1 144c-17.62 0-31.1 14.38-31.1 32s14.37 32 31.1 32c17.62 0 31.1-14.38 31.1-32S481.6 144 463.1 144z" fill="var(--ci-primary-color)"></path></svg>
                                       </div>
                                       <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">E-Sports</p>

                                   </a>

                             <a href="/games/play/6023/8357"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;margin-top: 13px">
                                     <svg class="control-svgWidth" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M448 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64V96C512 60.65 483.3 32 448 32zM254.1 80h67.88l-80 80H174.1L254.1 80zM48 126.1L94.06 80h67.88l-80 80H48V126.1zM464 416c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V208h416V416zM464 97.94L401.9 160h-67.88l80-80H448c8.822 0 16 7.178 16 16V97.94zM218.7 400c1.959 0 3.938-.5605 5.646-1.682l106.7-68.97C334.1 327.3 336 323.8 336 319.1s-1.896-7.34-5.021-9.354l-106.7-68.97C221.1 239.5 216.9 239.5 213.5 241.4C210.1 243.3 208 247 208 251v137.9c0 4.008 2.104 7.705 5.5 9.656C215.1 399.5 216.9 400 218.7 400z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories flex flex-col" style="line-height: 15px;padding-top: 5px;">Esportes<p style="font-weight: 550;font-size: 11px;">Ao Vivo</p></p>
                                 
                             </a>
                 
                             <a href="/games/play/400/12544"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;">
                                  <svg class="control-svgWidth" viewBox="0 0 296.6 330.5" xmlns="http://www.w3.org/2000/svg" lined="true"><path d="M141.2,133.8c-.2,9.8-9,18-18.8,17.5-9.7-.4-17.5-8.9-17.1-18.6.4-9.7,8.7-17.5,18.4-17.2,9.7.3,17.7,8.7,17.5,18.3ZM123.3,48.8c0-9.8-8-17.5-17.9-17.6-9.9,0-17.9,7.7-18,17.5,0,9.9,8.1,18,18.2,17.9,9.8,0,17.8-8.1,17.7-17.9ZM70,171.4c-10.1-.2-18.4,7.7-18.5,17.6-.1,9.5,7.9,17.8,17.2,17.9,10.5.1,18.5-7.3,18.7-17.3.2-9.9-7.5-17.9-17.4-18.2ZM77.3,125.3c0-9.7-8-17.7-17.8-17.8-9.7,0-17.9,7.9-18,17.6-.2,9.7,8.4,18.2,18.2,18.1,9.7,0,17.7-8.2,17.7-18ZM166.3,228.4c-10,0-17.9,7.7-18,17.5-.1,10,7.6,17.9,17.5,17.9,10.3,0,18.5-7.9,18.4-17.7-.1-9.8-8.1-17.7-17.9-17.8ZM265.2,189.3c.1-9.6-8-17.8-17.7-17.9-10.2,0-18.2,7.8-18.1,17.9,0,9.9,7.9,17.6,17.8,17.7,9.8,0,17.9-7.9,18-17.7ZM258.3,122.7c0-9.8-7.9-17.9-17.6-18-9.8-.2-18.3,8.2-18.2,18,0,9.6,8.2,17.7,18,17.8,9.7,0,17.9-8.1,17.9-17.7Z" fill="var(--ci-primary-color)" opacity="0.4"></path><path d="M296.5,148.2c1.8-68.1-42.7-127.4-107.9-143.6C156.1-3.5,124.3-1,94,13.1,53.4,31.8,27.4,63.5,14.7,106c-8.8-1.6-14.4,1.6-14.5,8.7-.3,19-.2,38,0,57,0,6.2,5.1,10,11.1,9.3,1.1-.1,2.2-.3,3.2-.4,17,54,52.7,88,107.3,102.7v13.6c-2.1,0-3.9,0-5.7,0-20.3,0-40.7.2-61,0-14.6-.2-19.5,2.8-18.8,18.9.5,10.7,4.2,14.8,14.9,14.8,63.5,0,127,0,190.5,0,15.9,0,18.4-2.5,18.4-18.6,0-11.1-3.9-14.9-15.1-14.9-21.7,0-43.3,0-65,0-1.8,0-3.5-.2-5.3-.3v-11.7c72.4-11.9,120-72.1,121.7-136.8ZM148.4,245.9c.1-9.9,8-17.5,18-17.5,9.8,0,17.8,7.9,17.9,17.8.1,9.8-8.1,17.8-18.4,17.7-9.9,0-17.6-8-17.5-17.9ZM247.2,207c-10,0-17.8-7.8-17.8-17.7,0-10.1,7.9-17.9,18.1-17.9,9.7,0,17.8,8.3,17.7,17.9-.1,9.8-8.2,17.7-18,17.7ZM240.7,104.7c9.8.2,17.6,8.3,17.6,18,0,9.7-8.2,17.8-17.9,17.7-9.7,0-17.9-8.1-18-17.8,0-9.9,8.4-18.2,18.2-18ZM141.2,133.8c-.2,9.8-9,18-18.8,17.5-9.7-.4-17.5-8.9-17.1-18.6.4-9.7,8.7-17.5,18.4-17.2,9.7.3,17.7,8.7,17.5,18.3ZM105.4,31.2c9.9,0,17.9,7.8,17.9,17.6,0,9.8-7.9,17.8-17.7,17.9-10.1,0-18.3-8-18.2-17.9,0-9.8,8-17.6,18-17.5ZM59.5,107.6c9.8,0,17.9,8.1,17.8,17.8,0,9.8-8.1,17.9-17.7,18-9.8,0-18.3-8.4-18.2-18.1.2-9.7,8.3-17.7,18-17.6ZM51.5,189c.1-9.9,8.4-17.8,18.5-17.6,9.8.2,17.5,8.3,17.4,18.2-.2,10-8.2,17.5-18.7,17.3-9.3-.1-17.3-8.4-17.2-17.9Z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories" style="line-height: 15px;padding-top: 5px;">Bingo</p>
                                 
                             </a>
      
                            <a href="/games/play/6023/8357"
                             
                             class="hover-target flex flex-col justify-center items-center min-w-[80px] text-center ">
                                 <div class="flex items-center justify-center p-4" style="background-color: var(--ci-primary-opacity-color);border-radius: 10%;width: 62px;height: 62px;margin-top: 13px">
                                     <svg class="control-svgWidth" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M448 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64V96C512 60.65 483.3 32 448 32zM254.1 80h67.88l-80 80H174.1L254.1 80zM48 126.1L94.06 80h67.88l-80 80H48V126.1zM464 416c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V208h416V416zM464 97.94L401.9 160h-67.88l80-80H448c8.822 0 16 7.178 16 16V97.94zM218.7 400c1.959 0 3.938-.5605 5.646-1.682l106.7-68.97C334.1 327.3 336 323.8 336 319.1s-1.896-7.34-5.021-9.354l-106.7-68.97C221.1 239.5 216.9 239.5 213.5 241.4C210.1 243.3 208 247 208 251v137.9c0 4.008 2.104 7.705 5.5 9.656C215.1 399.5 216.9 400 218.7 400z" fill="var(--ci-primary-color)"></path></svg>
                                 </div>
                                 <p class="titleCategories flex flex-col" style="line-height: 15px;padding-top: 5px;">Apostas<p style="font-weight: 550;font-size: 11px;">Ao Vivo</p></p>
                                 
                             </a>

                        </div>
                    </div>
                </div>-->
            </div>
            <div v-if="loading">
      <!-- Aplicar o efeito shimmer enquanto os dados estão carregando -->
      <div v-if="loading" class="shimmer4 shimmer-estilos-banner2" v-for="n in 1" :key="n" >
       
      </div>
    </div>
    <div v-else>
                <!--<div> <LastWinnersComponent></LastWinnersComponent></div>-->
</div>
              <div> <PayingALotComponent></PayingALotComponent></div>
                <div class="mt-4">
                    <h2 class="section-title">
                      🔥 Top Jogos no Brasil Hoje
                    </h2>
                    <Carousel v-bind="settingsRecommended" :breakpoints="breakpointsRecommended"
                        ref="carouselSubBanner">
                        <Slide v-for="(banner, index) in bannersHome" :key="index">
                            <div class="carousel__item  min-h-[60px] md:min-h-[105px] rounded-2xl w-full mr-4">
                                <a :href="banner.link" class="w-full h-full rounded-2xl">
                                    <img :src="`/storage/`+banner.image" alt="" class="h-full w-full rounded-2xl">
                                </a>
                            </div>
                        </Slide>

                        <template #addons>
                           
                        </template>
                    </Carousel>
                </div>
<a href="/sports">
  <div class="principais-ligas-section">
    <!-- Título da Seção -->
    <h2 class="section-title">
      🏆 Principais Ligas
    </h2>

    <!-- Container de Ligas com Scroll Horizontal -->
    <div class="ligas-scroll-container">
      <div class="ligas-wrapper">
        <!-- Brasileirão 2025 -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 32 34" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2256_1871">
          <rect width="32" height="34" fill="white"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2256_1871)">
          <path d="M16 5.84375L22.8281 18.3526C20.7513 20.9407 18.898 24.2438 19.08 27.7003C19.1351 28.7472 19.4688 29.8207 19.5664 30.8657C20.8196 30.6486 22.0885 29.9678 23.1447 29.2692C29.0598 25.3573 30.7672 17.2267 26.9108 11.2008L28.049 8.53417C34.7285 16.8483 31.0189 29.6234 21.0616 33.11C8.72456 37.4298 -2.85584 25.271 1.46693 12.895C1.84452 11.814 2.93924 9.52879 3.71588 8.73398C3.79589 8.65208 3.80467 8.59683 3.95005 8.63136L5.09062 11.1347C1.103 17.3555 3.00559 25.7303 9.26021 29.5405C9.67488 29.7931 12.0443 31.0546 12.3424 30.8247C13.8625 26.2276 12.0575 21.883 9.17093 18.3521L16 5.84375ZM20.4128 18.3328C20.4128 15.831 18.4082 13.8033 15.9358 13.8033C13.4635 13.8033 11.4589 15.8315 11.4589 18.3328C11.4589 20.8342 13.4635 22.8624 15.9358 22.8624C18.4082 22.8624 20.4128 20.8342 20.4128 18.3328Z" fill="var(--ci-primary-color)"></path>
          <path d="M27.565 0.829834C25.8912 4.2952 24.2082 7.77044 23.1066 11.482L22.0236 15.3578L15.9524 4.43779L9.83147 15.3598C8.9036 10.2496 6.71709 5.48963 4.43253 0.87917L7.13371 2.14464C13.742 4.7935 21.3621 4.32826 27.565 0.829834Z" fill="var(--ci-primary-color)"></path>
          <path d="M8.48016 18.0897C8.24648 18.1213 8.32746 18.0897 8.27917 17.955C7.98451 17.1336 7.80059 16.1587 7.52008 15.3091C5.75068 9.9522 3.05243 4.94557 0 0.245806L2.98754 0.00109863C5.43993 3.97611 7.37959 8.49382 8.62602 13.0194C8.80067 13.6539 9.4534 15.9742 9.32656 16.4572C9.21485 16.881 8.59919 17.6023 8.48016 18.0897Z" fill="var(--ci-primary-color)"></path>
          <path d="M32 0.245694C28.6632 5.28637 25.8634 10.7395 24.0711 16.5533C23.9306 17.0096 23.8491 17.4902 23.7125 17.9475C23.6716 18.0851 23.773 18.1202 23.5198 18.0896C23.4037 17.5869 22.7656 16.908 22.6725 16.459C22.5271 15.7555 23.3418 13.0992 23.5886 12.262C24.8482 7.989 26.642 3.75448 29.011 0L31.9995 0.245694H32Z" fill="var(--ci-primary-color)"></path>
          <path d="M23.4213 18.9683C22.7603 22.0824 22.3612 25.2779 22.83 28.4536C22.711 28.9174 20.6167 29.8035 20.1459 30.0847C19.1249 26.4407 20.4133 22.5811 22.6534 19.7019L23.4213 18.9683Z" fill="var(--ci-primary-color)"></path>
          <path d="M11.8546 30.0852C10.9462 29.5997 9.86417 29.2608 9.17241 28.4541C9.62952 25.2719 9.22412 22.0873 8.57968 18.9683C9.84953 20.0719 10.7106 21.5989 11.3243 23.1628C12.2258 25.4589 12.4697 27.6642 11.8546 30.0852Z" fill="var(--ci-primary-color)"></path>
          <path d="M16.9506 19.8321C16.5559 19.7961 15.1002 19.9698 14.8884 19.7512C14.8065 19.6669 14.3377 18.1088 14.3757 17.9658L15.8988 16.7629L17.5345 17.9593L16.9506 19.8321Z" fill="var(--ci-primary-color)"></path>
          <path d="M16.3047 15.2779L17.4935 14.7135C17.8887 14.8521 18.9039 15.5142 18.9727 15.9198C19.001 16.086 18.8424 16.9968 18.7444 17.1132C18.6346 17.244 17.9794 17.4324 17.8082 17.39C17.7238 17.3693 16.4418 16.4506 16.3857 16.383C16.193 16.1502 16.3052 15.5912 16.3042 15.2779H16.3047Z" fill="var(--ci-primary-color)"></path>
          <path d="M15.4978 15.2819L15.5163 16.1867C15.4763 16.3944 14.2074 17.3525 14.0011 17.393C13.6893 17.4546 13.3454 17.1557 13.0254 17.1009L12.9356 15.8177C13.6825 14.8546 14.4411 14.4397 15.4978 15.2814V15.2819Z" fill="var(--ci-primary-color)"></path>
          <path d="M12.881 17.9189C12.9747 17.9095 13.6684 18.1217 13.7362 18.1868C13.823 18.2711 14.3021 19.7616 14.3157 19.9343C14.3318 20.1336 13.8942 20.7636 13.7157 20.805C13.5371 20.8465 12.8278 20.6743 12.6717 20.5312C12.4117 20.2929 11.9614 19.0028 12.0658 18.6481C12.1136 18.4858 12.7063 17.9366 12.881 17.9189Z" fill="var(--ci-primary-color)"></path>
          <path d="M19.1537 20.5974C18.9497 20.7612 18.3668 20.7621 18.0892 20.811C17.9906 20.7794 17.554 20.1075 17.5423 19.9876C17.5291 19.8494 18.0233 18.3383 18.1146 18.2312C18.2068 18.1232 18.8166 17.8937 18.9439 17.9002C19.0815 17.9071 19.8093 18.619 19.8318 18.7354C19.8815 18.9939 19.3654 20.4267 19.1532 20.5974H19.1537Z" fill="var(--ci-primary-color)"></path>
          <path d="M15.0036 20.4469C15.227 20.3699 16.7266 20.403 16.9223 20.5214C17.4628 20.85 17.5135 21.6098 17.0657 22.0454C16.7383 22.3636 15.1943 22.371 14.8475 22.1332C14.7748 22.0834 14.3845 21.3123 14.3889 21.2585L15.0041 20.4469H15.0036Z" fill="var(--ci-primary-color)"></path>
          <path d="M16.8666 14.4831L15.9515 14.9626L14.9402 14.5783C14.9889 14.4031 15.4178 14.3888 15.5622 14.3809C16.0017 14.3563 16.4383 14.3859 16.8666 14.4831Z" fill="var(--ci-primary-color)"></path>
          <path d="M19.8552 17.9923C19.6859 18.0328 19.2127 17.3939 19.2039 17.3485C19.1795 17.2242 19.2878 16.6514 19.4224 16.5305L19.8552 17.9923Z" fill="var(--footer-color-dark-gradient)"></path>
          <path d="M12.0492 17.9928C12.0273 17.7161 12.0961 17.4526 12.1712 17.1911C12.2205 17.0199 12.3736 16.6292 12.5293 16.531C12.6844 17.2301 12.7034 17.5986 12.0492 17.9933V17.9928Z" fill="var(--ci-primary-color)"></path>
          <path d="M13.9508 21.3339C13.9811 21.3591 14.2382 21.8174 14.1211 21.8934L13.3015 21.212C13.4645 21.2184 13.8367 21.2387 13.9513 21.3339H13.9508Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Brasileirão 2025</p>
        </div>

        <!-- Brasileirão Série B -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 42 45" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2605_1739">
          <rect width="42" height="45" fill="white" transform="translate(0.0090332)"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2605_1739)">
          <path d="M34.47 0L32.0965 6.29658C37.4723 9.82525 41.5391 15.8543 41.9577 22.3596C43.4139 45.0474 13.4232 53.6035 2.67333 34.3324C-2.75034 24.6077 0.402955 12.7943 9.46343 6.58495L7.08985 0H34.47ZM31.1791 2.08116H10.8299C11.1777 3.25548 11.707 4.35961 12.0663 5.53394C14.2775 12.7753 13.9182 21.4414 12.9034 28.8839C12.6205 30.9555 12.1313 32.9968 11.879 35.0723L21.079 7.875L30.0554 35.0742C30.2733 35.0704 29.4611 31.297 29.4075 30.9612C28.1615 23.0805 27.55 13.7068 29.7917 5.97976C30.1777 4.65177 30.7491 3.39018 31.1772 2.08116H31.1791ZM11.8771 8.4707C1.75218 13.7599 -0.825875 27.4269 6.71337 36.1138C14.7151 45.3339 30.1185 44.4745 36.7767 34.1674C42.0838 25.9528 39.9071 15.1543 31.9741 9.53878C31.7333 9.36804 30.2656 8.3398 30.1319 8.4707L29.5451 11.5706C38.9458 16.8446 39.0796 31.0352 30.1319 36.8556L21.0064 10.4039L11.8045 36.8556C2.9275 30.7146 3.17021 17.2355 12.3358 11.4871L11.8771 8.4707Z" fill="var(--ci-primary-color)"></path>
          <path d="M20.3717 26.9411C26.9306 26.2544 28.5894 35.8444 22.2063 37.3811C14.8945 39.1397 12.9796 27.7152 20.3717 26.9411ZM22.2006 27.6431C21.6101 27.4629 20.9431 27.442 20.3297 27.4913C20.1557 27.5065 19.6589 27.5368 19.6589 27.7873L20.9297 28.2236L22.2006 27.6412V27.6431ZM20.5303 28.5575C20.0812 28.474 19.5346 27.9675 19.1218 27.9409C18.646 27.9106 17.3369 28.8686 17.2604 29.36C17.228 29.563 17.3923 30.6273 17.486 30.7658C17.5796 30.9043 18.4511 31.1755 18.625 31.1376C18.7301 31.1148 20.3354 30.0278 20.4042 29.9462C20.6794 29.6199 20.5533 28.9825 20.5303 28.5594V28.5575ZM21.3349 29.8419C21.398 29.9481 23.2632 31.1509 23.4122 31.1376C24.3793 31.0617 24.7615 30.2649 24.5952 29.3562C24.5035 28.861 23.2899 27.9049 22.7357 27.939C22.4949 27.9542 21.4782 28.4702 21.3769 28.6789C21.2756 28.8876 21.2298 29.6597 21.3349 29.84V29.8419ZM16.2189 31.9515C16.798 31.4924 17.3312 30.6956 16.7406 30.0202C16.4654 30.6216 16.1769 31.2723 16.2189 31.9515ZM25.6406 31.9515C25.6769 31.5303 25.5679 31.13 25.4495 30.7316C25.394 30.5495 25.266 30.0486 25.0462 30.0221L24.922 31.1035L25.6406 31.9515ZM22.1815 34.0118L22.9287 31.8471L20.9316 30.3123L18.9785 31.6498L19.6818 34.0118H22.1834H22.1815ZM17.0024 34.8863C17.1477 35.0229 18.1625 35.1994 18.3211 35.1387C18.4931 35.0742 19.0416 34.3134 19.0492 34.1104C19.055 33.9909 18.4606 32.2114 18.3803 32.1051C17.807 31.3482 16.775 31.758 16.3565 32.4637C16.1004 32.8962 16.6776 34.5809 17.0005 34.8863H17.0024ZM24.8532 34.8806C25.2297 34.579 25.7724 32.9247 25.503 32.4637C25.0883 31.758 24.0525 31.3482 23.4791 32.1051C23.3989 32.2114 22.8045 33.9909 22.8102 34.1104C22.8523 35.0362 24.1423 35.4498 24.8532 34.8806ZM22.3134 36.6696C22.3917 36.5938 22.7854 35.7249 22.7682 35.6186C22.5274 34.2053 19.3302 34.2053 19.0894 35.6186C19.0722 35.7192 19.4219 36.5065 19.4983 36.6013C19.7984 36.9732 21.998 36.9713 22.3115 36.6677L22.3134 36.6696Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Brasileirão Série B</p>
        </div>

        <!-- Premier League -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 35 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2256_1961">
          <rect width="33.1707" height="40" fill="white" transform="translate(0.914612)"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2256_1961)">
          <path d="M23.4366 8.63331C23.341 8.00187 23.2502 7.37452 22.9505 6.79518C24.9208 7.22074 26.7523 8.03201 28.2705 9.29796C28.4272 10.4648 28.835 11.5678 29.3772 12.6187C27.9384 11.298 26.2943 10.1838 24.4892 9.34956C24.3499 9.93502 24.3132 10.5746 23.9502 11.0845C22.89 10.3504 21.7747 9.59069 20.5762 9.06603C20.1419 8.87598 19.5834 9.02618 19.1136 9.11762C17.8238 9.36897 16.5966 9.87985 15.4894 10.543L14.7376 11.1116L15.4954 11.7757C14.5756 12.1359 13.7211 12.587 13.0643 13.3068C13.0195 13.3564 12.7522 13.6527 12.7959 13.691L14.3077 13.8958C14.3428 15.5485 16.0927 16.7945 17.7357 16.9115C19.6045 17.0449 21.6067 16.5958 23.3815 17.3182C23.4744 17.2329 22.6405 16.3526 22.5389 16.251C22.1592 15.8714 20.85 14.678 20.4001 14.5447C19.7212 14.3434 18.7825 14.5109 18.0593 14.4598C17.2053 14.3991 16.5264 13.951 15.766 13.6399C15.7481 13.5403 15.8367 13.4948 15.9026 13.4376C16.3779 13.0233 17.8286 12.2651 18.4589 12.238C18.7149 12.2268 19.4608 12.5155 19.7282 12.6263C20.2591 12.846 20.8003 13.1438 21.2562 13.4836C21.746 13.106 22.2284 12.7515 22.8954 12.7218C22.4131 13.1949 22.0766 13.7937 22.3969 14.4445C23.2697 15.2052 24.0809 16.0231 24.8387 16.887C26.1004 16.4007 27.8195 16.1789 29.1066 16.6811C29.3005 16.7567 29.4112 16.9805 29.5916 16.7322C29.3238 16.4931 29.0802 16.2275 28.8106 15.9899C28.3451 15.5797 27.401 15.0157 27.0531 14.6238C26.8673 14.4149 26.6702 13.9597 26.4822 13.6966C26.3737 13.5449 25.9616 13.1392 25.9205 13.0529C25.9076 13.0258 25.9103 12.966 25.947 12.9773C26.2808 13.1362 26.6329 13.2644 26.943 13.4657C27.0526 13.5372 27.4739 13.9372 27.5398 13.8964C27.5787 13.5771 28.5076 13.0319 28.7572 13.177C28.9403 13.2833 29.3416 14.0711 29.3281 14.2805C29.3092 14.5687 28.789 14.7378 28.7847 14.7904L30.2155 16.2975C30.3419 16.3189 30.2857 16.2438 30.2943 16.1692C30.3176 15.9582 30.3257 15.7171 30.3564 15.5117C30.3651 15.455 30.3759 15.2732 30.4574 15.2762C32.0551 17.5302 33.3519 19.9691 33.8439 22.6742C34.3554 25.4845 34.0221 28.2995 33.1585 31.0112L31.6473 29.5296C31.2049 33.6744 28.7961 37.3721 25.1347 39.6419L24.5168 37.3971C24.0609 37.6725 23.6191 37.9668 23.1492 38.2232C19.9091 39.9924 15.8551 40.5472 12.2693 39.4033C12.0111 39.3211 10.4059 38.7091 10.3859 38.5486C11.1788 35.4246 11.37 32.1208 10.366 29.0193C10.2417 28.9897 10.2774 29.0428 10.2434 29.0836C9.6784 29.7631 9.18421 30.5637 8.60575 31.2615C7.59197 32.4845 6.44802 33.6253 5.15392 34.5842C4.46204 33.5237 4.11691 32.1474 3.90141 30.9197C3.49903 28.6269 3.46392 26.1742 4.04778 23.9105L0.914612 24.8281C1.28243 21.7424 2.57868 18.6827 4.64082 16.2709C4.07964 16.1248 3.465 16.1401 2.89951 16.0267C2.82875 16.0124 2.73316 16.015 2.75854 15.9225C2.80067 15.7718 3.02751 15.4029 3.11933 15.2405C3.97486 13.7252 5.34782 12.1108 6.66514 10.9312C6.92925 10.6947 7.92629 9.81803 8.1796 9.70666C8.20769 9.6944 8.27142 9.69696 8.25954 9.7317C7.4753 11.3951 7.93872 13.6246 9.77184 14.4578C9.65464 14.1324 9.4575 13.8412 9.33814 13.5147C8.27736 10.6104 10.1386 8.31504 13.1745 10.2175C12.8694 9.22746 11.8847 8.41773 10.7986 8.2757C11.0146 8.11324 11.3603 7.96969 11.6266 7.85883C13.9501 6.89072 16.8689 6.2838 19.4155 6.38393C19.7358 6.3967 20.3585 6.42838 20.6518 6.49173C21.2864 6.62915 22.5837 7.82715 23.0607 8.30022C23.1228 8.36204 23.3415 8.70586 23.4371 8.63331H23.4366ZM26.9959 19.3162C26.1522 19.0971 25.4334 18.603 24.7166 18.1489C22.8171 18.5857 21.2016 19.5834 19.6515 20.6639L21.6542 24.3468C23.7752 24.2671 25.3453 22.8653 26.9516 21.7414L26.9964 19.3162H26.9959ZM30.0794 18.2894C30.0102 18.2413 29.1623 18.9489 29.017 19.046C28.8133 19.1819 28.5865 19.284 28.378 19.4123C28.3726 20.0984 28.2236 20.8565 28.2943 21.5365C28.3251 21.8328 28.7118 22.0469 28.9198 22.2732C29.388 22.784 29.8109 23.3424 30.108 23.9601C30.2301 23.9601 30.4202 23.5417 30.4682 23.4323C31.1742 21.82 30.8069 19.8378 30.0799 18.2889L30.0794 18.2894ZM26.8938 29.3754C28.0594 28.8405 29.1785 27.1061 29.3113 25.9126C29.3761 25.3287 28.7728 24.3126 28.3132 23.9197L26.566 23.932C25.3891 24.8373 24.0852 25.6991 22.5724 26.0041L23.7957 28.2044C24.8754 28.0088 25.8741 27.5234 26.6767 26.821C26.8771 27.6598 26.9186 28.5171 26.8938 29.3754Z" fill="var(--ci-primary-color)"></path>
          <path d="M22.0874 0C22.1851 0.0194133 22.1878 0.100642 22.1965 0.176763C22.2732 0.846009 22.2559 1.59393 22.3029 2.27288C22.3423 2.84251 22.4411 3.41163 22.4103 3.98483C22.5049 4.00322 22.5438 3.93885 22.5999 3.88367C23.1649 3.32989 23.6283 2.60036 24.2721 2.09357L25.1109 1.48256C24.4169 2.87878 24.1603 4.40323 23.9761 5.92666C19.2345 4.6413 14.077 5.28654 9.80207 7.56044C9.54444 7.03475 9.38133 6.47279 9.13342 5.94301C8.71267 5.04489 8.16446 4.19173 7.55792 3.39732C7.60005 3.32069 7.68809 3.41214 7.73778 3.43155C8.84446 3.87448 9.84906 4.68268 10.798 5.36419L10.1234 1.27719L14.4956 4.18764L16.0646 0.00102175L18.5491 3.77946L22.0874 0Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Premier League</p>
        </div>

        <!-- La Liga -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 36 34" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2256_1967">
          <rect width="36" height="34" fill="white"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2256_1967)">
          <path d="M36 0L17.2187 27.2H25.5892L12.5626 34H12.5103L9.38128 29.9258C8.1053 27.9746 8.26643 26.2719 9.46446 24.3456L26.2693 0H36Z" fill="var(--ci-primary-color)"></path>
          <path d="M18.8926 0L7.59239 16.4156H14.8643L3.48875 22.3157C2.72337 21.2112 1.76861 20.1917 1.01003 19.0883C-0.139871 17.4154 -0.363259 15.836 0.624985 13.9889L10.1035 0H18.8926Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">La Liga</p>
        </div>

        <!-- Bundesliga -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2256_1987">
          <rect width="39.6774" height="30" fill="white" transform="translate(0.161255)"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2256_1987)">
          <path d="M36.8387 0C38.4955 0 39.8387 1.34315 39.8387 3V27C39.8387 28.6569 38.4955 30 36.8387 30H3.16126C1.50441 30 0.161255 28.6569 0.161255 27V3C0.161255 1.34315 1.5044 0 3.16125 0H36.8387ZM13.7329 11.3898C13.7331 11.3899 13.7334 11.3898 13.7335 11.3895C13.8719 10.0742 14.4629 8.83714 15.0003 7.62557C15.0967 7.40827 15.2278 7.17262 15.4654 7.16507C15.7712 7.15535 16.1593 7.31078 16.3636 7.17173C16.4531 7.11073 16.7611 6.34605 16.9367 6.14148C17.0006 6.06753 17.1214 6.03672 17.1899 5.93875C17.3348 5.73171 17.1847 5.14819 17.2186 4.8364C17.2846 4.227 17.7042 4.02428 17.1645 3.36435C15.8138 1.71056 13.2214 2.30414 13.2564 4.48469C13.2569 4.51551 13.2452 4.54623 13.2235 4.56802C13.1967 4.59474 13.1583 4.60603 13.1213 4.59831C11.4765 4.25541 9.76739 4.36088 8.10353 4.52831C7.95276 4.55727 7.97234 4.7828 7.85813 4.8364C7.74391 4.89001 7.59184 4.84195 7.46979 4.8629C7.12714 4.92205 6.59196 5.55734 6.34982 5.8186C5.92216 6.28092 5.52052 6.76825 5.12111 7.25643C4.59929 7.89422 3.87916 8.40385 3.25274 8.93925C3.22672 8.96148 3.19969 8.98303 3.17134 9.00364C2.9886 9.13673 2.42731 9.3185 2.36726 9.4251C2.33724 9.47748 2.33136 9.52123 2.36726 9.57299C2.58587 9.96959 2.84726 9.76972 2.5394 10.1018C2.40555 10.2463 2.40947 10.3657 2.78431 10.4085C3.37302 10.4757 4.30241 10.1189 4.62352 9.6383C4.7782 9.406 4.78538 9.09237 5.04645 8.90813L7.1867 7.18047C7.56292 6.87677 8.02536 6.69949 8.50818 6.67386L9.22658 6.72907C9.68023 6.76394 9.64434 7.05372 9.44345 7.46195C9.0042 8.35295 8.66678 10.1756 8.53885 11.1738C8.51147 11.3885 8.37276 12.4825 8.45015 12.7408C8.46105 12.7772 8.49949 12.7885 8.53727 12.7846C8.64114 12.7738 8.72817 12.8621 8.71883 12.9662C8.6093 14.1856 8.79919 15.459 9.06816 16.6511C9.1269 16.9129 9.40363 18.0954 9.5172 18.2396C9.62162 18.3721 9.8494 18.3338 9.88987 18.3893C9.95252 18.4756 10.0804 19.0492 10.1431 19.2199C10.4354 20.0166 9.94855 20.9299 9.24747 21.4081C8.91813 21.6327 8.60912 21.8852 8.32282 22.1147C7.84311 22.4998 6.83279 23.5837 6.26497 23.6576C5.5849 23.7464 5.31534 23.3619 4.81345 23.3637C4.67116 23.3637 4.28936 23.4864 4.21038 23.5837C4.12423 23.6897 4.19276 23.8376 4.13729 23.9565C4.0929 24.052 3.91538 24.0877 3.90233 24.1389C3.86904 24.272 3.93365 24.4026 3.86251 24.5819C3.81487 24.7027 3.23008 25.4021 3.09368 25.5746C3.0382 25.6442 2.90506 25.6578 2.87177 25.7594C2.82413 25.9036 2.92398 26.0355 2.90571 26.1784C2.88352 26.3516 2.69686 26.4434 2.70534 26.5802C2.71056 26.6615 2.79476 26.7398 2.80846 26.8322C2.85219 27.1415 2.73732 27.5458 3.25358 27.5433C3.53749 27.5421 3.81291 26.9536 4.00806 26.733C5.74806 24.7668 9.68428 24.2855 12.0156 23.0994C12.107 23.0378 12.0378 22.8961 12.0756 22.8369C12.105 22.7913 12.9071 22.4413 13.0716 22.3292C13.8189 21.8208 13.7556 21.2502 13.7328 20.4455L13.6056 18.4719C13.6012 18.4038 13.6398 18.3402 13.7023 18.3127C13.7671 18.2842 13.8059 18.217 13.7983 18.1466L13.5887 16.2025C13.583 16.1497 13.5626 16.0997 13.5296 16.0581L13.5138 16.038C13.4989 16.0193 13.4802 16.004 13.4589 15.9933C13.3077 15.9168 13.3567 15.6932 13.5261 15.6898C14.9926 15.6596 16.4611 15.7422 17.9329 15.7147C18.0204 15.7131 18.0984 15.6841 18.1327 15.6036C18.1453 15.574 18.1597 15.5429 18.1787 15.517C18.2468 15.4245 18.3874 15.4675 18.5021 15.4746C19.4799 15.5356 20.6182 15.4162 21.5517 15.5191C22.0268 15.5715 22.2402 15.8143 22.624 15.9794C23.7453 16.4613 25.4226 16.1803 26.6555 16.2481C26.9616 16.2647 27.7585 16.3442 28.0228 16.4298C28.4895 16.5808 28.1625 17.5057 28.6925 17.6141C28.8282 17.6419 29.4006 17.6832 29.4868 17.5987C29.5475 17.5396 29.5429 17.4053 29.6238 17.3818C29.7119 17.356 29.8731 17.4854 30.0089 17.4046C30.0761 17.3646 30.097 17.2013 30.1877 17.1311C30.2608 17.075 31.5198 16.5309 31.6184 16.5136C31.8168 16.4791 31.9271 16.6048 32.0831 16.4144C32.1196 16.3701 32.1294 16.2616 32.1438 16.2512C32.194 16.2154 32.367 16.3387 32.5034 16.2758C32.5393 16.2592 32.8643 15.8352 32.8656 15.7798C32.8661 15.7553 32.8644 15.7326 32.8607 15.7114C32.8068 15.4037 32.3585 15.428 32.0462 15.4203C30.2598 15.3758 28.5502 15.0754 26.8748 14.4698C26.0087 14.1568 24.3209 13.2744 23.5208 13.1647C23.3955 13.1475 23.3302 13.2448 23.2238 13.2491C23.0704 13.2553 21.9341 13.1284 21.7259 13.0957C21.352 13.0365 20.651 12.6983 20.1909 12.5812C19.8051 12.4829 19.4134 12.4085 19.02 12.3432C18.796 12.306 18.6818 12.1526 18.5104 12.0035C18.4789 11.9761 18.4357 11.9533 18.3745 11.9391L13.7331 11.3891C13.7327 11.389 13.7325 11.3896 13.7329 11.3898ZM37.6496 12.7223C37.6496 11.5719 36.6622 10.6396 35.4436 10.6396C34.2251 10.6396 33.2376 11.5719 33.2376 12.7223C33.2376 13.8727 34.2251 14.805 35.4436 14.805C36.6622 14.805 37.6496 13.8727 37.6496 12.7223Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Bundesliga</p>
        </div>

        <!-- 2. Bundesliga -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 44 36" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_3168_4131">
          <rect width="43.7073" height="35" fill="white" transform="translate(0 0.5)"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_3168_4131)">
          <path d="M43.6746 15.229V35.4641H0.117554V32.6027L30.6905 20.4073V22.0805C32.1622 21.3993 33.7637 21.0458 35.3839 21.0441C37.0912 21.0441 37.7468 21.5205 37.7468 22.7515C37.7468 23.8066 37.3558 24.2146 35.9268 24.6295L34.2093 25.1229C30.9449 26.0585 30.0776 27.4363 30.0776 29.8334V32.7922H40.791V30.1458H33.4973V29.5346C33.4973 28.599 33.6834 28.1227 35.1466 27.7146L36.8778 27.2212C40.1593 26.2856 40.9924 25.3005 40.9924 22.4937C40.9924 19.8029 39.338 18.3807 36.0941 18.2527L43.6712 15.2307L43.6746 15.229Z" fill="var(--ci-primary-color)"></path>
          <path d="M0.117554 0.617783V31.6807L43.6746 14.307V0.617783H0.117554ZM29.3997 16.2329L29.3229 16.2756L29.3485 16.3268C29.3656 16.3592 29.3349 16.4088 29.2819 16.4361L29.1658 16.4941C29.1129 16.5214 29.0566 16.5146 29.0395 16.4822L29.0156 16.4361L28.8705 16.5078L28.8944 16.5573C28.9097 16.5914 28.879 16.6392 28.8244 16.6649L28.7066 16.7195C28.6519 16.7434 28.5956 16.7366 28.5802 16.7024L28.5597 16.658C28.1073 16.8749 27.6037 17.1002 27.0829 17.341L27.1119 17.4075C27.129 17.44 27.0966 17.4878 27.0436 17.5134L26.9258 17.568C26.8712 17.5919 26.8149 17.5834 26.7995 17.551L26.7688 17.4844L26.598 17.5663L26.6288 17.6329C26.6441 17.6671 26.6134 17.7149 26.5588 17.7405L26.441 17.7951C26.3863 17.8207 26.33 17.8139 26.3146 17.7797L26.2839 17.7149C26.0466 17.8088 25.7888 17.848 25.601 17.498C25.5224 17.3341 25.5173 16.9619 25.4558 16.7622C25.4302 16.6973 25.3722 16.6512 25.3039 16.641C23.0127 16.2005 22.2358 16.6905 20.7676 16.3268C20.3049 16.2124 20.0539 15.7822 19.4854 15.7822C18.2493 15.7463 17.8788 15.7634 16.5334 15.7122C16.4685 15.9068 16.4685 15.9495 16.4685 15.9495L11.7393 15.9273L12.4632 16.2824L12.7073 18.3636C12.7073 18.3636 12.5161 18.4251 12.4597 18.4251C12.5058 18.8434 12.5502 19.3983 12.5724 19.9105C12.5929 20.3646 12.6117 20.8392 12.6117 21.1414C12.6134 21.3378 12.569 21.5307 12.4785 21.7049C12.388 21.8568 12.2685 21.9866 12.1251 22.089C12.0824 22.1214 11.9049 22.241 11.688 22.369C11.4712 22.497 11.2237 22.6268 11.0956 22.6883C11.1144 22.7463 11.1366 22.8027 11.1622 22.859C8.28536 24.2471 4.72048 24.7217 3.56633 26.931C3.43146 27.187 2.96365 27.0539 2.94999 26.779V26.3334H2.90902C2.87146 26.3317 2.84585 26.2822 2.84585 26.2224V26.0927C2.84755 26.0329 2.87999 25.9885 2.91755 25.9885H2.96707C2.98243 25.8605 3.00633 25.7341 3.04048 25.6095L2.99609 25.5941C2.96877 25.5822 2.94999 25.5258 2.96877 25.4695L3.01146 25.3483C3.03194 25.2902 3.07463 25.2561 3.11219 25.268L3.15487 25.2834C3.35975 24.8036 3.75585 24.5902 3.94024 24.1395L3.91121 24.1292C3.87536 24.1156 3.86341 24.061 3.8839 24.0046L3.92658 23.8817C3.94707 23.8253 3.99146 23.7912 4.02731 23.8031L4.05804 23.8134C4.08536 23.7485 4.1178 23.6751 4.15365 23.6034L4.11609 23.5778C4.08365 23.5573 4.08365 23.4992 4.11609 23.4497L4.18609 23.3405C4.21682 23.2875 4.26804 23.2671 4.30048 23.2875L4.31755 23.2961H4.33463C4.34316 23.2961 4.34829 23.2858 4.35853 23.2858C4.3756 23.2653 4.39438 23.2466 4.41487 23.2295C4.59755 23.098 4.8417 23.098 5.02438 23.2295C5.20536 23.3388 5.90877 23.74 6.5917 23.1288C7.70829 22.1231 9.01951 20.7556 10.0063 20.7078C9.73316 20.1324 9.2739 18.9236 9.22097 18.478L8.88975 18.4063C8.71731 18.0358 8.29731 16.3217 8.17951 15.0327C8.17951 15.0327 8.04463 13.6429 8.17951 13.1546C8.09585 13.1478 7.96268 13.2622 7.92511 13.2622C7.74414 12.82 8.33146 9.07925 8.91024 7.98998L9.79975 7.63486C9.70755 7.63486 9.0656 7.60242 7.37365 7.46412C6.42951 8.29217 5.34024 9.19364 4.78707 9.68364C4.69487 9.75193 4.53609 10.288 4.53609 10.288C4.53609 10.288 4.25438 10.5339 3.99658 10.7149C3.65512 10.9556 2.8117 11.14 2.63073 10.8566C2.58292 10.7866 2.59146 10.7558 2.63073 10.7149C2.76219 10.5749 3.24536 10.341 3.41609 10.0319C3.14804 10.1651 2.84926 10.3102 2.61707 10.2846C2.51633 10.2795 2.46341 10.0302 2.59487 9.98413C2.95853 9.83047 3.23853 9.76559 3.44853 9.47193C3.61072 9.19534 3.89926 9.01608 4.21853 8.99217C4.21853 8.99217 5.79097 6.93827 6.71804 5.96339C6.97585 5.70388 7.45048 5.79266 7.45048 5.79266L7.53073 5.47681C7.53073 5.47681 10.708 5.09778 12.1866 5.58778C12.1524 4.69315 12.5554 3.49803 13.9605 3.49803C14.6827 3.49803 15.7463 4.13656 15.888 4.91168C15.929 5.15071 15.7907 5.30778 15.7173 5.60998C15.5961 6.06754 15.7702 6.57291 15.7173 6.73339C15.6746 6.85973 15.5278 6.85973 15.3997 7.03047C15.2871 7.20461 15.1915 7.38729 15.1095 7.57851L14.9183 8.00876L13.928 7.93705C13.7471 8.32803 13.4705 8.92217 13.2076 9.61534C12.9429 10.3085 12.6919 11.1007 12.5622 11.8912C13.3407 11.9561 16.8646 12.4683 16.8646 12.4683L16.95 12.7551C17.8805 12.8797 18.7905 13.1341 19.651 13.5114C19.9224 13.578 20.6071 13.4756 21.0544 13.6822C21.0834 13.6634 21.1585 13.5883 21.1858 13.5678C22.7702 14.0595 24.0798 14.8858 25.6078 15.2546C25.6078 15.2546 26.3215 15.4288 26.5622 15.4749C26.9668 15.5534 27.3766 15.6063 27.788 15.6319C28.278 15.6712 28.5478 15.6644 28.9063 15.6849C29.1607 15.7002 29.4697 15.6575 29.5705 16.0263C29.5858 16.0929 29.5227 16.1424 29.3997 16.2329ZM31.8395 15.1163C30.7605 15.1163 29.8846 14.2405 29.8846 13.1614C29.8846 12.0824 30.7605 11.2066 31.8395 11.2066C32.9185 11.2066 33.7944 12.0824 33.7944 13.1614C33.7944 14.2405 32.9185 15.1163 31.8395 15.1163Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">2. Bundesliga</p>
        </div>

        <!-- MLS -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 43 45" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <radialGradient id="paint0_radial_2773_240" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(23.9645 20.1296) scale(15.2092 15.3909)">
          <stop stop-color="#008AD4"></stop>
          <stop offset="1" stop-color="#141C45"></stop>
          </radialGradient>
          <clipPath id="clip0_2773_240">
          <rect width="42" height="45" fill="white" transform="translate(0.63501)"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2773_240)">
          <path d="M8.74443 31.3134L8.73795 31.32L8.21692 31.1165L8.54121 30.7883L8.74443 31.3134Z" fill="var(--ci-primary-color)"></path>
          <path d="M9.98107 34.2822L8.75525 35.5226V35.5204L9.97891 34.2822H9.98107Z" fill="var(--ci-primary-color)"></path>
          <path d="M39.176 4.73871L37.4464 6.48892V6.48673L39.176 4.73871Z" fill="var(--ci-primary-color)"></path>
          <path d="M9.97891 34.2822L8.75525 35.5205L9.98107 34.2822H9.97891ZM14.9643 40.5392C15.1935 40.677 15.4183 40.8061 15.641 40.9308C15.4183 40.8061 15.1935 40.6748 14.9643 40.5392ZM20.1595 42.9807C20.2762 43.0223 20.3843 43.0595 20.4816 43.0901C20.3843 43.0573 20.2762 43.0201 20.1595 42.9807ZM20.7475 43.1754C20.7129 43.1645 20.6783 43.1536 20.6394 43.1426C20.6762 43.1557 20.7129 43.1667 20.7475 43.1776C20.7713 43.1711 20.7951 43.1623 20.821 43.1536C20.7951 43.1601 20.7713 43.1689 20.7475 43.1754ZM25.6032 41.073C25.8259 40.9549 26.0508 40.828 26.2799 40.6923C26.0508 40.8236 25.8259 40.9505 25.6032 41.073ZM27.6852 39.826C27.923 39.6728 28.1651 39.5087 28.4051 39.3381C28.163 39.5066 27.923 39.6685 27.6852 39.826ZM29.8601 38.2464C29.5855 38.4674 29.3131 38.6774 29.0407 38.8809C29.3131 38.6796 29.5877 38.4674 29.8601 38.2486C30.0287 38.113 30.1974 37.9751 30.3617 37.8351C30.1974 37.9729 30.0287 38.1108 29.8601 38.2464ZM30.8503 37.4129C31.1724 37.1285 31.4859 36.8375 31.7886 36.54C31.4859 36.8353 31.1724 37.1263 30.8503 37.4129Z" fill="var(--ci-primary-color)"></path>
          <path d="M9.98107 34.2822L8.75525 35.5226V35.5204L9.97891 34.2822H9.98107Z" fill="#F6FE98"></path>
          <path d="M39.176 4.73871L37.4464 6.48892V6.48673L39.176 4.73871Z" fill="var(--ci-primary-color)"></path>
          <path d="M9.97891 34.2822L8.75525 35.5205L9.98107 34.2822H9.97891Z" fill="url(#paint0_radial_2773_240)"></path>
          <path d="M38.9662 0L37.2366 1.75021H0.63501V18.0928C0.63501 24.9229 2.61967 30.1167 5.34155 34.0262C5.68098 34.5163 6.03337 34.9844 6.39442 35.4351L1.3398 40.5501L2.56346 41.7884L6.3101 37.997L7.5316 36.7609C7.93156 37.1963 8.338 37.6098 8.74877 38.0036C14.3331 43.3548 20.7497 45 20.7497 45C20.7497 45 40.9055 39.85 40.9055 18.0928V5.46283L42.635 3.71263V0H38.9662ZM7.62456 34.1925C7.25919 33.7287 6.91112 33.2561 6.58251 32.7704C6.11769 32.0835 5.68962 31.3746 5.30048 30.6439C3.35257 26.986 2.36456 22.7614 2.36456 18.0928V3.50041H37.9522L36.2227 5.25062L8.85687 32.9454L7.62456 34.1925ZM39.1759 18.0928C39.1759 22.7308 38.1987 26.9313 36.2703 30.5739C36.1751 30.7555 36.0757 30.9371 35.9741 31.1143C35.8746 31.2937 35.7709 31.4731 35.6628 31.6481C35.559 31.8253 35.4509 32.0025 35.3385 32.1754C35.2282 32.3526 35.1158 32.5232 34.999 32.6939C34.8845 32.8667 34.7677 33.0351 34.6466 33.2036C34.5277 33.3721 34.4045 33.5405 34.2791 33.7068C34.1645 33.8599 34.0478 34.0109 33.9289 34.1597C33.9202 34.1728 33.9094 34.1859 33.8986 34.199C33.8835 34.2187 33.8683 34.2384 33.8511 34.2581C33.8511 34.2581 33.8496 34.2596 33.8467 34.2625C33.8467 34.2625 33.8402 34.269 33.8381 34.2734C33.73 34.4113 33.6197 34.5513 33.503 34.6847C33.3711 34.8466 33.2349 35.0041 33.0944 35.1617C32.9582 35.3214 32.8176 35.4767 32.6728 35.6298C32.5604 35.7545 32.4436 35.877 32.3269 35.9974C32.2728 36.0543 32.2188 36.1111 32.1626 36.1658C32.0393 36.2927 31.914 36.4174 31.7886 36.5399C31.4859 36.8375 31.1724 37.1284 30.8503 37.4129C30.6903 37.5551 30.5281 37.6973 30.3617 37.8351C30.1974 37.9751 30.0287 38.1129 29.8601 38.2486C29.5877 38.4674 29.3131 38.6796 29.0407 38.8808C28.9499 38.9487 28.8591 39.0143 28.7683 39.0799C28.6473 39.1696 28.5262 39.2549 28.4051 39.3381C28.1651 39.5087 27.923 39.6728 27.6852 39.826C27.5663 39.9069 27.4474 39.9835 27.3285 40.0557C27.2096 40.1344 27.0928 40.2066 26.9761 40.2766C26.8572 40.351 26.7404 40.421 26.6258 40.4888C26.5091 40.5589 26.3967 40.6267 26.2821 40.6923H26.2799C26.0508 40.8279 25.8259 40.9548 25.6033 41.073C25.493 41.1342 25.3827 41.1933 25.2746 41.2502C24.9417 41.4274 24.6174 41.5893 24.3061 41.7402C24.2088 41.7884 24.1137 41.8321 24.0207 41.8759C23.9213 41.924 23.824 41.97 23.7267 42.0137C23.6294 42.0575 23.5343 42.1012 23.4413 42.1428C23.1603 42.2675 22.8943 42.3834 22.6436 42.4841C22.5506 42.5213 22.462 42.5585 22.3733 42.5935C22.302 42.6219 22.2328 42.6503 22.1636 42.6766C22.0144 42.7357 21.8717 42.7882 21.7399 42.8363C21.5993 42.8888 21.4675 42.9348 21.3464 42.9763C21.2491 43.0113 21.1583 43.042 21.074 43.0704C21.0394 43.0835 21.0048 43.0945 20.9702 43.1054C20.9378 43.1163 20.9054 43.1273 20.8751 43.136C20.8556 43.1426 20.8383 43.1492 20.821 43.1535C20.7951 43.1623 20.7713 43.171 20.7475 43.1776C20.7129 43.1667 20.6762 43.1557 20.6394 43.1426C20.6005 43.1317 20.5594 43.1185 20.5184 43.1032C20.5054 43.0988 20.4946 43.0966 20.4816 43.0901C20.3843 43.0595 20.2762 43.0223 20.1595 42.9807C20.1054 42.9632 20.0471 42.9435 19.9887 42.9216C19.9844 42.9216 19.9822 42.9216 19.9779 42.9173C19.8547 42.8735 19.7185 42.8232 19.5758 42.7685C19.3574 42.6875 19.1218 42.5957 18.8688 42.4906C18.791 42.46 18.7131 42.4272 18.6332 42.3922C18.5488 42.3572 18.4602 42.3222 18.3716 42.2806C18.2894 42.2456 18.2008 42.2084 18.1121 42.169C18.1056 42.1647 18.1013 42.1625 18.0948 42.1603C18.004 42.1209 17.9132 42.0793 17.8181 42.0356C17.7251 41.994 17.63 41.9503 17.5306 41.9021C17.4333 41.8584 17.3338 41.8102 17.2322 41.7599C17.1306 41.7118 17.029 41.6615 16.9274 41.6112C16.722 41.5105 16.5101 41.4011 16.2961 41.2874C16.0821 41.1736 15.8637 41.0555 15.641 40.9308C15.4184 40.8061 15.1935 40.677 14.9643 40.5392C14.8498 40.4713 14.7352 40.4013 14.6206 40.3313C14.2725 40.1191 13.9201 39.8916 13.5634 39.6509C13.4445 39.5722 13.3256 39.489 13.2067 39.4059C12.9667 39.2396 12.7267 39.0668 12.4868 38.8874C12.2446 38.708 12.0047 38.522 11.7625 38.3295C11.5874 38.1917 11.4166 38.0495 11.248 37.9073C11.0772 37.7651 10.9107 37.6229 10.7464 37.4763C10.6297 37.3757 10.5172 37.2728 10.4027 37.1678C10.2665 37.0431 10.1302 36.9162 9.99621 36.7872C9.98756 36.7806 9.98107 36.7718 9.97243 36.7653C9.96378 36.7587 9.95729 36.75 9.94865 36.7412C9.86217 36.6603 9.77569 36.5771 9.69137 36.4918C9.66975 36.4699 9.64597 36.4481 9.62436 36.4262C9.53572 36.3387 9.4514 36.2533 9.36492 36.1658H9.36276C9.27412 36.0739 9.18764 35.9842 9.10116 35.8924C8.98442 35.7698 8.86984 35.6473 8.75525 35.5226L9.97891 34.2822H9.98107L37.4464 6.48889L39.1759 4.73868V18.0928Z" fill="var(--ci-primary-color)"></path>
          <path d="M8.67316 17.9681L9.15095 19.4557L7.89919 18.5369L6.64742 19.4557L7.12521 17.9681L5.87561 17.0492H7.4214L7.89919 15.5615L8.37697 17.0492H9.92276L8.67316 17.9681Z" fill="var(--ci-primary-color)"></path>
          <path d="M15.987 17.9681L16.4648 19.4557L15.213 18.5369L13.9634 19.4557L14.4412 17.9681L13.1895 17.0492H14.7352L15.213 15.5615L15.6908 17.0492H17.2366L15.987 17.9681Z" fill="var(--ci-primary-color)"></path>
          <path d="M12.3116 22.9277L12.7894 24.4154L11.5376 23.4965L10.288 24.4154L10.7658 22.9277L9.51404 22.0088H11.0598L11.5376 20.519L12.0154 22.0088H13.5612L12.3116 22.9277Z" fill="var(--ci-primary-color)"></path>
          <path d="M11.2199 5.39941H9.88165C9.79085 5.39941 9.73464 5.43442 9.70004 5.51536L7.76943 10.0003H7.72403L5.75883 5.51536C5.72424 5.43442 5.66587 5.39941 5.57506 5.39941H4.2152C4.14818 5.39941 4.10278 5.44754 4.10278 5.51536V13.1463C4.10278 13.2141 4.14818 13.2622 4.2152 13.2622H5.50804C5.57506 13.2622 5.62046 13.2141 5.62046 13.1463V8.71824H5.66587L7.10572 12.0349C7.15112 12.1399 7.2203 12.1858 7.32407 12.1858H8.11102C8.21479 12.1858 8.28397 12.1399 8.32937 12.0349L9.76707 8.71824H9.81463V13.1463C9.81463 13.2141 9.86003 13.2622 9.92705 13.2622H11.2199C11.2869 13.2622 11.3323 13.2141 11.3323 13.1463V5.51536C11.3323 5.44754 11.2869 5.39941 11.2199 5.39941Z" fill="var(--ci-primary-color)"></path>
          <path d="M17.8441 11.7461H14.4174C14.372 11.7461 14.3504 11.7242 14.3504 11.6783V5.51536C14.3504 5.44754 14.3028 5.39941 14.2358 5.39941H12.7851C12.7159 5.39941 12.6705 5.44754 12.6705 5.51536V13.1463C12.6705 13.2141 12.7159 13.2622 12.7851 13.2622H17.8441C17.9132 13.2622 17.9586 13.2141 17.9586 13.1463V11.8621C17.9586 11.7942 17.9132 11.7461 17.8441 11.7461Z" fill="var(--ci-primary-color)"></path>
          <path d="M22.0274 8.53228L21.6145 8.4754C20.7238 8.34851 20.4038 8.05973 20.4038 7.60905C20.4038 7.11024 20.7584 6.75363 21.4437 6.75363C22.0837 6.75363 22.6544 6.96147 23.2489 7.35308C23.3051 7.38808 23.3635 7.37715 23.4089 7.32026L24.1051 6.26795C24.1634 6.187 24.1505 6.14106 24.0834 6.09293C23.4305 5.58537 22.4728 5.27252 21.4437 5.27252C19.7639 5.27252 18.6916 6.23295 18.6916 7.67687C18.6916 9.12079 19.5693 9.8165 21.1475 10.0353L21.5583 10.0943C22.4836 10.2212 22.7582 10.51 22.7582 10.9716C22.7582 11.5273 22.2998 11.908 21.4891 11.908C20.6784 11.908 19.9693 11.5164 19.4569 11.0985C19.3985 11.0526 19.3315 11.0526 19.2839 11.1116L18.417 12.1158C18.3586 12.1858 18.3824 12.2668 18.4278 12.3127C19.0332 12.9034 20.2093 13.3891 21.4199 13.3891C23.4305 13.3891 24.4704 12.3368 24.4704 10.9148C24.4704 9.49271 23.6251 8.75325 22.0274 8.53228Z" fill="var(--ci-primary-color)"></path>
          <path d="M8.31209 32.5561L8.13265 32.7376C8.13265 32.7376 8.11319 32.7464 8.10455 32.7376L7.36084 31.985L7.35219 31.9763C7.35219 31.9763 7.34138 31.9697 7.3349 31.9763L7.09276 32.2213C7.09276 32.2213 7.0733 32.2301 7.06465 32.2213L6.90899 32.0638C6.90899 32.0638 6.90035 32.0441 6.90899 32.0354L7.61811 31.3156C7.61811 31.3156 7.63757 31.3068 7.64622 31.3156L7.80404 31.4753C7.80404 31.4753 7.81052 31.495 7.80188 31.5037L7.55974 31.7488C7.55974 31.7488 7.55541 31.7597 7.55974 31.7663L7.56839 31.775L8.31209 32.5276C8.31209 32.5276 8.32074 32.5473 8.31209 32.5561Z" fill="var(--ci-primary-color)"></path>
          <path d="M9.56814 31.2849L9.40816 31.4468C9.40816 31.4468 9.3887 31.4556 9.38006 31.4468L8.83957 30.8999L8.83308 30.9065L9.06225 31.495C9.06874 31.5147 9.06441 31.5278 9.0536 31.5409L8.95632 31.6394C8.94334 31.6525 8.92821 31.6547 8.91091 31.6481L8.32719 31.4184L8.32287 31.425L8.86119 31.9719C8.86119 31.9719 8.86984 31.9916 8.86119 32.0003L8.70337 32.1601C8.70337 32.1601 8.68391 32.1688 8.67526 32.1601L7.92939 31.4075L7.74347 31.2193C7.74347 31.2193 7.73482 31.1974 7.74347 31.1909L7.9121 31.0202C7.9121 31.0202 7.93372 31.0049 7.94669 31.0115L8.21693 31.1165L8.73796 31.32L8.74444 31.3134L8.54122 30.7883L8.43529 30.5192C8.4288 30.5039 8.43096 30.493 8.44394 30.482L8.60824 30.3136C8.60824 30.3136 8.6277 30.3048 8.63635 30.3136L8.82444 30.5039L9.56814 31.2565C9.56814 31.2565 9.57679 31.2762 9.56814 31.2849Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Major League Soccer</p>
        </div>

        <!-- Itália Série A -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 36 41" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2704_2066">
          <rect width="36" height="41" fill="white"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2704_2066)">
          <path d="M21.0571 19.4674L18.0017 11.8269C15.7668 17.4899 13.6904 23.2123 11.4889 28.8879C11.3872 29.1503 11.2582 29.5574 11.1309 29.786C11.0903 29.859 10.9997 29.8481 11.0014 29.8807L17.9466 40.9995L0 29.8731L13.1962 0L23.1602 0.00816473L36 29.7768L18.1129 41L25.1449 29.8541L25.1437 29.6902L23.5838 26.1554H14.7795L17.3345 19.4674H21.056H21.0571Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Itália Série A</p>
        </div>

        <!-- Ligue 1 -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2256_1973">
          <rect width="40" height="40" fill="white"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2256_1973)">
          <path d="M20.0628 0C20.2455 0.0939989 20.4923 0.0252404 20.7011 0.0443884C21.4667 0.114887 22.2037 0.332477 22.9269 0.576178C23.1001 0.769398 22.1162 1.34819 21.9872 1.42478C19.3751 2.9775 15.3573 4.3048 12.43 5.23783C10.6788 5.79573 7.33568 6.90892 5.5888 6.9124C4.88207 6.91414 5.15749 6.5747 5.4355 6.22394C6.04262 5.45629 6.93209 4.80613 7.68385 4.18382C7.77219 4.15336 8.09437 4.43796 8.2546 4.49454C8.36112 4.53196 8.46072 4.58244 8.57938 4.55981L14.7554 2.92528L19.8584 0.613604L19.9311 0.53266C19.615 0.36207 19.2677 0.297663 18.9334 0.183646C18.8754 0.163628 18.7991 0.170591 18.7853 0.0896471C19.117 0.0478698 19.4461 0.0548327 19.7804 0.0469994C19.8376 0.0452587 19.8809 0.00087036 19.8869 0.00087036H20.0636L20.0628 0Z" fill="var(--ci-primary-color)"></path>
          <path d="M27.5544 27.2362L27.2037 23.0315L28.3348 22.84C29.3637 21.1837 30.2904 19.4465 30.8022 17.5473C30.9062 17.1618 31.185 16.1382 31.1703 15.7892C31.1599 15.5533 30.3787 14.2165 30.2055 13.9205C29.2632 12.3086 28.1312 10.809 26.8044 9.49999C24.3603 9.43819 21.9136 9.75587 19.5362 10.2981C18.3133 12.5262 17.3866 14.9041 16.6782 17.3489C17.6257 19.7659 19.2201 21.8878 21.064 23.6869L22.3042 23.5667L22.7944 27.768C18.6753 27.1901 15.1521 24.1464 13.8824 20.1845C12.049 14.4619 14.5078 8.33371 20.1078 6.0464C25.3407 3.9088 31.3288 6.79056 33.5538 11.8395C34.3965 13.75 34.723 16.1904 34.4649 18.2628C33.9643 22.2786 31.269 25.7331 27.5536 27.2371L27.5544 27.2362Z" fill="var(--ci-primary-color)"></path>
          <path d="M2.21808 29.7167C3.64884 29.9273 5.09953 29.8925 6.4818 29.4408C6.84295 27.8541 7.11144 26.2266 7.24049 24.6007C7.30198 23.8244 7.45527 22.0845 7.30717 21.39C7.2171 20.967 6.85941 20.1906 6.6758 19.7659C6.15442 18.5639 5.49013 17.3254 4.77475 16.2296C4.63618 16.0172 3.79521 14.7805 3.6705 14.7248C3.54578 14.6691 2.97157 14.8632 2.80095 14.9128C1.93054 15.1704 1.08784 15.5351 0.279785 15.9433C0.703299 14.5812 1.64993 12.2425 3.14305 11.8021C5.28487 11.172 7.29418 13.7091 8.21829 15.3375C10.1687 18.7745 10.6684 23.1429 10.1436 27.0308C9.89329 28.8855 9.05579 32.4618 6.86201 32.8552C4.62752 33.2556 3.01314 31.6219 2.21894 29.7167H2.21808Z" fill="var(--ci-primary-color)"></path>
          <path d="M29.5811 37.7318C29.7032 36.905 29.7638 36.0215 29.7145 35.1834C29.7084 35.085 29.6608 34.6351 29.6253 34.609C28.3175 34.3104 26.9993 34.0476 25.6733 33.8422C24.705 33.6925 23.4666 33.4662 22.5069 33.4357C22.2151 33.4261 21.6313 33.6881 21.3299 33.8021C19.2912 34.5733 17.3243 35.6447 15.522 36.8658C15.4614 36.9311 15.4813 37.0059 15.4847 37.0834C15.5263 37.992 16.065 39.0713 16.4054 39.9025C15.0656 39.5735 13.4165 39.0695 12.8285 37.6744C11.984 35.6691 13.9076 34.0772 15.451 33.2077C19.2964 31.0414 26.1973 29.9395 30.183 32.145C32.9172 33.6577 32.0936 36.0268 29.9033 37.5473C29.8556 37.5804 29.6097 37.7649 29.5811 37.7327V37.7318Z" fill="var(--ci-primary-color)"></path>
          <path d="M24.2044 20.0958C26.2072 20.0958 27.8307 18.4638 27.8307 16.4507C27.8307 14.4376 26.2072 12.8057 24.2044 12.8057C22.2017 12.8057 20.5781 14.4376 20.5781 16.4507C20.5781 18.4638 22.2017 20.0958 24.2044 20.0958Z" fill="var(--ci-primary-color)"></path>
          <path d="M38.9659 14.4375C39.4371 15.77 39.7948 17.1652 39.9359 18.5787C40.2729 21.9548 39.2682 27.3537 37.4425 30.2441C37.252 30.5461 36.9895 30.9813 36.618 31.0396C36.4491 30.9979 36.379 30.3399 36.3677 30.1806C36.2187 28.0543 36.5773 25.3222 36.8579 23.1899C37.1645 20.8634 37.6556 17.0738 38.5485 14.9693C38.5918 14.8666 38.8213 14.3366 38.9659 14.4375Z" fill="var(--ci-primary-color)"></path>
          <path d="M1.54592 18.9225C2.35571 18.8103 2.99488 19.6075 3.34218 20.2385C4.12771 21.6668 4.37021 23.9523 3.80466 25.4885C3.23911 27.0247 2.03439 27.298 1.05399 25.9489C0.073582 24.5999 -0.287574 21.9366 0.277977 20.3047C0.469381 19.7529 0.914548 19.0096 1.54592 18.9225Z" fill="var(--ci-primary-color)"></path>
          <path d="M23.535 36.2392C24.4417 36.1835 26.4164 36.2862 26.8443 37.2723C27.1586 37.9964 26.4294 38.6483 25.876 38.9912C24.4495 39.8738 21.976 40.2785 20.372 39.792C18.6719 39.2759 18.7594 38.0835 20.1546 37.227C21.1082 36.6421 22.422 36.3088 23.535 36.24V36.2392Z" fill="var(--ci-primary-color)"></path>
          <path d="M37.2034 10.2746C36.1139 9.45554 35.0469 8.59388 34.031 7.68436C33.4576 7.17172 32.9267 6.60163 32.3577 6.08899C30.7373 4.62765 29.0553 3.22289 27.5103 1.68323C28.5253 1.98002 29.5152 2.56664 30.4151 3.12541C32.6972 4.54497 34.8841 6.58248 36.3685 8.83323L37.2043 10.2737L37.2034 10.2746Z" fill="var(--ci-primary-color)"></path>
          <path d="M16.4053 0.398682L15.7895 0.775547C13.8062 1.83826 11.6687 2.62854 9.44373 3.01063C9.6845 2.82263 9.98156 2.66162 10.2509 2.51627C12.1598 1.48837 14.2617 0.745955 16.4053 0.398682Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
          </button>
          <p class="titleCategories">Ligue 1</p>
        </div>

        <!-- Liga MX -->
        <div class="liga-item">
          <button class="liga-circle-button">
          <svg viewBox="0 0 60 45" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M36.7401 20.4411C36.7401 20.4411 41.1983 14.2052 41.4859 13.1978C41.4859 13.1978 43.7869 11.1351 39.9039 9.07244C39.9039 9.07244 35.8294 7.29759 33.6723 9.26435C33.6723 9.26435 26.4338 15.7402 24.2767 19.0502C24.2767 19.0502 23.0304 20.4892 24.4685 22.2161C24.4685 22.2161 30.2281 30.515 36.8397 37.8063C36.8397 37.8063 39.1939 40.2527 43.336 37.0866C43.336 37.0866 46.0878 34.8802 44.2662 31.6662C44.2662 31.6662 39.9518 23.607 36.7401 20.4411Z" fill="var(--ci-primary-color)"></path>
          <path d="M48.1914 10.3924C48.1914 10.3924 44.9741 8.19573 43.8915 11.4154C43.8915 11.4154 43.711 12.8899 44.7033 14.3643C44.7033 14.3643 54.3031 23.634 51.5347 33.6266C51.5347 33.6266 59.8762 21.7859 48.1914 10.3924Z" fill="var(--ci-primary-color)"></path>
          <path d="M45.3689 16.9575C45.3689 16.9575 42.0332 14.8798 39.6165 17.6728C39.6165 17.6728 37.8525 19.9711 39.064 22.196C39.0776 22.221 39.0916 22.246 39.106 22.271C40.3994 24.519 44.4499 28.1294 46.6284 34.1241C46.6284 34.1241 47.5472 37.2577 50.7128 33.0341C50.7128 33.0341 53.1637 30.4115 50.1343 24.2465C50.1343 24.2465 47.7857 19.3078 45.3689 16.9575H45.3689Z" fill="var(--ci-primary-color)"></path>
          <path d="M23.2733 20.4411C23.2733 20.4411 18.8152 14.2052 18.5276 13.1978C18.5276 13.1978 16.2266 11.1351 20.1095 9.07244C20.1095 9.07244 24.1841 7.29759 26.3412 9.26435C26.3412 9.26435 33.5796 15.7402 35.7367 19.0502C35.7367 19.0502 36.983 20.4892 35.545 22.2161C35.545 22.2161 29.7854 30.515 23.1737 37.8063C23.1737 37.8063 20.8194 40.2527 16.6774 37.0866C16.6774 37.0866 13.9256 34.8802 15.7472 31.6662C15.7472 31.6662 20.0615 23.607 23.2732 20.4411H23.2733Z" fill="var(--ci-primary-color)"></path>
          <path d="M11.8086 10.3924C11.8086 10.3924 15.026 8.19573 16.1085 11.4154C16.1085 11.4154 16.2891 12.8899 15.2967 14.3643C15.2967 14.3643 5.69696 23.634 8.46529 33.6266C8.46529 33.6266 0.12379 21.7859 11.8086 10.3924Z" fill="var(--ci-primary-color)"></path>
          <path d="M14.631 16.9575C14.631 16.9575 17.9667 14.8798 20.3833 17.6728C20.3833 17.6728 22.1474 19.9711 20.9359 22.196C20.9223 22.221 20.9083 22.246 20.8939 22.271C19.6005 24.5189 15.55 28.1294 13.3715 34.1241C13.3715 34.1241 12.4527 37.2577 9.28711 33.0341C9.28711 33.0341 6.83622 30.4115 9.86569 24.2465C9.86569 24.2465 12.2144 19.3078 14.631 16.9575Z" fill="var(--ci-primary-color)"></path>
          </svg>
          </button>
          <p class="titleCategories">Liga MX</p>
        </div>
      </div>
    </div>

    <!-- Seção de Esportes -->
    <div class="esportes-grid">
      <!-- Ao Vivo -->
      <button class="esporte-card">
        <div class="esporte-icon-wrapper">
          <div class="live-pulse"></div>
        </div>
        <div class="esporte-content">
          <small class="esporte-category">Esportes</small>
          <div class="esporte-title-wrapper">
            <p class="esporte-title">Ao vivo</p>
          </div>
        </div>
      </button>

      <!-- Próximos Eventos -->
      <button class="esporte-card">
        <div class="esporte-icon-wrapper">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2389_667">
          <rect width="24" height="24" fill="white" transform="translate(24) rotate(90)"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2389_667)">
          <path d="M23.8182 14.781C22.686 14.6028 21.8172 13.6203 21.8172 12.4389L21.8172 11.6023C21.8172 10.4207 22.686 9.43817 23.8182 9.26001L24 9.26001L24 14.781L23.8182 14.781Z" fill="var(--ci-primary-color)"></path>
          <path opacity="0.6" d="M13.0902 8.23187C14.8806 8.56348 16.2411 10.1356 16.2411 12.0205C16.2411 13.9054 14.8806 15.4775 13.0902 15.8091L13.0902 21.873C13.0902 21.9254 13.084 21.9763 13.0732 22.0254L20.4844 22.0254C22.4229 22.0254 24 20.4483 24 18.5098L24 16.2114C22.0043 16.1129 20.4109 14.4584 20.4109 12.4389L20.4109 11.6023C20.4109 9.58264 22.0043 7.9281 24 7.82977L24 5.53125C24 3.59271 22.4229 2.01562 20.4844 2.01562L13.0732 2.01562C13.084 2.0647 13.0902 2.1156 13.0902 2.16797L13.0902 8.23187Z" fill="var(--ci-primary-color)"></path>
          <path opacity="0.6" d="M11.684 15.8091C9.89355 15.4775 8.5329 13.9054 8.5329 12.0205C8.5329 10.1356 9.89355 8.56348 11.684 8.23187L11.684 2.16797C11.684 2.1156 11.69 2.0647 11.701 2.01562L3.51562 2.01562C1.57709 2.01562 -6.89367e-08 3.59271 -1.53673e-07 5.53125L-2.54144e-07 7.82977C1.99567 7.9281 3.58905 9.58264 3.58905 11.6023L3.58905 12.4389C3.58905 14.4586 1.99567 16.1129 -6.20518e-07 16.2114L-7.20982e-07 18.5098C-8.05718e-07 20.4483 1.57709 22.0254 3.51562 22.0254L11.701 22.0254C11.69 21.9763 11.684 21.9254 11.684 21.873L11.684 15.8091Z" fill="var(--ci-primary-color)"></path>
          <path d="M2.1828 12.4389L2.1828 11.6023C2.1828 10.3583 1.21967 9.33563 0 9.23932L-2.43139e-07 14.8017C1.21967 14.7054 2.1828 13.6827 2.1828 12.4389Z" fill="var(--ci-primary-color)"></path>
          <path d="M13.0902 14.365C14.0982 14.062 14.8348 13.1259 14.8348 12.0205C14.8348 10.9151 14.0982 9.97906 13.0902 9.67621L13.0902 14.365Z" fill="var(--ci-primary-color)"></path>
          <path d="M11.684 9.67621C10.676 9.97906 9.93915 10.9151 9.93915 12.0205C9.93915 13.1259 10.676 14.062 11.684 14.365L11.684 9.67621Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
        </div>
        <div class="esporte-content">
          <small class="esporte-category">Esportes</small>
          <div class="esporte-title-wrapper">
            <p class="esporte-title">Próximos Eventos</p>
          </div>
        </div>
      </button>

      <!-- Futebol -->
      <button class="esporte-card">
        <div class="esporte-icon-wrapper">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2389_680">
          <rect width="20" height="20" fill="white"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2389_680)">
          <path d="M3.95863 8.08462L0.785556 10.5212C0.775941 10.3481 0.771133 10.175 0.771133 10C0.767297 7.8932 1.48728 5.84901 2.81056 4.20962L3.95863 8.08462ZM2.20383 14.9442C3.45898 16.9213 5.41786 18.3482 7.68459 18.9365L6.27113 14.9442H2.20383ZM12.3202 18.9365C14.5869 18.3482 16.5458 16.9213 17.8009 14.9442H13.7336L12.3202 18.9365ZM17.1894 4.20962L16.0413 8.08462L19.2144 10.5212C19.224 10.3481 19.2288 10.175 19.2288 10C19.2327 7.8932 18.5127 5.84901 17.1894 4.20962ZM13.4856 1.45C11.2505 0.5423 8.74948 0.5423 6.5144 1.45L9.99998 3.84616L13.4856 1.45ZM12.3769 13.0769L13.8461 8.79808L9.99998 6.15385L6.15383 8.79808L7.62306 13.0769H12.3769Z" fill="var(--ci-primary-color)"></path>
          <path opacity="0.6" d="M10 0C8.02219 0 6.08879 0.58649 4.4443 1.6853C2.79981 2.78412 1.51809 4.3459 0.761209 6.17317C0.00433284 8.00043 -0.193701 10.0111 0.192152 11.9509C0.578004 13.8907 1.53041 15.6725 2.92894 17.0711C4.32746 18.4696 6.10929 19.422 8.0491 19.8079C9.98891 20.1937 11.9996 19.9957 13.8268 19.2388C15.6541 18.4819 17.2159 17.2002 18.3147 15.5557C19.4135 13.9112 20 11.9778 20 10C19.9972 7.34869 18.9427 4.80678 17.068 2.93202C15.1932 1.05727 12.6513 0.00279983 10 0ZM17.3577 14.175H14.125L13.2346 12.9481L14.449 9.41154L15.8914 8.94135L18.4144 10.8769C18.295 12.0377 17.9351 13.1609 17.3577 14.175ZM1.58847 10.8769L4.10673 8.94231L5.54904 9.4125L6.76347 12.949L5.875 14.175H2.64231C2.06424 13.1611 1.70369 12.0379 1.58366 10.8769H1.58847ZM2.55 6.00769L3.07981 7.79615L1.60673 8.92019C1.73727 7.90031 2.05407 6.91309 2.54135 6.00769H2.55ZM8.17308 12.3077L7.07116 9.10096L10 7.0875L12.9289 9.10096L11.8269 12.3077H8.17308ZM16.9298 7.79615L17.4596 6.00769C17.9469 6.91309 18.2637 7.90031 18.3942 8.92019L16.9298 7.79615ZM16.3337 4.39423L15.4192 7.47885L13.9702 7.94904L10.7692 5.74904V4.25096L13.5663 2.32788C14.6198 2.82062 15.5613 3.52384 16.3327 4.39423H16.3337ZM11.7375 1.71827L10 2.9125L8.2625 1.71827C9.40842 1.47841 10.5916 1.47841 11.7375 1.71827ZM6.43366 2.32788L9.23077 4.25096V5.74904L6.03077 7.94904L4.58174 7.47885L3.66731 4.39423C4.43871 3.52384 5.38016 2.82062 6.43366 2.32788ZM3.76443 15.7135H5.72308L6.4125 17.6625C5.41137 17.1914 4.51185 16.5293 3.76443 15.7135ZM8.26923 18.2817L7.12693 15.0683L8.01443 13.8462H11.9856L12.8731 15.0683L11.7356 18.2817C10.591 18.5216 9.40905 18.5216 8.26443 18.2817H8.26923ZM13.5923 17.6625L14.2817 15.7135H16.2404C15.4915 16.5298 14.5904 17.1919 13.5875 17.6625H13.5923Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
        </div>
        <div class="esporte-content">
          <small class="esporte-category">Esportes</small>
          <div class="esporte-title-wrapper">
            <p class="esporte-title">Futebol</p>
          </div>
        </div>
      </button>

      <!-- Basquete -->
      <button class="esporte-card">
        <div class="esporte-icon-wrapper">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
          <clipPath id="clip0_2389_713">
          <rect width="20" height="20" fill="white"></rect>
          </clipPath>
          </defs>
          <g clip-path="url(#clip0_2389_713)">
          <path d="M8.82167 10L6.46 12.3617L6.4575 12.3642C4.73824 10.8707 2.54626 10.0333 0.269167 10H0C-0.00071212 7.63643 0.8397 5.34974 2.37083 3.54917L8.82167 10Z" fill="var(--ci-primary-color)"></path>
          <path d="M10 0.269167C10.0335 2.54622 10.8709 4.73813 12.3642 6.4575L10 8.82167L3.54917 2.37083C5.34974 0.8397 7.63643 -0.00071212 10 0V0.269167Z" fill="var(--ci-primary-color)"></path>
          <path d="M13.5425 7.63583C15.2618 9.12916 17.4538 9.96656 19.7308 10H20C20.0007 12.3636 19.1603 14.6503 17.6292 16.4508L11.1783 10L13.5425 7.63583Z" fill="var(--ci-primary-color)"></path>
          <path d="M10 19.7067C9.93665 17.4427 9.10264 15.2682 7.63583 13.5425L10 11.1783L16.4508 17.6292C14.6503 19.1603 12.3636 20.0007 10 20V19.7067Z" fill="var(--ci-primary-color)"></path>
          <path opacity="0.6" d="M13.5433 5.27832C12.3113 3.85645 11.6436 2.03207 11.6667 0.150818C13.4319 0.447394 15.0846 1.21429 16.4508 2.37082L13.5433 5.27832ZM17.6292 3.54915L14.7217 6.45665C16.1553 7.6685 17.9719 8.33337 19.8492 8.33332C19.5526 6.56806 18.7857 4.91537 17.6292 3.54915ZM6.455 14.7233L3.54917 17.6292C4.91538 18.7857 6.56807 19.5526 8.33333 19.8492C8.33513 17.9718 7.66937 16.155 6.455 14.7233ZM0.150833 11.6667C0.44741 13.4319 1.21431 15.0846 2.37083 16.4508L5.27833 13.5433C3.84759 12.3264 2.02909 11.6608 0.150833 11.6667Z" fill="var(--ci-primary-color)"></path>
          </g>

          </svg>
        </div>
        <div class="esporte-content">
          <small class="esporte-category">Esportes</small>
          <div class="esporte-title-wrapper">
            <p class="esporte-title">Basquete</p>
          </div>
        </div>
      </button>
    </div>
  </div>
</a>

                <div v-if="loading">
      <!-- Aplicar o efeito shimmer enquanto os dados estão carregando -->
      <div v-if="loading" class="shimmer2 item-game" v-for="n in 13" :key="n">
        <div v-if="featured_games" class="mt-3">
<div class="w-full flex justify-between" >
    <div class="flex items-center">
        <h2 class="text-lg providersNames ">{{ $t('💚 +Jogados Da Semana') }}</h2>
        <button @click.prevent="fgCarousel.prev()"
            class="item-game px-2 py-1 rounded-lg text-[12px] ml-2 mr-2 celular-providers-setas">
            <i class="fa-solid fa-angle-left"></i>
        </button>
        <button @click.prevent="fgCarousel.next()"
            class="item-game px-2 py-1 rounded-lg text-[12px] celular-providers-setas">
            <i class="fa-solid fa-angle-right"></i>
        </button>
    </div>
    <div class="flex">

    </div>
</div>

<Carousel class="item-sombra2" ref="fgCarousel" v-bind="settingsGames" :breakpoints="breakpointsGames"
    @init="onCarouselInit(index)" @slide-start="onSlideStart(index)">
    <Slide v-if="loading" v-for="(i, loading) in 10" :index="loading">
        <div role="status"
            class=" w-full flex items-center justify-center h-48 mr-6 max-w-sm bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700 text-4xl">
            <i class="fa-duotone fa-gamepad-modern"></i>
        </div>
    </Slide>

    <Slide v-if="featured_games && !loading" v-for="(game, providerId) in featured_games"
        :index="providerId" class="p-2">
        <CassinoGameCard :index="providerId" :title="game.game_name" :cover="game.cover"
            :gamecode="game.game_code" :type="game.distribution" :game="game" />
    </Slide>
</Carousel>
</div>
      </div>
    </div>
    <div v-else>
                <div v-if="featured_games" class="mt-3">

                    <div class="w-full flex justify-between" style="border-radius:0.6rem; background: linear-gradient(90deg,var(--card-color-dark), rgba(255, 255, 255, 0) 100%);">
                        <div class="flex items-center">
                            <h2 class="text-lg providersNames ">{{ $t('💚 +Jogados Da Semana') }}</h2>
                            <button @click.prevent="fgCarousel.prev()"
                                class="item-game px-2 py-1 rounded-lg text-[12px] ml-2 mr-2 celular-providers-setas">
                                <i class="fa-solid fa-angle-left"></i>
                            </button>
                            <button @click.prevent="fgCarousel.next()"
                                class="item-game px-2 py-1 rounded-lg text-[12px] celular-providers-setas">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </div>
                        <div class="flex">

                        </div>
                    </div>

                    <Carousel class="item-sombra2" ref="fgCarousel" v-bind="settingsGames" :breakpoints="breakpointsGames"
                        @init="onCarouselInit(index)" @slide-start="onSlideStart(index)">
                        <Slide v-if="loading" v-for="(i, loading) in 10" :index="loading">
                            <div role="status"
                                class=" w-full flex items-center justify-center h-48 mr-6 max-w-sm bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700 text-4xl">
                                <i class="fa-duotone fa-gamepad-modern"></i>
                            </div>
                        </Slide>

                        <Slide v-if="featured_games && !loading" v-for="(game, providerId) in featured_games"
                            :index="providerId" class="p-2">
                            <CassinoGameCard :index="providerId" :title="game.game_name" :cover="game.cover"
                                :gamecode="game.game_code" :type="game.distribution" :game="game" />
                        </Slide>
                    </Carousel>
                </div>
                </div>

                <!-- <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-5">
                        <CassinoGameCard
                            v-for="(game, index) in featured_games"
                            :index="index"
                            :title="game.game_name"
                            :cover="game.cover"
                            :gamecode="game.game_code"
                            :type="game.distribution"
                            :game="game"
                        />
                    </div> -->

                <div class="">
                    <ShowProviders v-for="(provider, index) in providers" :provider="provider" :index="index" />
                </div>
				<div style="padding-top:30px;" ><LastWithdrawalComponent /></div>
<div style="padding-top:30px;" ><BetHistoryComponent /></div>
            </div>
        </div>
        <GameSearchOverlay :suggested-games="featured_games || []" />
    </BaseLayout>
</template>

<script>
    import {
        Carousel,
        Navigation,
        Pagination,
        Slide
    } from 'vue3-carousel';
    import {
        onMounted,
        ref
    } from "vue";

    import GameSearchOverlay from "@/Components/UI/GameSearchOverlay.vue";
    import BaseLayout from "@/Layouts/BaseLayout.vue";
    import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
    import {
        RouterLink,
        useRoute
    } from "vue-router";
    import {
        useAuthStore
    } from "@/Stores/Auth.js";
    import LanguageSelector from "@/Components/UI/LanguageSelector.vue";
    import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
    import HttpApi from "@/Services/HttpApi.js";
    import ShowCarousel from "@/Pages/Home/Components/ShowCarousel.vue";
    import {
        useSettingStore
    } from "@/Stores/SettingStore.js";
    import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
    import ShowProviders from "@/Pages/Home/Components/ShowProviders.vue";
    import {
        searchGameStore
    } from "@/Stores/SearchGameStore.js";
    import CustomPagination from "@/Components/UI/CustomPagination.vue";
    import LastWinnersComponent from "@/Components/UI/LastWinnersComponent.vue";
    import LastWithdrawalComponent from "@/Components/UI/LastWithdrawalComponent.vue";
    import BetHistoryComponent from "@/Components/UI/BetHistoryComponent.vue";
  	import PayingALotComponent from "@/Components/UI/PayingALotComponent.vue";

    export default {
      	name: 'PrincipaisLigas',
      	searchTerm: '',
        props: [],
        components: {
            GameSearchOverlay,
            CustomPagination,
            Pagination,
            ShowProviders,
            LoadingComponent,
            ShowCarousel,
            CassinoGameCard,
            Carousel,
            Navigation,
            Slide,
            LanguageSelector,
            MakeDeposit,
            BaseLayout,
            RouterLink,
            LastWinnersComponent,
          	LastWithdrawalComponent,
          	PayingALotComponent,
            BetHistoryComponent
        },
        data() {
            return {
                isLoading: true,
                loading: true,
                /// banners settings
                settings: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                    autoplay: 6000,
                    wrapAround: true
                },
                breakpoints: {
                    700: {
                        itemsToShow: 1,
                        snapAlign: 'center',
                    },
                    1024: {
                        itemsToShow: 1,
                        snapAlign: 'center',
                    },
                },

                settingsRecommended: {
                    itemsToShow: 2,
                  	autoplay: 4000,
                    snapAlign: 'start',
                  	pauseAutoplayOnHover: false,
    				transition: 500,
                  	wrapAround: true
                },
                breakpointsRecommended: {
                    700: {
                        itemsToShow: 3,
                        snapAlign: 'center',
                    },
                    1024: {
                        itemsToShow: 3,
                        snapAlign: 'start',
                    },
                },

                /// banners
                banners: null,
                bannersHome: null,

                settingsGames: {
                    itemsToShow: 2.5,
                    autoplay:3000,
                    snapAlign: 'start',
                  	transition: 500,
                    wrapAround: true,
                },
                breakpointsGames: {
                    700: {
                        itemsToShow: 3.5,
                        snapAlign: 'center',
                    },
                    1024: {
                        itemsToShow: 6,
                        snapAlign: 'start',
                    },
                },
                settingsImages: {
                    itemsToShow: 2,
                    snapAlign: 'start',
                },
                providers: null,

                featured_games: null,
            }
        },
        setup(props) {
          	
            const ckCarouselOriginals = ref(null)
            const fgCarousel = ref(null)

            onMounted(() => {

            });

            return {
                ckCarouselOriginals,
                fgCarousel
            };
            
        },
        computed: {
            searchGameStore() {
                return searchGameStore();
            },
            userData() {
                const authStore = useAuthStore();
                return authStore.user;
            },
            isAuthenticated() {
                const authStore = useAuthStore();
                return authStore.isAuth;
            },
            setting() {
                const settingStore = useSettingStore();
                return settingStore.setting;
            }
        },
        mounted() {
            window.scrollTo(0, 0);
            window.addEventListener('scroll', this.updateScrollTopButton, { passive: true });
            this.updateScrollTopButton();
        },
        beforeUnmount() {
            window.removeEventListener('scroll', this.updateScrollTopButton);
        },
        methods: {
            updateScrollTopButton() {
                const button = document.querySelector('.btn-scroll-top');
                if (!button) return;
                button.classList.toggle('show-btn-scroll-top', window.scrollY > 100);
            },
         searchGames: async function() {
            if (this.searchTerm.length > 2) {
                this.getData();
            }
        	},
          handleLigaClick(liga) {
            console.log('Liga clicada:', liga);
            // Adicione sua lógica de navegação aqui
          },
          handleEsporteClick(tipo) {
            console.log('Esporte clicado:', tipo);
            // Adicione sua lógica de navegação aqui
          },
            scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      },
            toggleSearch: function () {
                this.searchGameStore.openSearch();
            },
            getBanners: async function () {
                try {
                    const response = await HttpApi.get('settings/banners');
                    const allBanners = [...(response.data?.banners ?? [])].sort((a, b) => a.id - b.id);

                    this.banners = allBanners.filter(banner => banner.type === 'carousel');
                    this.bannersHome = allBanners.filter(banner => banner.type === 'home');
                } catch (error) {
                    console.error('Erro ao carregar banners:', error);
                    this.banners = [];
                    this.bannersHome = [];
                }
            },
            getAllGames: async function () {
                try {
                    const response = await HttpApi.get('games/all');
                    this.providers = response.data?.providers ?? [];
                } catch (error) {
                    console.error('Erro ao carregar jogos da Home:', error);
                    this.providers = [];
                }
            },
            getFeaturedGames: async function () {
                try {
                    const response = await HttpApi.get('featured/games');
                    this.featured_games = response.data?.featured_games ?? [];
                } catch (error) {
                    console.error('Erro ao carregar jogos em destaque:', error);
                    this.featured_games = [];
                }
            },
            initializeMethods: async function () {
                this.loading = true;
                this.isLoading = true;
                try {
                    await Promise.all([
                        this.getBanners(),
                        this.getAllGames(),
                        this.getFeaturedGames()
                    ]);
                } finally {
                    this.loading = false;
                    this.isLoading = false;
                }
            },
            onCarouselInit(index) {

            },
            onSlideStart(index) {

            },

        },
        async created() {
            await this.initializeMethods();
        },
        watch: {


        },
    };

</script>
