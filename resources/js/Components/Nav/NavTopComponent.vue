<style>
.input-wrapper {
  position: relative;
  margin: 20px 0;
}

/* Estilo do input */
input {
  border-radius: 4px;
  padding: 10px;
  font-size: 16px;
  width: 100%;
  box-sizing: border-box;
}

/* Estilo do label (placeholder) */
.label-formularios {
  position: absolute;
  top: 50%;
  left: 20px;
  font-size: 15px;
  color: #ADAFB0;
  pointer-events: none;
  transform: translateY(-50%);
}

/* Quando o input tem foco ou contém texto */
input:focus+label,
input:not(:placeholder-shown)+label {
  top: 20%;
  left: 20px;
  font-size: 10px;
  color: #ADAFB0;
}

html {
  font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
  ;
}

body {
  font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
  ;
}

.pad-modal-profile {
  padding: 0px 4%;
}

.hover-menu:hover {
  background-color: #0F2B39;
  border-radius: 10px;
}

.sair-menu:hover {
  background-color: #27171A;
  border-radius: 10px;
  color: #D3345D;
}

.sairp-menu:hover {
  color: #D3345D;
}

.notificacao-sino {
  font-size: 20px;
  color: gold;
}

.button-login-model {
  color: var(--ci-primary-color);
  border: 0.1rem solid var(--ci-primary-color);
  border-radius: 30px;
  color: white;
  font-weight: bold;
  font-size: .9rem;
  padding-top: 3px;
  padding-bottom: 3px
}

.button-register-model {
  color: #ACAFA7;
  border: 0.1rem solid var(--ci-primary-color);
  border-radius: 30px;
  color: var(--sub-text-color);
  font-weight: bold;
  font-size: .9rem;
  padding-top: 3px;
  padding-bottom: 3px;
  z-index: 1;
  background-color: var(--ci-primary-color);
}

.a-gift {
  box-shadow: -1px 3px 11px 0px rgba(0, 0, 0, 0.082);
  -webkit-box-shadow: -1px 3px 11px 0px rgba(0, 0, 0, 0.082);
  -moz-box-shadow: -1px 3px 11px 0px rgba(0, 0, 0, 0.082);
  padding: 3px;
  margin-left: 6px;
  margin-right: 8px;
  max-height: 26px;
  border-radius: 3px;
  background-color: #ee0000;
}

.tirar-div {
  display: none;
}

.padding-register {
  padding: 0px 8%;
}

.nav-indexx {
  z-index: 998;
}

.login-register-x {}

.login-register-100vh {
  background-color: var(--carousel-banners-dark);
  border-radius: 20px;
  max-width: 450px;
  margin: 0 auto;
  border-radius: 8px;
}

.login-register-100vh2 {
  background-color: var(--carousel-banners-dark);
  border-radius: 20px;
  max-width: 450px;
  margin: 0 auto;
  border-radius: 8px;
}

.x-mark-scale {
  opacity: .9;
  transition: .3s;
}

.x-mark-scale:hover {
  opacity: .8;
}

.msg-alerta {
  background-color: #0474CC;
  height: 30px;
  width: 100%;
  position: fixed;
  top: 0;
  display: flex;
  justify-content: center;
}

.msg-alerta-text {
  color: white;
  font-weight: 400;
  font-size: 14px;
  text-align: center;
  overflow: hidden;
}

.texto-esportes {
  opacity: .5;
  transition: .3s;
}

.texto-esportes:hover {
  opacity: 1;
}

@media (max-width:1025px) {
  #open-side-nav {
    display: none;
  }

  .tirar-esporte {
    display: none;
  }
}

@media (max-width:768px) {
  .logomobile {
    max-width: 105px;
    max-height: 1.75rem;
  }

  .button-login-model {
    font-size: 0.75rem;
  }

  .button-register-model {
    font-size: 0.75rem;
  }

  .a-gift {
    font-size: 12px;
  }

  .texto-indique {
    font-size: 14px;
    padding-top: 5px;
  }

  .texto-indique-pad {
    padding: 0 2%;
    text-align: center
  }

  .pad-modal-profile {
    padding: 0px 0px;
  }

  .por-height-alto {
    height: 100vh;
    border-radius: 0px;
  }

  .notificacao-sino {
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.25rem;
    padding: 0px 8px;
  }

  .search-menu {
    top: 0;
    min-height: 100vh;
  }

  .imagem-logo {
    max-width: 140px
  }

  .botao-entrar-mobile {
    padding: 3px 10px;
  }

  .botao-mobile-register-login {
    padding: 2px 12px;
    height: auto;
  }

  .login-register-100vh {
    height: 100vh;
    border-radius: 0px;
    max-width: 1000px;
    width: 100%;
  }

  .login-register-100vh2 {
    height: 100vh;
    border-radius: 0px;
    max-width: 1000px;
    width: 100%;
  }

  .padding-register {
    padding: 0px 4%;
  }
}

@media(max-width:600px) {
  .margin-teste {
    margin-left: 8px
  }

  .tirar-div {
    display: block;
  }

  .pulse2 {
    width: 2px;
    height: 2px;
    margin-left: 15px;
    bottom: 0;
  }

  @media(max-width:500px) {
    .texto-indique {
      font-size: 12px;
      padding-top: 5px;
    }
  }

}

@media (max-width:376px) {
  .login-register-100vh {
    height: calc(auto);
    border-radius: 0px;
    max-width: 1000px;
    width: 100%;
  }

  .login-register-100vh2 {
    height: 100vh;
    border-radius: 0px;
    max-width: 1000px;
    width: 100%;
  }
}

.IU5SJ {
  background: linear-gradient(90deg, var(--topbar-color1), var(--topbar-color2) 50%, var(--topbar-color3));
}

.IU5SJ {
  align-items: center;
  display: flex;
  gap: .75rem;
  justify-content: center;
  text-align: center;
  line-height: .75rem;
  padding: .60rem 2rem .60rem .5rem;
  font-size: .875rem;
  width: 100%;
  --tw-text-opacity: 1;
  color: rgb(255 255 255 / var(--tw-text-opacity, 1));
}

@media (max-width: 360px) {
  .IU5SJ span {
    font-size: .58rem;
    padding: .55rem 2rem .55rem .5rem;
  }
}

@media (max-width: 380px) {
  .IU5SJ span {
    font-size: .62rem;
    padding: .55rem 2rem .55rem .5rem;
  }
}

@media (max-width: 395px) {
  .IU5SJ span {
    font-size: .68rem;
  }
}

@media (max-width: 768px) {
  .nav-indexx {
    z-index: 999;
  }

  @media (max-width: 768px) {
    .nav-ind {
      z-index: 999;
    }
  }
}

.cMU8g .rClOu .dHdm7 {
  height: 7rem;
  margin-left: auto;
  margin-right: auto;
  width: 7rem;
}

.cMU8g .rClOu {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  position: relative;
  width: 100%;
}

/* Título */
.cMU8g .rClOu .h2bsN {
  font-size: 1.5rem;
  font-weight: 600;
  letter-spacing: -.025em;
  line-height: 2rem;
  margin-bottom: 1rem;
  color: #fff;
  /* cor branca */
}

