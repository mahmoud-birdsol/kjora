<script setup>
import { provide } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';
import ChatMessagesContainer from "@/Components/Chat/ChatMessagesContainer.vue";
import ChatHeader from '@/Components/Chat/ChatHeader.vue';
import ChatForm from '@/Components/Chat/ChatForm.vue';
import dayjs from 'dayjs';

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
            {{ $t('chat') }}
        </template>

        <ChatLayout :conversations="conversations">
            <template #header>
                <ChatHeader :conversation="conversation" :player="player" />
            </template>
            <template #main>
                <div class="flex justify-center text-xs ">{{ dayjs().format('DD MMMM YYYY') }}</div>
                <ChatMessagesContainer :conversation="conversation" :player="player" />
            </template>
            <template #footer>
                <ChatForm :conversation="conversation" :player="player"></ChatForm>
            </template>
        </ChatLayout>
    </AppLayout>
</template>
