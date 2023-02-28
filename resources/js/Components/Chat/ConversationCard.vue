<script setup>
import {computed, inject} from 'vue';
import {Link} from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import Avatar from "@/Components/Avatar.vue";
import {
    CheckCircleIcon
} from '@heroicons/vue/24/outline'

dayjs.extend(relativeTime)

const currentConversation = inject('conversation');

const props = defineProps({
    conversation: Object,
})

const active = computed(() => {
    return currentConversation && currentConversation.id === props.conversation.id;
});
</script>

<template>
    <Link :href="route('chats.show', conversation.id)" :class="active ? 'border-2 border-primary rounded-2xl' : ''">
        <div
            class="bg-[url(/images/player_bg_lg.png)] bg-cover relative rounded-2xl p-6 flex flex-col gap-8 items-start bg-[center_top]"
            :class="active ? 'border-2 border-white' : null"
        >
            <div class="flex flex-row items-center w-full gap-4" v-for="user in conversation.users">
                <div>
                    <Avatar :image-url="user.avatar" size="sm" :username="user.name" :border="true"/>
                </div>
                <div class="flex flex-col ">
                    <h4 class="m-0 text-lg leading-none text-white capitalize">{{ user.name }}</h4>
                    <span class="text-xs leading-none text-neutral-500"> {{ user.username }} </span>
                </div>
                <div class="mis-auto -mt-2">
                    <p class="text-xs text-gray-300" v-if="!user.online">Last seen</p>
                    <p class="text-xs text-gray-300" v-if="!user.online">{{
                            dayjs().to(dayjs(user.last_seen_at))
                        }}</p>

                    <p class="text-xs text-white flex items-center" v-else>
                        <CheckCircleIcon class="text-green-500 h-3 w-3 inline mr-1"/>
                        Online
                    </p>
                </div>
            </div>
            <div class="flex w-full gap-4">
                <p class="text-sm text-white truncate ">{{ conversation.latest_message.body }}</p>
            </div>
        </div>
    </Link>
</template>
