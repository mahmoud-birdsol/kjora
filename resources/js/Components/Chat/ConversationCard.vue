<script setup>
import { computed, inject, ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import Avatar from "@/Components/Avatar.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import { CheckCircleIcon, TrashIcon } from '@heroicons/vue/24/outline'
import DateTranslation from '../DateTranslation.vue';
import { Inertia } from '@inertiajs/inertia';
import Modal from '../Modal.vue';
import FadeInTransition from '@/Components/FadeInTransition.vue'
dayjs.extend(relativeTime)

const currentConversation = inject('conversation');
const showDeleteConvModal = ref(false)
const showNewMessagesPopup = ref(true)


const props = defineProps({
    conversation: Object,
})

const active = computed(() => {
    return currentConversation && currentConversation.id === props.conversation.id;
});

function removeConversation() {
    Inertia.delete(route('chats.delete', props.conversation.id), {
        preserveScroll: true,
        preserveState: false
    })
    showDeleteConvModal.value = false
}


</script>

<template>
    <Link :href="route('chats.show', conversation.id)" :class="active ? 'border-2 border-primary rounded-2xl' : ''">
    <div @click="showNewMessagesPopup = false" class="bg-[url(/images/chatbg.png)] bg-cover relative rounded-2xl p-6 flex flex-col gap-8 items-start bg-[center_center]" :class="active ? 'border-2 border-white' : ''">
        <div class="flex flex-row items-center w-full gap-4" v-for="user in conversation.users">
            <div>
                <Avatar :id="user.id" :image-url="user.avatar_url" size="lg" :username="user.name" :border="true" />
            </div>
            <div class="flex flex-col gap-1 max-sm:flex-1 ">
                <h4 class="m-0 text-lg leading-none text-white capitalize">{{ user.name }}</h4>
                <span class="text-xs leading-none text-neutral-400 rtl:before:content-['a'] rtl:before:text-transparent"> @{{
                    user.username }} </span>
                    <div class="flex sm:hidden " v-if="!user.online">
                    <p class="text-xs text-gray-300 max-sm:scale-75 rtl:origin-right ltr:origin-left ">{{ $t('Last seen') }}</p>
                    <p class="text-xs text-gray-300 max-sm:scale-75 rtl:origin-right ltr:origin-left -mis-2 ">
                        <DateTranslation :end="user.last_seen_at" type="period" />
                    </p>
                </div>
            </div>
            <div class="flex gap-2 -mt-2 mis-auto">
                <div class="max-sm:hidden " v-if="!user.online">
                    <p class="text-xs text-gray-300 max-sm:scale-75">{{ $t('Last seen') }}</p>
                    <p class="text-xs text-gray-300 max-sm:scale-75">
                        <DateTranslation :end="user.last_seen_at" type="period" />
                    </p>
                </div>
                <p class="flex items-center text-xs text-white rtl:flex-row-reverse" v-else>
                    <CheckCircleIcon class="inline w-3 h-3 mr-1 text-green-500" />
                    <span>Online</span>
                </p>


            </div>
        </div>
        <div class="flex w-full gap-6">
            <p class="text-sm text-white truncate max-w-[30ch] ">{{ conversation.latest_message?.body }}</p>

            <button @click.stop.prevent="showDeleteConvModal = true" class="self-end mis-auto ">
                <TrashIcon class="w-5 text-stone-200 hover:text-red-600 active:scale-90 " />
            </button>
            <!-- confirm delete media modal -->

            <ConfirmationModal :show="showDeleteConvModal" @close="showDeleteConvModal = false" @delete="removeConversation">
                <template #body>
                    <span>{{ $t('Are you sure you want delete this Conversation ? ') }}</span>
                </template>
            </ConfirmationModal>
        </div>
        <FadeInTransition>
            <div v-if="conversation.unread_messages !== 0 && showNewMessagesPopup" class="absolute p-1 ltr:right-1 top-1 rtl:left-1">
                <span class="grid w-6 h-6 p-1 text-xs bg-white rounded-full place-items-center">
                    {{ conversation.unread_messages }}</span>
            </div>
        </FadeInTransition>
    </div>
    </Link>
</template>

