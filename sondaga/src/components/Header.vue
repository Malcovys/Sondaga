<script setup>
import { useAuthStore } from '../stores/authStore';

const authStore = useAuthStore();

const logOut = () => {
        const toRemoveKey = [
            'name',
            'authenticated',
            'uid'
        ];

        for(let i = 0; i < toRemoveKey.length; i++){
            window.localStorage.removeItem(toRemoveKey[i]);
        }

        location.reload();
}
</script>

<template>
    <header id="nav">
        <div v-if="authStore.isAuthenticated">
            <div class="md:flex justify-center">
                <h1 class="font-medium text-white pt-2">Bienvenu {{ authStore.user }}</h1>
            </div>
            <div class="btn">
                <button @click="logOut" 
                    class="px-2 font-semibold border rounded border-white text-white"
                >Deconnection</button>
            </div>
        </div>
        <div v-else
            class="btn">
            <router-link to="/login" class="px-2 font-semibold text-white">SE CONNECTER</router-link>
            <router-link to="/singup" class="px-2 font-semibold text-white">S'ENREGISTER</router-link>
        </div>
    </header>
</template>

<style scoped>
#nav a.router-link-exact-active {
    border: solid white;
}

.btn {
    position: absolute;
    right: 25px;
    bottom: 12px;
}

#nav {
    background-color: rgb(8 47 73);
    height: 3rem;
    position: fixed;
    z-index: 1;
    width: 100vw;
}
</style>