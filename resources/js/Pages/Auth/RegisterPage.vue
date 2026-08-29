<style>
@media (max-width:600px) {
    .register-afiliado {
        margin-top: -67px;
        height: 100vh;
        background-image:linear-gradient(3deg, #48064ccc, transparent);
        width: 100%;
        z-index: 9999;
    }
}
   
</style>
<template>
    <AuthLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading') }}</span>
            </div>
        </LoadingComponent>
        
        <div v-if="!isLoading" class="">
            <div class="">
                <div class="text-center flex flex-col items-center justify-center md:mt-[130px]">
                    <div class="register-afiliado w-full md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700">
                        <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 20px;width: 100%;">
                        <a v-if="setting" class="w-full" style="display: flex;justify-content: center;margin: 0 auto;max-height: 300px;">
                            <img  :src="`/storage/`+setting.software_logo_black2" alt="" class="block md:rounded-t-lg" />
                       
                        </a>
                   
                       
                    </div>
                        <div class="register-afiliado p-6 sm:p-8 md:rounded-br-lg md:rounded-bl-lg md:pb-[30px]" style="background-image:linear-gradient(3deg, #48064ccc, transparent); margin-top: -30px;">
                         

                            <div class="mt-4 px-4">
                                <form @submit.prevent="registerSubmit" method="post" action="" class="padding-register">





                              <div style="display: flex;justify-content: center;margin: 0 auto;margin-bottom: 20px">
                              <a v-if="setting" class="flex md:ml-2 ml:1 md:mr-24 items-center pb-4" style="display: flex;justify-content: center;margin: 0 auto;">
                              <img :src="`/storage/`+setting.software_logo_black" alt="" class="h-8 block dark:hidden " />
                              <img :src="`/storage/`+setting.software_logo_white" alt=""  class="md:max-h-[35px] max-h-[30px] hidden dark:block" />
                              </a>
                              </div>

                              <div class="relative mb-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        
                            </div>
                            <input id="inputField" style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" type="email"
                                   name="email"
                                   v-model="registerForm.email"
                                   class="input-group"
                                   :placeholder="$t('')"
                                   required
                            >
                            <label class="label-formularios" for="inputField">E-mail<span style="color: #984258;">*</span></label>
                        </div>

                        <div class="relative mb-2">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                
                            </div>
                            <input id="inputField1" style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" :type="typeInputPassword"
                                   name="password"
                                   v-model="registerForm.password"
                                   class="input-group pr-[40px]"
                                   :placeholder="$t('')"
                                   required
                            >
                            <label class="label-formularios" for="inputField1">Senha <span style="color: #984258;">*</span></label>
                            <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 ">
                                <svg v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"  data-v-9b35dc4c="" height="1em" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256z" fill="currentColor"></path><path d="M95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400z" fill="currentColor" opacity="0.4"></path></svg>
                              


                              <svg v-if="typeInputPassword === 'password'" class="fa-regular fa-eye" data-v-9b35dc4c="" height="1em" viewBox="0 0 640 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196V9.196z" fill="currentColor"></path><path d="M446.6 324.7C457.7 304.3 464 280.9 464 256C464 176.5 399.5 112 320 112C282.7 112 248.6 126.2 223.1 149.5L150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L446.6 324.7zM313.4 220.3C317.6 211.8 320 202.2 320 192C320 180.5 316.1 169.7 311.6 160.4C314.4 160.1 317.2 160 320 160C373 160 416 202.1 416 256C416 269.7 413.1 282.7 407.1 294.5L313.4 220.3zM320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L177.4 235.8C176.5 242.4 176 249.1 176 256C176 335.5 240.5 400 320 400C338.7 400 356.6 396.4 373 389.9L446.2 447.5C409.9 467.1 367.8 480 320 480H320z" fill="currentColor" opacity="0.4"></path></svg>
                            </button>
                        </div>


<div class="relative mb-2">
                                        
                                        <input id="inputField2" style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);" type="text"
                                               name="cpf"
                                               v-maska
                                                data-maska="[
                                                    '###.###.###-##',
                                                    '###.###.###-##'
                                                ]"
                                               v-model="registerForm.cpf"
                                               class="input-group"
                                               :placeholder="$t('')"
                                               required
                                        >
                                        <label class="label-formularios" for="inputField2">CPF <span style="color: #984258;">*</span></label>
                                    </div>

                                    <div class="relative mb-2">
                          
                          <div class="flex items-center">
                          <input id="inputField3" style="padding: 15px 0px;padding-left: 20px;background-color: var(--input-primary);border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text"
                                 name="phone"
                                 v-maska
                                 data-maska="[
                                  '(##) ####-####',
                                  '(##) #####-####'
                                ]"
                                 v-model="registerForm.phone"
                                 class="input-group"
                                 :placeholder="$t('')"
                                 required
                          >
                          <label class="label-formularios" for="inputField3">Telefone <span style="color: #984258;">*</span></label>
                          <div class="flex items-center justify-center" style="padding: 14.5px 15px;background-color: var(--input-primary);border-bottom-right-radius: 8px;border-top-right-radius: 8px;border-left: 0.1rem solid #535455;"><svg xmlns="http://www.w3.org/2000/svg" width="1.3rem" height="1.3rem" viewBox="0 0 512 512"><mask id="a"><circle cx="256" cy="256" r="256" fill="#fff"></circle></mask><g mask="url(#a)"><path fill="#6da544" d="M0 0h512v512H0z"></path><path fill="#ffda44" d="M256 100.2 467.5 256 256 411.8 44.5 256z"></path><path fill="#eee" d="M174.2 221a87 87 0 0 0-7.2 36.3l162 49.8a88.5 88.5 0 0 0 14.4-34c-40.6-65.3-119.7-80.3-169.1-52z"></path><path fill="#0052b4" d="M255.7 167a89 89 0 0 0-41.9 10.6 89 89 0 0 0-39.6 43.4 181.7 181.7 0 0 1 169.1 52.2 89 89 0 0 0-9-59.4 89 89 0 0 0-78.6-46.8zM212 250.5a149 149 0 0 0-45 6.8 89 89 0 0 0 10.5 40.9 89 89 0 0 0 120.6 36.2 89 89 0 0 0 30.7-27.3A151 151 0 0 0 212 250.5z"></path></g></svg> <span style="font-size: 14px;padding-left: 5px;">+55</span> </div>
                      </div>
                      </div>
   



