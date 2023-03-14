<script setup>
import { XMarkIcon, Bars3Icon } from '@heroicons/vue/24/solid';
import { ref, onBeforeUnmount } from 'vue';
import SlideInTransition from '@/Components/SlideInTransition.vue';
import FadeInTransition from '@/Components/FadeInTransition.vue';
import ConversationsList from "@/Components/Chat/ConversationsList.vue";
import dayjs from "dayjs";

const props = defineProps({
    conversations: {
        required: true,
        type: Array,
    }
});

const showSideBar = ref(false);

props.conversations.forEach((conversation) => {
    Echo.join('chat.' + conversation.id)
        .here(function (users) {
            users.forEach(user => {
                updateConversationUserStatus(user, true);
            });
        })
        .joining(function (user) {
            updateConversationUserStatus(user, true);
        })
        .leaving(function (user) {
            updateConversationUserStatus(user, false);
            user.last_seen_at = dayjs();
        });
})

/**
 * Update a conversation user online status.
 *
 * @param user
 * @param status
 */
const updateConversationUserStatus = (user, status) => {
    props.conversations.forEach(conversation => {
        conversation.users.forEach(conversationUser => {
            if (conversationUser.id === user.id) {
                conversationUser.online = status;
            }
        });
    });
};

onBeforeUnmount(() => {
    props.conversations.forEach((conversation) => {
        Echo.leave('chat.' + conversation.id)

        axios.post(route('api.user.left'));
    });
});
</script>

<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">


            <div
                class="relative grid h-full w-full overflow-hidden min-h-[500px] rounded-2xl bg-white text-neutral-500 lg:grid-cols-[1.2fr_2fr]">
                <div
                    class="flex-col h-full gap-3 px-6 py-3 max-lg:border-b max-lg:border-b-stone-400 lg:flex lg:border-r lg:border-r-stone-400">
                    <div class="hidden lg:block">
                        <ConversationsList :conversations="conversations" />

                    </div>
                    <div class="flex justify-end h-full lg:hidden">
                        <button @click="showSideBar = true" class="p-1 text-black hover:text-primary">
                            <Bars3Icon class="w-6" />
                        </button>
                        <FadeInTransition>
                            <div v-show="showSideBar" @click="showSideBar = false" @touchend="showSideBar = false"
                                class="absolute inset-0 z-10 bg-stone-400/50"></div>
                        </FadeInTransition>
                        <SlideInTransition>
                            <div v-show="showSideBar"
                                class="absolute top-0 right-0 z-20 flex flex-col h-full px-6 py-3 bg-white gap-y-3">
                                <div class="flex justify-end">
                                    <button @click="showSideBar = false"
                                        class="p-1 text-black rounded-full hover:ring-primary hover:text-primary hover:ring-2">
                                        <XMarkIcon class="w-5" />
                                    </button>
                                </div>
                                <ConversationsList :conversations="conversations" />
                            </div>
                        </SlideInTransition>
                    </div>
                </div>

                <!-- Chat layout body... -->
                <div class="grid h-full grid-flow-row">
                    <div v-if="$slots.header" class="flex self-start border-b border-b-stone-400 min-h-[1rem]">
                        <slot name="header"></slot>
                    </div>
                    <div v-if="$slots.main" class="self-stretch p-4 contain">
                        <slot name="main"></slot>
                    </div>
                    <div v-if="$slots.footer" class="self-end p-2 border-t h-min border-t-stone-400">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
