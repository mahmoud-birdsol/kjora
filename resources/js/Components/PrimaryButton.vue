<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type"
        class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-center text-white uppercase transition bg-black border border-transparent rounded-full ltr:tracking-widest enabled:hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:bg-stone-500">
        <slot />
    </button>
</template>
