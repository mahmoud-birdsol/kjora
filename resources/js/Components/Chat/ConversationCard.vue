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

dayjs.extend(relativeTime)

const currentConversation = inject('conversation');
const showDeleteConvModal = ref(false)

const props = defineProps({
    conversation: Object,
})

const active = computed(() => {
    return currentConversation && currentConversation.id === props.conversation.id;
});

function removeConversation() {
    Inertia.delete(route('chats.delete', props.conversation.id), {
        preserveScroll:true,
        preserveState:false
    })
    showDeleteConvModal.value = false
}
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
                <span class="text-xs leading-none text-neutral-500 before:content-['a'] before:text-transparent"> @{{
                    user.username }} </span>
            </div>
            <div class="mis-auto -mt-2">
                <p class="text-xs text-gray-300" v-if="!user.online">{{ $t('Last seen') }}</p>
                <p class="text-xs text-gray-300" v-if="!user.online">
                    <DateTranslation :end="user.last_seen_at" type="period" />
                </p>

                <p class="text-xs text-white flex items-center" v-else>
                    <CheckCircleIcon class="text-green-500 h-3 w-3 inline mr-1" />
                    Online
                </p>
            </div>
        </div>
        <div class="flex w-full gap-4">
            <p class="text-sm text-white truncate max-w-[30ch] ">{{ conversation.latest_message?.body }}</p>

            <button @click.stop.prevent="showDeleteConvModal = true" class="self-end mis-auto ">
                <TrashIcon class="w-5 text-stone-200 hover:text-red-600 active:scale-90 " />
            </button>
            <!-- confirm delete media modal -->
            <Modal :show="showDeleteConvModal" @close="showDeleteConvModal = false" :closeable="true"
                :show-close-icon="false" :max-width="'sm'">
                <div class="flex flex-col justify-center p-6 text-stone-800 ">
                    <p class="mb-3 text-lg">
                        {{ $t('Are you sure you want delete this Conversation ? ') }}</p>
                    <div class="flex justify-center w-full gap-4">
                        <button
                            class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                            @click="showDeleteConvModal = false">{{ $t('Cancel')
                            }}
                        </button>
                        <button
                            class="p-2 px-8 text-white bg-black border-2 border-black rounded-full hover:bg-transparent hover:text-black active:scale-95 "
                            @click="removeConversation">{{ $t('Delete') }}
                        </button>
                    </div>
                </div>
            </Modal>
        </div>
    </div>
    </Link>
</template>
