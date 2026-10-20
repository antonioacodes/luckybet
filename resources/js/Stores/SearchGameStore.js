import { defineStore } from 'pinia'

export const searchGameStore = defineStore('seachgames', {
    state() {
        return {
            searchgameStatus: false,
        }
    },

    actions: {
        openSearch() {
            this.searchgameStatus = true;
        },
        closeSearch() {
            this.searchgameStatus = false;
        },
        setSearchGameToogle() {
            this.searchgameStatus = !this.searchgameStatus;
        },
    },

    getters: {
        getSearchGameStatus() {
            return this.searchgameStatus
        },
    },

})