/* Botão “Continuar” (primário) */
.cMU8g .rClOu .hQlUG {
  border-radius: .5rem;
  gap: .5rem;
  height: 50px;
  width: 100%;
  background-color: var(--ci-primary-color);
  /* amarelo */
  color: #191b32;
  /* texto escuro */
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Botão “Sim, quero cancelar” (secundário) */
.cMU8g .rClOu .PLsB5 {
  color: #ffffffb3;
  /* branco com 70% de opacidade */
  cursor: pointer;
  font-size: .875rem;
  gap: .25rem;
  line-height: 1.25rem;
  display: flex;
  align-items: center;
}

/* Garantir que links e botões recebam foco/outline padrão */
a,
button {
  opacity: 1;
  outline: 2px solid transparent;
  outline-offset: 2px;
}

/* Responsividade do título (quando a tela for ≥ 768 px) */
@media (min-width: 768px) {
  .cMU8g .rClOu .h2bsN {
    font-size: 1.5rem;
    line-height: 2rem;
    margin-bottom: .75rem;
  }
}

.menu-user-dropdown {
    color: var(--ci-gray-over);
    border-radius:0.6rem;
}
.menu-user-dropdown:hover {
    color: var(--ci-gray-over);
    background-color: hsl(from var(--ci-primary-color) h s l / 0.15);
}

</style>
<template>
  <nav v-if="showNavtop" :class="[
    sidebar === true ? 'w-full' : 'w-full',
    hideTopBanner ? 'top-0' : 'top-0'
  ]" class="fixed z-30 navtop-color nav-ind">
    <!--<div v-if="!hideTopBanner" class="fixed top-0 texto-indique-pad" style="background-color:var(--ci-primary-color);height: 45px;width:100%;display: flex;align-items: center;justify-content: center;margin-top: -5px">
        <p class="texto-indique" style="color: black;font-size: 12px;">🔥 Multiplicador de 2000x ativado na casa, APROVEITE! </p>
    </div>-->
    <div v-if="!hideTopBanner" class="IU5SJ"><span>{{ setting.topbar_text }}</span>
    </div>
    <div class="px-3 lg:px-5 lg:pl-3 nav-menu relative py-1">

      <div class="absolute top-0 left-5 block lg:block">
        <div class="flex items-center justify-center h-full" style="align-items: center;">
          <div
            class="flex-row w-[100%] cursor-pointer items-center px-2 py-3 border-primary flex justify-center tirar-esporte"
            style="border-bottom: 3px solid;margin-left: 10px;margin-top:10px;padding-left: 10px;padding-right: 10px;padding-bottom: 1em;">
            <svg height="1em" viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M220.7 7.468C247.3-7.906 281.4 1.218 296.8 27.85L463.8 317.1C479.1 343.8 470 377.8 443.4 393.2L250.5 504.5C223.9 519.9 189.9 510.8 174.5 484.2L7.468 194.9C-7.906 168.2 1.218 134.2 27.85 118.8L220.7 7.468zM143.8 277.3C136.9 303.2 152.3 329.1 178.3 336.9C204.3 343.9 230.1 328.5 237.9 302.5L240.3 293.6C240.4 293.3 240.5 292.9 240.6 292.5L258.4 323.2L246.3 330.2C239.6 334 237.4 342.5 241.2 349.2C245.1 355.9 253.6 358.1 260.2 354.3L308.4 326.5C315.1 322.6 317.4 314.1 313.5 307.4C309.7 300.8 301.2 298.5 294.5 302.3L282.5 309.3L264.7 278.6C265.1 278.7 265.5 278.8 265.9 278.9L274.7 281.2C300.7 288.2 327.4 272.8 334.4 246.8C341.3 220.8 325.9 194.1 299.9 187.1L196.1 159.6C185.8 156.6 174.4 163.2 171.4 174.3L143.8 277.3z"
                fill="currentColor"></path>
              <path
                d="M324.1 499L459.4 420.9C501.3 396.7 515.7 343.1 491.5 301.1L354.7 64.25C356.5 64.08 358.2 64 360 64H584C614.9 64 640 89.07 640 120V456C640 486.9 614.9 512 584 512H360C346.4 512 333.8 507.1 324.1 499V499zM579.8 135.7C565.8 123.9 545.3 126.2 532.9 138.9L528.1 144.2L523.1 138.9C510.6 126.2 489.9 123.9 476.4 135.7C460.7 149.2 459.9 173.1 473.9 187.6L522.4 237.6C525.4 240.8 530.6 240.8 533.9 237.6L582 187.6C596 173.1 595.3 149.2 579.8 135.7H579.8z"
                fill="currentColor" opacity="0.4"></path>
            </svg>
            <p class="text-[16px] font-bold" style="font-size: .875rem;font-weight: 700;padding-left: 8px;color: white">
              CASSINO</p>
          </div>
          <div class="flex-row w-[100%] items-center px-2 py-3 gap-2 flex justify-center texto-esportes tirar-esporte">
            <a v-if="custom.esportes" :href="custom.esportes" style="display: flex;align-items: center">
              <svg height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M355.5 45.53L342.4 14.98c-27.95-9.983-57.18-14.98-86.42-14.98c-29.25 0-58.51 4.992-86.46 14.97L156.5 45.53l99.5 55.13L355.5 45.53zM86.78 96.15L53.67 99.09c-34.79 44.75-53.67 99.8-53.67 156.5L.0001 256c0 2.694 .0519 5.379 .1352 8.063l24.95 21.76l83.2-77.67L86.78 96.15zM318.8 336L357.3 217.4L255.1 144L154.7 217.4l38.82 118.6L318.8 336zM512 255.6c0-56.7-18.9-111.8-53.72-156.5L425.6 96.16L403.7 208.2l83.21 77.67l24.92-21.79C511.1 260.1 512 258.1 512 255.6zM51.77 367.7l-7.39 32.46c33.48 49.11 82.96 85.07 140 101.7l28.6-16.99l-48.19-103.3L51.77 367.7zM347.2 381.5l-48.19 103.3l28.57 17c57.05-16.66 106.5-52.62 140-101.7l-7.38-32.46L347.2 381.5z"
                  fill="currentColor"></path>
                <path
                  d="M458.3 99.08L458.3 99.08L458.3 99.08zM511.8 264c-1.442 48.66-16.82 95.87-44.28 136.1l-7.38-32.46l-113 13.86l-48.19 103.3l28.22 16.84c-23.48 6.78-47.67 10.2-71.85 10.2c-23.76 0-47.51-3.302-70.58-9.962l28.23-17.06l-48.19-103.3l-113-13.88l-7.39 32.46c-27.45-40.19-42.8-87.41-44.25-136.1l24.95 21.76l83.2-77.67L86.78 96.15L53.67 99.09c29.72-38.29 69.67-67.37 115.2-83.88l.3613 .2684L156.5 45.53l99.5 55.13l99.5-55.13L342.4 14.98c45.82 16.48 86 45.64 115.9 84.11L425.6 96.16L403.7 208.2l83.21 77.67L511.8 264zM357.3 217.4L255.1 144L154.7 217.4l38.82 118.6L318.8 336L357.3 217.4z"
                  fill="currentColor" opacity="0.4"></path>
              </svg>
              <p class="text-[16px] font-bold" style="font-size: .875rem;font-weight: 700;padding-left: 8px;"> ESPORTES
              </p>
            </a>



            <div v-else style="margin-top: -5px;margin-bottom:-5px;"
              class="flex-row w-[100%] items-center px-2 flex justify-center texto-esportes tirar-esporte cursor-not-allowed">
              <a class="cursor-not-allowed" style="display: flex;align-items: center">
                <svg style="margin-top: -3px;" height="1em" viewBox="0 0 448 512" width="1em"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M384 192C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H384zM256 320C256 302.3 241.7 288 224 288C206.3 288 192 302.3 192 320V384C192 401.7 206.3 416 224 416C241.7 416 256 401.7 256 384V320z"
                    fill="currentColor"></path>
                  <path
                    d="M224 64C179.8 64 144 99.82 144 144V192H80V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H304V144C304 99.82 268.2 64 224 64z"
                    fill="currentColor" opacity="0.4"></path>
                </svg>
                <p class="text-[16px] font-bold" style="font-size: .875rem;font-weight: 700;padding-left: 8px;">
                  ESPORTES</p>
              </a>
            </div>

          </div>
        </div>
      </div>


      <div :class="[
        sidebar === true ? 'lg:ml-[245px]' : 'lg:ml-[280px]',
      ]">
        <div class="mx-auto w-full" style="max-width: 1110px">
          <div class="flex items-center justify-between" style="align-items: center">
            <div class="flex items-center justify-start" style="align-items: center">
              <button id="open-side-nav" @click.prevent="toggleMenu" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg" style="margin: 0 auto ">
                <span class="sr-only">Open sidebar</span>
                <!-- <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                                </svg> -->
                <svg height="22px" viewBox="0 0 448 512" width="22px" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"
                    fill="#fff"></path>
                </svg>
              </button>

              <a v-if="setting" href="/" class="flex md:ml-2 ml:1 md:mr-24 align-items">
                <img v-if="isDark" :src="`/storage/` + setting.software_logo_white" alt="Logo escura"
                  style="max-width: 160px;" class="logomobile h-12 imagem-logo opacidade-hover" />
                <img v-else :src="`/storage/` + setting.software_logo_black" alt="Logo clara" style="max-width: 160px;"
                  class="logomobile h-12 imagem-logo opacidade-hover" />

                <a style="" href="">
                  <i style="transform: scale(0.9);" class="fa-duotone fa-gift fa-shake a-gift opacidade-hover"></i>
                </a>
                <div>

                </div>
              </a>
            </div>

            <div v-if="!simple" class="flex items-center md:py-2" style="max-height: 54px">

              <div v-if="!isAuthenticated" class="flex items-center md:py-1 py-2 ml-5" style="max-height: 54px">
                <div class="relative flex items-center" style="margin-top: -10px;">
                  <div data-v-4265f672="" class="aaDu6 flex items-center "
                    style="border-radius: 30px;position: absolute;top: 20%;right: 0;background-color: #FFE800;margin-top: -7px;z-index: 2;padding-left: 3px;padding-right: 3px">
                    <img data-v-4265f672="" style="width: 15px;"
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAAnCAYAAACMo1E1AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAatSURBVHja7Zh7UFRVHMf5pyRLNERx8ZGBq4hoPkZUTIUERQJkEyFzJs3XpJCPSTNHbTCb0WawzHEGUUhAHmKgItgCymN5yIKPFYQUDNBCJRGEhX2wmL/6nulcucjD3RrzD8/MZ+7evXvP/Zzf4yyL2cvxf4ymlJljDOokmUFTOf2R5qL0TnH+Ky+MnC7VMkVX6EMGtZLatVcft2vL7mpbkgc8dxFDY+Gyds2FMBx5hLQ5VtmaRAvSNZwgQ7OcgQg+V7EbGT42TVW7qK057zEi9Ej/qwoRalU5JraeH0j6e19SW0MEA2nubh4s6l+nXhMmt9UrSqLaim+Etl8t3wPqLjhTQ2mgurVoZ7Lu0q6zrcVbG9rqj9VqVFLS3wpC9BiIbOf5sBBEnS/OUFu5yWS5+wFbldqYdDJcui7QmLWeGjKChXN9bAy1pC3V6ar9CbQ1nSL28NsqBV8QJCDbpk6t4mnX1O43aEs2UkvhmkMm1edv81c8Um/aR/rMi09kioqZYHtNCc7ZNe3OHdSc5U668kX/pFTJrreXVgO8hhDEmRQTKgkxoImajlsTut0osVKPDW9ed/2QIKitOMyiAXRVCsLErQXrSP97HIOdR/tCDnXHRJA2XEN0IAvwvr4uTQ0wJ+Z4mOBQaXTUrrkFuUDul1UL6UHFctQRE0FDIEp1e6yperMF/RFqCxABRn1EP0JzqBX2OMdr3I/7WNTUd8IIQAzlgCYzWg6RK30voKVkuyfdynOiihQHJnPvM6lA3RfWAKJMsCFhKjWneCKCEMP7LHJlSVIRmItnAw1iUs1dniaLvrlvLpuszE9Car/tpAk+hKNA88pvCHWJ97UhCew1UozmQAcjyuWxDoyyv+XB3WBXerh6MTVu82av7//0bqxJcuWRc9jEqkmOdNctkFrDk5kEIzSRnaOjdSdzSCcvJH1qPkQRQRbNG2v6IOJCVJti1uFedo8+XcloPhmhMHrfK5n1gQpyl0NHkWrkDKpylCEymJihT8iCFITwEHQuBCGNyEAIYhBkKdZcPY3P4j4c2efbcq6wo16uPGaUIBriWvIMyt9lR4X2rnTZcR7VzlqBlQtSAEJ4AMA55LCIRn8vwqZ9+7gVYE2BbsdCuBiHLexUQSU2/l7Foj2d7Uq9ZcTkPn0iV2nvSfW+G6hp71GklKeVg3NcQy3ic2gcdCuAHDoVEYSMCAhjkVyw163kir8nk0vyk1C2vQvkAFIMIIpUdwmugZtz7HiHCqDJkAGAOu7Mvfc/P9GjXMaMwCDsceiuSGcLSrGZQLmOHiyCmTZOlCOZS3k2Hr2i9BhNRTHTnxDnQlj0heFe3YJG7FHuksuSbapALzZh+ERLkg+yF+QyhrlT9lAZQzHMjx9F8PdRElyKkzNBRrm2H3fLFae1Hj3KFc32z8QGjIl/HPk65JBaADmRUM7wgC7JlnhS/v7xglRhnBspv5/PBBR2Kxm50jUiCsauquEOvcph8oj+lkglE0sb5UZZ1r5cqkfw+dzImZBiKOMXUG6gj0gmzz5QhHLy+gPPJIdVcjk8iMtlShZBsEfSB88j+azRiJggBnLdPkLERHIKh01UMGnL/aI53+7A12avcqg5yGGP43KoOcjhwR1FkGIOxNOtfSihrwOdCXpLFLXCCG+ktMu0Fk3ZHGnUF78ydt5jPCBm4AiIAdQbHg6J7oA87kHURXIFWxd1KYbosSYwZkAuYbkNtpFnljs3REaplu503MGa8o+5cjmeUpFYtnQtxFhKjf4xgwkjF1ohlWh/ADkIdAvEk/o5Y+OGHBfkKe0sBnhKjRu5UbL6+LnWIrmzgzwhwEWeAtdRb/LdjuhULoeUQgxADAjNgG8jo+WyDvt+jQ04Y3wAR5BLs/J6ClxDSlFvmUemQE4QREozRiyjc7arBTmI5Tt9VW1mykjeO/2d+KV2D9OmBRI4O2IJBDhcRgRSimhDjgui6yHWUe78mPVMrsh9334zU8cPqyQS+ezNCsidlHiLRE73d+0M30IgxsHGi4VxOSDIFcwPnWqyHP8jgMt1EEGURCS84cRSmhLyNqUdHAeY3M/OC+jMkMVckMuZntLOe97pyUGN8VZuIhEQ13eyQNRr4wk1CjkOGgMLwcK4IJfLnBr8idl/MeKHysIhByEu0pEj5lLAtp7E3UMFULNHLZwzcT9AFiBlZDp7/8v46IDZFRF9Jz4IMx9Xc9B87MUDr0qjvzOXhu81t90Z0sd2+e6Jw1QRGy3/5ERtGVyDpjJ7EQYWANBE+LHy8t+qL0cP4y+8YDcmAoXhVwAAAABJRU5ErkJggg=="><span
                      data-v-4265f672="" style="color: black;font-size: 8px;font-weight: bold">100%</span></div>
                  <button class="relative px-4 button-register-model opacidade-hover" @click.prevent="registerToggle"
                    style="">
                    Registre-se
                  </button>
                </div>
                <button @click.prevent="loginToggle"
                  class="md:ml-4 ml-2 rounded flex flex-row items-center botao-entrar-mobile px-4 button-login-model opacidade-hover"
                  style="margin-top: -1px;">
                  <svg style="color: var(--ci-primary-color);" data-v-2b009606="" class="mr-2" height="1em"
                    viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M344.7 273.5l-144.1 136c-6.975 6.578-17.2 8.375-26 4.594C165.8 410.3 160.1 401.6 160.1 392V320H32.02C14.33 320 0 305.7 0 288V224c0-17.67 14.33-32 32.02-32h128.1V120c0-9.578 5.707-18.25 14.51-22.05c8.803-3.781 19.03-1.984 26 4.594l144.1 136C354.3 247.6 354.3 264.4 344.7 273.5z"
                      fill="currentColor"></path>
                    <path
                      d="M416 32h-64c-17.67 0-32 14.33-32 32s14.33 32 32 32h64c17.67 0 32 14.33 32 32v256c0 17.67-14.33 32-32 32h-64c-17.67 0-32 14.33-32 32s14.33 32 32 32h64c53.02 0 96-42.98 96-96V128C512 74.98 469 32 416 32z"
                      fill="currentColor" opacity="0.4"></path>
                  </svg>
                  <span style="color: var(--ci-primary-color);">Entrar</span>
                </button>
              </div>


              <div v-if="isAuthenticated" class="flex items-center ">
                <!--<DropdownDarkLight />-->
                <MakeDeposit :showMobile="false" :title="$t('Depositar')" />
                <WalletBalance />

                <!--<LanguageSelector />-->


                <div class="flex items-center ml-3 margin-teste" style="margin-top: -10px;">
                  <div>
                    <button style="color: var(--ci-primary-color)" type="button"
                      class="flex text-sm bg-[white] rounded-full" aria-expanded="false"
                      data-dropdown-toggle="dropdown-user2">
                      <span class="sr-only">Open user menu</span>
                      <img style="width: 25px;" src="https://i.ibb.co/18WcWXy/user.png" alt="">
                    </button>



                  </div>
                  <div class="z-50 hidden text-left list-none rounded shadow p-2" id="dropdown-user2"
                    style="background-color: whitesmoke; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">

                    <div class="" style="background-color: #323637;border-radius: 8px;">
                      <div class="p-2">
                        <div class="flex items-center">
                          <div>
                            <div class="flex items-center" style="margin-top: -15px;">
                              <input style="font-weight: bold;font-size: 12px;width: 100%;" @change.prevent="updateName"
                                v-model="profileName" type="text" :readonly="true"
                                class=" bg-transparent border-none text-center" :placeholder="profileName">
                              <button disabled="{true}">
                                <svg style="margin-top: -10px;" height="12px" viewBox="0 0 512 512" width="12px"
                                  xmlns="http://www.w3.org/2000/svg" class="_1ou3z opacidade-hover" role="none">
                                  <path
                                    d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"
                                    fill="var(--ci-primary-color)" role="none"></path>
                                </svg>
                              </button>

                            </div>

                            <div class="flex items-center" style="margin-top: -20px;">
                              <div>
                                <input ref="fileInput" type="file" style="display: none;" @change="handleFileChange">
                                <button style="margin-right: -30px;margin-bottom: -10px;" @click="openFileInput"
                                  type="button" class="">
                                  <img
                                    style="width: 63px;max-width: 63px;border-radius: 50%;height: 60px;max-height: 60px;border: 2px solid var(--ci-primary-color);"
                                    class="rounded-full opacidade-hover"
                                    :src="userData?.avatar ? '/storage/' + userData.avatar : `https://i.imgur.com/HgiEtYX.jpeg`"
                                    alt="">
                                </button>
                              </div>

                              <div v-if="!isLoading && currentLevel"
                                style="background-color: #232626;color:white;border-radius: 5px;padding: 2.5%;position: absolute;right: 8%;display: flex;flex-direction: column;margin-bottom: -5px">
                                <p
                                  style="position: absolute;top:0;left:25%;font-size: 10px;opacity: .5;padding-bottom: 3px">
                                  Nível atual:
                                </p>
                                <div class="flex items-center">
                                  <img style="width: 30px;height: 30px" :src="`/storage/${currentLevel.bet_symbol}`"
                                    :alt="currentLevel.vip_name" class="h-16">
                                  <div class="flex flex-col">
                                    <div class="flex items-center">
                                      <strong style="padding-right: 3px;">{{ currentLevel.vip_name }}</strong>
                                      <p style="opacity: .5;font-size: 10px;margin-bottom: -5px">
                                        Nível {{ currentLevel.bet_level }}
                                      </p>
                                    </div>
                                  </div>
                                </div>
                                <RouterLink :to="{ name: 'vipPage' }">
                                  <div class="flex items-center gap-2 justify-center opacidade-hover mt-2"
                                    style="background-color: #393C3C;border-radius: 3px;align-items: center;">
                                    <svg style="color: var(--ci-primary-color);font-size: 10px;" fill="currentColor"
                                      height="1em" stroke="currentColor" viewBox="0 0 140.599 140.599" width="1em"
                                      xmlns="http://www.w3.org/2000/svg" role="none">
                                      <!-- SVG path content -->
                                    </svg>
                                    <p style="color: white;font-size: 10px;">Ver níveis</p>
                                  </div>
                                </RouterLink>
                              </div>


                            </div>
                            <div style="background-color: #393C3C;text-align: center" v-if="profileUser != null">


                              <p style="font-size: 10px;font-weight: bold;color: #777979;text-align: center">Conta
                                Criada {{ profileUser.dateHumanReadable }}</p>
                            </div>
                          </div>
                          <div>

                          </div>
                        </div>
                      </div>

                    </div>


                    <ul class="py-1 px-2 mt-3" role="none">
                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'profileWallet' }"
                          class="flex items-center block px-4 py-2 text-sm">
                          <span class="">
                            <i class="fa-duotone fa-wallet pr-3"></i>
                          </span>
                          <p style="font-weight: bold"> Carteira</p>
                        </RouterLink>
                      </li>
                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'dailyRoulette' }"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-3">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" width="16px" height="16px" version="1.1" id="Icons" viewBox="0 0 32 32" xml:space="preserve">
