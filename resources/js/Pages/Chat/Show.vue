<script setup>
import {provide} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';
import ChatMessages from "@/Components/Chat/ChatMessages.vue";
import ChatHeader from '@/Components/Chat/ChatHeader.vue';
import ChatForm from '@/Components/Chat/ChatForm.vue';

const props = defineProps({
    conversation: null,
    conversations: null,
    player: null,
})

provide('conversation', props.conversation);
</script>

<template>
    <AppLayout title="Chat">
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
