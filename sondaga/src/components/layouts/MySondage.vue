<script setup>
import axios from 'axios';
import { ref, watchEffect} from 'vue';
import Button from './Button.vue';

import SondageChartPolarArea from '../charts/SondageChartPolarArea.vue';
import { useAuthStore } from '../../stores/authStore';

const props = defineProps([ 
    'id',
    'options',
    'title',
    'votes_numer',
    'list_votes',
]);
const statistics_data = ref([]);
const transform = ref(false);

const remove = async() => {

    const authStore = useAuthStore();
    try {
        await axios.delete(import.meta.env.VITE_API_BASE_URL+'sondage/remove/'+props.id+'-'+authStore.uid);
    } catch(error) {
        console.error('(MySondage layouts)Fail remove sondage id : '+props.id);
    }
}
    

watchEffect(function statistic() {
    const countArray = props.options.map(option => {
        return props.list_votes.filter(vote => vote.option === option).length;
    });
    statistics_data.value = countArray;
});
</script>

<template>
    <div v-if="!transform"  @click="transform = true"
    class="item 
        hover:scale-105 duration-700 transition-transform transform">
        <SondageChartPolarArea
        :title="props.title"
        :options="props.options"
        :data="statistics_data"/>
        <div class="grid self-end w-full pb-2">
            <div class="font-semibold opacity-50">Total Votes: {{ props.votes_numer }}</div>
        </div>
    </div> 

    <div v-else="transform"
    class="item
        sm:absolute fixed xl:w-[34rem] ease-in-out xl:top-[5rem] xl:left-[28rem]">
        <div class="opacity-[60%] grid w-full">
            <button @click="transform = false" class="justify-self-end rounded-full hover:bg-slate-100 w-5">x</button>
        </div>
        <SondageChartPolarArea
        :title="props.title"
        :options="props.options"
        :data="statistics_data"/>
        <div class="grid self-end w-full pb-2">
            <div class="font-semibold opacity-50">Total Votes: {{ props.votes_numer }}</div>
            <div class="justify-self-end">
                <Button @click="remove" class="bg-red-600 border-0 text-white" type="button">Supprimer</Button>
            </div> 
        </div>
    </div>
</template>

<style scoped>
.item {
    background-color: white;
    margin-right: 8px;
    border-radius: 8px;
    padding-left: 8px;
    padding-right: 8px
}
</style>