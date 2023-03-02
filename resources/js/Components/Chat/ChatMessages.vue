<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import ChatMessage from "@/Components/Chat/ChatMessage.vue";
import ChatNotice from "@/Components/Chat/ChatNotice.vue";
import { useChat } from "@/stores/chat";
import { usePage } from "@inertiajs/inertia-vue3";

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
const messagesContainer = ref(null);
onMounted(() => {
    const currentUser = usePage().props.value.auth.user

    chat.initialize({
        conversation: props.conversation,
        container: messagesContainer.value,
        currentUserId: currentUser.id
    });
});

onUnmounted(() => {
    chat.unRegisterScrollListener();
});
</script>

<template>
    <div ref="messagesContainer" v-loading="chat.isLoading"
        class="relative flex flex-col gap-y-4 overflow-auto p-2 min-h-[300px] max-h-[350px] md:min-h-[400px] md:max-h-[450px]">

        <ChatNotice v-if="chat.lastPageReached">No more messages to load.</ChatNotice>
        <ChatNotice v-if="chat.isLoading">Loading.</ChatNotice>

        <template v-for="message in [...chat.messageList].reverse()" :key="message.id">
            <ChatMessage :message="message" :player="player" />
        </template>
    </div>
</template>
