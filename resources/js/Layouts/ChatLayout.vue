<template>
    <div class="py-12 min-h-[500px] ">
        <!-- chat box -->
        <div class="grid  w-full h-full lg:grid-cols-[1fr_2fr]  text-neutral-500 bg-white rounded-2xl ">

            <div v-if="$slots.sidebar"
                class="flex flex-col h-full gap-3 px-6 py-3 lg:border-r lg:border-r-stone-400 max-lg:border-b-1 max-lg:border-b-stone-400">
                <slot name="sidebar"></slot>
            </div>
            <div class="grid h-full grid-flow-row">
                <!-- header -->
                <div v-if="$slots.header" class="flex self-start min-h-[1rem] border-b border-b-stone-400">
                    <slot name="header"></slot>
                </div>
                <div v-if="$slots.main" class="self-stretch p-4">
                    <div class="text-[0.5rem] mb-2 text-center">{{ dayjs(todayDate).format('DD/MM/YYYY') }}</div>

                    <slot name="main"></slot>
                </div>
                <!-- this is empty div for acts like separation -->

                <div v-if="$slots.footer" class="self-end p-2 border-t h-min border-t-stone-400">
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

<style lang="scss" scoped></style>
