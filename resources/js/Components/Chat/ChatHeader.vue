<script setup>
import { ref, watch } from "vue";
import FadeInTransition from '@/Components/FadeInTransition.vue';
import Avatar from '@/Components/Avatar.vue';
import ReportModal from "@/Components/ReportModal.vue";
import { useChat } from "@/stores/chat";
import {
    FlagIcon,
    MagnifyingGlassIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import TextInput from "../TextInput.vue";

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

const showSearchForm = ref(false);

watch(() => chat.search, () => {
    _.debounce(chat.searchMessages, 500)();
});
</script>

<template>
    <FadeInTransition>
        <div v-if="showSearchForm" class="w-full">
            <div class="flex justify-between items-center gap-4 p-4">
                <div class="grow">
                    <TextInput type="search" v-model="chat.search" placeholder="Search" />
                </div>
                <div class="flex-none">
                    <button @click="showSearchForm = false" class="rounded-full p-1 group hover:ring-primary hover:ring">
                        <XMarkIcon class="w-5 text-black group-hover:text-primary" />
                    </button>
                </div>
            </div>
        </div>
        <div class="flex w-full" v-else>
            <div class="flex flex-1 items-center gap-4 border-r border-r-stone-400 p-4">
                <Avatar :image-url="player.avatar_url" :username="player.name" size="md" :border="true"
                    border-color="primary" />

                <div class="flex flex-col">
                    <h4 class="mb-1 font-bold capitalize leading-none text-primary">
                        {{ player.name }}
                    </h4>
                    <span class="text-xs leading-none text-neutral-500">
                        @{{ player.username }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4">
                <button @click="showSearchForm = true">
                    <MagnifyingGlassIcon class="h-5 w-5 cursor-pointer text-primary hover:text-primaryDark" />
                </button>
                <ReportModal :reportable-id="conversation.id" :reportable-type="'App\\Models\\Conversation'">
                    <template #trigger>
                        <button>
                            <FlagIcon class="h-5 w-5 text-red-500 mt-0.5" />
                        </button>
                    </template>
                </ReportModal>
            </div>
        </div>
    </FadeInTransition>
</template>
