<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { XMarkIcon } from "@heroicons/vue/24/solid";

const message = usePage().props.value.flash?.message;
const show = ref(true);
</script>

<template>
    <div v-if="message && show" class="flex w-full justify-between fixed bottom-0 z-[5]">
        <!-- Info Message -->
        <div v-if="message.type === 'info'" class="flex w-full bg-sky-500 px-6 py-4">
            <div class="w-full flex items-center justify-between space-x-4">
                <p class="font-bold text-sky-50">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="show = false" v-if="message.closeable && !message.action">
                    <XMarkIcon class="h-6 w-6 text-white" />
                </button>
            </div>
        </div>

        <!-- Warning Message -->
        <div v-if="message.type === 'warning'" class="flex w-full bg-yellow-300 px-6 py-4">
            <div class="flex w-full justify-between gap-y-2 flex-col md:flex-row items-center space-x-4">
                <p class="font-bold text-gray-700">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="show = false" v-if="message.closeable && !message.action">
                    <XMarkIcon class="h-6 w-6 text-white" />
                </button>
            </div>
        </div>

        <!-- Danger Message -->
        <div v-if="message.type === 'danger'" class="flex w-full bg-rose-500 px-6 py-4">
            <div class="w-full flex items-center justify-between space-x-4">
                <p class="font-bold text-rose-50">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="show = false" v-if="message.closeable && !message.action">
                    <XMarkIcon class="h-6 w-6 text-white" />
                </button>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="message.type === 'success'" class="flex w-full bg-emerald-500 px-6 py-4">
            <div class="w-full flex items-center justify-between space-x-4">
                <p class="font-bold text-emerald-50">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="show = false" v-if="message.closeable && !message.action">
                    <XMarkIcon class="h-6 w-6 text-white" />
                </button>
            </div>
        </div>
    </div>
</template>
