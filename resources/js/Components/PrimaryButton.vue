<script setup>
import { usePage} from '@inertiajs/inertia-vue3'
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
const state = usePage().props.value.auth.user.state_name
</script>

<template>
    <button :type="type"
        class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-center text-white uppercase transition border border-transparent rounded-full focus:ring ltr:tracking-widest focus:outline-none"
        :class="state === 'Free'?'bg-black enabled:hover:bg-gray-700 active:bg-gray-900  focus:border-gray-900  disabled:bg-stone-500':'bg-golden enabled:hover:bg-golden/50 focus:border-golden/90 focus:ring-golden disabled:bg-golden/30'"
        >
        <slot />
    </button>
</template>
