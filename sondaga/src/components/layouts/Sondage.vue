<script setup>
import { ref, watchEffect} from 'vue';
import axios from 'axios';
import Button from './Button.vue';
import SondageChartBar from '../charts/SondageChartBar.vue';
import { useAuthStore } from '../../stores/authStore';

const props = defineProps([ 
    'is_have_voted',
    'id',
    'options',
    'title',
    'votes_numer',
    'list_votes',
]);

const vote = ref(null);
const statistics_data = ref([]);

const handleSubmit = async () => {
    try {
        const authStore = useAuthStore();

        await axios.post(import.meta.env.VITE_API_BASE_URL+'sondage/vote', {
                option: vote.value,
                user_id: authStore.uid,
                sondage_id: props.id,
            }
        );

    } catch(error) {
        console.log("Get sondage Error (Sondage component) : " + error);
    }
};

watchEffect(function statistic() {
    const countArray = props.options.map(option => {
        return props.list_votes.filter(vote => vote.option === option).length;
    });
    statistics_data.value = countArray;
});
</script>

<template>
    <form @submit.prevent="handleSubmit" class="bg-white rounded-sm p-3 mr-2 sm:w-[35rem] md:w-[40rem] lg:w-[50rem] shadow flex flex-col">
        <h1 v-if="!is_have_voted" class="font-bold">{{ props.title }}</h1>

        <div v-if="!is_have_voted" class="my-4 flex flex-col h-full">
            <div v-for="(option, index) in props.options" :key="index">
                <input type="radio" id="{{ index }}" :value="option" v-model="vote">
                <label for="option" class="ml-2">{{ option }}</label>
            </div>
        </div>

        <div v-if="is_have_voted" class="options my-4">
           <SondageChartBar
           :title="props.title"
           :data="statistics_data"
           :categories="props.options"/>
        </div>

        <div class="grid self-end w-full">
            <div class="font-semibold opacity-50">Total Votes: {{ props.votes_numer }}</div>

            <div  v-if="!is_have_voted" class="justify-self-end">
                <Button class="bg-sky-950 text-white">Vote</Button>
            </div> 

        </div>
    </form>
</template>