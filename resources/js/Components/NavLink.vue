<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center gap-2 px-1 pt-1 border-b-2 border-primary text-sm font-medium leading-5 text-white focus:outline-none focus:border-primary transition'
        : 'inline-flex items-center gap-2 px-1 pt-1 text-sm font-medium leading-5 text-stone-400 hover:text-white focus:outline-none focus:text-gray-700 transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
