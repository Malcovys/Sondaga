<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useAuthStore } from '../stores/authStore';

import Button from './layouts/Button.vue';

const title = ref(null);
const option = ref(null);
const options = ref([]);
const inputOpt = ref(null);

defineEmits([
    'close'
]);

const addOption = () => {
    if (option.value) {
        options.value.push(option.value);
        option.value = null;
    }
};

const touchOption = (value, index) => {
    option.value = value;
    inputOpt.value.focus();

    if(index) {
        options.value = options.value.slice(index);
    } else {
        options.value = [];
    }
};

const handleSubmit = async () => {
    try  {
        const authStore = useAuthStore();

        const response = await axios.post(
            import.meta.env.VITE_API_BASE_URL+'sondage/save', {
                titre: title.value,
                options: options.value,
                user_id: authStore.uid,
            }
        );

        if(response.status == 200) {
            title.value = null;
            options.value = [];
        }

    } catch (error) {
        console.error("Create sondage error (SondageForm) : " + error);
    }
}

</script>

<template>
    <form @submit.prevent="handleSubmit" class="bg-white rounded-lg px-5 pb-2 flex flex-col space-y-5  sm:w-[30rem] sm:min-h-[27rem] w-[25rem]">
        <div>
            <div class="grid">
            <button type="button" @click="$emit('close')" class="justify-self-end rounded-full py-2 px-4 hover:bg-zinc-100 font-md">X</button>
        </div>
        <div class="flex flex-row justify-center">
            <h1 class="border-b font-bold">Nouveau sondage 🕵️‍♂️</h1>
        </div>
        </div>
        <div class="grid">
            <label for="title">Titre :</label>
            <input type="text" :id="[title ? 'fill' : 'title']" v-model="title">
        </div>
        <div class="grid">
            <label for="title">Options :</label>
            <input @keydown.enter.prevent="addOption" ref="inputOpt" type="text" id="option" v-model="option">
        </div>
        <div id="list-options" class="grid grid-cols-5 gap-4  pt-10">
            <span class="option-item" 
                v-for="(option, index) in options" :key="index">
                <button type="button" @click="touchOption(option, index)">{{ option }}</button>
            </span>
        </div>
        <div class="pt-10 grid"><Button class="justify-self-end bg-sky-950 text-white">Créer</Button></div>
    </form>
</template>

<style scoped>
.option-item, #title, #option, #fill {
    border-color: #082f49;
}

#title:focus, #option:focus, #fill{
    outline: none;
    opacity: 1;
    transition: 0.5s;
}

#fill {
    border-bottom: 1px solid;
}

#title, #option {
    border-bottom: 1px solid;
    opacity: 0.2;
    transition: 0.5s;
}
.option-item {
    display: flex;
    justify-content: center;
    text-align: center;
    padding: 2px;
    color: #082f49;
    border: 1.5px solid;
    border-radius: 10%;
    font-weight: bold;
    transition: 0.5s;
}
.option-item:hover {
    color: white;
    background-color: #082f49;
    transition: 0.5s;
}
</style>