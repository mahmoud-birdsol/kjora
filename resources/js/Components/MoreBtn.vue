<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps({
    url: String,
})
</script>
<template>
    <Link :href="url"
        class="block w-full px-6 py-2 text-gray-500 transition duration-150 border border-gray-500 rounded-full sm:text-sm disabled:bg-gray-100 text-start focus:outline-transparent focus:border hover:border focus:border-primary hover:border-primary focus:text-primary hover:text-primary">
    <slot />
    </Link>
</template>
