<template>
    <Teleport to="body">
        <transition name="promo-fade">
            <div v-if="visible" class="promo-backdrop" role="dialog" aria-modal="true" aria-labelledby="first-deposit-title">
                <section class="promo-card">
                    <button class="promo-close" type="button" aria-label="Fechar oferta" @click="close">×</button>
                    <div class="promo-content">
                        <span class="promo-kicker">⚡ OFERTA DE BOAS-VINDAS</span>
                        <h2 id="first-deposit-title">Deposite e ganhe<br><strong>rodadas grátis</strong></h2>
                        <p class="promo-subtitle">Escolha uma oferta e aproveite enquanto há tempo.</p>
                        <div class="promo-expiry">
                            <span>EXPIRA EM</span>
                            <strong>{{ formattedTime }}</strong>
                        </div>
                        <div class="promo-offers">
                            <button v-for="offer in offers" :key="offer.amount" type="button" @click="goToDeposit(offer.amount)">
                                <span>DEPOSITE <b>R$ {{ offer.amount }}</b></span>
                                <span>E GANHE <b>{{ offer.spins }} RODADAS</b></span>
                            </button>
                        </div>
                        <button class="promo-cta" type="button" @click="goToDeposit()">DEPOSITAR AGORA</button>
                        <small>Rodadas grátis sujeitas aos termos da promoção.</small>
                    </div>
                </section>
            </div>
        </transition>
    </Teleport>
</template>

<script>
import HttpApi from "@/Services/HttpApi.js";
import { useAuthStore } from "@/Stores/Auth.js";

const PROMO_DURATION = 30 * 60 * 1000;

export default {
    name: "FirstDepositPromoModal",
    data() {
        return {
            visible: false,
            remaining: 0,
            timer: null,
            offers: [
                { amount: 20, spins: 10 },
                { amount: 50, spins: 25 },
                { amount: 100, spins: 50 },
            ],
        };
    },
    computed: {
        auth() {
            return useAuthStore();
        },
        formattedTime() {
            const minutes = Math.floor(this.remaining / 60);
            const seconds = this.remaining % 60;
            return `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
        },
    },
    watch: {
        "auth.isAuth": {
            immediate: true,
            handler(isAuthenticated) {
                if (isAuthenticated) this.checkEligibility();
                else this.visible = false;
            },
        },
    },
    beforeUnmount() {
        clearInterval(this.timer);
    },
    methods: {
        async checkEligibility() {
            try {
                const { data } = await HttpApi.get("wallet/deposit/first-deposit-status");
                const hasCompletedDeposit = Boolean(data?.hasCompletedDeposit);
                const userId = this.auth.user?.id || "guest";
                const dismissed = sessionStorage.getItem(`first-deposit-promo-dismissed-${userId}`);

                if (!hasCompletedDeposit && !dismissed) {
                    this.startTimer(userId);
                    this.visible = true;
                }
            } catch (error) {
                this.visible = false;
            }
        },
        startTimer(userId) {
            const key = `first-deposit-promo-expires-${userId}`;
            let deadline = Number(localStorage.getItem(key));
            if (!deadline) {
                deadline = Date.now() + PROMO_DURATION;
                localStorage.setItem(key, String(deadline));
            }
            const tick = () => {
                this.remaining = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
                if (this.remaining === 0) clearInterval(this.timer);
            };
            tick();
            clearInterval(this.timer);
            this.timer = setInterval(tick, 1000);
        },
        close() {
            const userId = this.auth.user?.id || "guest";
            sessionStorage.setItem(`first-deposit-promo-dismissed-${userId}`, "1");
            this.visible = false;
        },
        goToDeposit(amount) {
            if (amount) localStorage.setItem("first-deposit-promo-amount", String(amount));
            this.visible = false;
            this.$router.push({ name: "profileDeposit" });
        },
    },
};
</script>

<style scoped>
.promo-backdrop{position:fixed;inset:0;z-index:9999999;display:grid;place-items:center;padding:18px;background:rgba(5,7,18,.86);backdrop-filter:blur(7px)}
.promo-card{position:relative;width:min(430px,100%);overflow:hidden;border:1px solid rgba(167,244,50,.35);border-radius:24px;background:radial-gradient(circle at 80% 10%,rgba(167,244,50,.18),transparent 35%),linear-gradient(145deg,#28233f,#111522 65%);box-shadow:0 25px 80px rgba(0,0,0,.65),0 0 45px rgba(167,244,50,.12);color:#fff}
.promo-content{padding:34px 24px 24px}.promo-close{position:absolute;right:14px;top:12px;z-index:2;width:34px;height:34px;border:1px solid rgba(255,255,255,.25);border-radius:50%;font-size:25px;line-height:28px;color:#fff;background:rgba(0,0,0,.25)}
.promo-kicker{font-size:12px;letter-spacing:.08em;color:#c9c6d8}.promo-card h2{margin:12px 0 8px;font-size:34px;line-height:1.02;text-transform:uppercase;font-weight:900}.promo-card h2 strong{color:#a7f432}.promo-subtitle{color:#c9c6d8;font-size:14px}
.promo-expiry{display:flex;align-items:flex-end;justify-content:space-between;margin:18px 0 14px;padding:12px 14px;border-radius:12px;background:rgba(0,0,0,.25);color:#ff4f86}.promo-expiry span{font-size:12px;font-weight:800}.promo-expiry strong{font-variant-numeric:tabular-nums;font-size:28px;line-height:1}
.promo-offers{display:grid;gap:9px}.promo-offers button{display:flex;justify-content:space-between;align-items:center;padding:13px;border:1px solid rgba(255,255,255,.14);border-radius:12px;background:rgba(10,13,27,.72);color:#ddd;text-align:left;font-size:10px}.promo-offers b{display:block;margin-top:2px;font-size:17px;color:#fff}.promo-offers span:last-child{text-align:right}.promo-offers span:last-child b{color:#a7f432}
.promo-cta{width:100%;margin-top:14px;padding:14px;border-radius:12px;background:#a7f432;color:#10151b;font-size:17px;font-weight:900}.promo-card small{display:block;margin-top:10px;text-align:center;color:#8e92a3;font-size:10px}.promo-fade-enter-active,.promo-fade-leave-active{transition:.2s}.promo-fade-enter-from,.promo-fade-leave-to{opacity:0}
</style>
