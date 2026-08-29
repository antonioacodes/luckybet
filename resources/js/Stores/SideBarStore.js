import { defineStore } from 'pinia'

export const sidebarStore = defineStore('sidebar', {
    state() {
        const savedStatus = localStorage.getItem('sidebarStatus');
        return {
            sidebarStatus: savedStatus ? JSON.parse(savedStatus) : false,
            
            // ✅ NOVO: Adicionamos o estado de visibilidade do banner aqui.
            // O padrão é 'true', ou seja, o banner é visível na maioria das páginas.
            isTopBannerVisible: true, 
        };
    },
    actions: {
        setSidebarToogle() {
            this.sidebarStatus = !this.sidebarStatus;
            localStorage.setItem('sidebarStatus', JSON.stringify(this.sidebarStatus));
        },
        setSidebarStatus(status) {
            this.sidebarStatus = status;
            localStorage.setItem('sidebarStatus', JSON.stringify(this.sidebarStatus));
        },

        // ✅ NOVO: Adicionamos as actions para controlar o banner.
        /**
         * Define a visibilidade do Top Banner.
         * @param {boolean} isVisible 
         */
        setTopBannerVisibility(isVisible) {
            this.isTopBannerVisible = isVisible;
        },
    },
    getters: {
        getSidebarStatus() {
            return this.sidebarStatus;
        },

        // ✅ NOVO: Adicionamos um getter para o status do banner.
        // Isso mantém o padrão do seu código.
        getIsTopBannerVisible() {
            return this.isTopBannerVisible;
        },
    },
})