<style type="text/css">
	.st0{stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
</style>
<path d="M29.9,10.3C29.9,10.3,29.9,10.3,29.9,10.3C29.9,10.3,29.9,10.2,29.9,10.3c-0.8-1.9-1.9-3.5-3.2-4.9c0,0,0,0,0,0c0,0,0,0,0,0  c-1.4-1.4-3-2.5-4.8-3.2c0,0,0,0,0,0c0,0,0,0,0,0C20,1.4,18,1,16,1s-4,0.4-5.7,1.1c0,0,0,0,0,0c0,0,0,0,0,0C8.4,2.9,6.8,4,5.4,5.4  c0,0,0,0,0,0c0,0,0,0,0,0c-1.4,1.4-2.5,3-3.2,4.8c0,0,0,0,0,0c0,0,0,0,0,0C1.4,12.1,1,14,1,16s0.4,3.9,1.1,5.7c0,0,0,0,0,0  c0,0,0,0,0,0c0.8,1.8,1.9,3.4,3.2,4.8c0,0,0,0,0,0c0,0,0,0,0,0c1.4,1.4,3,2.5,4.8,3.2c0,0,0,0,0,0c0,0,0,0,0,0C12,30.6,14,31,16,31  c2,0,4-0.4,5.7-1.1c0,0,0,0,0,0c0,0,0,0,0,0c1.8-0.8,3.4-1.9,4.8-3.2c0,0,0,0,0,0c0,0,0,0,0,0c1.4-1.4,2.5-3,3.2-4.8c0,0,0,0,0,0  c0,0,0,0,0,0C30.6,19.9,31,18,31,16S30.6,12.1,29.9,10.3z M27.6,10.1l-2.8,1.1c-0.3-0.6-0.7-1.1-1.1-1.6l2.1-2.1  C26.5,8.3,27.1,9.2,27.6,10.1z M21.9,4.4c0.9,0.5,1.8,1,2.6,1.7l-2.1,2.1c-0.5-0.4-1-0.8-1.6-1.1L21.9,4.4z M17,3.1  c1.1,0.1,2.1,0.3,3,0.6l-1.2,2.8c-0.6-0.2-1.2-0.3-1.9-0.4V3.1z M15,3.1v3c-0.6,0.1-1.3,0.2-1.9,0.4L12,3.6  C12.9,3.3,13.9,3.1,15,3.1z M10.1,4.4l1.1,2.8c-0.6,0.3-1.1,0.7-1.6,1.1L7.6,6.1C8.3,5.5,9.2,4.9,10.1,4.4z M6.1,7.6l2.1,2.1  c-0.4,0.5-0.8,1-1.1,1.6l-2.8-1.1C4.9,9.2,5.5,8.3,6.1,7.6z M3.6,12l2.8,1.2c-0.2,0.6-0.3,1.2-0.4,1.9h-3C3.1,13.9,3.3,12.9,3.6,12z   M3.1,17h3c0.1,0.6,0.2,1.3,0.4,1.9L3.6,20C3.3,19.1,3.1,18.1,3.1,17z M4.4,21.9l2.8-1.1c0.3,0.6,0.7,1.1,1.1,1.6l-2.1,2.1  C5.5,23.7,4.9,22.8,4.4,21.9z M10.1,27.6c-0.9-0.5-1.8-1-2.6-1.7l2.1-2.1c0.5,0.4,1,0.8,1.6,1.1L10.1,27.6z M15,28.9  c-1.1-0.1-2.1-0.3-3-0.6l1.2-2.8c0.6,0.2,1.2,0.3,1.9,0.4V28.9z M14,21c0-0.7,0.4-1.4,1-1.7v-1.6c-0.3-0.2-0.5-0.4-0.7-0.7h-1.6  c-0.3,0.6-1,1-1.7,1c-1.1,0-2-0.9-2-2s0.9-2,2-2c0.7,0,1.4,0.4,1.7,1h1.6c0.2-0.3,0.4-0.5,0.7-0.7v-1.6c-0.6-0.3-1-1-1-1.7  c0-1.1,0.9-2,2-2s2,0.9,2,2c0,0.7-0.4,1.4-1,1.7v1.6c0.3,0.2,0.5,0.4,0.7,0.7h1.6c0.3-0.6,1-1,1.7-1c1.1,0,2,0.9,2,2s-0.9,2-2,2  c-0.7,0-1.4-0.4-1.7-1h-1.6c-0.2,0.3-0.4,0.5-0.7,0.7v1.6c0.6,0.3,1,1,1,1.7c0,1.1-0.9,2-2,2S14,22.1,14,21z M17,28.9v-3  c0.6-0.1,1.3-0.2,1.9-0.4l1.2,2.8C19.1,28.7,18.1,28.9,17,28.9z M21.9,27.6l-1.1-2.8c0.6-0.3,1.1-0.7,1.6-1.1l2.1,2.1  C23.7,26.5,22.8,27.1,21.9,27.6z M25.9,24.4l-2.1-2.1c0.4-0.5,0.8-1,1.1-1.6l2.8,1.1C27.1,22.8,26.5,23.7,25.9,24.4z M28.4,20  l-2.8-1.2c0.2-0.6,0.3-1.2,0.4-1.9h3C28.9,18.1,28.7,19.1,28.4,20z M25.9,15c-0.1-0.6-0.2-1.3-0.4-1.9l2.8-1.2c0.3,1,0.5,2,0.6,3  H25.9z"/>
</svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Roleta Diária') }}</p>
                        </RouterLink>
                      </li>

                      
                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'awardsPage' }"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-3">
							<svg height="15px" width="15px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="currentColor">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> 
                                <g> <path class="st0" d="M497.679,53.348c-9.285-10.52-22.496-16.551-36.246-16.551h-47.01c-2.358-33.432-25.059-28.785-33.9-28.785 c-9.33,0-124.522,0-124.522,0s-115.191,0-124.521,0c-8.842,0-31.547-4.646-33.904,28.785h-47.01 c-13.748,0-26.959,6.033-36.246,16.551C3.064,66.1-1.793,84.503,0.594,105.255c0.442,9.219,5.098,56.574,54.09,90.256 c24.898,17.117,48.828,25.844,70.598,30.285c4.771,1.031,9.598,1.957,14.545,2.68c0.068,0.076,0.135,0.154,0.205,0.229 c101.859,107.191,89.42,45.18,89.42,143.435c0,38.092-52.771,25.762-52.771,55c0,29.236-41.129,5.174-37.322,39.863 c2.332,21.264,65.318,37.205,116.644,37.205c51.322,0,114.312-15.942,116.644-37.205c3.805-34.689-37.326-10.627-37.326-39.863 c0-29.238-52.768-16.908-52.768-55c0-98.256-12.44-36.244,89.42-143.435c0.14-0.149,0.27-0.307,0.41-0.457 c25.365-3.285,54.457-11.779,84.938-32.736c48.988-33.682,53.644-81.037,54.086-90.256 C513.794,84.503,508.935,66.098,497.679,53.348z M471.214,101.165l-0.184,0.992l0.025,1.353 c-0.096,2.625-2.006,34.916-36.621,58.715c-9.467,6.51-18.627,11.444-27.535,15.276c-2.014,0.816-4.024,1.633-6.084,2.344 c12.162-34.25,14.137-72.558,14.172-102.654h46.445c1.558,0,3.857,0.502,5.965,2.888C470.99,84.149,472.382,91.833,471.214,101.165 z M227.514,204.143c-3.805,4.799-9.436,7.299-15.117,7.299c-4.198,0-8.424-1.363-11.967-4.174 c-48.381-38.371-52.434-91.045-52.434-137.404c0-10.646,8.633-19.277,19.279-19.277c10.646,0,19.277,8.631,19.277,19.277 c0,40.676,2.895,79.482,37.836,107.195C232.73,183.676,234.129,195.802,227.514,204.143z M77.566,162.225 c-34.584-23.777-36.524-56.029-36.623-58.707l0.022-0.92l-0.18-1.434c-1.168-9.33,0.224-17.016,3.818-21.086 c2.108-2.386,4.406-2.888,5.963-2.888h46.445c0.031,25.693,1.533,57.357,9.52,87.386c1.332,5.178,2.808,10.326,4.543,15.385 C100.31,175.89,89.16,170.196,77.566,162.225z">
                                  </path> 
                                </g> 
                              </g>
                            </svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Missões') }}</p>
                        </RouterLink>
                      </li>

                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'vipPage' }"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-1">
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20px" height="20px" viewBox="-4 0 32 32" version="1.1">
<title>crown</title>
<path d="M12 10.938c-1.375 0-2.5-1.125-2.5-2.5 0-1.406 1.125-2.5 2.5-2.5s2.5 1.094 2.5 2.5c0 1.375-1.125 2.5-2.5 2.5zM2.031 9.906c1.094 0 1.969 0.906 1.969 2 0 1.125-0.875 2-1.969 2-1.125 0-2.031-0.875-2.031-2 0-1.094 0.906-2 2.031-2zM22.031 9.906c1.094 0 1.969 0.906 1.969 2 0 1.125-0.875 2-1.969 2-1.125 0-2.031-0.875-2.031-2 0-1.094 0.906-2 2.031-2zM4.219 23.719l-1.656-9.063c0.5-0.094 0.969-0.375 1.344-0.688 1.031 0.938 2.344 1.844 3.594 1.844 1.5 0 2.719-2.313 3.563-4.25 0.281 0.094 0.625 0.188 0.938 0.188s0.656-0.094 0.938-0.188c0.844 1.938 2.063 4.25 3.563 4.25 1.25 0 2.563-0.906 3.594-1.844 0.375 0.313 0.844 0.594 1.344 0.688l-1.656 9.063h-15.563zM3.875 24.5h16.25v1.531h-16.25v-1.531z"/>
</svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Clube VIP') }}</p>
                        </RouterLink>
                      </li>


                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'profilePage' }"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-1">
							<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier"> 
                                <path opacity="0.5" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="currentColor"></path> 
                                <path d="M16.807 19.0112C15.4398 19.9504 13.7841 20.5 12 20.5C10.2159 20.5 8.56023 19.9503 7.193 19.0111C6.58915 18.5963 6.33109 17.8062 6.68219 17.1632C7.41001 15.8302 8.90973 15 12 15C15.0903 15 16.59 15.8303 17.3178 17.1632C17.6689 17.8062 17.4108 18.5964 16.807 19.0112Z" fill="currentColor"></path> 
                                <path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3432 6 9.00004 7.34315 9.00004 9C9.00004 10.6569 10.3432 12 12 12Z" fill="currentColor"></path> 
                              </g>
                            </svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Dados da conta') }}</p>
                        </RouterLink>
                      </li>

                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'profileTransactions' }"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-1">
