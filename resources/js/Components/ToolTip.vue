<script setup>
defineProps({
    value:String
})
</script>
<template>

        <div class="absolute top-full ltr:left-1/2 rtl:right-1/2 -translate-x-1/2 bg-black bg-opacity-50 text-white p-2 rounded-lg text-xs z-10 hidden whitespace-nowrap">
            {{ value }}
        </div>
</template>