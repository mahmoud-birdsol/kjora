<script setup>
defineProps({
    value:String,
    right:{
        default:'right-1/2'
    },
    left:{
        default:'left-1/2'
    },
    top:{
        default:'top-full'
    }
})
</script>
<template>

        <div class="absolute bg-black bg-opacity-50 text-white p-2 rounded-lg text-xs z-10 hidden whitespace-nowrap"
        :class="`ltr:${left} rtl:${right} ${top}`"
        >
            {{ value }}
        </div>
</template>