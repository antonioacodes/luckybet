<style>
:is(.dark .teste-margin) {
    background-color: var(--ci-gray-medium);
  	color: rgb(170, 186, 159);
    border-radius: 5px;
}
.teste-margin {
    background-color: var(--sidebar-color);
  	color: var(--ci-gray-medium);
  	max-height: 400px;
  	border-radius: .5rem;
}
#imagem-cash {
    max-width: 300px;
    margin-top: -60px;
}
@media (min-width:1025px) and (max-width:1410px) {
    .padding-wallet {
        padding: 0px 4%;
    }
}
@media (min-width:640px) and (max-width:1024px) {
    .teste-margin {
        margin-top: 40px;
    }
}
@media (max-width:600px) {
    #imagem-cash {
        max-width: 150px;
        margin-top: 0px;
    }
}
@media (max-width:768px) {
    .padding-wallet {
      padding: 0px 4%;
    }
}

:is(.dark .bonus-rollover-container) {
  background-color: var(--ci-gray-medium);
  color: rgb(170, 186, 159);
  gap: 0;
}
  
.bonus-rollover-container {
  background-color: var(--sidebar-color);
  color: var(--ci-gray-medium);
  gap: 0;
}

:is(.dark .transactions-container) {
  background-color: var(--ci-gray-medium);
  color: rgb(170, 186, 159);
  gap: 0;
}
  
.transactions-container {
  background-color: var(--sidebar-color);
  color: var(--ci-gray-medium);
  gap: 0;
}
  
@media (min-width: 768px) {
  .bonus-rollover-container {
    flex-direction: row;
    gap: 1.5rem;
  }
}
@media (max-width: 767px) {
  .bonus-rollover-container {
    flex-direction: column;
  }
  .bonus-rollover-container > div {
    margin-bottom: 1.25rem;
  }
}

</style>
<template>
    <BaseLayout>

