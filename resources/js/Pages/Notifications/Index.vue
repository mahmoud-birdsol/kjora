<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import NotificationComponent from "@/Components/NotificationComponent.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    notifications: Object,
});
</script>

<template>
    <Head title="Notifications" />

    <AppLayout>
        <template #header>Notifications</template>

        <div class="max-w-3xl mx-auto min-h-[500px] my-4">
            <div v-if="notifications.data.length">
                <ul role="list" class="divide-y divide-gray-200">
                    <template v-for="notification in notifications.data">
                        <NotificationComponent :notification="notification" />
                    </template>
                </ul>
            </div>

            <div v-else>
                <div class="p-6 mt-4 bg-white rounded">
                    <div
                        class="block px-4 py-2 text-xs text-center text-gray-500"
                    >
                        You don't have any notifications yet.
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-start">
            <Pagination :links="notifications.links" />
        </div>
    </AppLayout>
</template>
