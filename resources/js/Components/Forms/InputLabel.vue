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
    <label class="block font-medium  text-xs uppercase ml-4 mb-1" :class="`text-${color}`">
        <span v-if="value">{{ value }}</span>
        <span v-else>
            <slot />
        </span>
    </label>
</template>
