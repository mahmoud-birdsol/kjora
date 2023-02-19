<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import ConversationsList from '../../Components/ConversationsList.vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import ChatLayout from '../../Layouts/ChatLayout.vue';
import { FaceSmileIcon, PhotoIcon, } from '@heroicons/vue/24/outline'
import { XMarkIcon, PaperAirplaneIcon, ArrowUpCircleIcon } from '@heroicons/vue/24/solid'
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import { FlagIcon } from '@heroicons/vue/24/outline'
import Modal from '../../Components/Modal.vue';
import ChatMessage from '../../Components/ChatMessage.vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const props = defineProps({
    conversation: null,
    conversations: null,
    // messages: null,
    player: null
})

const showReportModal = ref(false)
const messages = ref([])
const messagesContainer = ref(null)
const repliedMessage = ref(null);
const isReply = ref(false)
const isAttachment = ref(false)
const isDisabled = ref(false)
const attachmentsInput = ref(null)
const filePreview = ref(null);
const footer = ref(null);
const currentUser = usePage().props.value.auth.user


// function scrollToBottom() {
//     messagesContainer.value.scrollTo({
//         top: messagesContainer.value.scrollHeight,
//         left: 0,
//         behavior: 'smooth'
//     });
// }


Echo.private('users.chat.' + currentUser.id)
    .listen('.message-sent', (event) => {
        messages.value.unshift(event)
        setTimeout(() => {
            messagesContainer.value.scrollTo({
                top: messagesContainer.value.scrollHeight,
                left: 0,
                behavior: 'smooth'
            });
        }, 200);
    });


const page = ref(1)
onMounted(() => {

    axios.get(route('api.messages.index', props.conversation), { page: page.value }).then(response => {

        messages.value = response.data.data


    }).then(() => {

        messagesContainer.value.scrollTo({
            top: messagesContainer.value.scrollHeight,
            left: 0,
            behavior: 'smooth'
        });

    })


});







// load next conversations page after scrolling to the end of the list
function fetchMore() {
    console.log('fetch next page')

}
/* ----------------------handle loading messages on scroll to the top of the messageContainer---------------------------- */


onMounted(() => {

    messagesContainer.value ? messagesContainer.value.addEventListener('scroll', throttledHandleScroll) : null

});
onUnmounted(() => {
    messagesContainer.value ? messagesContainer.value.removeEventListener('scroll', throttledHandleScroll) : null

});
const throttledHandleScroll = window._.throttle(handleScroll, 1000)
function handleScroll(e) {
    let element = e.target
    function getNextPage() {
        page.value = page.value + 1;

        axios.get(route('api.messages.index', props.conversation), {
            params: {
                page: page.value
            }
        }).then(response => {
            console.log(response)

            messages.value = [...messages.value, ...response.data.data]
            // console.log(messages.value)


        })
    }
    element.scrollTop === 0 ? getNextPage() : null
}



//send message fuctionality
const newMessageForm = useForm({
    parent_id: null,
    body: null,
    attachments: null
})


function submitNewMessage() {
    axios.post(route('api.messages.store', props.conversation.id), {
        body: newMessageForm.body
        , parent_id: repliedMessage.value && repliedMessage.value.id
        , attachments: newMessageForm.attachments
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        messages.value.unshift(response.data.data);
        isDisabled.value = true

    }).then(() => {
        newMessageForm.body = null
        newMessageForm.parent_id = null
        newMessageForm.attachments = null
        isReply.value = false
        isAttachment.value = false
        filePreview.value = null
        repliedMessage.value = null
        isDisabled.value = false
        messagesContainer.value.scrollTo({
            top: messagesContainer.value.scrollHeight,
            left: 0,
            behavior: 'smooth'
        });

    }).catch((err => {
        console.error(err)
    }))


}
// attachments

function clickFileInput() {
    attachmentsInput.value.click()
}




/* -------------------------------------------------------------------------- */




