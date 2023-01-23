<script setup>
import { computed } from 'vue';
import { TrashIcon, EyeIcon } from '@heroicons/vue/24/outline';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import ElNotification from 'element-plus';
import { notify } from "notiwind"

dayjs.extend(relativeTime);

const props = defineProps({
    notification: Object
});

const borderColor = computed(() => {
    return {
        'success': 'border-green-500',
        'warning': 'border-amber-500',
        'danger': 'border-red-500',
        'info': 'border-sky-500'
    }[props.notification.data.color.toString()];
});

const readForm = useForm({});

const markAsRead = () => {
    readForm.patch(route('notification.read', { notificationId: props.notification.id }), {
        preserveState: true,
        preserveScroll: true,
    });
};

const deleteForm = useForm({});

const deleteNotification = () => {
    deleteForm.delete(route('notification.delete', { notificationId: props.notification.id }), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <!--
        border-green-500
        border-amber-500
        border-red-500
        border-sky-500
    -->
    <li class="relative border-l-2 bg-white py-4 px-2 hover:bg-gray-50"
        :class="borderColor"
    >
        <div class="flex justify-between space-x-3">
            <div class="">
                <Link :href="notification.data.action" class="block focus:outline-none">
                    <p class="truncate text-sm font-medium text-gray-700">{{ notification.data.title }}</p>
                </Link>
            </div>
            <div>
                <time :datetime="notification.created_at"
                      class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">{{ dayjs(notification.created_at).fromNow() }}
                </time>
            </div>
        </div>
        <div class="mt-1">
            <p class="text-xs text-gray-500 line-clamp-2">{{ notification.data.subtitle }}</p>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="javascript:;" @click="markAsRead">
                <EyeIcon class="h-4 w-4 text-gray-500"/>
            </a>
            <a href="javascript:;" @click="deleteNotification">
                <TrashIcon class="h-4 w-4 text-gray-500"/>
            </a>
        </div>
    </li>
</template>
