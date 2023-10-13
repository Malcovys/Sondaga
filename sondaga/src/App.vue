<script setup>
import Header from './components/Header.vue';
import NavMenu from './components/NavMenu.vue';

import { useAuthStore } from './stores/authStore';

const authStore = useAuthStore();
</script>

<template>
  <Header/>
  <div class="pt-[3rem]">
    <NavMenu class="fixed" v-if="authStore.isAuthenticated"/>
    <router-view class="ml-[5rem]"></router-view>
  </div> 
</template>

<style>
.fixed, .absolute {
  z-index: 1;
}

.page-icon-container {
  width: 95%;
  height: 515px;
  display: flex;
  justify-content: center;
}
.page-icon {
  width: 150px;
  color: #64748bb9;
}
</style>
