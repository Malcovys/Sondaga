<script setup>
import axios from 'axios'
import { ref } from 'vue';
import { useAuthStore } from '../stores/authStore';
import { useRouter } from 'vue-router';

const name = ref('');
const password = ref('');

const router = useRouter();
const authStore = useAuthStore();


const handleSubmit = async () => {
    try  {

        const response = await axios.post(
            import.meta.env.VITE_API_BASE_URL+'login', {
                name: name.value,
                password: password.value,
            }
        );

        if(!response.data.authentificationError){

            authStore.setUserId(response.data.id);
            authStore.setUserName(response.data.name);
            authStore.setIsAuthenticated(true);

            router.push('/');

        } else {
            authStore.setAuthentificationError(response.data.authentificationError);
            console.log(authStore.authentificationError)
        }
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <div class="mt-10">
        <div v-if="authStore.authentificationError" class="flex mb-2">
            <h5 class="font-bold text-red-600">{{ authStore.authentificationError }}</h5>
        </div>
        <form  @submit.prevent="handleSubmit" 
        class="flex">
            <div class=" p-8
                rounded-md
                shadow-[0_2.8px_2.2px_rgba(0,_0,_0,_0.034),_0_6.7px_5.3px_rgba(0,_0,_0,_0.048),_0_12.5px_10px_rgba(0,_0,_0,_0.06),_0_22.3px_17.9px_rgba(0,_0,_0,_0.072),_0_41.8px_33.4px_rgba(0,_0,_0,_0.086),_0_100px_80px_rgba(0,_0,_0,_0.12)]
                w-[30rem]">
                <div class="mb-4 font-semibold">Connection</div>
                <div class="mb-4">
                    <label for="username">
                        Nom d'utilisateur
                    </label>
                    <input v-model="name"
                        class="shadow focus:outline-none focus:shadow-outline" 
                        type="text" 
                    required>
                </div>
                <div class="mb-4">
                    <label for="password">
                        Mot de passe
                    </label>
                    <input v-model="password"
                        class="shadow focus:outline-none focus:shadow-outline" 
                        type="password" 
                    required>
                </div>
                <div class="mt-10 flex flex-row space-x-2">
                    <button type="submit"
                        class="rounded bg-sky-500 px-5 py-2 text-stone-100 font-bold">SE CONNECTER</button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped>
.flex {
    justify-content: center;
    align-items: center;
}

label, input {
    color: rgb(55 65 81);
}

label {
    font-size: 14px;
    line-height: 20px;
    font-weight: 700;
    margin-bottom: 8px;
}

input {
    border-width: 1px;
    border-radius: 4px;
    width: 100%;
    padding-top: 8px;
    padding-bottom: 8px;
    line-height: 1.25;
    appearance: none;
}
</style>