<p style="text-align: center;font-size: 10px;color: white;font-weight: lighter;margin-bottom: -14px" class="text-sm text-gray-500 dark:text-gray-300 mb-6 pt-4"><a @click="$router.push('/terms/service')" href="" >Ao se registrar <strong style="color:var(--ci-primary-color);font-weight: lighter;">você concorda com nossos termos e condições</strong></a></p>

<div class="mt-5 w-full flex flex-col items-center">
    <button style="color: var(--title-color);font-size: 17px;font-weight: 600;padding: 12px;width: 100%;margin: 0 auto;color: var(--title-color);" type="submit" class="ui-button-blue w-full mb-3">
       Criar conta <i class="fa-solid fa-arrow-right"></i>
    </button>



</div>
</form>

                                <!-- <div class="login-wrap mt-5">
                                    <div class="line-text">
                                        <div class="l"></div>
                                        <div class="t">{{ $t('Register with your social networks') }}</div>
                                        <div class="l"></div>
                                    </div>

                                    <div class="social-group mt-3">
                                        <a :href="redirectSocialTo()" class="text-social-button hover:text-white focus:ring-4 focus:outline-none font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:hover:text-white ">
                                            <i class="fa-brands fa-google"></i>
                                        </a>
                                    </div>
                                </div> -->
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
import HttpApi from "@/Services/HttpApi.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {useRoute, useRouter} from "vue-router";
import {onMounted, reactive} from "vue";
import {useSpinStoreData} from "@/Stores/SpinStoreData.js";
import {useSettingStore} from "@/Stores/SettingStore.js";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";

export default {
    props: [],
    components: {LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            typeInputPassword: 'password',
            isReferral: false,
            registerForm: {
                name: '',
                email: '',
                password: '',
                reference_code: '',
                term_a: false,
                agreement: false,
                spin_data: null
            },
        }
    },
    setup() {
        const router = useRouter();
        const routeParams = reactive({
            code: null,
        });

        onMounted(() => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('code')) {
                routeParams.code = params.get('code');
            }
        });

        return {
            routeParams,
            router
        };
    },
    computed: {
        getSetting: function() {
                const _this = this;
                const settingStore = useSettingStore();
                const settingData = settingStore.setting;

                if(settingData) {
                    _this.setting = settingData;
                }
            },
        setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    beforeUnmount() {

    },
    mounted() {
        const router = useRouter();
        if(this.isAuthenticated) {
            router.push({ name: 'home' });
        }

        if (this.router.currentRoute.value.params.code) {
            try {
                const str = atob(this.router.currentRoute.value.params.code);
                const obj = JSON.parse(str);


                this.registerForm.spin_token = this.router.currentRoute.value.params.code;
            } catch (e) {
                this.registerForm.reference_code = this.routeParams.code;
                this.isReferral = true;
            }
        }else if(this.routeParams.code) {
            this.registerForm.reference_code = this.routeParams.code;
            this.isReferral = true;
        }
    },
    methods: {
        redirectSocialTo: function() {
            return '/auth/redirect/google'
        },
        togglePassword: function() {
            if(this.typeInputPassword === 'password') {
                this.typeInputPassword = 'text';
            }else{
                this.typeInputPassword = 'password';
            }
        },
        registerSubmit: async function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            const authStore = useAuthStore();
            await HttpApi.post('auth/register', _this.registerForm)
                .then(response => {
                    if(response.data.access_token !== undefined) {
                        authStore.setToken(response.data.access_token);
                        authStore.setUser(response.data.user);
                        authStore.setIsAuth(true);

                        _this.registerForm = {
                            name: '',
                            email: '',
                            password: '',
                            reference_code: '',
                            term_a: false,
                            agreement: false,
                            spin_data: null
                        };

                        _this.router.push({ name: 'home' });
                        _toast.success(_this.$t('Your account has been created successfully'));
                       
                    }
                    
                    if(_this.isCasinoPlayPage){
                            location.reload();
                        }else{
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
    created() {
        this.getSetting();
        this.custom = custom;
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
