<script setup>
import { computed } from 'vue';

const props = defineProps({
    imageUrl: {
        required: false,
        type: String,
    },
    size: {
        required: false,
        type: String,
        default: 'sm',
    },
    username: {
        required: false,
        type: String,
        default: 'Kjora',
    },
    border: {
        required: false,
        type: Boolean,
        default: false,
    }
    , borderColor: null
});

const sizeClasses = computed(() => {
    return {
        'sm': 'h-8 w-8',
        'md': 'h-10 w-10',
        'lg': 'h-20 w-20',
    }[props.size];
});
const borderColorClass = computed(() => {
    return {
        'white': 'border-white',
        'primary': 'border-primary',
        'black': 'border-stone-800',
    }[props.borderColor];
});

const borderClasses = computed(() => {
    return props.border ? 'border-2 ' : 'border-none';
})
</script>

<template>
    <span v-if="imageUrl" class="block rounded-full bg-cover bg-no-repeat bg-center"
        :class="[sizeClasses, borderClasses, borderColorClass]" :style="'background-image: url(' + imageUrl + ');'" />

    <span v-if="!imageUrl" class="block rounded-full bg-cover bg-no-repeat bg-center"
        :class="[sizeClasses, borderClasses, borderColorClass]"
        :style="'background-image: url(\'https://ui-avatars.com/api/?name=' + username + '&color=094609FF&background=E2E2E2\');'" />
</template>
