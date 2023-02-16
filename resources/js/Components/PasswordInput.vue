<script setup>
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid';
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    placeholder: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

const type = ref('password');

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative mt-1 rounded-md shadow-sm">
        <input
            ref="input"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            class="block w-full rounded-full border-gray-300 px-4 shadow-sm focus:border-primary focus:ring-primary sm:text-sm disabled:bg-gray-100"
            @input="$emit('update:modelValue', $event.target.value)"
            auto-complete="new-password"
            aria-required="true"
        >
        <div class="cursor-pointer absolute inset-y-0 right-0 flex items-center pr-3">
            <EyeSlashIcon v-if="type == 'text'" @click="type = 'password'" class="h-5 w-5 text-gray-400"/>
            <EyeIcon v-if="type == 'password'" @click="type = 'text'" class="h-5 w-5 text-gray-400"/>
        </div>
    </div>
</template>
