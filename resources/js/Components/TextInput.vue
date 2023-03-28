<script setup>
import {onMounted, ref} from 'vue';

defineProps({
    modelValue: String,
    type: {
        required: false,
        type: String,
        default: 'text'
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <input
        ref="input"
        class="block w-full rounded-full border-gray-300 px-4 shadow-sm focus:border-primary focus:ring-0 sm:text-sm disabled:bg-gray-100 text-xs"
        :type="type"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
