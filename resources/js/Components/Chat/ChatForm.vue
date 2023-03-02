<script setup>
import { ref } from 'vue';
import { useChat } from "@/stores/chat";
import MediaPreview from "@/Components/MediaPreview.vue";
import {
    ArrowUpCircleIcon,
    PaperAirplaneIcon,
    PhotoIcon,
    XMarkIcon
} from '@heroicons/vue/24/solid'
import axios from "axios";
import { useForm } from "@inertiajs/inertia-vue3";
import Avatar from "../Avatar.vue";
import UplaodChatFile from './UplaodChatFile.vue';
const props = defineProps({
    conversation: {
        required: true,
        type: Object,
    },
    player: {
        required: true,
        type: Object,
    }
});

const chat = useChat();
const hasAttachement = ref(false);
const loading = ref(false);
let openModual = ref(false);
const filesData = ref(null)
const form = useForm({
    parent_id: null,
    body: '',
    attachments: null
});

const submit = () => {
    loading.value = true;

    if (chat.repliedMessage) {
        form.parent_id = chat.repliedMessage.id;
    }

    axios.post(route('api.messages.store', props.conversation.id), form.data(), {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        console.log('currentuserid', chat.currentUserId)
        chat.pushNewMessage(response.data.data);
    }).catch(error => {
        console.error(error.response)
    }).finally(() => {
        loading.value = false;
        filePreview.value = null;
        form.reset();
        filesData.value = []
    });
};

// TODO: message body character count based on current screen
// TODO: view should determine the number of rows with a max number
// TODO: of rows before activating scroll.

const attachmentsInput = ref(null)
const filePreview = ref(null);

function clickFileInput() {
    attachmentsInput.value.click()
}

/* -------------------------------------------------------------------------- */
let fileType = ref(null)
let fileName = ref(null)

function handleFile(file) {
    if (!file) return;
    fileType.value = file.type
    fileName.value = file.name

    const reader = new FileReader();

    reader.onload = (e) => {
        filePreview.value = e.target.result;
        hasAttachement.value = true
    };


    reader.readAsDataURL(file);
}

// on photoInput change method
const handleAttachments = (e) => {
    const file = attachmentsInput.value.files[0];
    form.attachments = attachmentsInput.value.files[0]

    handleFile(file)
}
function addFiles(files, filesUrls) {
    if (form.attachments) {
        form.attachments = [...form.attachments, ...files]
        filesData.value = [...filesData.value, ...filesUrls]
    } else {
        form.attachments = files
        filesData.value = filesUrls
    }

}
const removePhoto = (i) => {
    filesData.value.splice(i, 1)
    form.attachments.splice(i, 1)
};
</script>

<template>
    <div class="grid gap-y-4 rounded-2xl bg-white p-6">
        <!--The gray section to display attachment or a message I am replying to. -->
        <Transition enter-from-class="opacity-0" enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="chat.repliedMessage"
                class="flex w-full flex-row items-center group justify-between relative rounded-xl bg-gray-100 px-2 py-2 text-sm">
                <div v-if="chat.repliedMessage" class="flex justify-start items-center space-x-4">
                    <Avatar :image-url="chat.repliedMessage.message_sender.avatar_url"
                        :username="chat.repliedMessage.message_sender.name" :border="true" border-color="primary"
                        size="sm" />
                    <div class="font-bold capitalize text-primary">

                        {{
                            chat.repliedMessage.sender_id === $page.props.auth.user.id
                            ? $page.props.auth.user.name
                            : player.name
                        }}
                        <p class="text-gray-600 text-xs font-normal ">@{{ chat.repliedMessage.message_sender.username }}</p>

                    </div>
                    <div class="max-w-[70ch] truncate">{{ chat.repliedMessage.body }}</div>

                </div>
                <div>
                    <div class="text-black max-w-[15rem]">
                        <div v-if="chat.repliedMessage.attachments.length">
                            <MediaPreview :fileType="chat.repliedMessage.attachments[0].mime_type"
                                :filePreview="chat.repliedMessage.attachments[0].original_url"
                                :fileName="chat.repliedMessage.attachments[0].file_name" />
                        </div>

                    </div>
                </div>
                <button @click.prevent="chat.setMessageToReplyTo(null)"
                    class="absolute group-hover:block hidden top-0 left-0 bg-white bg-opacity-90 rounded-br-xl">
                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                        <XMarkIcon class="w-5 h-5 text-stone-800" />
                    </div>
                </button>
            </div>
        </Transition>

        <transition enter-from-class="opacity-0" enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="filesData"
                class="ml-auto overflow-hidden grid grid-cols-4 gap-2 overflow-y-auto max-h-32 hideScrollBar place-items-center">
                <!-- {{ form.attachments }} -->
                <template v-for="(file, index) in filesData">
                    <div class="relative w-full">
                        <MediaPreview :fileType="file.type" :filePreview="file.url" :fileName="file.name" />
                        <button @click.prevent="removePhoto(index)"
                            class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                            <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                <XMarkIcon class="w-5 h-5 text-stone-800" />
                            </div>
                        </button>
                    </div>
                </template>
            </div>
        </transition>
        <div class="flex w-full flex-row items-center gap-x-3">
            <!--            <button>-->
            <!--                <FaceSmileIcon class="w-6 text-neutral-400"/>-->
            <!--            </button>-->
            <div class="flex flex-grow items-center">
                <textarea v-model="form.body" @keydown.enter.prevent="submit" name="body" id="body" rows="1"
                    placeholder="Type your Message Here"
                    class="w-full resize-none rounded-full border-none bg-stone-100 p-2 px-4 placeholder:text-neutral-400 text-stone-700 hideScrollBar"></textarea>
            </div>
            <button class="relative" @click="openModual = true">
                <PhotoIcon class="h-6 w-6 text-neutral-400" />
                <span class="absolute bottom-0 rounded-full bg-white -right-[1px]">
                    <UplaodChatFile :show="openModual" @close="openModual = false" :should-upload="true"
                        @upload="addFiles" />
                    <ArrowUpCircleIcon class="h-2 w-2 text-neutral-400" />
                </span>
            </button>
            <button :disabled="loading" class="p-1 group" @click="submit">
                <PaperAirplaneIcon class="w-5" :class="loading ? 'text-neutral-400' : 'text-neutral-900'" />
            </button>
        </div>
    </div>
</template>
