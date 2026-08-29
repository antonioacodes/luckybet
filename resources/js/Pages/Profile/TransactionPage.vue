<style>
</style>
<template>
    <BaseLayout>
        <div class="md:w-3/6 2xl:w-3/6 mx-auto p-4 mt-20 ">
            <div class="grid grid-cols-1">
                <div class="col-span-1 hidden md:block">
                    
                </div>
                <div class="col-span-2 relative">
                    <div style="background-color:#0d0d22;margin-top:15px;border-radius:12px;" v-if="isLoading === false && wallet" class="flex flex-col w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-700 p-4 rounded">
                        <div class="header flex w-full mb-3">
                          
                            <div class="flex flex-col">
                                <h1 class="text-2xl font-bold">{{ $t('Withdrawal List') }}</h1>
                                <p class="text-gray-400 text-sm">{{ $t('Below is the list of all requested withdrawals') }}</p>
                            </div>
                        </div>

                        <div v-if="withdraws && wallet" class="mt-3">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400  border dark:border-gray-600">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Proof') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Type') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Value') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(withdraw, index) in withdraws.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                <a v-if="withdraw.proof" href="" class="flex">
                                                    <i class="fa-regular fa-file-export mr-2"></i>
                                                    {{ $t('Click here') }}
                                                </a>
                                                <span v-else>{{ $t('Processing') }}</span>
                                            </td>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <span class="uppercase">{{ withdraw.type }}</span>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ state.currencyFormat(parseFloat(withdraw.amount), 'BRL') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span v-if="withdraw.status === 1" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $t('Concluded') }}</span>
                                                <span v-if="withdraw.status === 0" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{ $t('Pending') }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ withdraw.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="header flex w-full mb-3 mt-5">
                           
                            <div class="flex flex-col">
                                <h1 class="text-2xl font-bold">{{ $t('Deposits List') }}</h1>
                                <p class="text-gray-400 text-sm">{{ $t('List of deposits made') }}</p>
                            </div>
                        </div>

                        <div v-if="deposits && wallet" class="mt-3">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400  border dark:border-gray-600">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Type') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Value') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(deposit, index) in deposits.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <span class="uppercase">{{ deposit.type }}</span>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ state.currencyFormat(parseFloat(deposit.amount), 'BRL') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span v-if="deposit.status === 1" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $t('Concluded') }}</span>
                                                <span v-if="deposit.status === 0" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{ $t('Pending') }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ deposit.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <i class="fa-duotone fa-spinner-third fa-spin" style="font-size: 45px;--fa-primary-color: var(--ci-primary-color); --fa-secondary-color: #000000;"></i>
                        <span class="sr-only">{{ $t('Loading') }}...</span>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import {RouterLink} from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import {useToast} from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import CustomPagination from "@/Components/UI/CustomPagination.vue";
import {useAuthStore} from "@/Stores/Auth.js";

export default {
    props: [],
    components: {CustomPagination, WalletSideMenu, BaseLayout, RouterLink},
    data() {
        return {
            isLoading: false,
            wallet: {},
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
    },
    created() {
        this.getWallet();
        this.getWithdraws();
        this.getDeposits();
    },
    watch: {},
};
</script>

<style scoped>

</style>
