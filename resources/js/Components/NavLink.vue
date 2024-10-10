<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center gap-2 px-1 pt-1  before:absolute before:h-1 before:bg-primary relative before:rounded-full before:bottom-[0px] before:w-[60%]  text-sm font-medium leading-5 text-white focus:outline-none  transition uppercase'
        : 'inline-flex items-center gap-2 px-1 pt-1 text-sm font-medium leading-5 hover:text-stone-400 text-white focus:outline-none focus:text-gray-700 transition uppercase';
});
</script>

<template>
    <Link :href="href" :class="classes" class=" py-2 ">
    <slot />
    </Link>
</template>
