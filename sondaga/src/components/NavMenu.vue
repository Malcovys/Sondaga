<script setup>
import IconHome from './icons/IconHome.vue';
import IconHand from './icons/IconHand.vue';
import IconChart from './icons/IconChart.vue';
</script>

<template>
    <nav id="nav-bar" class="border w-[4rem] h-[15rem] shadow m-1 rounded flex justify-center bg-white">
        <ul class="p-1 flex flex-col justify-center items-center space-y-2">
            <li class="item">
                <router-link 
                    to="/"
                    class="item-icon"
                ><IconHome/></router-link>
            </li>
            <li class="item">
                <router-link 
                    to="/vote"
                    class="item-icon"
                ><IconHand/></router-link>
            </li>
            <li class="item">
                <router-link 
                    to="/sondage"
                    class="item-icon"
                ><IconChart/></router-link>
            </li>
        </ul>
    </nav>
</template>

<style scoped>
#nav-bar a.router-link-exact-active{
    color: #082f49;
    background-color: #d6d3d13d;
    font-weight: 700;
}

.item-icon:hover{
    background-color: #d6d3d1;
    color: black;
}

.item{
    display: flex;
    justify-content: center;
    width: 2.8em;
    height: 2.8em;
}
.item-icon{
    display: flex;
    justify-content: center;
    width: 2em;
    height: 2em;
    padding: 2px;
    border-radius: 50%;
    color: #78716c;
}
</style>