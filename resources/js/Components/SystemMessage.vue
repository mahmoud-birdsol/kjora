<script setup>
import { usePage, Link } from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
const message = usePage().props.value.flash?.message;
</script>

<template>
    <div v-if="message" class="flex w-full">
        <!-- Info Message -->
        <div v-if="message.type == 'info'" class="w-full flex bg-sky-500 px-6 py-4">
            <div class="flex justify-between max-w-7xl mx-auto items-center space-x-4">
                <p class="text-sky-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>

        <!-- Warning Message -->
        <div v-if="message.type == 'warning'" class="w-full flex bg-amber-500 px-6 py-4">
            <div class="flex justify-between max-w-7xl mx-auto items-center space-x-4">
                <p class="text-amber-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>

        <!-- Danger Message -->
        <div v-if="message.type == 'danger'" class="w-full flex bg-rose-500 px-6 py-4">
            <div class="flex justify-between max-w-7xl mx-auto items-center space-x-4">
                <p class="text-rose-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="message.type == 'success'" class="w-full flex bg-emerald-500 px-6 py-4">
            <div class="flex justify-between max-w-7xl mx-auto items-center space-x-4">
                <p class="text-emerald-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>
