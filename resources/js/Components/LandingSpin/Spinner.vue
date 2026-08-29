<template>
    <div ref="pixiContainer" id="pixiContainer"></div>
    <ComponentLastWinners
        :winners="winners"
        @close="HandleCloseWinList"
        @close-modal="HandleCloseModal"
        v-if="showWinList"
    ></ComponentLastWinners>
</template>

<script>
import ComponentLastWinners from '@/Components/LandingSpin/LastWinners.vue';
import { Application, Container, Sprite, Assets } from 'pixi.js';
import { Howl } from 'howler';
import { gsap } from "gsap";
import HttpApi from "@/Services/HttpApi.js";
import { useSpinStoreData } from '@/Stores/SpinStoreData';

export default {
    emits: ['prized', 'hide-win-list', 'close-modal', 'loaded'],
    props: ['showWinList', 'winners'],
    components: {
        ComponentLastWinners
    },
    data() {
        return {
            app: null,
            pixiWidth: 420,
            pixiHeight: 633,
            wheel: new Container(),
            centerContainer: new Container(),
            textContainer: new Container(),
            sounds: new Howl({
                src: ['/assets/sounds/spin/b8fb8ba1.mp3'],
                volume: 1,
                sprite: {
                    rooling: [2400, 2000, true],
                    stopping: [100, 1700],
                    winner: [5900, 3700]
                }
            }),
            spinStoreData: useSpinStoreData(),
            selectedPrize: null,
            spinning: false,
            spinVelocity: 0,
            stopSpinningInterval: null,
            buttonSprite: null,
            circleSpriteLight: null,
            lightTurn: false,
        };
    },
    async mounted() {
        this.initPixi();
        await this.loadAssets();
        this.GetWheelPrizes();
    },
    methods: {
        initPixi() {
            this.app = new Application({
                width: this.pixiWidth,
                height: this.pixiHeight,
                antialias: true,
                transparent: true,
                resolution: 1
            });
            this.$refs.pixiContainer.appendChild(this.app.view);
            this.app.stage.addChild(this.wheel, this.textContainer);
        },
        async loadAssets() {
            const assetManifest = {
                spinPoint: '/assets/images/spin/spin-point.png',
                spinBtn: '/assets/images/spin/spin-btn.png',
                spinBackground: '/assets/images/spin/spin-background.png',
                spinLight: '/assets/images/spin/spin-light.png',
                spinHand: '/assets/images/spin/spin-hand.png',
                spinHead: '/assets/images/spin/spin-head.png',
                spinIcon_brl: '/assets/images/spin/spin-icon-brl.png'
            };
            
            const loadedAssets = await Assets.load(Object.values(assetManifest));
            
            this.buttonSprite = new Sprite(loadedAssets[assetManifest.spinBtn]);
            this.circleSpriteLight = new Sprite(loadedAssets[assetManifest.spinLight]);
            
            this.startRotation();
        },
        startRotation() {
            setInterval(() => {
                this.lightTurn = !this.lightTurn;
                this.circleSpriteLight.rotation = this.lightTurn ? Math.PI * 2 : (Math.PI / 180) * 22;
            }, 1000);
        },
        async startSpinning() {
            this.sounds.play('rooling');
            this.spinVelocity = 0.01;
            this.stopSpinningInterval = setInterval(() => {
                if (this.spinVelocity < 0.5) {
                    this.spinVelocity += 0.01;
                } else {
                    clearInterval(this.stopSpinningInterval);
                }
            }, 100);
            this.app.ticker.add(this.spinUpdate);

            const response = await HttpApi.post('spin/result?sessionId=1', { action: 'start' });
            this.selectedPrize = response.data.data.index;
            this.spinStoreData.set(response.data);
            setTimeout(() => {
                this.sounds.stop();
                this.sounds.play('stopping');
                setTimeout(() => this.stopSpinning(), 1000);
            }, 2000);
        },
        spinUpdate(delta) {
            if (this.spinVelocity > 0) {
                this.wheel.rotation += this.spinVelocity * delta;
                if (this.wheel.rotation >= 6.28) {
                    this.wheel.rotation = 0;
                }
            } else {
                clearInterval(this.stopSpinningInterval);
                this.finalPosition();
            }
        },
        finalPosition() {
            this.app.ticker.remove(this.spinUpdate);
            gsap.to(this.wheel, { rotation: this.calculateTargetRotation(), duration: 2, ease: "elastic.out(1, 0.3)", onComplete: this.handleWinnerEffects });
        },
        handleWinnerEffects() {
            this.sounds.stop();
            this.sounds.play('winner');
            this.$emit('prized', this.selectedPrize);
        },
        stopSpinning() {
            clearInterval(this.stopSpinningInterval);
            this.spinVelocity = 0;
        },
        async GetWheelPrizes() {
            const response = await HttpApi.get('spin/prizes?sessionId=3', { action: 'get-winners' });
            this.wheelPrizes = response.data;
        },
        HandleCloseWinList() {
            this.$emit('hide-win-list');
        },
        HandleCloseModal() {
            this.$emit('close-modal');
        }
    }
};
</script>
