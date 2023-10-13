<script setup>
import { ref, watch, onMounted } from 'vue';
import { useAuthStore } from '../stores/authStore';
import { getSondage } from '../composables/getSondage';
import Sondage from '../components/layouts/Sondage.vue';
import IconPaperAirplane from '../components/icons/IconPaperAirplane.vue';

const sondages = ref([])
const newSondage = ref(null);
const newVote = ref(null);
const removedSondageId = ref(null);
const authStore = useAuthStore();

watch(newSondage, (newSondage) => {
    if(newSondage.user_id != authStore.uid) {
        sondages.value.unshift(newSondage);
    } 
});

watch(removedSondageId, (id) => {

    let index = null;

    for(let i=0; i < sondages.value.length; i++){
        if(sondages.value[i].id == id) {
            index = i;
            break;
        }
    }

    if(index !== null) {
        sondages.value.splice(index, 1);
    }
});

watch(newVote, (newVote) => {
    if(newVote.user_id != authStore.uid){

        let index = null;
        for(let i=0; i < sondages.value.length; i++){
            if(sondages.value[i].id == newVote.id) {
                index = i;
                break;
            }
        };

        if(index !== null) {
            let is_have_voted = false;
            newVote.votes.forEach(vote => {
                if(vote.user_id == authStore.uid) {
                    is_have_voted = true;
                }
            });

            if(is_have_voted) {
                sondages.value.splice(index,1);
            } else {
                sondages.value[index].votes = newVote.votes;
                sondages.value[index].votes_number = newVote.votes_number;
                sondages.value[index].is_have_voted = is_have_voted;
            }
        };
    }
});

onMounted( async () => {
    try  {
        let data = await getSondage();

        data.forEach(element => {
            if(element.user_id != authStore.uid && !element.is_have_voted){
                sondages.value.push(element);
            }
        });

    } catch (error) {
        console.error("Get sondage error (Home view) : " + error);
    }
});

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
        <div v-if="sondages.length" class="flex flex-col w-full justify-center my-5 space-y-5 items-center">
            <div v-for="(sondage, index) in sondages" :key="index">
                <Sondage
                :id="sondage.id"
                :title="sondage.titre"
                :options="sondage.options"
                :list_votes="sondage.votes"
                :votes_numer="sondage.votes_number"
                :is_have_voted="sondage.is_have_voted"/>
            </div>
        </div>
        <div v-else class="page-icon-container">
            <IconPaperAirplane class="page-icon"/>
        </div>
    </div>
</template>