function handleFile(file) {
    if (!file) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        filePreview.value = e.target.result;
        isAttachment.value = true
    };



    reader.readAsDataURL(file);
}
// on photoInput change method
const handleAttachments = (e) => {
    const file = attachmentsInput.value.files[0];
    newMessageForm.attachments = attachmentsInput.value.files[0]

    handleFile(file)
}
/* -------------------------------------------------------------------------- */

//handle reply

function handleReply(message) {

    repliedMessage.value = message
    isReply.value = true
}
///search messages functionality

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


        <!-- show page -->

        <ChatLayout>
            <template #sidebar>
                <ConversationsList :conversations="conversations" @fetch-more="fetchMore"
                    :currentConvId="conversation.id" />
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
                            <img :src="'https://ui-avatars.com/api/?name=' + player.name + '&color=094609FF&background=E2E2E2'"
                                alt="" class="object-cover w-10 h-10 rounded-full border-2 border-primary">
                        </div>
                        <div class="flex flex-col ">
                            <h4 class="mb-2   leading-none text-primary capitalize">{{ player.name }}</h4>
                            <span class="text-xs leading-none text-neutral-500"> @{{ player.username }}
                            </span>
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
                <div ref="messagesContainer" class="flex flex-col gap-y-4 div max-h-[40vh]  overflow-auto hideScrollBar "
                    :class="isSearching ? 'lg:max-h-[calc(70vh)]' : ' lg:max-h-[calc(70vh-180px)]'">
                    <template v-for="message in [...messages].reverse()" :key="message.id">

                        <ChatMessage :message="message" @reply="handleReply" :player="player" />

                    </template>
                </div>
            </template>
            <!-- new Message form  -->
            <template v-if="!isSearching" #footer>
                <div ref="footer" class="grid p-6 bg-white gap-y-4 rounded-2xl">
                    <Transition enterFromClass="opacity-0" enterToClass="opacity-100" leaveFromClass="opacity-100"
                        leaveToClass="opacity-0" leave-active-class="transition-all duration-150 ease-in"
                        enterActiveClass="transition-all duration-150 ease-out">
                        <div v-if="isReply || isAttachment"
                            class="bg-neutral-200 text-sm w-full flex flex-row items-center  rounded-xl py-2 px-12">
                            <div v-if="repliedMessage">
                                <div class="text-primary capitalize font-bold ">{{ repliedMessage.sender_id ===
                                    currentUser.id ?
                                    currentUser.name : player.name }}
                                </div>
                                <div class="text-black">{{ repliedMessage.body }}</div>
                            </div>
                            <div v-show="filePreview" class="ml-auto overflow-hidden ">
                                <span class="block w-20 h-20 bg-center bg-no-repeat bg-contain rounded-lg"
                                    :style="'background-image: url(\'' + filePreview + '\');'" />
                            </div>
                        </div>
                    </Transition>
                    <div class="flex flex-row items-center gap-x-2 w-full">
                        <button>
                            <FaceSmileIcon class="text-neutral-300  w-5" />
                        </button>
                        <div class="flex-grow  flex items-center ">

                            <textarea v-model="newMessageForm.body" name="newMessage" id="newMessage" rows="1"
                                placeholder="Type your Message Here"
                                class="w-full rounded-full resize-none hideScrollBar p-2 px-4 border-none  placeholder:text-neutral-400 "></textarea>
                        </div>
                        <button class="relative" @click="clickFileInput">
                            <PhotoIcon class="text-neutral-300  h-5 w-5" />
                            <div class="bg-white absolute bottom-0 -right-[1px] rounded-full  ">
                                <input ref="attachmentsInput" type="file" class="hidden" @change="handleAttachments">
                                <ArrowUpCircleIcon class="text-neutral-300    h-2 w-2" />
                            </div>
                        </button>
                        <button :disabled="isDisabled" @click="submitNewMessage">
                            <PaperAirplaneIcon class="text-neutral-900  w-5" />
                        </button>
                    </div>
                </div>
            </template>
        </ChatLayout>


    </AppLayout>
</template>



<style  scoped></style>
