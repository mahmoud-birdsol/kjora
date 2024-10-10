<script setup>
import { onMounted, onUnmounted, ref, computed } from "vue";
import ChatMessage from "@/Components/Chat/ChatMessage.vue";
import ChatNotice from "@/Components/Chat/ChatNotice.vue";
import { useChat } from "@/stores/chat";
import { usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import DateTranslation from "@/Components/DateTranslation.vue";

const props = defineProps({
    conversation: {
        required: true,
        type: Object,
    },
    player: {
        required: true,
        type: Object,
    },
});

const chat = useChat();
const messagesContainer = ref(null);

function groupMessagesByDate(messages) {
    return messages.reduce((groups, message) => {
        const date = dayjs(message.created_at).format("DD MMMM YYYY");
        if (groups[date]) {
            groups[date].push(message);
            // groups[date].unshift(message);
        } else {
            groups[date] = [message];
        }
        return groups;
    }, {});
}
const messagesGroups = computed(() =>
    groupMessagesByDate([...chat.messageList].reverse())
);

onMounted(() => {
    const currentUser = usePage().props.auth.user;

    chat.initialize({
        conversation: props.conversation,
        container: messagesContainer.value,
        currentUserId: currentUser.id,
    });
});

onUnmounted(() => {
    chat.unRegisterScrollListener();
    chat.clearFetchNewMessages();
    chat.UnsubscribeFromChatChannel();
});
</script>

<template>
    <div
        ref="messagesContainer"
        v-loading="chat.isLoading"
        class="relative overscroll-contain flex flex-col gap-y-4 overflow-auto p-2 min-h-[300px] max-h-[350px] hideScrollBar md:min-h-[400px] md:max-h-[450px]"
    >
        <ChatNotice v-if="chat.showLastPageNotice"
            >No more messages to load.</ChatNotice
        >
        <ChatNotice v-if="chat.isLoading">Loading.</ChatNotice>
        <template v-for="(messagesGroup, date) in messagesGroups" :key="date">
            <div class="flex justify-center gap-1 text-xs font-bold">
                <DateTranslation :start="date" format="DD MMMM YYYY" />
            </div>
            <template v-for="message in [...messagesGroup]" :key="message.id">
                <ChatMessage :message="message" :player="player" />
            </template>
        </template>
    </div>
</template>
