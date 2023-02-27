<script setup>
import {
    onMounted,
    onUnmounted,
    ref,
    provide
} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';
import {useForm, usePage} from '@inertiajs/inertia-vue3';
import axios from 'axios';
import ChatMessages from "@/Components/Chat/ChatMessages.vue";
import ChatHeader from '@/Components/Chat/ChatHeader.vue';
import ChatForm from '@/Components/Chat/ChatForm.vue';

const props = defineProps({
    conversation: null,
    conversations: null,
    player: null,
})

provide('conversation', props.conversation);

const repliedMessage = ref(null);
const isReply = ref(false)
const isAttachment = ref(false)
const isDisabled = ref(false)
const attachmentsInput = ref(null)
const filePreview = ref(null);

const currentUser = usePage().props.value.auth.user


//send message fuctionality
const newMessageForm = useForm({
    parent_id: null,
    body: null,
    attachments: null
})


function submitNewMessage() {
    isDisabled.value = true
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
        isDisabled.value = false

    }))


}

// attachments

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
</script>

<template>
    <AppLayout title="chat">
        <template #header>
            Chat
        </template>

        <ChatLayout :conversations="conversations">
            <template #header>
                <ChatHeader :conversation="conversation" :player="player"/>
            </template>
            <template #main>
                <ChatMessages :conversation="conversation" :player="player"/>
            </template>
            <template #footer>
                <ChatForm :conversation="conversation" :player="player"></ChatForm>
            </template>
        </ChatLayout>
    </AppLayout>
</template>


<style scoped></style>
