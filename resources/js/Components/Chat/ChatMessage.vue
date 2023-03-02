<script setup>
import { computed, ref } from '@vue/reactivity';
import ReplyIcon from '../Icons/ReplyIcon.vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
import { TrashIcon, ArrowDownCircleIcon } from '@heroicons/vue/24/outline'
import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';
import dayjs from 'dayjs';
import MediaPreview from '@/Components/MediaPreview.vue';
import { useChat } from "../../stores/chat";
import ChatGallery from './ChatGallery.vue';
import SingleMediaPreview from './SingleMediaPreview.vue';
import MediaThumbnails from './MediaThumbnails.vue';
const chat = useChat();

const props = defineProps({
    message: Object,
    player: null
})
const emits = defineEmits(['reply'])
onMounted(() => {
    // props.message.media.media !== [] && console.log(props.message.media)
})
const currentUser = usePage().props.value.auth.user
const showOptions = ref(false)
const showChatGallery = ref(false)


const isCurrentUser = computed(() => { return props.message.sender_id === currentUser.id })

const alignmentClass = computed(() => {
    return isCurrentUser.value ? 'self-end  ' : 'self-start   ';
})
const parentClasses = computed(() => {
    return isCurrentUser.value ? 'relative flex justify-end   pie-8 ' : 'flex gap-2 items-center  ';
})
const bodyClass = computed(() => {
    return isCurrentUser.value ? ' bg-primary text-white rounded-br-none' : ' bg-stone-200 text-black rounded-bl-none';
})
const repliedClasses = computed(() => {
    return isCurrentUser.value ? 'bg-white text-black  ' : 'bg-primary text-white  ';
})

function handleReply(e) {
    // emits('reply', props.message)
    chat.setMessageToReplyTo(props.message)
    showOptions.value ? showOptions.value = false : null
}
const imagesVideosOnly = props.message.attachments.filter(a => a.mime_type.startsWith('image') || a.mime_type.startsWith('video'))
const otherMedia = props.message.attachments.filter(a => !a.mime_type.startsWith('image') && !a.mime_type.startsWith('video'))

</script>

<template>
    <div v-if="showOptions" class="fixed inset-0 z-10 w-full h-full cursor-pointer " @click="showOptions = false">
    </div>
    <div :class="alignmentClass + parentClasses" class="w-full ">

        <!-- avatar for non current user message -->
        <div v-if='!isCurrentUser'>
            <div><img :src="'https://ui-avatars.com/api/?name=' + player.name + '&color=094609FF&background=E2E2E2'" alt=""
                    class="object-cover w-10 h-10 border-2 rounded-full border-primary">
            </div>
        </div>
        <!-- message body -->
        <div class="max-w-[60%]">
            <div :class="bodyClass" class="p-4 rounded-2xl">
                <!-- replied message -->
                <div v-if="message.parent_id" :class="repliedClasses" class="p-3 mb-2 text-xs rounded-lg">
                    <!-- name -->
                    <div class="mb-2 font-semibold capitalize" :class="isCurrentUser ? 'text-primary' : 'text-white'">
                        <h4 v-if="message.parent?.sender_id === player.id">{{ player.name }}</h4>
                        <h4 v-else>{{ currentUser.name }}</h4>
                    </div>
                    <span class="">{{ message.parent?.body }}</span>
                    <MediaPreview v-if="message.parent.attachments[0]" :fileType="message.parent.attachments[0].mime_type"
                        :filePreview="message.parent.attachments[0].original_url"
                        :fileName="message.parent.attachments[0].name" />
                </div>
                <!-- media message -->
                <template v-if="message.attachments && message.attachments.length === 1">
                    <SingleMediaPreview @click="showChatGallery = true" :media="message.attachments[0]"
                        :is-current-user="isCurrentUser" />
                </template>
                <!-- message.attachments && message.attachments.length > 1 -->
                <template v-if="message.attachments.length > 1">
                    <!-- images and videos -->
                    <div v-if="imagesVideosOnly.length" class="grid grid-cols-2 grid-rows-2 gap-2 place-items-center ">
                        <MediaThumbnails :media="imagesVideosOnly[0]" />
                        <MediaThumbnails :media="imagesVideosOnly[1]" />
                        <MediaThumbnails :media="imagesVideosOnly[2]" />
                        <div class="relative w-28 aspect-square" @click="showChatGallery = true">
                            <MediaThumbnails :media="imagesVideosOnly[4]" />
                            <div
                                class="absolute inset-0 bg-stone-700/70  text-white font-bold rounded-md grid place-items-center cursor-pointer">
                                + {{ imagesVideosOnly.length - 3 }} more... </div>
                        </div>
                    </div>
                    <!-- docs and PDFs   -->
                    <div v-if="otherMedia.length" class="flex flex-col gap-1 mt-2">
                        <template v-for="(item, index) in otherMedia" :key="item.id">
                            <SingleMediaPreview :media="item" :is-current-user="isCurrentUser" />
                        </template>
                    </div>
                    <ChatGallery :show="showChatGallery" @close="showChatGallery = false" :media="imagesVideosOnly"
                        :user="message.message_sender" />
                </template>
                <!-- text message -->
                <span class="break-words whitespace-pre-wrap ">
                    {{ message.body }}
                </span>
            </div>

            <!-- date -->
            <div class="mt-2 text-xs " :class="isCurrentUser ? 'text-end' : null"> <span>{{ message.read_at ?
                dayjs(message.read_at).format('hh:mm A') : dayjs(message.created_at).format('hh:mm A') }}</span> | <span
                    class="capitalize text-primary">{{ message.read_at ? 'r' : 's' }}</span></div>
        </div>

        <!-- options menu if message of the current user -->
        <div v-if="isCurrentUser" class="absolute top-0 right-0">
            <button @click="showOptions = !showOptions">
                <EllipsisVerticalIcon class="w-6 text-neutral-500" />
            </button>

            <Transition enterFromClass="opacity-0" enterToClass="opacity-100" leaveFromClass="opacity-100"
                leaveToClass="opacity-0" leave-active-class="transition-all duration-150 ease-in"
                enterActiveClass="transition-all duration-150 ease-out">
                <div v-show="showOptions"
                    class="absolute z-20 px-6 py-2 text-xs text-white bg-black border -top-1 rounded-xl border-neutral-500 pie-10 z-2 right-7">
                    <ul class="flex flex-col justify-center gap-y-2">
                        <button class="hover:text-gray-400 ">
                            <li class="flex items-center justify-center gap-x-2">
                                <TrashIcon class="w-4" />
                                <span> delete</span>
                            </li>
                        </button>
                        <button class="hover:text-gray-400 group" @click="handleReply">
                            <li class="flex items-center justify-center gap-x-2">
                                <ReplyIcon
                                    class="cursor-pointer fill-transparent group-hover:stroke-gray-400 stroke-white ">
                                </ReplyIcon>
                                <span>Quote</span>
                            </li>
                        </button>
                    </ul>
                </div>
            </Transition>
        </div>
        <!-- reply icon for non current user message -->
        <button v-if="!isCurrentUser" @click="chat.setMessageToReplyTo(message)">
            <ReplyIcon class="fill-transparent hover:fill-black stroke-black "></ReplyIcon>
        </button>

    </div>
</template>



<style  scoped></style>
