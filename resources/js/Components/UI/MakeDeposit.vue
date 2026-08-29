<style>
.container-deposit {
    margin: 4%;
  	z-index:9999!important;
}
.ui-button-blue2 {
    font-size: .875rem;
    font-weight: 700;
    line-height: 1.25rem;
    border-radius: 3px;
    -webkit-box-shadow: 0px 2px 11px 0px var(--ci-primary-color);
    -moz-box-shadow: 0px 2px 11px 0px var(--ci-primary-color);
    box-shadow: 0px 2px 11px 0px var(--ci-primary-color);
    background-color: var(--ci-primary-color);
    color: var(--sub-text-color);
    width: auto;
    padding: 9px 15px;
    -webkit-flex: none;
    -ms-flex: none;
    flex: none;
}

.ui-button-blue2:hover {
    opacity: .9;
}
.pixFont {
    color: black;
    font-size: 10px;
    font-weight: bold
}

@media(max-width:768px) {
    .pixFont {
        font-size: 8px;
    }
    .container-deposit {
        margin: 0;
        width: 100vw;
        padding-bottom: 50px;
        height: 100vh;
    }
    .ui-button-blue2 {
    font-size: .775rem;
    font-weight: 700;
    line-height: 1.25rem;
    
    padding: 5px 8px;
   
}
}
@media(max-width:376px) {
     .container-deposit {
        margin: 0;
        width: 100vw;
        height: calc(auto + 160px);
    }
}
</style>
<template>
    
    <div class="relative flex items-center opacidade-hover" style="">
           <div data-v-4265f672="" class="aaDu6 flex items-center " style="border-radius: 30px;position: absolute;top: 0;right: 0;background-color: #FFE800;margin-top: -7px;padding-left: 3px;padding-right: 3px"><i style="font-size: 12px;color: #01BEB0;" class="fa-brands fa-pix"></i><span data-v-4265f672="" class="pixFont" style="">PIX</span></div>
    <button style="background-color: var(--ci-primary-color);border-radius: 30px;
" class="md:py-[6px] md:px-[20px] py-[5px] px-[13px] md:text-base text-xs" @click.prevent="toggleModalDeposit" type="button" :class="[showMobile === true ? 'hidden md:block' : '', isFull ? 'w-full' : '']">
        <strong class="md:text-base text-xs" style="color: var(--sub-text-color);">Depositar</strong>
    </button>
</div>
    <div style="background-color:rgb(0,255,90, 8%);
  backdrop-filter: blur(10px);height: 100vh;z-index: 1000;" id="modalElDeposit" aria-hidden="true" class="fixed top-0 left-0 right-0 hidden w-full overflow-x-hidden overflow-y-auto">
 
        <div class="relative w-full max-w-2xl container-deposit overflow-y-auto" style="background-color: var(--ci-gray-over);border-radius: 8px;max-width: 550px;margin: 0 auto;z-index: 2;">

            
            
            <div class="flex flex-col pb-8 my-auto relative" style="justify-content: flex-end;position: relative;">

                <a style="position: absolute;right: 2%;top: 2%;z-index: 3;" class="login-register-x" @click.prevent="toggleModalDeposit" href="">
                    <div class="x-mark-scale" style="box-shadow: 0px 2px 20px rgbrgb(0,255,90, 14%);background-color: var(--carousel-banners-dark);padding: 7px 13px;border-radius: 5px;max-width: 40px;">
                    <i style="color: var(--ci-primary-color);font-weight: bold" class="fa-light fa-x"></i>
                    </div>
                </a>

            

                <DepositWidget ref="depositWidget" />
            </div>
        </div>
    </div>

</template>

<script>
    import {useAuthStore} from "@/Stores/Auth.js";
    import DepositWidget from "@/Components/Widgets/DepositWidget.vue";
    import {onMounted, ref, watch, watchEffect} from "vue";
    import {initFlowbite} from "flowbite";
    import HttpApi from "@/Services/HttpApi.js";

    import { useRouter } from 'vue-router';

    export default {
        props: ['showMobile', 'title', 'isFull'],
        components: { DepositWidget },
        data() {
            return {
                isModalOpen: true,
                isLoading: false,
                modalDeposit: null,
                isLoadingWallet: true,
                wallet: null,
            }
        },
        setup(props) {
            onMounted(() => {
                initFlowbite();
            });

            const router = useRouter();
            const isCasinoPlayPage = ref(false);

            watchEffect(() => {
                checkRoute();
            });

            onMounted(() => {
                checkRoute();
            });

            function checkRoute() {
                // Verifique se a rota atual é 'casinoPlayPage'
                isCasinoPlayPage.value = router.currentRoute._value.name === 'casinoPlayPage';
            }

            return {
                router,
                isCasinoPlayPage
            };

        },
        computed: {
            isAuthenticated() {
                const authStore = useAuthStore();
                return authStore.isAuth;
            },
        },
        mounted() {
            window.scrollTo(0, 0);
            this.modalDeposit = new Modal(document.getElementById('modalElDeposit'), {
                placement: 'center',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 backmodaldeposit',
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
            window.addEventListener('open-deposit-modal', this.openDepositFromPromotion);
        },
        beforeUnmount() {
            window.removeEventListener('open-deposit-modal', this.openDepositFromPromotion);
        },
        methods: {
            openDepositFromPromotion(event) {
                const amount = Number(event?.detail?.amount);
                if (amount && this.$refs.depositWidget) {
                    this.$refs.depositWidget.setAmount(amount);
                }
                this.modalDeposit.show();
            },
            getWallet: async function() {
                const _this = this;

                await HttpApi.get('profile/wallet')
                    .then(response => {
                        _this.wallet = response.data.wallet;
                        _this.isLoadingWallet = false;
                    })
                    .catch(error => {
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                            if(value == 'unauthenticated') {
                                localStorage. clear();
                                clearInterval(this.processInterval);
                            }
                        });

                        _this.isLoadingWallet = false;
                    });
            },
            toggleModalDeposit: function() {
                this.modalDeposit.toggle();
            },
        },
        async created() {
            await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método

            
        },
        watch: {

        },
    };
</script>

<style scoped>

</style>
