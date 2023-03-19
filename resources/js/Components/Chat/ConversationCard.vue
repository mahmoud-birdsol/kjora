<script setup>
import { computed, inject } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import Avatar from "@/Components/Avatar.vue";
import { CheckCircleIcon } from '@heroicons/vue/24/outline'
import DateTranslation from '../DateTranslation.vue';

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
    <div class="bg-[url(/images/player_bg_lg.png)] bg-cover relative rounded-2xl p-6 flex flex-col gap-8 items-start bg-[center_top]"
        :class="active ? 'border-2 border-white' : ''">
        <div class="flex flex-row items-center w-full gap-4" v-for="user in conversation.users">
            <div>
                <Avatar :id="user.id" :image-url="user.avatar" size="sm" :username="user.name" :border="true" />
            </div>
            <div class="flex flex-col ">
                <h4 class="m-0 text-lg leading-none text-white capitalize">{{ user.name }}</h4>
                <!-- <Link :href="route('player.profile', user)" class="text-xs leading-none text-neutral-500"> @{{
                        user.username }} </Link> -->
                <span class="text-xs leading-none text-neutral-500 before:content-['a'] before:text-transparent"> @{{ user.username }} </span>
            </div>
            <div class="mis-auto -mt-2">
                <p class="text-xs text-gray-300" v-if="!user.online">{{$t('Last seen')}}</p>
                <p class="text-xs text-gray-300" v-if="!user.online">
                <DateTranslation :end="user.last_seen_at" type="period"/>
                </p>

                <p class="text-xs text-white flex items-center" v-else>
                    <CheckCircleIcon class="text-green-500 h-3 w-3 inline mr-1" />
                    Online
                </p>
            </div>
        </div>
        <div class="flex w-full gap-4">
            <p class="text-sm text-white truncate max-w-[30ch] ">{{ conversation.latest_message?.body }}</p>
        </div>
    </div>
    </Link>
</template>
