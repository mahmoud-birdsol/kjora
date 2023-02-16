<script setup>
defineProps({
    value: String,
    color: {
        required: false,
        type: String,
        default: 'white',
    }
});
</script>

<template>
    <label class="block font-bold text-xs uppercase ml-4 mb-2" :class="`text-${color}`">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
