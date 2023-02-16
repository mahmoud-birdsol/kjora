<template>
    <!-- search input -->
    <div class="grid items-center w-full grid-cols-1 ">

        <input type="search" class="w-full col-start-1 row-start-1 pis-10 rounded-3xl">
        <div class="col-start-1 row-start-1 pis-3">
            <MagnifyingGlassIcon class="w-5 h-5 text-primary">
            </MagnifyingGlassIcon>
        </div>

    </div>
    <div>
        <p class="mb-3 font-bold text-black uppercase">total (3)</p>
        <div class="flex flex-col gap-3 hideScrollBar max-h-[40vh] overflow-auto  lg:max-h-[70vh] ">
            <template v-for="friend in friends" :key="friend.id">

                <ChatFriendCard :friend="friend" />


            </template>
        </div>
    </div>
</template>

<script setup>

import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import ChatFriendCard from './ChatFriendCard.vue';

defineProps({
    friends: Array
})
</script>

<style  >

</style>
