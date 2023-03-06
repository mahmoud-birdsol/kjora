<script setup>
const emit =defineEmits(['clicked'])
</script>
<template>
    <button
        class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-2  focus:ring-primary sm:text-sm disabled:bg-gray-100 text-start py-2 px-6 text-gray-500 transition duration-500" @click="$emit('clicked')">
        <slot />
    </button>
</template>