<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 -16.04 72.617 72.617">
  <g id="Group_58" data-name="Group 58" transform="translate(-621.208 -934.226)">
    <g id="Group_57" data-name="Group 57">
      <path id="Path_48" data-name="Path 48" d="M688.461,944.951a191.915,191.915,0,0,0-11.136-10.725h-50.3a5.823,5.823,0,0,0-5.817,5.816v18.223A192.8,192.8,0,0,0,631.935,969.4a6.063,6.063,0,0,0,6.014,5.364h49.819a6.064,6.064,0,0,0,6.057-6.057V950.965A6.063,6.063,0,0,0,688.461,944.951Zm-64.253,13.314V940.042a2.82,2.82,0,0,1,2.817-2.816h50.3a2.815,2.815,0,0,1,2.769,2.341H632.367a5.824,5.824,0,0,0-5.817,5.817v15.649A2.816,2.816,0,0,1,624.208,958.265Zm5.342,5.341V945.384a2.821,2.821,0,0,1,2.817-2.817h50.3a2.816,2.816,0,0,1,2.769,2.341H637.949a6.064,6.064,0,0,0-6.057,6.057v15.41A2.815,2.815,0,0,1,629.55,963.606Zm61.275,5.1a3.061,3.061,0,0,1-3.057,3.057H637.949a3.06,3.06,0,0,1-3.057-3.057V950.965a3.06,3.06,0,0,1,3.057-3.057h49.819a3.061,3.061,0,0,1,3.057,3.057Z" fill="#0c2b67"/>
      <path id="Path_49" data-name="Path 49" d="M662.858,950c-4.952,0-8.981,4.411-8.981,9.834s4.029,9.833,8.981,9.833,8.981-4.411,8.981-9.833S667.81,950,662.858,950Zm0,16.667c-3.3,0-5.981-3.066-5.981-6.833S659.56,953,662.858,953s5.981,3.065,5.981,6.834S666.156,966.67,662.858,966.67Z" fill="#0c2b67"/>
      <path id="Path_50" data-name="Path 50" d="M681.352,954.732a5.1,5.1,0,1,0,5.1,5.1A5.111,5.111,0,0,0,681.352,954.732Zm0,7.208a2.1,2.1,0,1,1,2.1-2.1A2.107,2.107,0,0,1,681.352,961.94Z" fill="#0c2b67"/>
      <path id="Path_51" data-name="Path 51" d="M644.717,954.732a5.1,5.1,0,1,0,5.1,5.1A5.11,5.11,0,0,0,644.717,954.732Zm0,7.208a2.1,2.1,0,1,1,2.1-2.1A2.1,2.1,0,0,1,644.717,961.94Z" fill="#0c2b67"/>
    </g>
    <path id="Path_52" data-name="Path 52" d="M662.531,962.846c-1.6-.11-2.423-.94-2.478-2.184h1.833a.8.8,0,0,0,.645.784v-1.2c-1.686-.23-2.349-.811-2.349-2.1,0-1.151.884-1.962,2.349-2.063v-.82h.746v.829c1.373.11,2.193.728,2.294,2.027h-1.8a.64.64,0,0,0-.5-.627v1.133c1.428.194,2.386.664,2.386,2.009,0,1.152-.718,2.1-2.386,2.211V964h-.746Zm0-4.321v-1.059c-.378.064-.571.258-.571.525C661.96,958.286,662.107,958.433,662.531,958.525Zm.746,1.852v1.087c.378-.083.553-.295.553-.58C663.83,960.617,663.692,960.478,663.277,960.377Z" fill="#0d2b67"/>
  </g>
</svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Minhas Transações') }}</p>
                        </RouterLink>
                      </li>

                      <li class="opacidade-hover menu-user-dropdown">
                        <RouterLink :to="{ name: 'profileAffiliate' }"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-3">
                            <svg fill="currentColor" height="1em" viewBox="0 0 448 448.5" width="1em"
                              xmlns="http://www.w3.org/2000/svg" active="true" aria-hidden="true" class="I9SFw">
                              <path
                                d="M209,.5c49.67-3.92,87.5,15.08,113.5,57,16.47,33.39,17.8,67.39,4,102-24.64,47.41-63.81,68.91-117.5,64.5-54.17-10.17-86.33-42.33-96.5-96.5-4.41-49.68,14.42-87.51,56.5-113.5,12.72-6.67,26.06-11.17,40-13.5ZM223,40.5c3.06.3,5.56,1.63,7.5,4,1.11,3.59,1.61,7.25,1.5,11,18.12,5.29,25.96,17.29,23.5,36-3.19,3.5-6.69,3.84-10.5,1-2.17-5.61-4.33-11.27-6.5-17-9.67-9.33-19.33-9.33-29,0-6.61,12.48-3.78,21.98,8.5,28.5,18.14-.2,30.64,7.97,37.5,24.5,3.59,14.9-.58,27.07-12.5,36.5-3.23,2.57-6.89,4.07-11,4.5.32,4.25-.51,8.25-2.5,12-3.67,2.67-7.33,2.67-11,0-1.99-3.75-2.82-7.75-2.5-12-18.12-5.29-25.96-17.29-23.5-36,3.19-3.51,6.69-3.84,10.5-1,2.17,5.6,4.34,11.27,6.5,17,8.15,8.16,16.99,9,26.5,2.5,8-9.33,8-18.67,0-28-6.26-3.16-12.92-4.82-20-5-18.1-6.03-26.26-18.53-24.5-37.5,2.57-14.07,10.74-22.73,24.5-26-.11-3.75.39-7.41,1.5-11,1.5-1.97,3.33-3.3,5.5-4Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path>
                              <path
                                d="M246,239.5c2.43.02,4.76.52,7,1.5l26.5,26.5c.67,3,.67,6,0,9-9.53,9.86-19.36,19.36-29.5,28.5-9.91.37-13.07-4.13-9.5-13.5l10.5-10.5c-26.33-.33-52.67-.67-79-1-1.83-.5-3-1.67-3.5-3.5-.67-2.67-.67-5.33,0-8,.5-1.83,1.67-3,3.5-3.5,26.67-.33,53.33-.67,80-1l-11.5-11.5c-1.9-6.16-.07-10.49,5.5-13Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path>
                              <path
                                d="M198,303.5c9.36.52,12.53,5.19,9.5,14l-10.5,10.5c26.33.33,52.67.67,79,1,1.83.5,3,1.67,3.5,3.5.67,2.67.67,5.33,0,8-.5,1.83-1.67,3-3.5,3.5-26.67.33-53.33.67-80,1,3.83,3.83,7.67,7.67,11.5,11.5,1.81,10.53-2.36,14.36-12.5,11.5-8.83-8.83-17.67-17.67-26.5-26.5-.67-3-.67-6,0-9,9.73-9.9,19.56-19.56,29.5-29Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.96;stroke-width:0px;"></path>
                              <path
                                d="M73,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path>
                              <path
                                d="M45,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path>
                              <path
                                d="M353,208.5c34.54-2.91,56.71,12.09,66.5,45,3.4,34.57-11.43,56.73-44.5,66.5-34.59,3.37-56.76-11.47-66.5-44.5-3.19-34.59,11.64-56.92,44.5-67Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.98;stroke-width:0px;"></path>
                              <path
                                d="M325,336.5c26-.17,52,0,78,.5,24.14,5.47,38.97,20.31,44.5,44.5.67,14.33.67,28.67,0,43-3.17,12.5-11,20.33-23.5,23.5-40,.67-80,.67-120,0-12.5-3.17-20.33-11-23.5-23.5-.67-14.33-.67-28.67,0-43,5.68-24.18,20.51-39.18,44.5-45Z"
                                style="fill-rule:evenodd;isolation:isolate;opacity:0.99;stroke-width:0px;"></path>
                            </svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Seja um Afiliado') }}</p>
                        </RouterLink>
                      </li>

                      <li v-if="custom.Suporte" class="opacidade-hover menu-user-dropdown">
                        <a  :href="custom.Suporte"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="pr-3">
                            <svg height="1em" viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg"
                              active="false" aria-hidden="true" class="I9SFw">
                              <path
                                d="M640 191.1v191.1c0 35.25-28.75 63.1-64 63.1h-32v54.24c0 7.998-9.125 12.62-15.5 7.873l-82.75-62.12L319.1 447.1C284.7 447.1 256 419.2 256 383.1v-31.98l96-.002c52.88 0 96-43.12 96-95.99V128h128C611.3 128 640 156.7 640 191.1z"
                                fill="currentColor"></path>
                              <path
                                d="M352 0H64C28.75 0 0 28.75 0 63.1V256C0 291.2 28.75 320 64 320l32 .0098v54.25c0 7.998 9.125 12.62 15.5 7.875l82.75-62.12L352 319.9c35.25 .125 64-28.68 64-63.92V63.1C416 28.75 387.3 0 352 0z"
                                fill="currentColor" opacity="0.4"></path>
                            </svg>
                          </span>
                          <p style="font-weight: bold"> {{ $t('Suporte Ao Vivo') }}</p>
                        </a>
                      </li>



                      <div class=""
                        style="height: 1px;background-color: #27292A;width: 100%;margin-top: 10px;margin-bottom: 10px">
                      </div>

                      <li class="opacidade-hover mb-3 menu-user-dropdown">
                        <a @click.prevent="logoutAccount" href="#"
                          class="flex items-center block px-4 py-2 text-sm"
                          role="menuitem">
                          <span class="">
                            <i class="fa-duotone fa-right-from-bracket pr-3"></i>
                          </span>
                          <p> Sair</p>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Barra de Natal Animada

  <div class="christmas-bar w-full h-2 shadow-md"></div>
 <div class="pascoa-bar w-full h-2 shadow-md"></div> -->
    </div>
    

  </nav>
  <div v-if="showModal" class="modal-overlay" @click="closeModal" style="z-index: 999;background-color:rgba(0, 0, 0, 0.80);
  backdrop-filter: none;height: 100vh;">
    <div class="modal-content" @click.stop style="background-color: var(--carousel-banners-dark);">


      <div class="relative">
        <div class="flex justify-between items-center">
          <h2 style="font-size: 12px;display: flex;justify-content: start;padding-top: 20px">Nome de usuário</h2>
          <button @click="closeModal" style="border-radius: 3px;font-size: 16px;margin-top: -10px">x</button>
        </div>
        <input style="border: none;outline: none;border-bottom: 1px solid white;border-radius: 0"
          @change.prevent="updateName" v-model="profileName" type="text"
          class=" appearance-none border border-gray-300 rounded-md p-2 bg-transparent border-none text-center"
          :placeholder="profileName">

      </div>

      <button @click="closeModal"
        style="background-color: #008000;border-radius: 3px;font-size: 12px;padding: 1px 8px;">Ok</button>
    </div>
  </div>

  <div style="z-index: 9999;background-color:rgba(0, 0, 0, 0.80);
  backdrop-filter: none;height: 100vh;" id="modalElAuth" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 hidden w-full overflow-x-hidden overflow-y-auto  h-screen md:h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-3xl max-h-full rounded-lg" style="border-radius: 5px;">
      <div class="flex md:justify-between">


      </div>
      <div class="w-full login-register-100vh2" style="position: relative">

        <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 20px;width: 100%;">
          <a v-if="setting" class="w-full"
            style="display: flex;justify-content: center;margin: 0 auto;max-height: 300px;">
            <img :src="`/storage/` + setting.software_logo_black2" alt="" class="block md:rounded-t-lg" />

          </a>

          <a class="login-register-x" @click.prevent="loginToggle" href=""
            style="position: absolute;right: 2%;top: 2%;">
            <div class="x-mark-scale"
              style="box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.50);background-color: var(--carousel-banners-dark);padding: 7px 13px;border-radius: 5px">
              <i style="color: var(--ci-primary-color);font-weight: bold" class="fa-light fa-x"></i>
            </div>
          </a>
        </div>
        <div style="padding: 0 4%;">
          <div class="tirar-div"
            style="display: flex;align-items: center;justify-content: space-between;margin-top: -17px;padding-bottom: 10px;padding: 20px 4%;">
            <div style="display: flex;align-items: center;margin: 0 auto;text-align:center;gap:20px;">
              <p class="text-sm text-gray-500 dark:text-gray-300 tirar-div" style=""><a
                  style="color: var(--ci-primary-color)" href="" @click.prevent=""><strong
                    style="font-weight: 600;font-size: 12px;">Entrar</strong></a></p>

              <p class="text-sm text-gray-500 dark:text-gray-300 tirar-div" style=""><a style="color: white" href=""
                  @click.prevent="hideLoginShowRegisterToggle"><strong
                    style="color: white;font-weight: 600;font-size: 12px;">Registre-se</strong></a></p>

            </div>


            <h5 class="font-bold text-xl"></h5>




          </div>
          <div class="tirar-div" style="height: .5px;background-color: #303334;width: 100%;margin-bottom: 20px;"></div>
          <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 10px">
            <a v-if="setting" class="flex md:ml-2 ml:1 md:mr-24"
              style="display: flex;justify-content: center;margin: 0 auto;">
              <img style="max-width: 100px;" :src="`/storage/` + setting.software_logo_black" alt=""
                class="h-8 block dark:hidden " />
              <img style="max-width: 80px;" :src="`/storage/` + setting.software_logo_white" alt=""
                class="md:max-h-[35px] max-h-[30px] dark:block imagem-logo opacidade-hover" />
            </a>
          </div>


          <div v-if="isLoadingLogin" class="absolute top-0 left-0 right-0 bottom-0 z-[999]"
            style="background-color: rgba(42, 43, 43, 0.9);border-radius: 8px;">
            <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
              <i class="fa-duotone fa-spinner-third fa-spin"
                style="font-size: 45px;--fa-primary-color: var(--ci-primary-color); --fa-secondary-color: #000000;"></i>
              <span class="sr-only">Loading...</span>
            </div>
          </div>

          <form @submit.prevent="loginSubmit" method="post" action="" class="padding-register"
            style="padding-top: 15px;">






            <div class="relative mb-2">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">

              </div>
              <input id="inputField5"
                style="padding: 15px 0px;padding-left: 20px;outline: none;border: none;background-color: var(--input-primary);"
                required type="text" v-model="loginForm.email" name="email" class="input-group" :placeholder="$t('')">
              <label class="label-formularios" for="inputField5">E-mail</label>
            </div>

            <div class="relative mb-3">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">

              </div>
              <input id="inputField6"
                style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" required
                :type="typeInputPassword" v-model="loginForm.password" name="password" class="input-group pr-[40px]"
                :placeholder="$t('')">
              <label class="label-formularios" for="inputField6">Senha</label>
              <button type="button" @click.prevent="togglePassword"
                class="absolute inset-y-0 right-0 flex items-center pr-3.5 ">


                <svg v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash" data-v-9b35dc4c=""
                  height="1em" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256z"
                    fill="currentColor"></path>
                  <path
                    d="M95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400z"
                    fill="currentColor" opacity="0.4"></path>
                </svg>



                <svg v-if="typeInputPassword === 'password'" class="fa-regular fa-eye" data-v-9b35dc4c="" height="1em"
                  viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196V9.196z"
                    fill="currentColor"></path>
                  <path
                    d="M446.6 324.7C457.7 304.3 464 280.9 464 256C464 176.5 399.5 112 320 112C282.7 112 248.6 126.2 223.1 149.5L150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L446.6 324.7zM313.4 220.3C317.6 211.8 320 202.2 320 192C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 160 320 160C373 160 416 202.1 416 256C416 269.7 413.1 282.7 407.1 294.5L313.4 220.3zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 256C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z"
                    fill="currentColor" opacity="0.4"></path>
                </svg>
              </button>
            </div>
            <div style="display: flex;justify-content: flex-end;padding-top: 10px;">
              <a @click="showModal2 = true"
                style="color:var(--ci-primary-color);color: #8D9090;font-size: 12px;margin-top: -15px;font-weight: 500"
                class="text-white text-sm">{{ $t('Esqueceu a senha?') }}</a>

            </div>

            <div v-if="showModal2" class="modal2-overlay" @click.self="showModal = false"
              style="z-index: 999999;background-color:rgba(0, 0, 0, 0.47);">
              <div class="modal2-content login-register-100vh relative"
                style="background-color: var(--carousel-banners-dark);border-radius: 12px;z-index: 999999;">
                <span style="max-width: 40px" @click="showModal2 = false" class="close" href="">
                  <div class="x-mark-scale"
                    style="box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.50);background-color: var(--carousel-banners-dark);padding: 7px;border-radius: 5px;max-width: 40px;position: absolute;right: 0;top: 0;">
                    <i style="color: var(--ci-primary-color);font-weight: bold;" class="fa-light fa-x"></i>
                  </div>
                </span>
                <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 10px">
                  <a v-if="setting" class="flex md:ml-2 ml:1 md:mr-24"
                    style="display: flex;justify-content: center;margin: 0 auto;">
                    <img style="max-width: 100px;" :src="`/storage/` + setting.software_logo_black" alt=""
                      class="h-8 block dark:hidden " />
                    <img style="max-width: 100px;" :src="`/storage/` + setting.software_logo_white" alt=""
                      class="md:max-h-[35px] max-h-[30px] hidden dark:block" />
                  </a>
                </div>


                <div class="mt-4 px-4">
                  <form @submit.prevent="forgotPasswordSubmit" method="post" action="" class="">
                    <div class="relative mb-3">
                      <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fa-regular fa-envelope text-success-emphasis"></i>
                      </div>
                      <input type="email" name="email" v-model="form.email" class="input-group"
                        :placeholder="$t('Enter email or phone')" required>
                    </div>
                    <div class="mt-5 w-full">
                      <button type="submit" class="ui-button-blue rounded w-full mb-3">
                        {{ $t('Reset Password') }}
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <div class=" w-full flex items-center">
              <button
                style="font-size: 17px;color: var(--title-color);font-weight: 600;padding: 12px;width: 100%;margin: 0 auto;margin-top:20px;color: var(--title-color);"
                type="submit" class="ui-button-blue w-full mb-4">
                {{ $t('Log in') }}
              </button>
            </div>
            <div></div>
            <div id="container" class="container flex items-center pt-2">
              <!-- Loading Spinner SVG -->
              <div id="loading" class="spinner">
                <i style="width: 12px;" class="fa-sharp fa-light fa-spinner-third"></i>
              </div>
              <div id="loading-message" class="message">Validando Captcha (T)</div>

              <!-- Check SVG -->
              <div id="check" class="hidden flex items-center">
                <svg width="14" height="14" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10 25l10 10 20-20" stroke="#2ecc71" stroke-width="5" fill="none" />
                </svg>
                <span class="message">Validando Captcha (T)</span>
              </div>
            </div>
            <div class="flex justify-center items-center">
              <div style="height: 0.1rem;background-color: gray;width: 40px;padding-right: 20px;opacity: .3;"></div>
              <span
                style="text-align: center;color: gray;padding: 24px 0;text-transform: uppercase;font-size: 12px;font-weight: 550;margin-left: 20px;margin-right: 20px;">entrar
                usando sua conta:</span>
              <div style="height: 0.1rem;background-color: gray;width: 40px;padding-left: 20px;opacity: .3;"></div>
            </div>
            <div class="flex w-full items-center justify-center gap-4" style="flex: 1">
              <button
                style="border: 0.1rem solid #303334;width: 100%;text-align: center;display: flex;justify-content: center;border-radius: 3px;padding: 10px;"><svg
                  height="1em" viewBox="0 0 488 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"
                    fill="currentColor"></path>
                </svg></button>
              <button
                style="border: 0.1rem solid #303334;width: 100%;text-align: center;display: flex;justify-content: center;border-radius: 3px;padding: 10px;"><svg
                  height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z"
                    fill="currentColor"></path>
                </svg></button>
            </div>
            <p style="text-align: center;padding-top: 20px;padding-bottom: 20px;font-size: 12px;color: white;font-weight: 500;"
              class="text-sm text-gray-500 dark:text-gray-300 mb-6"><a href=""
                @click.prevent="hideLoginShowRegisterToggle">Ainda não tem uma conta? <strong
                  style="color:var(--ci-primary-color);font-weight: 500;">Criar uma conta grátis</strong></a></p>
          </form>
        </div>




      </div>
    </div>
  </div>

  <div style="z-index: 9999; height: 100vh; background-color:rgba(0, 0, 0, 0.80);
  backdrop-filter: none; height: 100vh;" id="modalElRegister" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-screen md:h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-3xl max-h-full">
      <div v-if="isLoadingRegister" class="absolute top-0 left-0 right-0 bottom-0 z-[999]"
        style="background-color: rgba(42, 43, 43, 0.9);border-radius: 12px;">
        <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
          <i class="fa-duotone fa-spinner-third fa-spin"
            style="font-size: 45px;--fa-primary-color: var(--ci-primary-color); --fa-secondary-color: #000000;"></i>
          <span class="sr-only">Loading...</span>
        </div>
      </div>

      <div class="w-full login-register-100vh" style="position: relative">

        <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 20px;width: 100%;">
          <a v-if="setting" class="w-full"
            style="display: flex;justify-content: center;margin: 0 auto;max-height: 300px;">
            <img :src="`/storage/` + setting.software_logo_black2" alt="" class="block md:rounded-t-lg" />

          </a>

          <a class="login-register-x" @click.prevent="hideRegisterShowCupomToggle" href=""
            style="position: absolute;right: 2%;top: 2%;">
            <div class="x-mark-scale"
              style="box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.50);background-color: var(--carousel-banners-dark);padding: 7px 13px;border-radius: 5px">
              <i style="color: var(--ci-primary-color);font-weight: bold" class="fa-light fa-x"></i>
            </div>
          </a>
        </div>
        <div style="padding: 0 4%;">
          <div class="tirar-div"
            style="display: flex;align-items: center;justify-content: space-between;margin-top: -17px;padding-bottom: 10px;padding: 20px 4%;">
            <div style="display: flex;align-items: center;margin: 0 auto;text-align:center;gap:20px;">
              <p class="text-sm text-gray-500 dark:text-gray-300 tirar-div" style=""><a style="color: white;" href=""
                  @click.prevent="hideLoginShowRegisterToggle"><strong
                    style="font-weight: 600;font-size: 12px;">Entrar</strong></a></p>

              <p class="text-sm text-gray-500 dark:text-gray-300 tirar-div" style=""><a style="color: white" href=""
                  @click.prevent=""><strong
                    style="font-weight: 600;font-size: 12px;color: var(--ci-primary-color)">Registre-se</strong></a></p>

            </div>


            <h5 class="font-bold text-xl"></h5>




          </div>
          <div class="tirar-div" style="height: .5px;background-color: #303334;width: 100%;margin-bottom: 20px;"></div>
          <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 10px">
            <a v-if="setting" class="flex md:ml-2 ml:1 md:mr-24"
              style="display: flex;justify-content: center;margin: 0 auto;">
              <img style="max-width: 100px;" :src="`/storage/` + setting.software_logo_black" alt=""
                class="h-8 block dark:hidden " />
              <img style="max-width: 100px;" :src="`/storage/` + setting.software_logo_white" alt=""
                class="md:max-h-[35px] max-h-[30px] hidden dark:block" />
            </a>
          </div>
          <form @submit.prevent="registerSubmit" method="post" action="" class="padding-register">




            <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 20px">
              <a v-if="setting" class="flex md:ml-2 ml:1 md:mr-24 items-center"
                style="display: flex;justify-content: center;margin: 0 auto;">
                <img :src="`/storage/` + setting.software_logo_black2" alt="" class="h-8 block dark:hidden " />
                <img style="max-width: 80px;" :src="`/storage/` + setting.software_logo_white" alt=""
                  class="md:max-h-[35px] max-h-[30px] dark:block imagem-logo opacidade-hover" />
              </a>
            </div>


            <div class="relative mb-2">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">

              </div>
              <input id="inputField"
                style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" type="email"
                name="email" v-model="registerForm.email" class="input-group" :placeholder="$t('')" required>
              <label class="label-formularios" for="inputField">E-mail <span style="color: #984258;">*</span></label>
            </div>

            <div class="relative mb-2">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">

              </div>
              <input id="inputField1"
                style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);"
                :type="typeInputPassword" name="password" v-model="registerForm.password" class="input-group pr-[40px]"
                :placeholder="$t('')" required>
              <label class="label-formularios" for="inputField1">Senha <span style="color: #984258;">*</span></label>
              <button type="button" @click.prevent="togglePassword"
                class="absolute inset-y-0 right-0 flex items-center pr-3.5 ">
                <svg v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash" data-v-9b35dc4c=""
                  height="1em" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256z"
                    fill="currentColor"></path>
                  <path
                    d="M95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400z"
                    fill="currentColor" opacity="0.4"></path>
                </svg>



                <svg v-if="typeInputPassword === 'password'" class="fa-regular fa-eye" data-v-9b35dc4c="" height="1em"
                  viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196V9.196z"
                    fill="currentColor"></path>
                  <path
                    d="M446.6 324.7C457.7 304.3 464 280.9 464 256C464 176.5 399.5 112 320 112C282.7 112 248.6 126.2 223.1 149.5L150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L446.6 324.7zM313.4 220.3C317.6 211.8 320 202.2 320 192C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 160 320 160C373 160 416 202.1 416 256C416 269.7 413.1 282.7 407.1 294.5L313.4 220.3zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 256C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z"
                    fill="currentColor" opacity="0.4"></path>
                </svg>
              </button>
            </div>

            <div class="relative mb-2">

              <input id="inputField2"
                style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" type="text"
                name="cpf" v-maska data-maska="[
                                                    '###.###.###-##',
                                                    '###.###.###-##'
                                                ]" v-model="registerForm.cpf" class="input-group" :placeholder="$t('')"
                required>
              <label class="label-formularios" for="inputField2">CPF <span style="color: #984258;">*</span></label>
            </div>


            <div class="relative mb-2">

              <div class="flex items-center">
                <input id="inputField3"
                  style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);border-bottom-right-radius: 0px;border-top-right-radius: 0px;"
                  type="text" name="phone" v-maska data-maska="[
                                    '(##) ####-####',
                                    '(##) #####-####'
                                  ]" v-model="registerForm.phone" class="input-group" :placeholder="$t('')" required>
                <label class="label-formularios" for="inputField3">Telefone <span
                    style="color: #984258;">*</span></label>
                <div class="flex items-center justify-center"
                  style="padding: 14.5px 15px;background-color: var(--input-primary);border-bottom-right-radius: 8px;border-top-right-radius: 8px;border-left: 0.1rem solid #535455;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.3rem" height="1.3rem" viewBox="0 0 512 512">
                    <mask id="a">
                      <circle cx="256" cy="256" r="256" fill="#fff"></circle>
                    </mask>
                    <g mask="url(#a)">
                      <path fill="#6da544" d="M0 0h512v512H0z"></path>
                      <path fill="#ffda44" d="M256 100.2 467.5 256 256 411.8 44.5 256z"></path>
                      <path fill="#eee"
                        d="M174.2 221a87 87 0 0 0-7.2 36.3l162 49.8a88.5 88.5 0 0 0 14.4-34c-40.6-65.3-119.7-80.3-169.1-52z">
                      </path>
                      <path fill="#0052b4"
                        d="M255.7 167a89 89 0 0 0-41.9 10.6 89 89 0 0 0-39.6 43.4 181.7 181.7 0 0 1 169.1 52.2 89 89 0 0 0-9-59.4 89 89 0 0 0-78.6-46.8zM212 250.5a149 149 0 0 0-45 6.8 89 89 0 0 0 10.5 40.9 89 89 0 0 0 120.6 36.2 89 89 0 0 0 30.7-27.3A151 151 0 0 0 212 250.5z">
                      </path>
                    </g>
                  </svg> <span style="font-size: 14px;padding-left: 5px;">+55</span> </div>
              </div>

            </div>


            <div class="mb-3 mt-5">
              <button @click.prevent="isReferral = !isReferral" type="button" class="flex justify-center w-full">
                <p style="color:white;font-size: 12px">{{ $t('Código de referência') }}</p>
                <div class="">

                </div>
              </button>

              <div v-if="isReferral" class="relative mb-3 mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">

                </div>
                <input style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" type="text"
                  name="name" v-model="registerForm.reference_code" class="input-group" :placeholder="$t('Code')">
              </div>
              <p style="text-align: center;font-size: 10px;color: white;font-weight: lighter;margin-bottom: -14px"
                class="text-sm text-gray-500 dark:text-gray-300 mb-6"><a @click="$router.push('/terms/service')"
                  href="">Ao se registrar <strong style="color:var(--ci-primary-color);font-weight: lighter;">você
                    concorda com nossos termos e condições</strong></a></p>

              <div class="mt-5 w-full flex flex-col items-center">
                <button
                  style="color: var(--carousel-banners-dark);font-size: 17px;font-weight: 600;padding: 12px;width: 100%;margin: 0 auto;"
                  type="submit" class="ui-button-blue w-full mb-3">
                  Criar conta <i class="fa-solid fa-arrow-right"></i>
                </button>
                <div id="container2" class="container">
                  <!-- Loading Spinner SVG -->
                  <div id="loading2" class="spinner">
                    <i style="width: 12px;" class="fa-sharp fa-light fa-spinner-third"></i>
                  </div>
                  <div id="loading-message2" class="message">Validando Captcha (T)</div>

                  <!-- Check SVG -->
                  <div id="check2" class="hidden flex items-center">
                    <svg width="14" height="14" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                      <path d="M10 25l10 10 20-20" stroke="#2ecc71" stroke-width="5" fill="none" />
                    </svg>
                    <span class="message">Validando Captcha (T)</span>
                  </div>
                </div>
                <div class="flex justify-center items-center">
                  <div style="height: 0.1rem;background-color: gray;width: 40px;padding-right: 20px;opacity: .3;"></div>
                  <span
                    style="text-align: center;color: gray;padding: 24px 0;text-transform: uppercase;font-size: 12px;font-weight: 550;margin-left: 20px;margin-right: 20px;">Registrar
                    usando sua conta:</span>
                  <div style="height: 0.1rem;background-color: gray;width: 40px;padding-left: 20px;opacity: .3;"></div>
                </div>
                <div class="flex w-full items-center justify-center gap-4" style="flex: 1">
                  <button
                    style="border: 0.1rem solid #303334;width: 100%;text-align: center;display: flex;justify-content: center;border-radius: 3px;padding: 10px;"><svg
                      height="1em" viewBox="0 0 488 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"
                        fill="currentColor"></path>
                    </svg></button>
                  <button
                    style="border: 0.1rem solid #303334;width: 100%;text-align: center;display: flex;justify-content: center;border-radius: 3px;padding: 10px;"><svg
                      height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z"
                        fill="currentColor"></path>
                    </svg></button>
                </div>
                <p style="text-align: center;padding-top: 20px;font-size: 12px;color: white;font-weight: 500;"
                  class="text-sm text-gray-500 dark:text-gray-300 mb-6"><a href=""
                    @click.prevent="hideLoginShowRegisterToggle">Já tem uma conta? <strong
                      style="color:var(--ci-primary-color);font-weight: 500;">Entrar</strong></a></p>
              </div>







            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <!-- Overlay (mantém o mesmo id e atributos que já existiam) -->
  <div id="modalcupom" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-screen md:h-[calc(100%-1rem)] max-h-full"
    style="z-index: 9999; backdrop-filter: none; height: 100vh; background-color: rgba(0, 0, 0, 0.80);">

    <!-- Container interno (centraliza o conteúdo) -->
    <div class="relative w-full max-w-3xl max-h-full mx-auto my-8">

      <!-- Spinner de carregamento (mantido, caso ainda precise) -->
      <div v-if="isLoadingRegister"
        class="absolute inset-0 z-[999] flex items-center justify-center bg-black/30 rounded">
        <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
          <i class="fa-duotone fa-spinner-third fa-spin"
            style="font-size:45px; --fa-primary-color: var(--ci-primary-color); --fa-secondary-color:#000;"></i>
          <span class="sr-only">Loading...</span>
        </div>
      </div>

      <!-- ====================== NOVO LAYOUT ====================== -->
      <div class="cMU8g flex h-full relative">

        <!-- Conteúdo do modal -->
        <div class="rClOu w-full p-5 m-auto login-register-100vh">

          <img alt="Quit icon" aria-hidden="true" class="dHdm7"
            src="https://static.7k.bet.br/deploy-b571d93300fe1387e469cb73c04498571017bebf-cfcd66d1ec6d46e4cd46/assets/images/svg/quit.svg">

          <!-- Texto principal -->
          <h6 class="h2bsN text-center">
            Tem certeza que deseja cancelar seu registro?
          </h6>

          <!-- Texto secundário (opcional) -->
          <p class="text-center text-sm text-white/60 mb-6">
            Cadastre‑se e deposite agora para ganhar o dobro do seu depósito até R$ 5.000!
          </p>

          <!-- Botões de ação -->
          <div class="flex flex-col items-center gap-3 w-full">

            <!-- Botão “Continuar” (ação principal) -->
            <button @click.prevent="hideCupomShowRegisterToggle"
              class="hQlUG w-full h-[50px] bg-[var(--ci-primary-color)] text-[#191b32] font-bold rounded-md flex items-center justify-center gap-2">
              Continuar
              <span class="cdn-icon inline-flex items-center" role="img" aria-label="arrows/arrow_right"
                style="width:1em;height:1em;">
                <i class="fa-solid fa-arrow-right" data-v-398f7f48=""></i>
              </span>
            </button>

            <!-- Botão “Sim, quero cancelar” (ação secundária) -->
            <button @click.prevent="modalcupomToggle"
              class="PLsB5 text-white/70 cursor-pointer text-sm flex items-center gap-1">
              <span class="cdn-icon inline-flex items-center text-[10px] mr-1" role="img" aria-label="close"
                style="width:1em;height:1em;">
                <i class="fa-solid fa-x" data-v-398f7f48=""></i>
              </span>
              Sim, quero cancelar
            </button>
          </div>

        </div> <!-- /.rClOu -->
      </div> <!-- /.cMU8g -->
      <!-- ========================================================= -->

    </div> <!-- /.relative (container interno) -->
  </div> <!-- #modalcupom -->


  <div id="modalProfileEl" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-screen md:h-[calc(100%-1rem)] max-h-full pad-modal-profile">
    <div
      class="relative w-full max-w-2xl md:max-w-lg max-h-full bg-white dark:bg-gray-900 rounded-lg shadow-lg por-height-alto">
      <div v-if="!isLoadingProfile" class="flex flex-col">

        <!-- PROFILE HEADER -->
        <div class="flex justify-between w-full p-4 ">
          <h1 class="text-2xl font-bold pt-2 p-4">{{ $t('Seu Perfil') }}</h1>
          <button @click.prevent="profileToggle" type="button" class="text-1xl">
            <div class="x-mark-scale"
              style="box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.50);background-color: #212425;padding: 7px 13px;border-radius: 5px;max-width: 40px">
              <i style="color: var(--ci-primary-color);font-weight: bold" class="fa-light fa-x"></i>
            </div>
          </button>
        </div>

        <!-- PROFILE BODY -->
        <div v-if="profileUser != null" class="flex flex-col w-full p-4"
          style="background-color: #1C1E22;border-bottom-left-radius: 8px;border-bottom-right-radius: 8px;">

          <!-- PROFILE INFO -->
          <div class="flex items-center self-center justify-between w-full pt-4">
            <div class="text-center flex flex-col justify-center self-center items-center">
              <div class="relative">
                <img style="max-width: 100px" class=""
                  :src="userData?.avatar ? '/storage/' + userData.avatar : `https://static3.smr.vc/fb020020-e232-4ece-a510-3082026ff106/37.png`"
                  alt="">
                <input ref="fileInput" type="file" style="display: none;" @change="handleFileChange">
                <button style="margin-right: -30px;margin-bottom: -10px" @click="openFileInput" type="button"
                  class="absolute bottom-0 right-0 text-3xl">
                  <i style="" class="fa-duotone fa-camera-retro"></i>
                </button>
              </div>
              <div class="relative">
                <input @change.prevent="updateName" v-model="profileName" type="text" :readonly="!readonly"
                  class="mt-4 appearance-none border border-gray-300 rounded-md p-2 bg-transparent border-none text-center"
                  :placeholder="profileName">
                <p style="font-weight: bold" class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                  role="none">
                  {{ userData?.email }}</p>
              </div>
            </div>
            <div class="">
              <button @click.prevent="readonly = !readonly" type="button"
                class="bg-gray-200 hover:bg-gray-400 hover:dark:bg-gray-700 w-10 h-10  rounded">
                <i v-if="!readonly" class="fa-sharp fa-light fa-pen"></i>
                <i v-if="readonly" class="fa-solid fa-xmark"></i>
              </button>
            </div>
          </div>




          <div class="mt-3 shadow flex flex-col bg-gray-100 dark:bg-gray-900 rounded-lg">
            <div class="flex justify-between px-4 pt-4">
              <h1><span class="mr-2"><i class="fa-solid fa-chart-mixed"></i></span> {{ $t('Statistics') }}</h1>
            </div>
            <div class="p-4">
              <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-200 dark:bg-gray-700 text-center p-4">
                  <p class="text-[12px]">{{ $t('Total winnings') }}</p>
                  <p class="text-2xl font-bold">
                    {{ totalEarnings }}
                  </p>
                </div>
                <div class="bg-gray-200 dark:bg-gray-700 text-center p-4">
                  <p class="text-[12px]">{{ $t('Total bets') }}</p>
                  <p class="text-2xl font-bold">{{ totalBets }}</p>
                </div>
                <div class="bg-gray-200 dark:bg-gray-700 text-center p-4">
                  <p class="text-[12px]">{{ $t('Total bet') }}</p>
                  <p class="text-2xl font-bold">{{ sumBets }}</p>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>
      <div v-if="isLoadingProfile" class="flex flex-col w-full h-full">
        <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
          <i class="fa-duotone fa-spinner-third fa-spin"
            style="font-size: 45px;--fa-primary-color: var(--ci-primary-color); --fa-secondary-color: #000000;"></i>
          <span class="sr-only">{{ $t('Loading') }}...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { RouterLink, useRoute } from "vue-router";
