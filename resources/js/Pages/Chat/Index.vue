<script setup>
import { onMounted, provide } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';

import { router, usePage } from "@inertiajs/vue3";

const props = defineProps(['conversations', 'last_online_at']);

const user = usePage().props.auth.user;

const acceptChatRegulations = () => {
    router.get(route('accept-chat-regulations'), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            if (user.latest_conversation) {
                router.get(route('chats.show', user.latest_conversation.id), {}, {
                    preserveState: false

                })
            }

        }
    });
}

onMounted(() => {
    if (user.accepted_chat_regulations_at != null) {
        if (user.latest_conversation) {
            router.get(route('chats.show', user.latest_conversation.id), {}, {
                preserveState: false
            })
        }

    }
})

provide('conversation', null);
</script>
<template>
    <AppLayout title="Chat">
        <template #header>
            {{ $t('chat') }}
        </template>

        <ChatLayout :conversations="conversations">
            <template #main v-if="user.accepted_chat_regulations_at == null">
                <div class="flex flex-col gap-4 p-8">
                    <h2 class="text-2xl font-bold capitalize">{{ $t('Welcome to chat!') }}</h2>


                    <p class="text-sm font-bold">{{$t("before-you-proceed-please-read-these-ground-rules-don-t-worry-we-ll-only-show-this-message-one-but-please-do-take-a-few-seconds-to-familiarize-yourself-with-these-rules-this-will-help-us-ensure-a-safe-and-friendly-environment-in-the-chat")}} .

                    </p>
                    <ul class="text-sm [&>li_p]:before:content-['•'] [&>li_p]:before:pie-6 font-bold">
                        <li>
                            <p>{{ $t('be nice and thoughtful your word can both help and hurt') }}</p>
                        </li>
                        <li>
                            <p>{{ $t("don't use offensive or vulgar words") }} </p>
                        </li>
                        <li>
                            <p>{{ $t("don't post any personal details") }} </p>
                        </li>
                        <li>
                            <p>{{ $t("don't post any advertising or promotional material") }}</p>
                        </li>
                        <li>
                            <p>{{ $t("don't create Threads that encourage spamming") }} </p>
                        </li>
                    </ul>

                </div>
            </template>
            <template #main v-else>
                <div class="flex flex-col gap-4 p-8">
                    <h2 class="text-2xl font-bold capitalize">{{$t('Welcome to chat!')}}</h2>

                    <p class="text-sm font-bold">{{$t('sorry-you-havent-any-conversation-yet')}}
                    </p>

                </div>
            </template>

            <template #footer v-if="user.accepted_chat_regulations_at == null">
                <div class="grid p-10 bg-white place-items-center rounded-2xl">
                    <button class="py-2 text-white bg-black px-28 rounded-3xl" v-if="user.latest_conversation" @click="acceptChatRegulations">{{ $t('ok')
                    }}</button>
                    <button class="py-2 text-white bg-black px-28 rounded-3xl" v-if="!user.latest_conversation">{{ $t('ok') }}</button>
                </div>
            </template>
        </ChatLayout>
    </AppLayout>
</template>
