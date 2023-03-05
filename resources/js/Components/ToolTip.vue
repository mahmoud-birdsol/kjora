<script setup>
defineProps({
    value:String
})
</script>
<template>

        <div class="absolute top-full left-1/2 -translate-x-1/2 bg-black bg-opacity-50 text-white p-2 rounded-lg text-xs z-10 block whitespace-nowrap">
            {{ value }}
        </div>
</template>