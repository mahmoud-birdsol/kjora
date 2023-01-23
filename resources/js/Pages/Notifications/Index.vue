<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import NotificationComponent from '@/Components/NotificationComponent.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    notifications: Object
});
</script>

<template>
    <Head title="Notifications"/>

    <AppLayout>
        <template #header>Notifications</template>

        <div class="max-w-3xl mx-auto min-h-[500px] my-4">
            <div v-if="notifications.data.length">
                <ul role="list" class="divide-y divide-gray-200">
                    <template v-for="notification in notifications.data">
                        <NotificationComponent :notification="notification"/>
                    </template>
                </ul>
            </div>

            <div v-else>
                <div class="bg-white rounded p-6 mt-4">
                    <div class="block px-4 py-2 text-xs text-gray-500 text-center">
                        You don't have any notifications yet.
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-start">
            <Pagination :links="notifications.links"/>
        </div>
    </AppLayout>
</template>
