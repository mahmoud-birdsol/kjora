
<template>
    <div class="grid p-6 bg-white gap-y-4 rounded-2xl">
        <!--The gray section to display attachment or a message I am replying to. -->
        <Transition enter-from-class="opacity-0" enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="chat.repliedMessage"
                class="relative flex flex-row items-center justify-between w-full px-2 py-2 text-sm bg-gray-100 group rounded-xl">
                <div v-if="chat.repliedMessage" class="flex items-center justify-start space-x-4">
                    <Avatar :id="chat.repliedMessage.message_sender.id" :image-url="chat.repliedMessage.message_sender.avatar_url"
                        :username="chat.repliedMessage.message_sender.name" :border="true" border-color="primary"
                        size="sm" />
                    <div class="font-bold capitalize text-primary pis-3">
                        <div>
                            {{
                                chat.repliedMessage.sender_id === $page.props.auth.user.id
                                ? $page.props.auth.user.name
                                : player.name
                            }}
                        </div>

                        <Link class="text-xs font-normal text-gray-600 "
                            :href="route('player.profile', chat.repliedMessage.message_sender.id)">@{{
                                chat.repliedMessage.message_sender.username }}</Link>

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
                    class="absolute top-0 left-0 hidden bg-white group-hover:block bg-opacity-90 rounded-br-xl">
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
                class="grid grid-cols-4 gap-2 ml-auto overflow-hidden overflow-y-auto max-h-32 hideScrollBar place-items-center">
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

        <div class="flex flex-row items-center w-full gap-x-3">

                    <OnClickOutside class="hidden sm:block" @trigger="showEmojiPicker = false">
                <div class="relative flex items-center">
                    <button @click="showEmojiPicker = !showEmojiPicker" :data-cancel-blur="true">
                        <FaceSmileIcon class="w-6 text-neutral-400" />
                    </button>
                    <div class="absolute z-20 bottom-full ltr:left-full rtl:right-full" v-show="showEmojiPicker">
                        <EmojiPickerElement @selected-emoji="onSelectEmoji" />
                    </div>
                </div>
            </OnClickOutside>
                        <div class="flex items-center flex-grow bg-stone-100 p-1 rounded-full ">
                            <textarea v-model="form.body" @keypress.enter.exact.prevent="submit" name="body" id="body" rows="1"
                                :placeholder="$t('Type your Message Here')"
                                    class="w-full p-2 px-4 border-none rounded-full resize-none max-sm:placeholder:text-xs focus:ring-primary  bg-stone-100 placeholder:text-neutral-400 text-stone-700 hideScrollBar"></textarea>
            </div>
            <button class="relative" @click="openModual = true">
                <PhotoIcon class="w-6 h-6 text-neutral-400" />
                <span class="absolute bottom-0 rounded-full bg-white -right-[1px]">
                    <UplaodChatFile :show="openModual" @close="openModual = false" :should-upload="true"
                        @upload="addFiles" />
                    <ArrowUpCircleIcon class="w-2 h-2 text-neutral-400 " />
                </span>
            </button>
            <button :disabled="loading" class="p-1 group" @click="submit">
                <PaperAirplaneIcon class="w-5 rtl:rotate-180" :class="loading ? 'text-neutral-400' : 'text-neutral-900'" />
            </button>
        </div>
    </div>
</template>



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
import { useForm, Link } from "@inertiajs/inertia-vue3";
import Avatar from "../Avatar.vue";
import UplaodChatFile from './UplaodChatFile.vue';
import EmojiPickerElement from '../EmojiPickerElement.vue';
import { FaceSmileIcon } from '@heroicons/vue/24/outline';
import { fromPairs } from 'lodash';

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
const showEmojiPicker = ref(false)
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

    if (loading.value) { return }

    if (form.body === '' && !form.attachments.length) { return }

    loading.value = true;
    if (chat.repliedMessage) {
        form.parent_id = chat.repliedMessage.id;
    }

    axios.post(route('api.messages.store', props.conversation.id), form.data(), {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
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

function onSelectEmoji(emoji) {
    form.body += emoji
}

</script>

