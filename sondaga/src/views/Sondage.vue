<script setup>
import { onMounted, ref, watch } from 'vue';
import { useAuthStore } from '../stores/authStore';
import { getSondage } from '../composables/getSondage';

import CreateSondageForm from '../components/CreateSondageForm.vue';
import Button from '../components/layouts/Button.vue';
import MySondage from '../components/layouts/MySondage.vue';
import IconChartBar from '../components/icons/IconChartBar.vue';

const show = ref(false);
const sondages = ref([]);
const newVote = ref(null);
const newSondage = ref(null);
const removedSondageId = ref(null);
const authStore = useAuthStore();

//Au changement newSondage
watch(newSondage, (newSondage) => {
    if(newSondage.user_id == authStore.uid) {
        sondages.value.unshift(newSondage);
    } 
});

watch(removedSondageId, (id) => {
    let index;

    for(let i=0; i < sondages.value.length; i++){
        if(sondages.value[i].id == id) {
            index = i;
            break;
        }
    }

    sondages.value.splice(index, 1);
});

watch(newVote, (newVote) => {
    if(newVote.user_id == authStore.uid){

        let index = null;
        for(let i=0; i < sondages.value.length; i++){
            if(sondages.value[i].id == newVote.id) {
                index = i;
                break;
            }
        };

        if(index !== null) {
            sondages.value[index].votes = newVote.votes;
            sondages.value[index].votes_number = newVote.votes_number;
        };
    }
});

// prende les datas au montage du component
onMounted(async ()=> {
    try {
        let data = await getSondage();

        data.forEach(element => {
            if(element.user_id == authStore.uid){
                sondages.value.push(element);
            }
        });

    } catch(error) {

    console.error("Get sondage Error (Sondage views) : " + error);

    }
});

// Montage d'une fonction d'écoute websocket
onMounted(() => {
    window.Echo.channel('new-channel').listen('NewSondageEvent', (eventData) => {
            newSondage.value = eventData[0][0];
    });

    window.Echo.channel('remove-channel').listen('RemoveSondageEvent', (eventData) => {
        removedSondageId.value = eventData[0];
    });

    window.Echo.channel('vote-channel').listen('VoteEvent', (eventData) => {
        newVote.value = eventData[0][0];
    });
});
</script>

<template>
    <div>
        <div v-if="show">
            <CreateSondageForm @close="show = false" class="absolute top-[10%] xl:left-[33%] md:left-[29%] lg:left-[35%] sm:left-[19%]"/>
        </div>
        <div class="grid justify-items-end sm:px-10 py-2">
            <Button @click="show = true" type="button">Nouveau sondage</Button>
        </div>
        <div v-if="sondages.length" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 grid-rows-1">
            <div class="my-4" v-for="(sondage, index) in sondages" :key="index">
                <MySondage
                :id="sondage.id"
                :title="sondage.titre"
                :options="sondage.options"
                :list_votes="sondage.votes"
                :votes_numer="sondage.votes_number"/>
            </div>
        </div>
        <div v-else class="page-icon-container">
            <IconChartBar class="page-icon"/>
        </div>
    </div>
</template>

<style scoped>

.tab-item {
    text-align: center;
    font-weight: bold;
}

#sondage-list-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2em;
}
</style>