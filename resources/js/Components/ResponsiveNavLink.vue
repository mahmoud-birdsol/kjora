<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'block pl-3 pr-4 py-2 border-l-4 border-primary text-base font-medium text-white bg-transparent focus:outline-none focus:text-primary focus:bg-transparent focus:border-primary transition'
        : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:text-white hover:bg-transparent hover:border-primary focus:outline-none focus:text-white focus:bg-gray-50 focus:border-primary transition';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <Link v-else :href="href" class="flex gap-2 items-center" :class="classes">
        <slot />
        </Link>
    </div>
</template>
