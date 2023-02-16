<template>
    <div class="py-12 ">
        <!-- chat box -->
        <div class="grid  w-full h-full md:grid-cols-[1fr_2fr]  text-neutral-500 bg-stone-300 rounded-2xl ">

            <div v-if="$slots.sidebar"
                class="flex flex-col gap-3 px-6 py-3 md:border-r-2 md:border-r-stone-500 max-md:border-b-2 max-md:border-b-stone-500">
                <slot name="sidebar"></slot>
            </div>
            <div class="grid grid-flow-row auto-rows-min">
                <!-- header -->
                <div v-if="$slots.header" class="flex self-start min-h-[1rem] border-b-2 border-b-stone-500">
                    <slot name="header"></slot>
                </div>
                <div v-if="$slots.main" class="self-stretch p-4">
                    <div class="text-[0.5rem] text-center">{{ dayjs(todayDate).format('DD/MM/YYYY') }}</div>

                    <slot name="main"></slot>
                </div>
                <!-- this is empty div for acts like separation -->
                <div v-if="$slots.main && $slots.footer" class="self-end h-2 border-y-2 border-y-stone-500">&nbsp;</div>
                <div v-if="$slots.footer" class="self-end p-2 h-min">
                    <!-- ok model -->
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import dayjs from 'dayjs';
import { ref } from 'vue';
const todayDate = ref(new Date().now)

</script>

<style lang="scss" scoped>

</style>
