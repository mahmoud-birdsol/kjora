<script setup>
import { onMounted , ref } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import { FlagIcon } from '@heroicons/vue/24/outline'
import ChatLayout from '../../Layouts/ChatLayout.vue';
import ConversationsList from '../../Components/ConversationsList.vue';
import ReportModal from '../../Components/ReportModal.vue';



const props = defineProps(['conversations', 'last_online_at'])
let showReport = ref(true)

onMounted(() => {

})




</script>
<template>
    <AppLayout title="chat">
        <template #header>
            <p>chat</p>
        </template>
        <h1 class="text-white">chat welcome page</h1>
        <ChatLayout>
            <template #sidebar>
                <ConversationsList :conversations="conversations" :lastActiveAt="last_online_at" />
            </template>
            <template #header>
                <div class="flex-1 border-r border-r-stone-400"></div>
                <div class="flex items-center gap-2 p-4">
                    <button>
                        <MagnifyingGlassIcon class="w-4 h-4 cursor-pointer hover:text-primaryDark text-primary">
                        </MagnifyingGlassIcon>
                    </button>
                    <ReportModal v-if="showReport" :reportable-id="1" :reportable-type="'App\\Models\\Chat'">
                        <template #trigger>
                            <button>
                                <FlagIcon class="h-4 w-4 text-red-500" />
                            </button>
                        </template>
                    </ReportModal>
                </div>
            </template>
            <template #main>
                <div class="flex flex-col gap-4 p-8">
                    <h2 class="text-2xl font-bold capitalize">welcome to chat!</h2>

                    <p class="text-sm font-bold">Beofre you proceed, please read thse ground rules. Don't worry,
                        we'll
                        only show this message one - but please do take a few seconds to familiarize yourself
                        with these rules. This will help us ensure a safe and friendly environment in the chat .
                    </p>
                    <ul class="text-sm [&>li_p]:before:content-['•'] [&>li_p]:before:pie-6 font-bold">
                        <li>
                            <p>be nice and thoughtful your word can both help and hurt</p>
                        </li>
                        <li>
                            <p>don't use offensive or vulgar words </p>
                        </li>
                        <li>
                            <p>don't post any personal details </p>
                        </li>
                        <li>
                            <p>don't post any advertising or promotional material</p>
                        </li>
                        <li>
                            <p>don't create Threads that encourage spamming </p>
                        </li>
                    </ul>

                </div>
            </template>
            <template #footer>
                <div class="grid p-10 bg-white place-items-center rounded-2xl">
                    <button class="py-2 text-white bg-black px-28 rounded-3xl">ok</button>
                </div>
            </template>
        </ChatLayout>





    </AppLayout>
</template>


<style  ></style>
