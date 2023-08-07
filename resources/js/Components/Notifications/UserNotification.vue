<template>
    <div class="pointer-events-auto flex w-full max-w-md rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
        <div class="w-0 flex-1 p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-0.5">
                    <img class="h-10 w-10 rounded-full"
                        :src="notification.userAvatar ?? 'https://ui-avatars.com/api/?name=' + notification.userName + '&color=094609FF&background=E2E2E2'"
                        alt="" />
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ notification.userName }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ notification.subtitle }}</p>
                </div>
            </div>
        </div>
        <div class="flex border-l border-gray-200" v-if="notification.actionData">
            <Link :href="notification.actionData.route">
            <button type="button" @click="show = false"
                class="flex flex-col h-full w-full items-center justify-center rounded-none rounded-r-lg border border-transparent p-4 text-sm font-medium text-primary hover:text-primaryDark focus:outline-none focus:ring-2 focus:ring-primary">
                {{ notification.actionData.text }}
            </button>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        required: true,
        type: Object,
    },
});
</script>