<!-- Modal -->

        <div v-if="setting != null" class="flex mx-auto w-full sm:max-w-[690px] w-full padding-wallet" style="border-radius: 5px;">
            <div class="">
                <div class="">
                   
                </div>
                <div class="relative sm:max-w-[690px] lg:max-w-[1110px] mx-auto w-full overflow-x-auto item-sombra2" style="margin: 0 auto;border-radius: 5px;">
                    <div v-if="!isLoadingWallet" class="grid grid-rows-1 gap-4 mt-3 overflow-x-auto w-full" style="padding-top: 55px;border-radius: 5px;">
                        <div class="grid grid-rows-1 p-4 teste-margin relative" style="width: 100%;height: 200px;">
                        <div class="flex">
                                
                                <div class="leading-4 ml-3 mr-3 flex flex-col sm:max-w-[50px] md:max-w-[50px] lg:max-w-[50px] max-w-[50px] w-full">
                                    
                                    <div class="flex items-center">
                                    <svg style="border-radius: 100%;margin-right: 8px;width: 20px;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><mask id="a"><circle cx="256" cy="256" r="256" fill="#fff"></circle></mask><g mask="url(#a)"><path fill="#6da544" d="M0 0h512v512H0z"></path><path fill="#ffda44" d="M256 100.2 467.5 256 256 411.8 44.5 256z"></path><path fill="#eee" d="M174.2 221a87 87 0 0 0-7.2 36.3l162 49.8a88.5 88.5 0 0 0 14.4-34c-40.6-65.3-119.7-80.3-169.1-52z"></path><path fill="#0052b4" d="M255.7 167a89 89 0 0 0-41.9 10.6 89 89 0 0 0-39.6 43.4 181.7 181.7 0 0 1 169.1 52.2 89 89 0 0 0-9-59.4 89 89 0 0 0-78.6-46.8zM212 250.5a149 149 0 0 0-45 6.8 89 89 0 0 0 10.5 40.9 89 89 0 0 0 120.6 36.2 89 89 0 0 0 30.7-27.3A151 151 0 0 0 212 250.5z"></path></g></svg>
                                      <h1>
                                        BRL
                                      </h1>
                                    </div>
                                  	 <span style="color: #AABA9F; font-size: 0.6rem; text-align:center;width:70px; font-weight: 400;background: #23242c; border-radius: 7px; padding: 1px 8px;">
                                          # {{ wallet?.id }}
                                     </span>
                                    <strong class="text-5xl mt-2" style="font-weight: 500">{{ state.currencyFormat(wallet?.total_balance, wallet?.currency) }}</strong>
                                    <i style="color: #5B5E5F;font-size: 45px;opacity: .5;position: absolute;right: 4%;top: 4%;" class="fa-duotone fa-wallet"></i>
                                </div>
                               
                            </div>
                            <div class="leading-4 ml-3 flex flex-col gap-5" style="position: absolute;left: 0;bottom: 0;">
                                    
                                    <div class="mt-2 pb-3" style="gap: 5px;display: flex">
                                    <MakeDeposit :showMobile="false" :title="$t('Depositar')" />
                                      
                                      <div class="relative flex items-center opacidade-hover">
                                        <div data-v-4265f672="" class="aaDu6 flex items-center" style="border-radius: 30px; position: absolute; top: 0px; right: 0px; background-color: rgb(255, 232, 0); margin-top: -7px; padding-left: 3px; padding-right: 3px; margin-right: 6px;">
                                        </div>
                                        <a href="/profile/withdraw">
                                        <button class="md:py-[6px] md:px-[20px] py-[5px] px-[13px] md:text-base text-xs" type="button" style="margin-right:10px; background-color: rgb(255, 232, 0); border-radius: 30px;">
                                          <strong class="md:text-base text-xs" style="color: var(--sub-text-color);">Sacar</strong>
                                        </button>
                                        </a>
                                      </div>
                                
                                                <!-- <RouterLink style="border-radius: 3px;color: var(--title-color);font-weight: bold;color: var(--title-color);background-color: #5B5E5F" :to="{ name: 'profileWithdraw' }" active-class="profile-menu-active" class="block px-8 text-sm text-gray-700 dark:text-gray-300 ml-3 ui-button-blue">
                                                    <span class="">
                                                    
                                                    </span>
                                                    {{ $t('Sacar') }}
                                                </RouterLink> -->
                                            
                                </div>
                                </div>
                                </div>
                                <div class="bonus-rollover-container flex flex-col md:flex-row w-full gap-0 md:gap-6">
                                  <!-- Bloco do Bônus -->
                                  <div class="flex-1 rounded-lg p-4 mb-5 md:mb-0">
                                    <div class="flex items-center gap-2 mb-2">
                                      <span class="inline-block h-2 w-2 rounded-full bg-lime-400"></span>
                                      <span class="text-[#AABA9F] font-bold text-sm tracking-wider">BÔNUS</span>
                                    </div>
                                    <div class="text-[2em]">
                                      R$ {{ state.currencyFormat(wallet?.balance_bonus, wallet.currency) }}
                                    </div>
                                    <div class="flex items-center mt-1 mb-4">
                                      <svg height="12" viewBox="0 0 512 512" width="12" xmlns="http://www.w3.org/2000/svg"><path d="M256 192c17.67 0 32-14.33 32-32c0-17.67-14.33-32-32-32S224 142.3 224 160C224 177.7 238.3 192 256 192zM296 336h-16V248C280 234.8 269.3 224 256 224H224C210.8 224 200 234.8 200 248S210.8 272 224 272h8v64h-16C202.8 336 192 346.8 192 360S202.8 384 216 384h80c13.25 0 24-10.75 24-24S309.3 336 296 336z" fill="currentColor"></path><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z" fill="currentColor" opacity="0.4"></path></svg>
                                      <span class="pl-2 text-xs font-medium text-[#AABA9F]">Rollover cassino ou esportes ainda não definido.</span>
                                    </div>
                                    <a href="/casino/provider/category">
                                      <button class="transactions-period w-full font-semibold rounded-md py-2 transition mb-2">
                                        Acessar jogos
                                      </button>
                                    </a>
                                    <button @click="showModal = true" class="w-full bg-[var(--ci-gray-light)] text-[var(--ci-primary-color)] rounded-md py-2 flex justify-center items-center">
                                      <span style="padding-right: 5px;">Dúvidas?</span>
                                    </button>
                                  </div>
                                  <!-- Bloco do Rollover -->
                                  <div class="flex-1 rounded-lg p-4" style="min-width:190px;">
                                    <div class="flex flex-col gap-3">
                                      <div>
                                        <span class="bg-[var(--ci-gray-light)] text-[var(--ci-primary-color)] font-bold px-2 py-1 rounded text-xs">Rollover</span>
                                      </div>
                                      <div>
                                        <div class="flex justify-between items-center text-xs text-[#ADAFB0] mb-1">
                                          <span>Valor restante Rollover</span>
                                          <span class="">{{ state.currencyFormat(parseFloat(wallet.balance_deposit_rollover), wallet.currency) }}</span>
                                        </div>
                                        <div class="w-full bg-[#34353a] h-2 rounded-full">
                                          <div class="bg-[var(--ci-primary-color)] h-2 rounded-full" :style="{ width: Math.min(100, Math.round((parseFloat(wallet.total_balance_without_bonus)/parseFloat(wallet.balance_deposit_rollover))*100)) + '%' }"></div>
                                        </div>
                                        <div class="text-right text-xs text-[#AABA9F] mt-1">
                                          R$ {{ wallet.balance_deposit_rollover }}
                                        </div>
                                      </div>
                                      <div class="mt-4">
                                        <div class="flex justify-between items-center text-xs text-[#ADAFB0] mb-1">
                                          <span>Valor restante Rollover Bônus</span>
                                          <span class="">{{ state.currencyFormat(parseFloat(wallet.balance_bonus_rollover), wallet.currency) }}</span>
                                        </div>
                                        <div class="w-full bg-[#34353a] h-2 rounded-full">
                                          <div class="bg-[var(--ci-primary-color)] h-2 rounded-full" :style="{ width: Math.min(100, Math.round((parseFloat(wallet.total_balance_without_bonus)/parseFloat(wallet.balance_bonus_rollover))*100)) + '%' }"></div>
                                        </div>
                                        <div class="text-right text-xs text-[#AABA9F] mt-1">
                                          R$ {{ wallet.balance_bonus_rollover }}
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                       
                       </div>
                       
                        </div>

                        
                       

                                    
                        <div class=" w-full">
            <div class="grid grid-cols-1">
                <div class="col-span-1 hidden md:block w-full" >
                    
                </div>
                <div class="col-span-2 relative w-full ">
                    <div style="margin-top: 15px;" v-if="isLoading === false && wallet" class="transactions-container flex flex-col gap-5 w-full p-4 mr-3 rounded">
                        <div class="header flex w-full">
                          
                            <div class="flex flex-col">
                                <h3 style="font-weight: bold;font-size:1.5em;">Minhas Transações</h3>
                                <div class="flex items-center mb-1 mt-2 overflow-x-auto" style="font-size: 12px;font-weight: bold;">