import { sidebarStore } from "@/Stores/SideBarStore.js";
import { Modal } from 'flowbite';
import { useAuthStore } from "@/Stores/Auth.js";
import { useToast } from "vue-toastification";
import { useRouter } from 'vue-router';
import { onMounted, ref, watch, watchEffect } from "vue";

import DropdownDarkLight from "@/Components/UI/DropdownDarkLight.vue";
import LanguageSelector from "@/Components/UI/LanguageSelector.vue";
import WalletBalance from "@/Components/UI/WalletBalance.vue";
import HttpApi from "@/Services/HttpApi.js";
import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
import { useSettingStore } from "@/Stores/SettingStore.js";

export default {
  props: ['simple', 'hideTopBanner'],
  components: { MakeDeposit, WalletBalance, LanguageSelector, DropdownDarkLight, RouterLink },
  data() {
    return {
      vipPoints: 0,
      currentLevel: null,
      nextLevel: null,
      nivelToday: [],
      nivelWeekly: [],
      nivelMonthly: [],
      nivelYearly: [],
      isLoading: true,
      retryCount: 0,
      form: {
        email: '',
      },
      showModal2: false,
      isClosed: false,
      showModal: false,
      sidebar: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? false : (localStorage.getItem('sidebarStatus') ? JSON.parse(localStorage.getItem('sidebarStatus')) : false),
      showNavtop: true,
      isLoadingLogin: false,
      isLoadingRegister: false,
      isReferral: false,
      modalAuth: null,
      modalRegister: null,
      isDark: true,
      modalProfile: null,
      modalcupom: null,
      typeInputPassword: 'password',
      readonly: false,
      profileUser: null,
      custom: null,
      modalDepositNav: null,
      loginForm: {
        email: '',
        password: '',
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        reference_code: '',
        term_a: false,
        agreement: false,
      },
      avatarUrl: 'https://static3.smr.vc/fb020020-e232-4ece-a510-3082026ff106/37.png',
      isLoadingProfile: false,
      profileName: '',
      sumBets: 0,
      totalBets: 0,
      totalEarnings: 0,
    }
  },
  setup(props) {
    const router = useRouter();


    watchEffect(() => {
      checkRoute();
    });

    onMounted(() => {
      checkRoute();
    });

    function checkRoute() {
      // Verifique se a rota atual é 'casinoPlayPage'

    }

    return {
      router,
      isCasinoPlayPage
    };
  },
  computed: {
    logoSrc() {
      return this.isDark
        ? `/storage/${this.setting.software_logo_white}`
        : `/storage/${this.setting.software_logo_black}`;
    },
    isAuthenticated() {
      const authStore = useAuthStore();
      return authStore.isAuth;
    },

    sidebarMenuStore() {
      return sidebarStore();
    },
    sidebarMenu() {
      const sidebar = sidebarStore()
      return sidebar.getSidebarStatus;
    },
    isAuthenticated() {
      const authStore = useAuthStore();
      return authStore.isAuth;
    },
    userData() {
      const authStore = useAuthStore();
      return authStore.user;
    },
    setting() {
      const authStore = useSettingStore();
      return authStore.setting;
    }
  },
  unmounted() {

  },
  mounted() {
    this.isDark = document.documentElement.classList.contains('dark');

    // Ouça mudanças (se seu app troca tema via botão, escute evento ou use watch em store, etc)
    // Exemplo básico: ouvinte manual
    const observer = new MutationObserver(() => {
      this.isDark = document.documentElement.classList.contains('dark');
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    // Captura o código de afiliado da URL quando o componente é montado
    const urlParams = new URLSearchParams(window.location.search);
    const codeFromUrl = urlParams.get('code');

    if (codeFromUrl) {
      // Armazenamos o código no modelo, sem mostrar o campo automaticamente
      this.registerForm.reference_code = codeFromUrl;
      console.log('Código de afiliado capturado da URL:', codeFromUrl);
    }

    // Function to switch from loading to check in the second modal
    function switchToCheck2() {
      document.getElementById('loading2').classList.add('hidden');
      document.getElementById('loading-message2').classList.add('hidden');
      document.getElementById('check2').classList.remove('hidden');
    }

    // Function to remove the check element in the second modal
    function removeCheck2() {
      document.getElementById('check2').remove(); // Remove the check element
    }

    // Wait for 3 seconds then switch to check and remove check element after an additional 3 seconds
    setTimeout(() => {
      switchToCheck2();
      setTimeout(removeCheck2, 3000); // Remove the check element after an additional 3 seconds
    }, 3000);
    function switchToCheck() {
      document.getElementById('loading').classList.add('hidden');
      document.getElementById('loading-message').classList.add('hidden');
      document.getElementById('check').classList.remove('hidden');
    }

    // Function to remove the check element
    function removeCheck() {
      document.getElementById('check').remove(); // Remove the check element
    }

    // Wait for 3 seconds then switch to check and remove check element after an additional 3 seconds
    setTimeout(() => {
      switchToCheck();
      setTimeout(removeCheck, 3000); // Remove the check element after an additional 3 seconds
    }, 3000);
    if (!this.isAuthenticated && this.$route.path !== '/register') {
      this.$nextTick(() => {
        this.modalRegister.toggle();
      });
    }
    /*
    * $targetEl: required
    * options: optional
    */
    this.modalProfile = new Modal(document.getElementById('modalProfileEl'), {
      placement: 'center',
      backdrop: 'dynamic',
      backdropClasses: 'fixed inset-0 z-40',
      closable: false,
      onHide: () => {

      },
      onShow: () => {

      },
      onToggle: () => {

      }
    });

    /*
    * $targetEl: required
    * options: optional
    */
    this.modalAuth = new Modal(document.getElementById('modalElAuth'), {
      placement: 'center',
      backdrop: 'dynamic',
      backdropClasses: 'fixed inset-0 z-40',
      closable: false,
      onHide: () => {

      },
      onShow: () => {

      },
      onToggle: () => {

      }
    });

    /*
   * $targetEl: required
   * options: optional
   */
    this.modalRegister = new Modal(document.getElementById('modalElRegister'), {
      placement: 'center',
      backdrop: 'dynamic',
      backdropClasses: 'fixed inset-0 z-40',
      closable: false,
      onHide: () => {

      },
      onShow: () => {

      },
      onToggle: () => {

      }
    });
    this.modalcupom = new Modal(document.getElementById('modalcupom'), {
      placement: 'center',
      backdrop: 'dynamic',
      backdropClasses: 'fixed inset-0 z-40',
      closable: false,
      onHide: () => {

      },
      onShow: () => {

      },
      onToggle: () => {

      }
    });
  },
  methods: {
    getProgress(requiredPoints) {
      if (this.vipPoints >= requiredPoints) {
        return 100;
      }
      return (this.vipPoints / requiredPoints) * 100;
    },
    loadingVipTab: function () {
      const tabsElement = document.getElementById('tabs-vip');
      console.log(tabsElement);
      if (tabsElement) {
        const tabElements = [
          {
            id: 'vipdefault',
            triggerEl: document.querySelector('#vipdefault-tab'),
            targetEl: document.querySelector('#vipdefault-panel'),
          },
          {
            id: 'weeklybonus',
            triggerEl: document.querySelector('#weeklybonus-tab'),
            targetEl: document.querySelector('#weeklybonus-panel'),
          },
          {
            id: 'monthlybonus',
            triggerEl: document.querySelector('#monthlybonus-tab'),
            targetEl: document.querySelector('#monthlybonus-panel'),
          },
          {
            id: 'annualbonus',
            triggerEl: document.querySelector('#annualbonus-tab'),
            targetEl: document.querySelector('#annualbonus-panel'),
          },
        ];

        const options = {
          defaultTabId: 'vipdefault',
          activeClasses: 'text-[var(--ci-primary-color)] hover:text-[var(--ci-primary-color)] dark:text-[var(--ci-primary-color)] dark:hover:text-[var(--ci-primary-color)] border-[var(--ci-primary-color)] dark:border-[var(--ci-primary-color)]',
          inactiveClasses: 'text-[#7A818C] hover:text-[#7A818C] dark:text-[#7A818C] border-[#7A818C] hover:border-[#7A818C] dark:border-[#7A818C] dark:hover:text-[#7A818C]',
          onShow: () => {

          },
        };

        const instanceOptions = {
          id: 'vipdefault',
          override: true
        };

        /*
        * tabElements: array of tab objects
        * options: optional
        * instanceOptions: optional
        */
        this.tabs = new Tabs(tabsElement, tabElements, options, instanceOptions);
      }
    },
    getVips: async function () {
      try {
        const response = await HttpApi.get(`/profile/vip/`);

        // Verificações de segurança para evitar erros
        this.vipPoints = response.data.vipPoints || 0;
        this.currentLevel = response.data.currentLevel || null;
        this.nextLevel = response.data.nextLevel || null;
        this.nivelToday = response.data.nivelToday || [];
        this.nivelWeekly = response.data.nivelWeekly || [];
        this.nivelMonthly = response.data.nivelMonthly || [];
        this.nivelYearly = response.data.nivelYearly || [];

        this.isLoading = false;

        // Usar nextTick para garantir que o DOM está atualizado
        this.$nextTick(() => {
          if (typeof this.loadingVipTab === 'function') {
            this.loadingVipTab();
          }
        });
      } catch (error) {
        console.error('Erro ao carregar informações VIP:', error);
        this.isLoading = false;

        // Opcional: Adicionar tratamento de erro mais detalhado
        if (error.response) {
          // O servidor respondeu com um status de erro
          console.error('Dados do erro:', error.response.data);
        } else if (error.request) {
          // A requisição foi feita, mas não houve resposta
          console.error('Sem resposta do servidor');
        } else {
          // Algo aconteceu ao configurar a requisição
          console.error('Erro na configuração da requisição');
        }
      }
    },
    forgotPasswordSubmit: async function (event) {
      const _this = this;
      const _toast = useToast();
      _this.isLoading = true;

      await HttpApi.post('auth/forget-password', _this.form)
        .then(async response => {

          _this.isLoading = false;
          _toast.success('Um token foi enviado para você em sua caixa de E-mail!');
        })
        .catch(error => {
          const _this = this;
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
            _toast.error(`${value}`);
          });
          _this.isLoading = false;
        });
    },


    close() {
      this.$emit('update:show', false);
    },
    checkBannerStatus() {
      const lastClosed = localStorage.getItem('bannerLastClosed');
      if (lastClosed) {
        const twelveHours = 12 * 60 * 60 * 1000; // 12 horas em milissegundos
        if (Date.now() - lastClosed < twelveHours) {
          this.isClosed = true;
        }
      }
    },
    closeBanner() {
      this.isClosed = true;
      localStorage.setItem('bannerLastClosed', Date.now());
    },
    closeModal() {
      this.showModal = false;
    },
    getSetting: function () {
      const _this = this;
      const settingStore = useSettingStore();
      const settingData = settingStore.setting;

      if (settingData) {
        _this.setting = settingData;
      }
    },
    redirectSocialTo: function () {
      return '/auth/redirect/google'
    },
    like: async function (id) {
      const _this = this;
      const _toast = useToast();
      await HttpApi.post('/profile/like/' + id, {})
        .then(response => {

          _this.getProfile();
          _toast.success(_this.$t(response.data.message));
        })
        .catch(error => {
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
            _toast.error(`${value}`);
          });
        });
    },
    updateName: async function (event) {
      const _this = this;
      _this.isLoadingProfile = true;

      await HttpApi.post('/profile/updateName', { name: _this.profileName })
        .then(response => {
          _this.isLoadingProfile = false;
        })
        .catch(error => {
          const _this = this;
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

          });
          _this.isLoadingProfile = false;
        });
    },
    togglePassword: function () {
      if (this.typeInputPassword === 'password') {
        this.typeInputPassword = 'text';
      } else {
        this.typeInputPassword = 'password';
      }
    },
    loginSubmit: function (event) {
      const _this = this;
      const _toast = useToast();
      _this.isLoadingLogin = true;
      const authStore = useAuthStore();

      HttpApi.post('auth/login', _this.loginForm)
        .then(async response => {
          await new Promise(r => {
            setTimeout(() => {
              authStore.setToken(response.data.access_token);
              authStore.setUser(response.data.user);
              authStore.setIsAuth(true);

              _this.loginForm = {
                email: '',
                password: '',
              }

              _this.modalAuth.toggle();
              _toast.success(_this.$t('You have been authenticated, welcome!'));

              _this.isLoadingLogin = false;

              if (_this.isCasinoPlayPage) {
                location.reload();
              }
            }, 1000)
          });
        })
        .catch(error => {
          const _this = this;
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
            _toast.error(`${value}`);
          });
          _this.isLoadingLogin = false;
        });
    },
    registerSubmit: async function (event) {
      const _this = this;
      const _toast = useToast();
      _this.isLoadingRegister = true;

      // Verificar se há um código na URL caso o campo esteja vazio
      if (!_this.registerForm.reference_code || _this.registerForm.reference_code.trim() === '') {
        const urlParams = new URLSearchParams(window.location.search);
        const codeFromUrl = urlParams.get('code');
        if (codeFromUrl) {
          _this.registerForm.reference_code = codeFromUrl;
          console.log('Usando código de afiliado da URL:', codeFromUrl);
        }
      }

      const authStore = useAuthStore();
      await HttpApi.post('auth/register', _this.registerForm)
        .then(response => {
          if (response.data.access_token !== undefined) {
            authStore.setToken(response.data.access_token);
            authStore.setUser(response.data.user);
            authStore.setIsAuth(true);

            //PIXELCOMPLETEREGISTRATION
            try {
              if (window.fbEvents) {
                window.fbEvents.trackCompleteRegistration({
                  email: response.data.user.email,
                  firstName: response.data.user.name.split(' ')[0],
                  lastName: response.data.user.name.split(' ')[1] || ''
                });
                console.log('CompleteRegistration event sent');
              }
            } catch (error) {
              console.error('Erro ao enviar evento CompleteRegistration:', error);
            }

            _this.registerForm = {
              name: '',
              email: '',
              password: '',
              password_confirmation: '',
              reference_code: '',
              term_a: false,
              agreement: false,
            }

            _this.modalRegister.toggle();
            _this.router.push({ name: 'home' });
            _toast.success(_this.$t('Your account has been created successfully'));

            if (_this.isCasinoPlayPage) {
              location.reload();
            } else {
              setTimeout(() => {

                this.modalDepositNav = new Modal(document.getElementById('modalElDeposit'), {
                  placement: 'center',
                  backdrop: 'dynamic',
                  backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-1 backmodaldeposit',
                  closable: true,
                  onHide: () => {
                    this.paymentType = null;
                    const divsToDelete = document.querySelectorAll('.backmodaldeposit');
                    if (divsToDelete.length > 0) {
                      divsToDelete.forEach(div => {
                        div.remove();
                      });
                    }
                  },
                  onShow: () => {

                  },
                  onToggle: () => {
                  },
                });

                this.modalDepositNav.toggle();

              }, 2000);
            }

          }

          _this.isLoadingRegister = false;
        })
        .catch(error => {
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
            _toast.error(`${value}`);
          });
          _this.isLoadingRegister = false;
        });
    },
    logoutAccount: function () {
      const authStore = useAuthStore();
      const _toast = useToast();

      HttpApi.post('auth/logout', {})
        .then(response => {
          authStore.logout();
          this.router.push({ name: 'home' });

          _toast.success(this.$t('You have been successfully disconnected'));

        })
        .catch(error => {
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
            console.log(value);
            //_toast.error(`${value}`);
          });
        });
    },
    hideLoginShowRegisterToggle: function () {
      this.modalAuth.toggle();
      this.modalRegister.toggle();
    },
    hideRegisterShowCupomToggle: function () {
      this.modalRegister.toggle();
      this.modalcupom.toggle();
    },
    hideCupomShowRegisterToggle: function () {
      this.modalcupom.toggle();
      this.modalRegister.toggle();
    },
    hideRegisterShowLoginToggle: function () {
      this.modalRegister.toggle();
      this.modalAuth.toggle();
    },
    toggleMenu: function () {
      this.sidebarMenuStore.setSidebarToogle();
    },
    loginToggle: function () {
      this.modalAuth.toggle();
    },
    registerToggle: function () {
      this.modalRegister.toggle();
    },
    modalcupomToggle: function () {
      this.modalcupom.toggle();
    },
    profileToggle: function () {
      this.modalProfile.toggle();
    },
    openFileInput() {
      this.$refs.fileInput.click();
    },
    async handleFileChange(event) {
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append('avatar', file);

      const reader = new FileReader();
      reader.onload = () => {
        this.avatarUrl = reader.result;
      };
      reader.readAsDataURL(file);

      await HttpApi.post('/profile/upload-avatar', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      }).then(response => {
        console.log('Avatar atualizado com sucesso', response.data);
        window.location.reload();
      })
        .catch(error => {
          console.error('Erro ao atualizar avatar', error);
        });
    },
    getProfile: async function () {
      const _this = this;
      _this.isLoadingProfile = true;

      await HttpApi.get('/profile/')
        .then(response => {
          _this.sumBets = response.data.sumBets;
          _this.totalBets = response.data.totalBets;
          _this.totalEarnings = response.data.totalEarnings;

          const user = response.data.user;

          if (user?.avatar != null) {
            _this.avatarUrl = '/storage/' + user.avatar;
          }

          _this.profileName = user.name;
          _this.profileUser = user;
          _this.isLoadingProfile = false;
        })
        .catch(error => {
          const _this = this;
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

          });
          _this.isLoadingProfile = false;
        });
    },
  },
  async created() {
    this.getVips();
    this.checkBannerStatus();
    this.getSetting();
    this.custom = custom;
    if (this.isAuthenticated) {
      await this.getProfile();
    }

    if (this.isCasinoPlayPage) {
      this.showNavtop = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? false : true;
    }


  },
  watch: {
    sidebarMenu(newVal, oldVal) {
      this.sidebar = newVal;
    },
  },
};
</script>

