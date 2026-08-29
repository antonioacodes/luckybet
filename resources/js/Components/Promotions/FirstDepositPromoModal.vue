<template>
    <Teleport to="body">
        <transition name="promo-fade">
            <div v-if="visible" class="promo-backdrop" role="dialog" aria-modal="true" aria-labelledby="first-deposit-title">
                <section class="promo-card">
                    <div class="promo-hero" aria-hidden="true"><img :src="promoHeroUrl" alt=""></div>
                    <button class="promo-close" type="button" aria-label="Fechar oferta" @click="close">×</button>
                    <div class="promo-content">
                        <span class="promo-kicker">⚡ OFERTA EXCLUSIVA</span>
                        <h2 id="first-deposit-title"><span style="color: white;">Recarregue e ganhe</span><br><strong>rodadas grátis</strong></h2>
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
            promoHeroUrl: "https://www.pgsoft.com/uploads/Games/Images/54cd3699-c08e-4c00-8d9e-ca5932d3c7d5.png",
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
                const dismissedKey = `first-deposit-promo-dismissed-${userId}`;
                const today = new Date().toISOString().slice(0, 10);
                const dismissed = sessionStorage.getItem(dismissedKey) === today;

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
            if (!deadline || deadline <= Date.now()) {
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
            sessionStorage.setItem(`first-deposit-promo-dismissed-${userId}`, new Date().toISOString().slice(0, 10));
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
.promo-card{position:relative;width:min(430px,100%);overflow:hidden;border:1px solid color-mix(in srgb,var(--ci-primary-color) 38%,transparent);border-radius:24px;background:radial-gradient(circle at 80% 10%,color-mix(in srgb,var(--ci-primary-color) 16%,transparent),transparent 35%),var(--card-color-dark,var(--background-color,#101522));box-shadow:0 25px 80px rgba(0,0,0,.65),0 0 45px color-mix(in srgb,var(--ci-primary-color) 13%,transparent);color:var(--text-color,#fff)}
.promo-hero{position:absolute;right:-18px;top:10px;width:225px;height:225px;opacity:.92;pointer-events:none}.promo-hero:after{content:"";position:absolute;inset:-1px;background:linear-gradient(90deg,var(--card-color-dark,var(--background-color,#101522)) 0%,transparent 58%),linear-gradient(0deg,var(--card-color-dark,var(--background-color,#101522)) 0%,transparent 48%)}.promo-hero img{width:100%;height:100%;object-fit:contain;filter:saturate(1.1) drop-shadow(-14px 12px 16px rgba(0,0,0,.72))}
.promo-content{position:relative;z-index:1;padding:34px 24px 24px}.promo-content>h2,.promo-content>.promo-subtitle{max-width:72%}.promo-close{position:absolute;right:14px;top:12px;z-index:2;width:34px;height:34px;border:1px solid rgba(255,255,255,.25);border-radius:50%;font-size:25px;line-height:28px;color:#fff;background:rgba(0,0,0,.25)}
.promo-kicker{font-size:12px;letter-spacing:.08em;color:#c9c6d8}.promo-card h2{margin:12px 0 8px;font-size:34px;line-height:1.02;text-transform:uppercase;font-weight:900}.promo-card h2 strong{color:var(--ci-primary-color)}.promo-subtitle{color:#c9c6d8;font-size:14px}
.promo-expiry{display:flex;align-items:flex-end;justify-content:space-between;margin:18px 0 14px;padding:12px 14px;border-radius:12px;background:rgba(0,0,0,.25);color:#ff4f86}.promo-expiry span{font-size:12px;font-weight:800}.promo-expiry strong{font-variant-numeric:tabular-nums;font-size:28px;line-height:1}
.promo-offers{display:grid;gap:9px}.promo-offers button{display:flex;justify-content:space-between;align-items:center;padding:13px;border:1px solid rgba(255,255,255,.14);border-radius:12px;background:rgba(10,13,27,.72);color:#ddd;text-align:left;font-size:12px}.promo-offers b{display:block;margin-top:2px;font-size:17px;color:#fff}.promo-offers span:last-child{text-align:right}.promo-offers span:last-child b{color:var(--ci-primary-color)}
.promo-cta{width:100%;margin-top:14px;padding:14px;border-radius:12px;background:var(--ci-primary-color);color:var(--sub-text-color,#10151b);font-size:17px;font-weight:900}.promo-card:before{content:"";position:absolute;inset:auto 0 0;height:3px;background:linear-gradient(90deg,var(--ci-primary-color),color-mix(in srgb,var(--ci-primary-color) 45%,#8b5cf6),#ff4f86)}
.promo-card small{display:block;margin-top:10px;text-align:center;color:#8e92a3;font-size:10px}.promo-fade-enter-active,.promo-fade-leave-active{transition:.2s}.promo-fade-enter-from,.promo-fade-leave-to{opacity:0}
</style>
