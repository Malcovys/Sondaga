import { defineStore } from 'pinia'

export const useAuthStore = defineStore("authStore", {
    state: () => ({
        uid : window.localStorage.getItem('uid') || null,
        user: window.localStorage.getItem('name') || null,
        isAuthenticated: window.localStorage.getItem('authenticated') || false,
        authentificationError: null,
    }),
    actions: {
        setUserId(id){
            this.uid = id;
            window.localStorage.setItem('uid', id);
        },
        setUserName(name){
            this.user = name;
            window.localStorage.setItem('name', name);
        },
        setIsAuthenticated(state){
            this.isAuthenticated = state;
            window.localStorage.setItem('authenticated', state);
        },
        setAuthentificationError(error) {
            this.authentificationError = error;
        }
    }
});