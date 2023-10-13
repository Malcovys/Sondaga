import { defineStore } from 'pinia'

export const useSingUpStore = defineStore("singUpStore", {
    state: () => ({
        isCreated: false,
    }),
    actions:{
        setIsCreated(value) {
            this.isCreated = value;
        }
    }
});