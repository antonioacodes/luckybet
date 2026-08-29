<template>
    <AuthLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading') }}</span>
            </div>
        </LoadingComponent>
        <div v-if="!isLoading" class="my-auto ">
            <div class="px-4 py-5">
                <div class="text-center flex flex-col items-center justify-center mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]">
                    <div class="w-full rounded-lg shadow-lg border-none md:mt-0 sm:max-w-md xl:p-0 mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px] md:mt-[60px] mt-[30px]" style="background-color: var(--footer-color-dark);">
                        <div class="p-2 space-y-2 md:space-y-2 sm:p-4" style="max-width: 500px;">
                            <h1 class="px-4 pt-2 mb-5 md:text-3xl text-xl text-left" style="color: var(--ci-primary-color);font-weight: 700;">{{ $t('Recuperar Senha') }}</h1>

                            <div class="mt-4 px-4">
                                <form @submit.prevent="resetPasswordSubmit" method="post" action="" class="">
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            
                                        </div>
                                        <label class="flex justify-start" for="label-reset-email" style="color: #C8ECFF;">E-mail<span style="color: #D83E5D;">*</span></label>
                                        <input id="label-reset-email" style="padding: 15px 0px;padding-left: 20px;outline: none;border: none;background-color: var(--input-primary);" type="email"
                                               name="email"
                                               v-model="form.email"
                                               class="input-group"
                                               :placeholder="$t('Insira seu e-mail')"
                                               required
                                        >
                                    </div>
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-start pl-3.5 pointer-events-none">
                                         
                                        </div>
                                        <label for="label-reset-senha" class="flex justify-start items-center" style="color: #C8ECFF;">Nova senha<span style="color: #D83E5D;">*</span></label>
                                        <input id="label-reset-senha" style="padding: 15px 0px;padding-left: 20px;outline: none;border: none;background-color: var(--input-primary);border-radius: 8px;" :type="typeInputPassword"
                                               name="password"
                                               v-model="form.password"
                                               class="input-group pr-[40px]"
                                               :placeholder="$t('Nova senha')"
                                               required
                                        >
                                        <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 " style="top: 33%;">
                                            <svg v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"  data-v-9b35dc4c="" height="1em" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256z" fill="currentColor"></path><path d="M95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400z" fill="currentColor" opacity="0.4"></path></svg>
                              


                                        <svg v-if="typeInputPassword === 'password'" class="fa-regular fa-eye" data-v-9b35dc4c="" height="1em" viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196V9.196z" fill="currentColor"></path><path d="M446.6 324.7C457.7 304.3 464 280.9 464 256C464 176.5 399.5 112 320 112C282.7 112 248.6 126.2 223.1 149.5L150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L446.6 324.7zM313.4 220.3C317.6 211.8 320 202.2 320 192C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 160 320 160C373 160 416 202.1 416 256C416 269.7 413.1 282.7 407.1 294.5L313.4 220.3zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 256C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z" fill="currentColor" opacity="0.4"></path></svg>
                                        </button>
                                    </div>
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                          
                                        </div>
                                        <label for="label-reset-senha2" class="flex justify-start" style="color: #C8ECFF;">Confirmar senha<span style="color: #D83E5D;">*</span></label>
                                        <input id="label-reset-senha2" style="padding: 15px 0px;padding-left: 20px;outline: none;border: none;background-color: var(--input-primary);" :type="typeInputPassword"
                                               name="password_confirmation"
                                               v-model="form.password_confirmation"
                                               class="input-group pr-[40px]"
                                               :placeholder="$t('Confirmar senha')"
                                               required
                                        >
                                        <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5" style="top: 33%;">
                                            <svg v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"  data-v-9b35dc4c="" height="1em" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256z" fill="currentColor"></path><path d="M95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400z" fill="currentColor" opacity="0.4"></path></svg>
                              


                                         <svg v-if="typeInputPassword === 'password'" class="fa-regular fa-eye" data-v-9b35dc4c="" height="1em" viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196V9.196z" fill="currentColor"></path><path d="M446.6 324.7C457.7 304.3 464 280.9 464 256C464 176.5 399.5 112 320 112C282.7 112 248.6 126.2 223.1 149.5L150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L446.6 324.7zM313.4 220.3C317.6 211.8 320 202.2 320 192C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 160 320 160C373 160 416 202.1 416 256C416 269.7 413.1 282.7 407.1 294.5L313.4 220.3zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 256C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z" fill="currentColor" opacity="0.4"></path></svg>
                                        </button>
                                    </div>
                                    <div class="mt-5 w-full" style="max-width: 100px;">
                                        <button type="submit" class="ui-button-blue rounded w-full mb-3 flex items-center justify-center gap-2">
                                            <svg data-v-90645a18="" height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" fill="currentColor"></path></svg> {{ $t('Enviar') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>


<script>

import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { useRoute, useRouter } from 'vue-router'
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import {onMounted, ref} from "vue";
import HttpApi from "@/Services/HttpApi.js";

export default {
    props: [],
    components: {LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            typeInputPassword: 'password',
            form: {
                email: '',
                password: '',
                password_confirmation: '',
                token: '',
            },
        }
    },
    setup(props) {

        const route = useRoute()
        const token = ref(null)

        onMounted(() => {
            token.value = route.params.token
        })

        return {
            token
        };
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {
        const router = useRouter();
        if(this.isAuthenticated) {
            router.push({ name: 'home' });
        }
    },
    methods: {
        togglePassword: function() {
            if(this.typeInputPassword === 'password') {
                this.typeInputPassword = 'text';
            }else{
                this.typeInputPassword = 'password';
            }
        },
        resetPasswordSubmit: async function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            /// token
            _this.form.token = _this.token;

            await HttpApi.post('auth/reset-password/' + _this.token, _this.form)
                .then(async response =>  {
                    _toast.success('Senha restaurada com sucesso!');
                    _this.isLoading = false;
                    
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
