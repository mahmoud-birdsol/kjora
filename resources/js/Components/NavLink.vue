<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium leading-5 text-white focus:outline-none focus:border-primary transition'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-white hover:border-primary focus:outline-none focus:text-gray-700 focus:border-primary transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
