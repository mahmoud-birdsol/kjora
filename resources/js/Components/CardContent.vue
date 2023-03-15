<script setup>
const props = defineProps({
    title: String,
})
</script>

<template>
    <div class="min-h-[500px] flex flex-col gap-4 ">
        <div v-if="props.title">
            <div class="flex justify-center my-4">
                <h2 class="text-xl text-primary font-bold uppercase">{{ props.title }}</h2>
            </div>
        </div>
        <div class="mx-8">
            <slot name="body"></slot>
        </div>
        <div class="md:mx-8 my-4" v-if="$slots.footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>
