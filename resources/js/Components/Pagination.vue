<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid';
defineProps({
	links: Array,
})
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <div v-if="links.at(0).url === null" class="px-4 py-3 mb-1 mr-1 text-lg leading-4 text-gray-400 border rounded ">
                <ChevronLeftIcon class="w-4 rtl:rotate-180 " />
            </div>
            <Link v-else
                class="px-4 py-3 mb-1 mr-1 text-lg leading-4 border rounded hover:bg-white hover:text-primary hover:border-primary focus:border-primary focus:text-primary"
                :class="{ 'bg-primary text-white': links.at(0).active }" :href="links.at(0).url">
            <ChevronLeftIcon class="w-4 rtl:rotate-180 " />
            </Link>
            <template v-for="(link, p) in links.slice(1, -1)" :key="p">
                <div v-if="link.url === null" class="px-4 py-3 mb-1 mr-1 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
                <Link v-else
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 border rounded hover:bg-white hover:text-primary hover:border-primary focus:border-primary focus:text-primary"
                    :class="{ 'bg-primary text-white': link.active }" :href="link.url" v-html="link.label" />
            </template>
            <div v-if="links.at(-1).url === null" class="px-4 py-3 mb-1 mr-1 text-lg leading-4 text-gray-400 border rounded ">
                <ChevronRightIcon class="w-4 rtl:rotate-180 " />
            </div>
            <Link v-else
                class="px-4 py-3 mb-1 mr-1 text-lg leading-4 border rounded hover:bg-white hover:text-primary hover:border-primary focus:border-primary focus:text-primary"
                :class="{ 'bg-primary text-white': links.at(0).active }" :href="links.at(-1).url">
            <ChevronRightIcon class="w-4 rtl:rotate-180" />
        </Link>
    </div>
</div></template>
