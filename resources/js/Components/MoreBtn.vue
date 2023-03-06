<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props =  defineProps({
    url:String,
})
</script>
<template>
    <Link
        :href="url"
        class="w-full block rounded-full border border-gray-500 focus:border-none focus:ring-2  focus:ring-primary sm:text-sm disabled:bg-gray-100 text-start py-2 px-6 text-gray-500 transition duration-500" >
        <slot />
    </Link>
</template>