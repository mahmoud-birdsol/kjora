<script setup>
import {provide} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';

const props = defineProps(['conversations', 'last_online_at'])

provide('conversation', props.conversation);
</script>
<template>
    <AppLayout title="Chat">
        <template #header>
            {{$t('chat')}}
        </template>

        <ChatLayout :conversations="conversations">
            <template #main>
                <div class="flex flex-col gap-4 p-8">
                    <h2 class="text-2xl font-bold capitalize">{{$t('Welcome to chat!')}}</h2>

                    <p class="text-sm font-bold">{{$t("Beofre you proceed, please read thse ground rules. Don't worry, we'll only show this message one - but please do take a few seconds to familiarize yourself with these rules. This will help us ensure a safe and friendly environment in the chat")}} .
                    </p>
                    <ul class="text-sm [&>li_p]:before:content-['•'] [&>li_p]:before:pie-6 font-bold">
                        <li>
                            <p>{{$t('be nice and thoughtful your word can both help and hurt')}}</p>
                        </li>
                        <li>
                            <p>{{$t("don't use offensive or vulgar words")}} </p>
                        </li>
                        <li>
                            <p>{{$t("don't post any personal details")}} </p>
                        </li>
                        <li>
                            <p>{{$t("don't post any advertising or promotional material")}}</p>
                        </li>
                        <li>
                            <p>{{$t("don't create Threads that encourage spamming")}} </p>
                        </li>
                    </ul>

                </div>
            </template>
            <template #footer>
                <div class="grid p-10 bg-white place-items-center rounded-2xl">
                    <button class="py-2 text-white bg-black px-28 rounded-3xl">{{$t('ok')}}</button>
                </div>
            </template>
        </ChatLayout>
    </AppLayout>
</template>
