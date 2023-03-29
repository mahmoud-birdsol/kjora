<script setup>
import { ref, onMounted } from 'vue';
import { usePage, Link } from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { XMarkIcon } from "@heroicons/vue/24/solid";

const message = usePage().props.value.flash?.message;
const showSystemMessage = ref(true);
const height = ref(null)
onMounted(() => {
    if (message) height.value = document.querySelector('#SysMessage').offsetHeight

    if (message?.type === 'success') {
        setTimeout(() => {
            showSystemMessage.value = false
        }, 10000)
    }
})

</script>

<template>
    <div class="m-0" :style="`height: ${height}px;`" v-if="message && showSystemMessage"></div>
    <div v-if="message && showSystemMessage" class="fixed bottom-0 z-40 flex justify-between w-full max-md:text-xs" id="SysMessage">
        <!-- Info Message -->
        <div v-if="message.type === 'info'" class="flex w-full px-6 py-4 bg-sky-500">
            <div class="flex items-center justify-between w-full space-x-4 mt-3">
                <p class="font-bold text-sky-50">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="showSystemMessage = false" v-if="message.closeable && !message.action" class="absolute top-1 rtl:-left-2 ltr:-right-2">
                    <XMarkIcon class="w-6 h-6 text-white" />
                </button>
            </div>
        </div>

        <!-- Warning Message -->
        <div v-if="message.type === 'warning'" class="flex w-full px-6 py-4 bg-yellow-300">
            <div class="flex flex-col items-center justify-between w-full space-x-4 gap-y-2 md:flex-row  mt-3">
                <p class="font-bold text-gray-700">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="showSystemMessage = false" v-if="message.closeable && !message.action" class="absolute top-1 rtl:-left-2 ltr:-right-2">
                    <XMarkIcon class="w-6 h-6 text-stone-600" />
                </button>
            </div>
        </div>

        <!-- Danger Message -->
        <div v-if="message.type === 'danger'" class="flex w-full px-6 py-4 bg-rose-500">
            <div class="flex items-center justify-between w-full space-x-4 mt-3">
                <p class="font-bold text-rose-50">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="showSystemMessage = false" v-if="message.closeable && !message.action" class="absolute top-1 rtl:-left-2 ltr:-right-2">
                    <XMarkIcon class="w-6 h-6 text-white" />
                </button>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="message.type === 'success'" class="flex w-full px-6 py-4 bg-emerald-500">
            <div class="flex items-center justify-between w-full space-x-4 mt-3">
                <p class="font-bold text-emerald-50">{{ message.body }}</p>
                <Link v-if="message.action" :href="message.action.url">
                <SecondaryButton size="sm">{{ message.action.text }}</SecondaryButton>
                </Link>

                <button @click="showSystemMessage = false" v-if="message.closeable && !message.action" class="absolute top-1 rtl:-left-2 ltr:-right-2">
                    <XMarkIcon class="w-6 h-6 text-white" />
                </button>
            </div>
        </div>
    </div>
</template>
