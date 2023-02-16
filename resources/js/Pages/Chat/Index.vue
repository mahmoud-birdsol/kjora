<script setup>
import { ref } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import { FlagIcon } from '@heroicons/vue/24/outline'
import ChatLayout from '../../Layouts/ChatLayout.vue';
import ConversationsList from '../../Components/ConversationsList.vue';
import ChatMessage from '../../Components/ChatMessage.vue';

import { FaceSmileIcon, PhotoIcon, } from '@heroicons/vue/24/outline'
import { PaperAirplaneIcon, ArrowUpCircleIcon } from '@heroicons/vue/24/solid'
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

const messages = [{ id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, },]





</script>
<template>
    <AppLayout title="chat">
        <template #header>
            <p>chat</p>
        </template>
        <h1 class="text-white">chat welcome page</h1>
        <ChatLayout>
            <template #sidebar>
                <ConversationsList :friends="friends" />
            </template>
            <template #header>
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
            </template>
            <template #main>
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
            </template>
            <template #footer>
                <div class="grid p-10 bg-white place-items-center rounded-2xl">
                    <button class="py-2 text-white bg-black px-28 rounded-3xl">ok</button>
                </div>
            </template>
        </ChatLayout>


        <!-- show page -->
        <h1 class="text-white"> conversation page page</h1>
        <ChatLayout>
            <template #sidebar>
                <ConversationsList :friends="friends" />
            </template>
            <template #header>
                <div class="flex-1 flex p-4 items-center gap-4 border-r-2 border-r-stone-500">
                    <div>
                        <img :src="'https://ui-avatars.com/api/?name=' + 'peter' + '&color=094609FF&background=E2E2E2'"
                            alt="" class="object-cover w-10 h-10 rounded-full border-2 border-primary">
                    </div>
                    <div class="flex flex-col ">
                        <h4 class="mb-2   leading-none text-primary capitalize">peter</h4>
                        <span class="text-xs leading-none text-neutral-500"> @username </span>
                    </div>
                </div>
                <div class="flex items-center gap-2 p-4">
                    <button>
                        <MagnifyingGlassIcon class="w-4 h-4 cursor-pointer hover:text-primaryDark text-primary">
                        </MagnifyingGlassIcon>
                    </button>
                    <button>
                        <FlagIcon class="w-4 h-4 text-red-600" />
                    </button>
                </div>
            </template>
            <template #main>
                <div class="flex flex-col gap-y-4 div max-h-[50vh] llg:max-h-[70vh] overflow-auto hideScrollBar ">
                    <template v-for="message in messages" :key="message.id">

                        <ChatMessage :message="message" />

                    </template>
                </div>
            </template>
            <template #footer>
                <div class="grid p-10 bg-white gap-y-4 rounded-2xl">
                    <div class="bg-neutral-200 text-sm w-full  rounded-xl py-2 px-12">
                        <div class="text-primary capitalize font-bold ">name</div>
                        <div class="text-black">message</div>
                    </div>
                    <div class="flex flex-row items-center gap-x-2 w-full">
                        <button>
                            <FaceSmileIcon class="text-neutral-300  w-5" />
                        </button>
                        <div class="flex-grow  ">
                            <!-- <input class="w-full rounded-full border-none " type="text" name="newMessage"
                                id="newMessage" placeholder="Type your Message Here"> -->
                            <textarea name="newMessage" id="newMessage" rows="1" placeholder="Type your Message Here"
                                class="w-full rounded-full resize-none hideScrollBar p-2 px-4 border-none  placeholder:text-neutral-400 "></textarea>
                        </div>
                        <button class="relative">
                            <PhotoIcon class="text-neutral-300  h-5 w-5" />
                            <div class="bg-white absolute bottom-0 -right-[1px] rounded-full  ">

                                <ArrowUpCircleIcon class="text-neutral-300    h-2 w-2" />
                            </div>
                        </button>
                        <button>
                            <PaperAirplaneIcon class="text-neutral-900  w-5" />
                        </button>
                    </div>
                </div>
            </template>
        </ChatLayout>

    </AppLayout>
</template>


<style  >

</style>
