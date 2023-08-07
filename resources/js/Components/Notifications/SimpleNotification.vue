<script setup>
import { Link } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {
    CheckCircleIcon,
    XCircleIcon,
    ExclamationTriangleIcon,
    ExclamationCircleIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    notification: {
        required: true,
        type: Object,
    },
});
</script>

<template>
    <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
        <div class="p-4">
            <div class="flex items-start">
                <!-- Notification Icon -->
                <div class="flex-shrink-0">
                    <CheckCircleIcon v-if="notification.state == 'success'" class="h-6 w-6 text-green-400" aria-hidden="true" />

                    <XCircleIcon v-if="notification.state == 'error'" class="h-6 w-6 text-red-400" aria-hidden="true" />

                    <ExclamationTriangleIcon v-if="notification.state == 'warning'" class="h-6 w-6 text-amber-400" aria-hidden="true" />

                    <ExclamationCircleIcon v-if="notification.state == 'info'" class="h-6 w-6 text-sky-400" aria-hidden="true" />
                </div>

                <!-- Notification Body -->
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">{{ notification.title }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ notification.subtitle }}</p>

                    <div class="mt-4" v-if="notification.actionData">
                        <Link class="mt-4" :href="notification.actionData.route">
                        <SecondaryButton size="sm">{{ notification.actionData.text }}</SecondaryButton>
                        </Link>
                    </div>
                </div>

                <!-- Notification close button -->
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" @click="$emit('close')"
                        class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Close</span>
                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
