<script setup>
import { computed, onMounted, ref } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import { FlagIcon } from '@heroicons/vue/24/outline'
import ChatLayout from '../../Layouts/ChatLayout.vue';
import ConversationsList from '../../Components/ConversationsList.vue';
import ChatMessage from '../../Components/ChatMessage.vue';
import Modal from '../../Components/Modal.vue';

import { FaceSmileIcon, PhotoIcon, } from '@heroicons/vue/24/outline'
import { XMarkIcon, PaperAirplaneIcon, ArrowUpCircleIcon } from '@heroicons/vue/24/solid'
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
const inTfriends = [{
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
let friends = ref(inTfriends)

const inTmessages = [{ id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 68, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'hello how are you', read_at: '12:15 pm', parent_id: 1215, }, { id: 1, sender_id: 124, body: 'what you will do today', read_at: '12:15 pm', parent_id: null, }, { id: 1, sender_id: 124, body: 'i have two schedules', read_at: '12:15 pm', parent_id: 1215, },]
const messages = ref(inTmessages)
const showReportModal = ref(false)
function fetchMore() {
    console.log('fetch next page')
    friends.value = [...friends.value, ...inTfriends,]
}


const newMessageForm = useForm({
    new_message: null
})
function submitNewMessage() {
    console.log('submit new  message')
    console.log(newMessageForm.new_message)
}


const searchMessagesForm = useForm({
    query: null
})
const debouncedSubmitSearchMessages = window._.debounce(submitSearchMessages, 500)
function submitSearchMessages() {
    console.log('send query and recive fitlerd data')
    console.log(searchMessagesForm.query)
}


const isSearching = ref(false)

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
                    <ul class="text-sm [&>li_p]:before:content-['•'] [&>li_p]:before:pie-6 font-bold">
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
                <ConversationsList :friends="friends" @fetch-more="fetchMore" />
            </template>
            <template #header>
                <!-- search header -->
                <template v-if="isSearching">
                    <div class="flex-1 flex p-4 items-center gap-4">
                        <div class="grid items-center w-full grid-cols-1 ">
                            <input v-model="searchMessagesForm.query" @input="debouncedSubmitSearchMessages" type="search"
                                class="w-full col-start-1 row-start-1 pis-10 rounded-3xl">
                            <div class="col-start-1 row-start-1 justify-self-start pis-3">
                                <MagnifyingGlassIcon class="w-5 h-5 text-primary">
                                </MagnifyingGlassIcon>
                            </div>
                        </div>
                        <button @click="isSearching = false" class="group hover:ring hover:ring-primary p-1  rounded-full ">
                            <XMarkIcon class="text-black w-5 group-hover:text-primary" />
                        </button>
                    </div>
                </template>
                <!-- defaultHeader -->
                <template v-else>
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
                        <button @click="isSearching = true">
                            <MagnifyingGlassIcon class="w-4 h-4 cursor-pointer hover:text-primaryDark text-primary">
                            </MagnifyingGlassIcon>
                        </button>
                        <button @click="showReportModal = !showReportModal">
                            <FlagIcon class="w-4 h-4 text-red-600" />
                            <Modal :show="showReportModal" @close="showReportModal = false" max-width="sm">
                                <div class="uppercase text-center flex   flex-col gap-y-6 p-4">
                                    <div class=" self-end">
                                        <button @click="showReportModal = false"
                                            class="group hover:ring hover:ring-primary p-1  rounded-full ">
                                            <XMarkIcon class="text-black w-5 group-hover:text-primary" />
                                        </button>
                                    </div>
                                    <div class="text-primary mb-4 font-bold">
                                        report
                                    </div>
                                    <!-- TODO:make it radio buttons group -->
                                    <ul
                                        class="[&_li]:px-4 [&_li]:py-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:border-gray-400 text-stone-500  flex flex-col gap-4 px-6 text-sm ">
                                        <li>spam</li>
                                        <li>hate speech, or uncivil</li>
                                        <li>sexual activity</li>
                                        <li>scam, or fraud</li>
                                        <li>bullying or harassment</li>
                                        <li>violence, or threats</li>
                                        <li>racism, discrimination, or insults</li>
                                    </ul>
                                    <button
                                        class="bg-black text-white p-2 px-6 w-full rounded-full uppercase ">report</button>
                                </div>
                            </Modal>
                        </button>
                    </div>
                </template>

            </template>
            <template #main>
                <!-- main content -->
                <div class="flex flex-col gap-y-4 div max-h-[40vh]  overflow-auto hideScrollBar "
                    :class="isSearching ? 'lg:max-h-[calc(70vh)]' : ' lg:max-h-[calc(70vh-180px)]'">
                    <template v-for="message in messages" :key="message.id">

                        <ChatMessage :message="message" />

                    </template>
                </div>
            </template>
            <!-- new Message form  -->
            <template v-if="!isSearching" #footer>
                <div class="grid p-6 bg-white gap-y-4 rounded-2xl">
                    <div class="bg-neutral-200 text-sm w-full  rounded-xl py-2 px-12">
                        <div class="text-primary capitalize font-bold ">name</div>
                        <div class="text-black">message</div>
                    </div>
                    <div class="flex flex-row items-center gap-x-2 w-full">
                        <button>
                            <FaceSmileIcon class="text-neutral-300  w-5" />
                        </button>
                        <div class="flex-grow  flex items-center ">
                            <!-- <input class="w-full rounded-full border-none " type="text" name="newMessage"
                                                                                                                                id="newMessage" placeholder="Type your Message Here"> -->
                            <textarea v-model="newMessageForm.new_message" name="newMessage" id="newMessage" rows="1"
                                placeholder="Type your Message Here"
                                class="w-full rounded-full resize-none hideScrollBar p-2 px-4 border-none  placeholder:text-neutral-400 "></textarea>
                        </div>
                        <button class="relative">
                            <PhotoIcon class="text-neutral-300  h-5 w-5" />
                            <div class="bg-white absolute bottom-0 -right-[1px] rounded-full  ">

                                <ArrowUpCircleIcon class="text-neutral-300    h-2 w-2" />
                            </div>
                        </button>
                        <button @click="submitNewMessage">
                            <PaperAirplaneIcon class="text-neutral-900  w-5" />
                        </button>
                    </div>
                </div>
            </template>
        </ChatLayout>


    </AppLayout>
</template>


<style  ></style>
