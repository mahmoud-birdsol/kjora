<script setup>
import { ref } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import dayjs from 'dayjs';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import { FlagIcon } from '@heroicons/vue/24/outline'
import ChatFriendCard from '../../Components/ChatFriendCard.vue';
const todayDate = ref(new Date().now)
const friends = [{
    name: 'friend 1', userName: '@friend1', imgUrl: null, id: 1
}, {
    name: 'friend 2', userName: '@friend2', imgUrl: null, id: 2
}, {
    name: 'friend 3', userName: '@friend3', imgUrl: null, id: 3
}, {
    name: 'friend 1', userName: '@friend1', imgUrl: null, id: 1
}, {
    name: 'friend 2', userName: '@friend2', imgUrl: null, id: 2
}, {
    name: 'friend 3', userName: '@friend3', imgUrl: null, id: 3
}, {
    name: 'friend 2', userName: '@friend2', imgUrl: null, id: 2
}, {
    name: 'friend 3', userName: '@friend3', imgUrl: null, id: 3
}, {
    name: 'friend 2', userName: '@friend2', imgUrl: null, id: 2
}, {
    name: 'friend 3', userName: '@friend3', imgUrl: null, id: 3
}, {
    name: 'friend 2', userName: '@friend2', imgUrl: null, id: 2
}, {
    name: 'friend 3', userName: '@friend3', imgUrl: null, id: 3
}]
</script>
<template>
    <AppLayout :title="chat">
        <template #header>
            <p>chat</p>
        </template>
        <div class="py-12 ">
            <!-- chat box -->
            <div class="grid  w-full h-full md:grid-cols-[1fr_2fr]  text-neutral-500 bg-stone-300 rounded-2xl ">
                <div
                    class="flex flex-col gap-3 px-6 py-3 md:border-r-2 md:border-r-stone-500 max-md:border-b-2 max-md:border-b-stone-500">
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
                        <div class="flex flex-col gap-3 hideScrollBar max-h-[40vh] lg:max-h-[60vh] overflow-auto">
                            <template v-for="friend in friends" :key="friend.id">

                                <ChatFriendCard :friend="friend" />


                            </template>
                        </div>
                    </div>
                </div>
                <div class="grid grid-row-[1fr_4fr_2fr]">
                    <!-- header -->
                    <div class="flex border-b-2 border-b-stone-500">
                        <div class="flex-1 border-r-2 border-r-stone-500"></div>
                        <div class="flex items-center gap-2 p-4">
                            <button>
                                <MagnifyingGlassIcon class="w-4 h-4 cursor-pointer hover:text-primaryDark text-primary">
                                </MagnifyingGlassIcon>
                            </button>

                            <button>
                                <FlagIcon class="w-4 h-4 text-red-600" />
                            </button>

                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-center">{{ dayjs(todayDate).format('DD/MM/YYYY') }}</div>
                        <div class="flex flex-col gap-4 p-8">
                            <h2 class="text-2xl font-bold capitalize">welcome to chat!</h2>

                            <p class="text-sm font-bold">Beofre you proceed, please read thse ground rules. Don't worry,
                                we'll
                                only show this message one - but please do take a few seconds to familiarize yourself
                                with these rules. This will help us ensure a safe and friendly environment in the chat .
                            </p>
                            <ul class="text-sm
                                [&>li_p]:before:content-['•'] [&>li_p]:before:pie-6 font-bold">
                                <li>
                                    <p>be nice and thoughtful your word can both help and hurt</p>
                                </li>
                                <li>
                                    <p>don't use offensive or vulgar words </p>
                                </li>
                                <li>
                                    <p>don't post any personal details </p>
                                </li>
                                <li>
                                    <p>don't post any advertising or promotional material</p>
                                </li>
                                <li>
                                    <p>don't create Threads that encourage spamming </p>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <!-- this is empty div for acts like separation -->
                    <div class="h-2 border-y-2 border-y-stone-500">&nbsp;</div>
                    <div class="p-2">
                        <!-- ok model -->
                        <div class="grid p-10 bg-white place-items-center rounded-2xl">
                            <button class="py-2 text-white bg-black px-28 rounded-3xl">ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<style  >
.hideScrollBar::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hideScrollBar {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}
</style>
