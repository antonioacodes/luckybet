// ✅<style>
    .item-sombra {
        position: relative;
    }

    .item-sombra::after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 50px;
        height: 50px;
        background: linear-gradient(to right, rgba(240, 240, 240, 0), #323637e7);
    }
    
    #placeholder-input::placeholder {
        color: white;
    }
    
    .texto-valor {
        font-size: 15px;
    }
    
    @media (max-width:768px) {
        .loading-mobile-qr {
            margin-top: 30vh;
        }
    }
    
    @media (max-width:600px) {
        .texto-valor {
            font-size: 12px;
        }
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #323637;
        transition: .4s;
        border-radius: 24px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .toggle-switch input:checked + .toggle-slider {
        background-color: #22892E !important;
    }

    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }

    .bonus-container {
        background-color: #213326;
        padding: 10px 15px;
        margin: 10px 0;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bonus-text {
        display: flex;
        flex-direction: column;
    }

    .bonus-title {
        color: #22892E;
        font-weight: bold;
        font-size: 14px;
    }

    .bonus-description {
        color: white;
        font-size: 12px;
        opacity: 0.8;
    }

    .timer {
        text-align: start;
    }

    .progress-bar {
        padding: 0px 6%;
        width: 100%;
        background-color: #323637;
        height: 4px;
        margin-bottom: 10px;
        position: relative;
        border-radius: 20px;
    }

    .progress-bar > div {
        height: 100%;
        background-color: #82A81B;
        position: absolute;
        top: 0;
        left: 0;
        transition: width 0.5s;
        border-radius: 20px;
    }

    .time-display {
        font-size: 24px;
        font-weight: bold;
    }

    .completed-message {
        padding: 40px 0;
        font-size: 22px;
        color: #C13A5C;
        text-align: center;
        font-weight: bold;
    }

    .item-selected {
        display: flex;
        gap: 6px;
        margin-bottom: 1px;
        margin-right: 0px;
    }

    .item {
        flex: 1;
        padding: 7px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }

    .item:hover {
        opacity: 0.8;
    }

    .item.active {
        border: 2px solid var(--ci-primary-color);
    }

    .ratio2 {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .ratio {
        position: relative;
        top: -3px;
        font-size: 10px;
        margin-top: 5px;
    }

    .img-check {
        position: absolute;
        top: -5px;
        left: -5px;
        width: 16px;
        height: 16px;
    }
</style>

<template>
    <!-- Stripe Section -->
    <div v-if="paymentType === 'stripe' && publishableKey && setting && setting.stripe_is_enable" class="p-4">
        <stripe-checkout
            ref="checkoutRef"
            :pk="publishableKey"
            :sessionId="sessionId"
        />
        <div style="z-index:9999 !important; background-color: var(--input-primary);" class="flex w-full mt-3 mb-3">
            <div class="w-36 mr-2">
                <label for="currency" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Currency') }}</label>
                <select id="currency" v-model="currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="USD">$ {{ $t('Dollar') }}</option>
                    <option value="BRL">R$ {{ $t('Real') }}</option>
                </select>
            </div>
            <div class="w-full">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Amount') }}</label>
                <input type="number"
                       v-model="amount"
                       class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       :min="setting.min_deposit"
                       :max="setting.max_deposit"
                       :placeholder="$t('0,00')"
                       required
                >
            </div>
        </div>
        <button :disabled="!sessionId" @click.prevent="checkoutStripe" class="ui-button-blue rounded w-full">{{ $t('Pay With Stripe') }}</button>
    </div>
    
    <!-- PIX Section -->
    <div v-if="paymentType === 'pix'">
        <!-- QR Code Display Screen -->
        <div v-if="showPixQRCode && wallet" class="flex flex-col">
            <div class="w-full">
                <!-- Header Image -->
                <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 20px;width: 100%;border-top-right-radius: 8px;border-top-left-radius: 8px;">
                    <a v-if="setting" class="w-full" style="display: flex;justify-content: center;margin: 0 auto;max-height: 300px;">
                        <img style="border-top-right-radius: 8px;border-top-left-radius: 8px" :src="`/storage/`+setting.software_logo_black2" alt="" class="block" />
                    </a>
                </div>
                
                <div class="flex items-center px-6 gap-4 overflow-y-auto">
                    <div>
                        <a href="" @click.prevent="$emit('close')">
                            <svg height="1em" viewBox="0 0 448 512" width="1em" xmlns="http://www.w3.org/2000/svg" class="text-auth-texts/80 cursor-pointer">
                                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="flex flex-col">
                        <h2 style="color: white;font-weight: 500;font-size: 18px;">Voltar</h2>
                    </div>
                </div>
                
                <div class="flex justify-center" style="margin-top: 10px;">
                    <p class="md:block hidden text-lg" style="text-align: center;font-weight: 600">
                        Escaneie a imagem <br> para realizar o pagamento
                    </p>
                    <p class="md:hidden block text-base" style="text-align: center;font-weight: 600">
                        Copie o código "copia e cola" <br> abaixo para realizar o pagamento
                    </p>
                </div>
            </div>

            <div class="w-full px-6 overflow-y-auto">
                <div class="qr-code-container p-3 flex justify-center items-center md:block hidden" style="max-width: 250px;margin: 0 auto;">
                    <QRCodeVue3 :value="qrcodecopypast"/>
                </div>

                <div @click.prevent="copyQRCode" class="mt-4 p-4 rounded-lg relative" style="text-align: center;border: 1px dashed rgba(253, 255, 255, .6);">
                    <p class="font-bold" style="font-size: 2em;color: var(--ci-primary-color);margin-bottom: 10px">
                        {{ formatCurrency(parseFloat(deposit.amount)) }}
                    </p>
                    <input style="background-color: var(--input-primary);font-size: 12px;border-radius: 10px;" 
                           id="pixcopiaecola" 
                           type="text" 
                           class="input appearance-none border border-gray-300 rounded-md bg-transparent border-none w-full" 
                           v-model="qrcodecopypast">

                    <div class="mt-5 w-full flex items-center justify-center">
                        <button @click.prevent="copyQRCode" type="button" class="w-full md:max-w-[270px] px-4 py-2" style="background-color: var(--ci-primary-opacity-color);color: var(--ci-primary-color);width: 100%;border-radius: 5px;">
                            <span style="text-wrap: nowrap;" class="text-lg md:max-w-[270px]">Copiar Código "copia e cola"</span>
                        </button>
                    </div>
                </div>

                <div style="">
                    <div v-if="!isCompleted" class="timer" style="padding:20px 4%;">
                        <p style="color: #CC833C;font-weight: 800;font-size: 13px;">O tempo para você pagar acaba em:</p>
                        <div class="time-display">{{ formattedTime }}</div>
                        <div class="progress-bar">
                            <div :style="{ width: progressBarWidth }"></div>
                        </div>
                    </div>
                    <div v-else class="completed-message">
                        Código PIX expirado
                    </div>
                </div>

                <div v-if="showQRCode" class="qr-code-container flex justify-center items-center" style="max-width: 200px;margin: 0 auto;">
                    <QRCodeVue3 :value="qrcodecopypast"/>
                </div>

                <div class="flex justify-center flex-col items-center">
                    <button style="background-color: #213326;color: #22892E;padding: 5px 15px;border-radius: 5px;margin-bottom: 10px;" @click="refreshPage">
                        Já paguei o pix
                    </button>
                    <button style="text-align: center;" class="md:hidden block flex justify-center" @click="showQRCode = !showQRCode">
                        {{ showQRCode ? 'Ocultar QR Code' : 'Exibir QR Code' }}
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Deposit Form Screen -->
        <div v-if="!showPixQRCode">
            <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2 flex flex-col items-center loading-mobile-qr gap-3">
                Gerando QR CODE...
                <i class="fa-duotone fa-spinner-third fa-spin" style="font-size: 45px;--fa-primary-color: var(--ci-primary-color); --fa-secondary-color: #000000;"></i>
            </div>
            
            <div v-if="setting != null && wallet != null && isLoading === false" class="flex flex-col w-full">
                <form action="" @submit.prevent="submitQRCode">
                    <!-- Header Image -->
                    <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 8px;width: 100%;border-top-right-radius: 8px;border-top-left-radius: 8px;">
                        <a v-if="setting" class="w-full" style="display: flex;justify-content: center;margin: 0 auto;max-height: 300px;">
                            <img style="border-top-right-radius: 8px;border-top-left-radius: 8px" :src="`/storage/`+setting.software_logo_black2" alt="" class="block" />
                        </a>
                    </div>
                    
                    <div class="flex items-center px-6 gap-4">
                        <div>
                            <a href="" @click.prevent="$emit('close')">
                                <svg height="1em" viewBox="0 0 448 512" width="1em" xmlns="http://www.w3.org/2000/svg" class="text-auth-texts/80 cursor-pointer">
                                    <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="flex flex-col">
                            <h2 style="color: white;font-weight: bold;font-size: 20px;">Depositar</h2>
                            <p style="font-size: 14px;opacity: .7;">Adicione saldo à sua conta</p>
                        </div>
                    </div>
                    
                    <div style="background-color: #213326;border-radius: 5px;" class="py-2 mt-1 mb-1 mx-6">
                        <p class="md:text-base text-xs font-semibold" style="color: #22912F;">
                            Multiplicador de prêmios ativado, deposite já!
                        </p>
                    </div>
                    
                    <!-- Payment Method Info -->
                    <div class="flex items-center px-6 w-full">
                        <div class="mr-4">
                            <label style="font-size: 12px;color: #87898A;opacity: .8;font-weight: bold;" for="methodpagamento">
                                Método de Pagamento
                            </label>
                            <input disabled style="padding: 7px 0px;padding-left: 10px;background-color: var(--input-primary);border-radius: 5px;opacity: .7;" 
                                   id="methodpagamento" type="text" value="Pix">
                        </div>
                        <div>
                            <label style="font-size: 12px;color: #87898A;opacity: .8;font-weight: bold;" for="methodpagamento2">
                                Depósito Mínimo
                            </label>
                            <div style="position: relative;">
                                <input disabled style="padding: 7px 0px;padding-left: 10px;background-color: var(--input-primary);border-radius: 5px;opacity: .7;" 
                                       id="methodpagamento2" type="text" value="">
                                <p style="position: absolute;left: 6%;top: 16%;z-index: 1;opacity: .7;">R$ {{ setting ? setting.min_deposit : '0,00' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-1 px-6">
                        <p class="text-gray-500 md:text-base text-xs" style="font-weight: 550;color: white;">
                            Valor a ser depositado:
                        </p>
                        
                        <div v-if="setting.bonus_is_enable" class="bonus-container">
                            <div class="bonus-text">
                                <span class="bonus-title">🎁 Bônus de Depósito</span>
                                <span class="bonus-description">
                                    {{ deposit.accept_bonus ? 'Receba +400% do valor depositado' : 'Apenas o valor depositado, sem bônus' }}
                                </span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" v-model="deposit.accept_bonus">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        
                        <div class="w-full flex items-center justify-between rounded py-1">
                            <div class="flex w-full items-center">
                                <i style="position: absolute;padding-left: 20px;font-size: 14px;z-index: 2;" class="fa-solid fa-brazilian-real-sign"></i>
                                
                                <div style="position: absolute;right: 0;font-size: 10px;z-index: 2;padding-right: 50px;display: flex;align-items: center;font-weight: bold;gap: 3px;">
                                    <svg style="max-width: 10px;" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                        <mask id="a"><circle cx="256" cy="256" r="256" fill="#fff"></circle></mask>
                                        <g mask="url(#a)">
                                            <path fill="#6da544" d="M0 0h512v512H0z"></path>
                                            <path fill="#ffda44" d="M256 100.2 467.5 256 256 411.8 44.5 256z"></path>
                                            <path fill="#eee" d="M174.2 221a87 87 0 0 0-7.2 36.3l162 49.8a88.5 88.5 0 0 0 14.4-34c-40.6-65.3-119.7-80.3-169.1-52z"></path>
                                            <path fill="#0052b4" d="M255.7 167a89 89 0 0 0-41.9 10.6 89 89 0 0 0-39.6 43.4 181.7 181.7 0 0 1 169.1 52.2 89 89 0 0 0-9-59.4 89 89 0 0 0-78.6-46.8zM212 250.5a149 149 0 0 0-45 6.8 89 89 0 0 0 10.5 40.9 89 89 0 0 0 120.6 36.2 89 89 0 0 0 30.7-27.3A151 151 0 0 0 212 250.5z"></path>
                                        </g>
                                    </svg>
                                    <p>BRL</p>
                                </div>
                                
                                <div style="position: absolute;right: 0;padding-right: 100px;z-index: 2;font-size: 12px;" v-if="deposit.amount > 0" class="text-right">
                                    <span v-if="deposit.accept_bonus" style="color: #A7F432;">
                                        = {{ formatCurrency(parseFloat(deposit.amount) * 5) }} Saldo
                                    </span>
                                    <span v-else style="color: #C13A5C;">
                                        = {{ formatCurrency(parseFloat(deposit.amount)) }} Saldo (sem bônus)
                                    </span>
                                </div>
                                
                                <input id="placeholder-input" 
                                       style="position: relative;padding-left: 38px;z-index: 1;background-color:var(--input-primary);font-weight: 600" 
                                       type="text"
                                       v-model="deposit.amount"
                                       class="appearance-none border border-gray-300 rounded-md bg-transparent border-none w-full py-2 md:text-xl text-base"
                                       placeholder="0,00"
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mx-6 mt-3 mb-2 rounded-lg p-3 flex items-center justify-between" style="background: linear-gradient(135deg, rgba(167,244,50,.16), rgba(33,51,38,.9)); border: 1px solid rgba(167,244,50,.28);">
                            <div>
                                <div class="text-xs font-extrabold" style="color:#A7F432;">🎁 RODADAS GRÁTIS NO PRIMEIRO DEPÓSITO</div>
                                <div class="text-[10px] text-white/70">A quantidade aparece em cada valor abaixo.</div>
                            </div>
                            <div class="text-right">
                                <div class="text-[9px] text-white/60">EXPIRA EM</div>
                                <div class="font-extrabold tabular-nums" style="color:#ff4f86;">{{ promoFormattedTime }}</div>
                            </div>
                        </div>
                    
                    <div class="mt-1 item-selected px-6">
                        <div style="background-color: var(--ci-primary-opacity-color);" @click.prevent="setAmount(20.00)" class="item" :class="{'active' : selectedAmount === 20.00}">
                            <button class="ratio2" style="color: var(--ci-primary-color);font-weight: 800;" type="button">{{ wallet.symbol }} 20</button>
                            <div class="ratio">+10 rodadas grátis</div>
                            <img v-if="selectedAmount === 20.00" class="img-check" :src="`/assets/images/check.png`" alt="">
                        </div>
                        <div style="background-color: var(--ci-primary-opacity-color);" @click.prevent="setAmount(50.00)" class="item" :class="{'active' : selectedAmount === 50.00}">
                            <button class="ratio2" style="color: var(--ci-primary-color);font-weight: 800;" type="button">{{ wallet.symbol }} 50</button>
                            <div class="ratio">+25 rodadas grátis</div>
                            <img v-if="selectedAmount === 50.00" class="img-check" :src="`/assets/images/check.png`" alt="">
                        </div>
                        <div style="background-color: var(--ci-primary-opacity-color);" @click.prevent="setAmount(100.00)" class="item" :class="{'active' : selectedAmount === 100.00}">
                            <button class="ratio2" style="color: var(--ci-primary-color);font-weight: 800;" type="button">{{ wallet.symbol }} 100</button>
                            <div class="ratio">+50 rodadas grátis</div>
                            <img v-if="selectedAmount === 100.00" class="img-check" :src="`/assets/images/check.png`" alt="">
                        </div>
                    </div>
                    
                    <div class="item-selected px-6">
                        <div style="background-color: var(--ci-primary-opacity-color);" @click.prevent="setAmount(250.00)" class="item" :class="{'active' : selectedAmount === 250.00}">
                            <button class="ratio2" style="color: var(--ci-primary-color);font-weight: 800;" type="button">{{ wallet.symbol }} 250</button>
                            <div class="ratio">+125 rodadas grátis</div>
                            <img v-if="selectedAmount === 250.00" class="img-check" :src="`/assets/images/check.png`" alt="">
                        </div>
                        <div style="background-color: var(--ci-primary-opacity-color);" @click.prevent="setAmount(500.00)" class="item" :class="{'active' : selectedAmount === 500.00}">
                            <button class="ratio2" style="color: var(--ci-primary-color);font-weight: 800;" type="button">{{ wallet.symbol }} 500</button>
                            <div class="ratio">+250 rodadas grátis</div>
                            <img v-if="selectedAmount === 500.00" class="img-check" :src="`/assets/images/check.png`" alt="">
                        </div>
                        <div style="background-color: var(--ci-primary-opacity-color);text-shadow: 2px 1px 11px var(--ci-primary-color);" @click.prevent="setAmount(1000.00)" class="item" :class="{'active' : selectedAmount === 1000.00}">
                            <button class="ratio2" style="color: var(--ci-primary-color);font-weight: 800;" type="button">{{ wallet.symbol }} 1000</button>
                            <div class="ratio">+500 rodadas grátis</div>
                            <img v-if="selectedAmount === 1000.00" class="img-check" :src="`/assets/images/check.png`" alt="">
                        </div>
                    </div>
                    
                    <div class="mt-1 w-full flex items-center justify-center px-6">
                        <button type="submit" class="w-full p-6 mt-1" style="border-radius: 5px; color: var(--sub-text-color); width: auto; padding: 7px 12px; flex: none; font-weight: 400; background-color: var(--ci-primary-color); padding-top: 10px; padding-bottom: 10px;">
                            <span class="text-xl" style="color: var(--sub-text-color);font-weight: 550;">DEPOSITAR</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import QRCodeVue3 from "qrcode-vue3";
import { useAuthStore } from "@/Stores/Auth.js";
import { StripeCheckout } from '@vue-stripe/vue-stripe';
import { useSettingStore } from "@/Stores/SettingStore.js";

export default {
    name: 'DepositWidget',
    props: ['showMobile', 'title', 'isFull'],
    emits: ['close'],
    components: { QRCodeVue3, StripeCheckout },
    
    data() {
        return {
            showQRCode: false,
            totalTime: 5 * 60,
            timeRemaining: 5 * 60,
            intervalId: null,
            isCompleted: false,
            isModalOpen: true,
            isLoading: false,
            isLoadingWallet: true,
            minutes: 15,
            seconds: 0,
            timer: null,
            promoInterval: null,
            promoTimeRemaining: 30 * 60,
            setting: null,
            wallet: null,
            deposit: {
                amount: '',
                cpf: '10292107994',
                gateway: 'bspay',
                accept_bonus: true
            },
            selectedAmount: 0,
            showPixQRCode: false,
            qrcodecopypast: '',
            idTransaction: '',
            paymentType: 'pix',
            paymentGateway: 'bspay',
            
            // ✅ Event IDs únicos do Facebook vindos do backend
            addtocartEventId: null,
            purchaseEventId: null,
            
            // ✅ Controle de eventos enviados para evitar duplicação
            addtocartSent: false,
            purchaseSent: false,
            
            // Stripe
            elementsOptions: {
                appearance: {},
            },
            confirmParams: {
                return_url: null,
            },
            successURL: null,
            cancelURL: null,
            amount: null,
            currency: null,
            publishableKey: null,
            sessionId: null,
        }
    },
    
    computed: {
        promoFormattedTime() {
            const minutes = Math.floor(this.promoTimeRemaining / 60);
            const seconds = this.promoTimeRemaining % 60;
            return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        },
        progressBarWidth() {
            const percentage = (this.timeRemaining / this.totalTime) * 100;
            return `${percentage}%`;
        },
        
        formattedTime() {
            const minutes = Math.floor(this.timeRemaining / 60);
            const seconds = this.timeRemaining % 60;
            return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        },
        
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    
    methods: {
        startPromoTimer() {
            const userId = useAuthStore().user?.id || 'guest';
            const key = `first-deposit-promo-expires-${userId}`;
            let deadline = Number(localStorage.getItem(key));
            if (!deadline) {
                deadline = Date.now() + (30 * 60 * 1000);
                localStorage.setItem(key, String(deadline));
            }
            const tick = () => {
                this.promoTimeRemaining = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
                if (this.promoTimeRemaining === 0) clearInterval(this.promoInterval);
            };
            tick();
            this.promoInterval = setInterval(tick, 1000);
        },
        refreshPage() {
            window.location.reload();
        },
        
        updateTimer() {
            if (this.timeRemaining > 0) {
                this.timeRemaining -= 1;
            } else {
                this.isCompleted = true;
                clearInterval(this.intervalId);
            }
        },
        
        closeModal() {
            this.isModalOpen = false;
        },
        
        getSession: function() {
            const _this = this;
            HttpApi.post('stripe/session', { amount: _this.amount, currency: _this.currency}).then(response => {
                if(response.data.id) {
                    _this.sessionId = response.data.id;
                }
            }).catch(error => { });
        },
        
        checkoutStripe: function() {
            const _toast = useToast();
            if(this.amount <= 0 || this.amount === '') {
                _toast.error('Você precisa digitar um valor');
                return;
            }
            this.$refs.checkoutRef.redirectToCheckout();
        },
        
        getPublicKeyStripe: function() {
            const _this = this;
            HttpApi.post('stripe/publickey', {}).then(response => {
                _this.$nextTick(() => {
                    _this.publishableKey = response.data.stripe_public_key;
                    _this.elementsOptions.clientSecret  = response.data.stripe_secret_key;
                    _this.confirmParams.return_url      = response.data.successURL;
                });
            }).catch(error => { });
        },
        
        setPaymentMethod: function(type, gateway) {
            if(type === 'stripe') {
                this.getPublicKeyStripe();
            }
            this.paymentType = type;
            this.paymentGateway = gateway;
        },
        
        /**
         * ✅ MÉTODO PRINCIPAL - SUBMIT QR CODE COM EVENT IDs DO BACKEND
         */
        submitQRCode: function(event) {
            const _this = this;
            const _toast = useToast();
            
            // Validações básicas
            if(_this.deposit.amount === '' || _this.deposit.amount === undefined) {
                _toast.error(_this.$t('You need to enter a value'));
                return;
            }

            if(_this.deposit.cpf === '' || _this.deposit.cpf === undefined) {
                _toast.error(_this.$t('Do you need to enter your CPF or CNPJ'));
                return;
            }

            if(parseFloat(_this.deposit.amount) < parseFloat(_this.setting.min_deposit)) {
                _toast.error('O valor mínimo de depósito é de '+ _this.setting.min_deposit);
                return;
            }

            if(parseFloat(_this.deposit.amount) > parseFloat(_this.setting.max_deposit)) {
                _toast.error('O valor máximo de depósito é de '+ _this.setting.max_deposit);
                return;
            }

            _this.deposit.paymentType = _this.paymentType;
            _this.deposit.gateway = _this.paymentGateway;

            // ✅ Resetar controles de eventos
            _this.addtocartSent = false;
            _this.purchaseSent = false;
            _this.addtocartEventId = null;
            _this.purchaseEventId = null;

            _this.isLoading = true;
            HttpApi.post('wallet/deposit/payment', _this.deposit).then(response => {
                _this.showPixQRCode = true;
                _this.isLoading = false;

                _this.idTransaction = response.data.idTransaction;
                _this.qrcodecopypast = response.data.qrcode;
/*                
                // ✅ CAPTURAR EVENT IDs EXATOS DO BACKEND
                _this.addtocartEventId = response.data.addtocartEventId;
                _this.purchaseEventId = response.data.purchaseEventId;
                
                console.log('📦 Event IDs recebidos do backend:', {
                    addtocart: _this.addtocartEventId,
                    purchase: _this.purchaseEventId,
                    transaction: _this.idTransaction,
                    expectedPurchase: `purchase_${_this.idTransaction}`
                });
                
                // ✅ VERIFICAR SE OS EVENT IDs FORAM RECEBIDOS
                if (!_this.addtocartEventId || !_this.purchaseEventId) {
                    console.error('❌ Event IDs não recebidos do backend!', {
                        addtocartEventId: _this.addtocartEventId,
                        purchaseEventId: _this.purchaseEventId,
                        serverResponse: response.data
                    });
                    _toast.error('Erro na configuração de rastreamento. Contate o suporte.');
                    return;
                }
                
                // ✅ VERIFICAR SE EVENT IDs ESTÃO NO FORMATO CORRETO
                if (_this.purchaseEventId !== `purchase_${_this.idTransaction}`) {
                    console.warn('⚠️ Event ID não está no formato esperado!', {
                        received: _this.purchaseEventId,
                        expected: `purchase_${_this.idTransaction}`
                    });
                }
                
                // ✅ ENVIAR ADDTOCART COM EVENT ID DO BACKEND
                _this.sendAddToCartEvent();
                */
                // ✅ INICIAR VERIFICAÇÃO DE STATUS
                _this.intervalId = setInterval(function () {
                    _this.checkTransactions(_this.idTransaction);
                }, 5000);

            }).catch(error => {
                console.log('❌ Erro na API:', error);
                if (error.request && error.request.responseText) {
                    try {
                        const errorResponse = JSON.parse(error.request.responseText);
                        Object.entries(errorResponse).forEach(([key, value]) => {
                            _toast.error(`${value}`);
                        });
                    } catch (e) {
                        _toast.error('Erro ao processar solicitação');
                    }
                } else {
                    _toast.error('Erro de conexão');
                }
                _this.showPixQRCode = false;
                _this.isLoading = false;
            });
        },
        
        /**
         * ✅ MÉTODO PARA ENVIAR ADDTOCART COM EVENT ID DO BACKEND
         */
        sendAddToCartEvent: function() {
            const _this = this;
            
            if (_this.addtocartSent) {
                console.warn('⚠️ AddToCart já foi enviado');
                return;
            }
            
            if (!_this.addtocartEventId) {
                console.error('❌ AddToCart Event ID não disponível');
                return;
            }
            
            try {
                // ✅ USAR EXATAMENTE O EVENT ID VINDO DO BACKEND
                fbq('track', 'AddToCart', {
                    content_ids: [_this.idTransaction],
                    content_type: 'product',
                    value: parseFloat(_this.deposit.amount),
                    currency: 'BRL'
                }, {
                    eventID: _this.addtocartEventId // ✅ EVENT ID EXATO DO BACKEND
                });
                
                _this.addtocartSent = true;
                
                console.log('✅ AddToCart enviado com Event ID do backend:', {
                    eventID: _this.addtocartEventId,
                    transaction: _this.idTransaction,
                    value: parseFloat(_this.deposit.amount)
                });
                
            } catch (e) {
                console.error('❌ Erro ao enviar AddToCart:', e);
            }
        },
        
        /**
         * ✅ MÉTODO PARA VERIFICAR STATUS COM DEDUPLICAÇÃO
         */
        checkTransactions: function(idTransaction) {
            const _this = this;
            const _toast = useToast();

            HttpApi.post(_this.paymentGateway+'/consult-status-transaction', { idTransaction: idTransaction }).then(response => {
                
                console.log('💰 Pagamento confirmado! Enviando Purchase...');
                
                // ✅ ENVIAR PURCHASE COM EVENT ID DO BACKEND
                _this.sendPurchaseEvent(idTransaction);
                
                _toast.success('Pedido concluído com sucesso');
                clearInterval(_this.intervalId);
                
            }).catch(error => {
                // Não exibe erro para o usuário, apenas loga
                console.log('🔄 Checando status do pagamento...');
            });
        },
        
        /**
         * ✅ MÉTODO PARA ENVIAR PURCHASE COM EVENT ID EXATO DO BACKEND
         */
        sendPurchaseEvent: function(idTransaction) {
            const _this = this;
            
            if (_this.purchaseSent) {
                console.warn('⚠️ Purchase já foi enviado');
                return;
            }
            
            if (!_this.purchaseEventId) {
                console.error('❌ Purchase Event ID não disponível');
                return;
            }
            
            try {
                console.log('🚀 ENVIANDO PURCHASE COM EVENT ID DO BACKEND:', {
                    eventID: _this.purchaseEventId,
                    transaction: idTransaction,
                    value: parseFloat(_this.deposit.amount),
                    message: '⚠️ ESTE EVENT ID DEVE SER IDÊNTICO AO DO BACKEND!'
                });
                
                // ✅ USAR EXATAMENTE O EVENT ID VINDO DO BACKEND
                fbq('track', 'Purchase', {
                    content_ids: [idTransaction],
                    content_type: 'product',
                    value: parseFloat(_this.deposit.amount),
                    currency: 'BRL'
                }, {
                    eventID: _this.purchaseEventId // ✅ EVENT ID EXATO DO BACKEND
                });
                
                _this.purchaseSent = true;
                
                console.log('✅ Purchase enviado com Event ID do backend:', {
                    eventID: _this.purchaseEventId,
                    transaction: idTransaction,
                    value: parseFloat(_this.deposit.amount),
                    message: 'Backend deve usar este MESMO Event ID!'
                });
                
            } catch (e) {
                console.error('❌ Erro ao enviar Purchase:', e);
            }
        },
        
        copyQRCode: function(event) {
            const _toast = useToast();
            var inputElement = document.getElementById("pixcopiaecola");
            if (inputElement) {
                inputElement.select();
                inputElement.setSelectionRange(0, 99999);
                document.execCommand("copy");
                _toast.success('Pix Copiado com sucesso');
            }
        },
        
        setAmount: function(amount) {
            this.deposit.amount = amount;
            this.selectedAmount = amount;
        },
        
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.currency = response.data.wallet.currency;
                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    if (error.request && error.request.responseText) {
                        try {
                            const errorResponse = JSON.parse(error.request.responseText);
                            Object.entries(errorResponse).forEach(([key, value]) => {
                                _toast.error(`${value}`);
                            });
                        } catch (e) {
                            _toast.error('Erro ao carregar carteira');
                        }
                    }
                    _this.isLoadingWallet = false;
                });
        },
        
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
                _this.amount = settingData.max_deposit;

                if(_this.paymentType === 'stripe' && settingData.stripe_is_enable) {
                    _this.getSession();
                }
            }
        },
        
        formatCurrency(value) {
            if (!value || !this.wallet) return 'R$ 0,00';
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        },
        
        /**
         * ✅ MÉTODO PARA DEBUG - VERIFICAR EVENT IDs
         */
        debugEventIds: function() {
            console.log('🔍 Debug Event IDs:', {
                'Frontend AddToCart ID': this.addtocartEventId,
                'Frontend Purchase ID': this.purchaseEventId,
                'Transaction ID': this.idTransaction,
                'Expected AddToCart': `addtocart_${this.idTransaction}`,
                'Expected Purchase': `purchase_${this.idTransaction}`,
                'AddToCart Match': this.addtocartEventId === `addtocart_${this.idTransaction}`,
                'Purchase Match': this.purchaseEventId === `purchase_${this.idTransaction}`,
                'AddToCart Sent': this.addtocartSent,
                'Purchase Sent': this.purchaseSent
            });
        },
        
        /**
         * ✅ MÉTODO PARA TESTAR FACEBOOK PIXEL
         */
        testFacebookPixel: function() {
            console.log('🧪 Testando Facebook Pixel...');
            
            if (typeof fbq === 'undefined') {
                console.error('❌ Facebook Pixel não está carregado!');
                return;
            }
            
            console.log('✅ Facebook Pixel está disponível');
            
            // Testar evento simples
            fbq('track', 'PageView');
            console.log('✅ PageView enviado');
            
            if (this.purchaseEventId) {
                console.log('🔄 Testando Purchase com Event ID:', this.purchaseEventId);
                
                fbq('track', 'Purchase', {
                    content_ids: ['test'],
                    content_type: 'product',
                    value: 1.00,
                    currency: 'BRL'
                }, {
                    eventID: this.purchaseEventId
                });
                
                console.log('✅ Purchase de teste enviado');
            }
        }
    },
    
    created() {
        if(this.isAuthenticated) {
            this.getWallet();
            this.getSetting();

            if(this.paymentType === 'stripe') {
                this.getSession();
                this.currency = 'USD';
            }
        }
    },

    mounted() {
        this.startPromoTimer();
        const promoAmount = Number(localStorage.getItem('first-deposit-promo-amount'));
        if (promoAmount) {
            this.setAmount(promoAmount);
            localStorage.removeItem('first-deposit-promo-amount');
        }
        this.intervalId = setInterval(this.updateTimer, 1000);
        if (this.setting) {
            // Prioridade para WazerPay, sem quebrar os outros
            if (this.setting.wazerpay_is_enable) {
                this.setPaymentMethod('pix', 'wazerpay');
            } else if (this.setting.bspay_is_enable) {
                this.setPaymentMethod('pix', 'bspay');
            } else if (this.setting.suitpay_is_enable) {
                this.setPaymentMethod('pix', 'suitpay');
            }
        }
        
        // ✅ DEBUG: Adicionar métodos globais para verificar estado
        window.debugDepositWidget = this.debugEventIds;
        window.testFacebookPixel = this.testFacebookPixel;
        window.depositWidget = this; // Para debugging completo
    },

    beforeUnmount() {
        clearInterval(this.intervalId);
        clearInterval(this.timer);
        clearInterval(this.promoInterval);
        this.paymentType = null;
        
        // ✅ Limpar debug globais
        if (window.debugDepositWidget) delete window.debugDepositWidget;
        if (window.testFacebookPixel) delete window.testFacebookPixel;
        if (window.depositWidget) delete window.depositWidget;
    },
    
    watch: {
        amount(oldValue, newValue) {
            if(this.paymentType === 'stripe') {
                this.getSession();
                this.currency = 'USD';
            }
        },
        
        currency(oldValue, newValue) {
            if(this.paymentType === 'stripe') {
                this.getSession();
            }
        },
        
        // ✅ WATCH PARA MONITORAR Event IDs
        addtocartEventId(newVal, oldVal) {
            if (newVal && newVal !== oldVal) {
                console.log('📝 AddToCart Event ID atualizado:', newVal);
            }
        },
        
        purchaseEventId(newVal, oldVal) {
            if (newVal && newVal !== oldVal) {
                console.log('📝 Purchase Event ID atualizado:', newVal);
                console.log('🔍 Verificando formato:', {
                    received: newVal,
                    expected: `purchase_${this.idTransaction}`,
                    match: newVal === `purchase_${this.idTransaction}`
                });
            }
        }
    },
};
</script>