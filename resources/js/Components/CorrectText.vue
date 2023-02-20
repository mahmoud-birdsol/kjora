<script setup>
import { CheckIcon } from '@heroicons/vue/24/solid';

</script>

<template>
    <p class="text-xs text-gray-900 font-light">
        <span class="inline">
            <CheckIcon class="h-5 w-5 text-green-500 inline"/>
        </span>

        <slot/>
    </p>
</template>
