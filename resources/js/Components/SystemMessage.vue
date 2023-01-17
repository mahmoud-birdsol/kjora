<script setup>
import { usePage, Link } from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
const message = usePage().props.value.flash?.message;
</script>

<template>
    <div v-if="message" class="max-w-3xl mx-auto sm:px-6 lg:px-8 sm:pt-4">
        <!-- Info Message -->
        <div v-if="message.type == 'info'" class="bg-sky-500 rounded-lg p-6">
            <div class="flex justify-between items-center space-x-4">
                <p class="text-sky-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton>{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>

        <!-- Warning Message -->
        <div v-if="message.type == 'warning'" class="bg-amber-500 rounded-lg p-6">
            <div class="flex justify-between items-center space-x-4">
                <p class="text-amber-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton>{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>

        <!-- Danger Message -->
        <div v-if="message.type == 'danger'" class="bg-rose-500 rounded-lg p-6">
            <div class="flex justify-between items-center space-x-4">
                <p class="text-rose-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton>{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="message.type == 'success'" class="bg-emerald-500 rounded-lg p-6">
            <div class="flex justify-between items-center space-x-4">
                <p class="text-emerald-50 font-bold">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                    <SecondaryButton>{{ message.action.text }}</SecondaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>
