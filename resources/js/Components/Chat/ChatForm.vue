<script setup>
import {ref} from 'vue';
import {useChat} from "@/stores/chat";
import MediaPreview from "@/Components/MediaPreview.vue";
import {
    ArrowUpCircleIcon,
    PaperAirplaneIcon,
    PhotoIcon
} from '@heroicons/vue/24/solid'
import axios from "axios";
import {useForm} from "@inertiajs/inertia-vue3";
import Avatar from "../Avatar.vue";

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
        chat.pushNewMessage(response.data.data);
    }).catch(error => {
        console.log(error.response)
    }).finally(() => {
        loading.value = false;
        filePreview.value = null;
        form.reset();
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

</script>

<template>
    <div class="grid gap-y-4 rounded-2xl bg-white p-6">
        <!--
        The gray section to display attachment or a message I am replying to.
         -->
        <Transition
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="chat.repliedMessage"
                 class="flex w-full flex-row items-center rounded-xl bg-gray-100 px-12 py-2 text-sm">
                <div v-if="chat.repliedMessage" class="flex justify-start space-x-4">
                    <Avatar :image-url="chat.repliedMessage.sender.avatar_url"
                            :username="chat.repliedMessage.sender.name"
                            :border="true"
                            border-color="primary"
                            size="sm"
                    />

                    <div>
                        <div class="font-bold capitalize text-primary">{{
                                chat.repliedMessage.sender_id === $page.props.auth.user.id
                                    ? $page.props.auth.user.name
                                    : player.name
                            }}
                        </div>
                        <div class="text-black">
                            <div>{{ chat.repliedMessage.body }}</div>
                            <div v-if="chat.repliedMessage.media.length">
                                <MediaPreview :fileType="chat.repliedMessage.media[0].mime_type"
                                              :filePreview="chat.repliedMessage.media[0].original_url"
                                              :fileName="chat.repliedMessage.media[0].name"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>

        <transition
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="hasAttachement && filePreview"
                 class="flex w-full flex-row items-center rounded-xl bg-neutral-200 px-12 py-2 text-sm">
                <div v-if="filePreview" class="ml-auto overflow-hidden">
                    <MediaPreview :fileType="fileType" :filePreview="filePreview" :fileName="fileName"/>
                </div>
            </div>
        </transition>
        <div class="flex w-full flex-row items-center gap-x-3">
            <!--            <button>-->
            <!--                <FaceSmileIcon class="w-6 text-neutral-400"/>-->
            <!--            </button>-->
            <div class="flex flex-grow items-center">
                <textarea
                    v-model="form.body"
                    @keydown.enter="submit"
                    name="body"
                    id="body"
                    rows="1"
                    placeholder="Type your Message Here"
                    class="w-full resize-none rounded-full border-none bg-stone-100 p-2 px-4 placeholder:text-neutral-400 text-stone-700 hideScrollBar"></textarea>
            </div>
            <button class="relative" @click="clickFileInput">
                <PhotoIcon class="h-6 w-6 text-neutral-400"/>
                <span class="absolute bottom-0 rounded-full bg-white -right-[1px]">
                    <input ref="attachmentsInput" type="file" accept="image/*,video/*,.pdf,.doc,.docx"
                           class="hidden" @change="handleAttachments">
                    <ArrowUpCircleIcon class="h-2 w-2 text-neutral-400"/>
                </span>
            </button>
            <button :disabled="loading" class="p-1 group" @click="submit">
                <PaperAirplaneIcon
                    class="w-5"
                    :class="loading ? 'text-neutral-400' : 'text-neutral-900'"/>
            </button>
        </div>
    </div>
</template>