<p class="transactions-period" style="margin-right: 10px;border-radius: 5px;padding: 2px 5px;cursor: pointer;display: inline-block;text-wrap: nowrap">3 dias</p><p class="transactions-period" style="margin-right: 10px;border-radius: 5px;padding: 2px 5px;cursor: pointer;text-wrap: nowrap">7 dias</p><p class="transactions-period" style="margin-right: 10px;border-radius: 5px;padding: 2px 5px;cursor: pointer;text-wrap: nowrap">15 dias</p><p class="transactions-period" style="margin-right: 10px;border-radius: 5px;padding: 2px 5px;cursor: pointer;text-wrap: nowrap">30 dias</p><p class="transactions-period" style="padding: 2px 5px;border-radius: 5px;cursor: pointer">Total</p>
                </div>
               
                            </div>
                            
                        </div>
                        <div class="w-full">
                                <p style="margin-bottom: -5px;font-weight: 500;display: block;border-radius: 5px;padding: 2px 5px;" class="text-400 text-sm">{{ $t('Saques') }}</p>
                            <div style="height: 2px;width: 100%;margin-top: 15px;">

</div>
</div>
                        <div v-if="withdraws && wallet" class="">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right">
                                    <thead class="text-xs uppercase">
                                        <tr>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Tipo') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Valor') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Date') }}
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(withdraw, index) in withdraws.data" :key="index" class="">
                                            <td class="px-6 py-4">
                                                <div class="transactions-period" title="Pago" v-if="withdraw.status === 1" style="border-radius: 5px;font-weight: bold;display: inline-block;padding: 5px;"><i class="fa-sharp fa-solid fa-arrow-down"></i></div>

                                                <div title="Pendente" v-if="withdraw.status === 0" style="border-radius: 5px;color: #000000;font-weight: bold;background-color: #ffd700;display: inline-block;padding: 2px 7px;"><i class="fa-sharp fa-solid fa-arrow-down"></i></div>
                                            </td>
                                            <td class="px-6 py-4" style="">
                                                {{ state.currencyFormat(parseFloat(withdraw?.amount), 'BRL') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span title="Pago" v-if="withdraw.status === 1" class="transactions-period text-xs font-medium me-2 px-2.5 py-0.5 rounded"><i class="fa-sharp fa-solid fa-badge-check"></i></span>
                                                <span title="Pendente" v-if="withdraw.status === 0" class="" style="border-radius: 5px;color: black;font-weight: bold;padding: 2px 3px;background-color: #ffd700;">Pendente</span>
                                            </td>
                                            <td class="px-6 py-4" style="">
                                                {{ withdraw.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="header flex flex-col">
                           
                            <div class="flex flex-col">
                                
                  
                            </div>
                            <p style="margin-bottom: -5px;font-weight: 500;display: block;border-radius: 5px;padding: 2px 5px;" class="text-400 text-sm">{{ $t('Depósitos') }}</p>
                            <div style="height: 2px;width: 100%;margin-top: 15px;">

</div>
                        </div>

                        <div v-if="deposits && wallet" class="">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right">
                   
                                    <thead class="text-xs uppercase">
                                        
                                        <tr>
                                            
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Tipo') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Value') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="font-weight: 400;">
                                                {{ $t('Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr v-for="(deposit, index) in deposits.data" :key="index" class="">
                                          
                                            <td class="px-6 py-4">
                                                <div class="transactions-period" title="Pago" v-if="deposit.status === 1" style="border-radius: 5px;font-weight: bold;display: inline-block;padding: 5px;"><svg height="1em" viewBox="0 0 384 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" fill="currentColor"></path></svg></div>

                                                <div title="Pendente" v-if="deposit.status === 0" style="border-radius: 5px;color: #000000;font-weight: bold;background-color: #ffd700;display: inline-block;padding: 5px;"><svg height="1em" viewBox="0 0 384 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" fill="currentColor"></path></svg></div>
                                            </td>
                                            <td class="px-6 py-4" style="font-weight: 400;">
                                                {{ state.currencyFormat(parseFloat(deposit?.amount), 'BRL') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="transactions-period" title="Pago" v-if="deposit.status === 1" style="border-radius: 5px;font-weight: bold;padding: 2px 3px;">Aprovado</span>
                                                <span title="Pendente" v-if="deposit.status === 0" style="border-radius: 5px;color: black;font-weight: bold;padding: 2px 3px;background-color: #ffd700;">Pendente</span>
                                            </td>
                                            <td class="px-6 py-4" style="">
                                                {{ deposit.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
    <!-- Botão para abrir o modal -->
 
                    <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <i class="fa-duotone fa-spinner-third fa-spin" style="font-size: 45px;--fa-primary-color: var(--ci-primary-color); --fa-secondary-color: #000000;"></i>
                        <span class="sr-only">{{ $t('Loading') }}...</span>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        <div v-if="showModal" class="modal-overlay" @click.self="showModal = false" style="z-index: 999999;background-color:rgba(0, 0, 0, 0.47);">
  <div class="modal-content login-register-100vh" style="background-color: var(--carousel-banners-dark);border-radius: 12px;z-index: 999999;">
    <span style="max-width: 40px" @click="showModal = false" class="close" @click.prevent="toggleSearch" href="">
                                <div class="x-mark-scale" style="box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.50);background-color: var(--carousel-banners-dark);padding: 7px;border-radius: 5px;max-width: 40px">
                                <i style="color: var(--ci-primary-color);font-weight: bold;" class="fa-light fa-x"></i>
                                </div></span>
                                <div class="flex items-center">
                                    <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M6 3H18C20.2 3 22 4.8 22 7C22 8.7 21 10.1 19.5 10.7V7C19.5 6.6 19.3 6.2 19.1 5.9C18.9 5.6 18.4 5.5 18 5.5H6C5.6 5.5 5.2 5.7 4.9 5.9C4.6 6.1 4.5 6.6 4.5 7V10.7C3 10.1 2 8.7 2 7C2 4.8 3.8 3 6 3Z" fill="#9CCE13" fill-opacity="0.3"></path><path clip-rule="evenodd" d="M18 7V19C18 20.1 17.1 21 16 21H8C6.9 21 6 20.1 6 19V7H18ZM10.5 14.5L11.2 15.2V11C11.2 10.6 11.5 10.2 12 10.2C12.5 10.2 12.8 10.5 12.8 11V15.2L13.5 14.5C13.8 14.2 14.3 14.2 14.6 14.5C14.9 14.8 14.9 15.3 14.6 15.6L13.3 16.9C12.6 17.6 11.5 17.6 10.8 16.9L9.5 15.6C9.2 15.3 9.2 14.8 9.5 14.5C9.8 14.2 10.2 14.2 10.5 14.5Z" fill="#9CCE13" fill-rule="evenodd"></path></svg>
                                    <p style="font-weight: 800;font-size: 20px;padding-left: 15px;">Regras do Bônus</p>
                                </div>
    
    <div class="p-4" style="background-color: #323536;border-radius: 8px;margin-top: 20px;line-height: 30px;">
        <p style="font-size: 12px;font-weight: 800;color: #A7A9A9;">Bônus de 1° Depósito: <span style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);padding: 2px 5px">100% até R$&nbsp;7.000,00</span></p>
        <p style="font-size: 12px;font-weight: 800;color: #A7A9A9;">Apostas Cassino: <span style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);padding: 2px 5px">150x</span></p>
        <p style="font-size: 12px;font-weight: 800;color: #A7A9A9;">Apostas Esportes: <span style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);padding: 2px 5px">75x</span></p>
        <p style="font-size: 12px;font-weight: 800;color: #A7A9A9;">Tempo de Expiração Cassino: <span style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);padding: 2px 5px">24 horas</span></p>
        <p style="font-size: 12px;font-weight: 800;color: #A7A9A9;">Tempo de Expiração Esportes: <span style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);padding: 2px 5px">72 horas</span></p>
        <p style="font-size: 12px;font-weight: 800;color: #A7A9A9;">Valor Máximo de Saque de Bônus: <span style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);padding: 2px 5px">3x</span></p>

        <div class="flex items-center">
        <svg style="color: #D08640;" height="2.2rem" viewBox="0 0 512 512" width="2.2rem" xmlns="http://www.w3.org/2000/svg"><path d="M256 320C269.3 320 280 309.3 280 296v-128c0-13.25-10.75-24-23.1-24S232 154.8 232 168v128C232 309.3 242.8 320 256 320zM256 353.1c-17.36 0-31.44 14.08-31.44 31.44C224.6 401.9 238.6 416 256 416s31.44-14.08 31.44-31.44C287.4 367.2 273.4 353.1 256 353.1z" fill="currentColor"></path><path d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z" fill="currentColor" opacity="0.4"></path></svg>
        <p style="color: #D08640;font-size: 12px;line-height: 15px;padding-left: 15px">Para realizar o saque do bônus para carteira real, você precisa cumprir as regras:</p>
    </div>
        <p style="color: #D08640;font-size: 14px;line-height: 15px;border-left: 1px solid #D08640;padding-left: 10px;margin-top: 15px;"><strong style="font-size: 14px;">Cassino:</strong> <br>
            Voce deve acessar algum jogo disponível na categoria Jogar com Bônus</p>
            <p style="color: #D08640;font-size: 14px;line-height: 15px;border-left: 1px solid #D08640;padding-left: 10px;margin-top: 15px;"><strong style="font-size: 14px;">Apostas esportivas:</strong> <br>
                Bilhetes de apostas Multipla ODD acima de 3.00</p>
                <p style="color: #D08640;font-size: 14px;line-height: 15px;border-left: 1px solid #D08640;padding-left: 10px;margin-top: 15px;">
                    Para usar o saldo bônus você não pode possuir o valor da aposta na sua carteira de saldo real.</p>
    </div>
  </div>
</div>
  </div>
    </BaseLayout>
</template>


<script>

import { RouterLink } from "vue-router";
import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";
import {useSettingStore} from "@/Stores/SettingStore.js";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import CustomPagination from "@/Components/UI/CustomPagination.vue";

export default {
    props: [],
    components: {MakeDeposit, CustomPagination, WalletSideMenu, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,
            showModal: false,
            isLoadingWallet: true,
            wallet: {},
            mywallets: null,
            setting: null,
            withdraws: null,
            deposits: null,
        }
    },
    setup(props) {


        return {};
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
    },
    mounted() {
        window.scrollTo(0, 0);
    },
    methods: {
        getWallet: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                });
        },
        getWithdraws: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('wallet/withdraw')
                .then(response => {
                    _this.withdraws = response.data.withdraws;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        getDeposits: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('wallet/deposit')
                .then(response => {
                    _this.deposits = response.data.deposits;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        setWallet: function(id) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.post('profile/mywallet/'+ id, {})
                .then(response => {
                   _this.getMyWallet();
                    _this.isLoadingWallet = false;
                    window.location.reload();

                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getMyWallet: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('profile/mywallet')
                .then(response => {
                    _this.mywallets = response.data.wallets;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                });
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
            }

            _this.isLoading = false;
        },
        rolloverPercentage(balance) {
            return Math.max(0, ((balance / 100) * 100).toFixed(2));
        },
    },
    created() {
        this.getWallet();
        this.getMyWallet();
        this.getSetting();
        this.getWithdraws();
        this.getDeposits();
    },
    watch: {

    },
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color:rgba(0, 0, 0, 0.47);
  backdrop-filter: none;
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  position: relative;
  max-width: 500px;
  width: 100%;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 24px;
  font-weight: bold;
}
</style>