<style scoped>
.hidden {
  display: none;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: Arial, sans-serif;
}

.message {
  margin-left: 10px;
  font-size: 16px;
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

.hidden {
  display: none;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.message {
  color: #6A6D6D;
  margin-left: 10px;
  font-size: 12px;
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

.modal2-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.47);
  backdrop-filter: none;
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal2-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  position: relative;
  max-width: 500px;
  width: 100%;
}

.close2 {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 24px;
  font-weight: bold;
}

.top-banner {
  position: fixed;
  /* Fixa a div no topo da tela */
  top: 0;
  left: 0;
  right: 0;
  background-color: #f4f4f4;
  padding: 10px;
  border-bottom: 1px solid #ddd;
  z-index: 1000;
  /* Garante que a div fique acima dos outros elementos */
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.top-banner p {
  margin: 0;
}

.top-banner button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}

.top-banner button:hover {
  background-color: #0056b3;
}

/* Estilo para o overlay do modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

/* Estilo para o conteúdo do modal */
.modal-content {
  background: white;
  padding: 20px;
  padding-top: 0;
  border-radius: 8px;
  width: 300px;
  text-align: center;
}

/* Estilo para o botão de fechar */
button {
  margin-top: 10px;
}

.item-game-container {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  /* Alinhamento à esquerda do contêiner da bolinha */
}

.online-indicator {
  margin-top: 5px;
  color: white;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  /* Alinhamento à esquerda dos itens dentro do indicador */
}

.pulse2 {
  position: absolute;
  right: 0;
  bottom: 8%;
  margin-left: 12px;
  /* Ajuste conforme necessário para alinhar com o card */
  width: 10px;
  height: 10px;
  background-color: #00ff00;
  border-radius: 50%;
  margin-right: 3px;
  box-shadow: 0 0 5px #00ff00, 0 0 20px #00ff00;
}

.christmas-bar {
    background: repeating-linear-gradient(
        45deg,
        #dc2626,
        #dc2626 20px,
        #ffffff 20px,
        #ffffff 40px
    );
    background-size: 56px 56px;

    /* AQUI: Combinamos as duas animações (movimento + brilho) separadas por vírgula */
    animation: move-stripes 8s linear infinite, christmas-glow 2s ease-in-out infinite;

    z-index: 50;
}

.pascoa-bar {
    background: repeating-linear-gradient(
        45deg,
        #f74095,
        #f74095 20px,
        #502208 20px,
        #502208 40px
    );
    background-size: 56px 56px;

    /* AQUI: Combinamos as duas animações (movimento + brilho) separadas por vírgula */
    animation: move-stripes 8s linear infinite, pascoa-glow 2s ease-in-out infinite;

    z-index: 50;
}

/* Animação de movimento (já existia) */
@keyframes move-stripes {
    0% { background-position: 0 0; }
    100% { background-position: 56px 0; }
}

/* NOVA: Animação de Brilho */
@keyframes christmas-glow {
    0%, 100% {
        box-shadow: 0 0 5px rgba(220, 38, 38, 0.5); /* Brilho fraco */
        filter: brightness(1);
    }
    50% {
        box-shadow: 0 0 20px rgba(220, 38, 38, 0.9); /* Brilho forte */
        filter: brightness(1.2); /* Fica mais claro */
    }
}

@keyframes pascoa-glow {
    0%, 100% {
        box-shadow: 0 0 5px rgba(247, 64, 149, 0.5); /* Brilho fraco */
        filter: brightness(1);
    }
    50% {
        box-shadow: 0 0 20px rgba(247, 64, 149, 0.9); /* Brilho forte */
        filter: brightness(1.2); /* Fica mais claro */
    }
}
</style>
