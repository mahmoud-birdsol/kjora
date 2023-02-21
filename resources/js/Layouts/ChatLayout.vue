<template>
    <div class="py-12 min-h-[500px] ">
        <!-- chat box -->
        <div
            class="grid relative w-full h-full lg:grid-cols-[1.2fr_2fr] text-neutral-500 bg-white rounded-2xl overflow-hidden ">
            <!-- sidebar -->
            <div v-if="$slots.sidebar"
                class="flex-col h-full gap-3 px-6 py-3 lg:flex lg:border-r lg:border-r-stone-400 max-lg:border-b max-lg:border-b-stone-400 ">
                <!-- sidebarContainer on large screen -->
                <div class="hidden lg:block">
                    <slot name="sidebar"></slot>
                </div>
                <!-- sidebarContainer on small screen -->
                <div class="flex justify-end lg:hidden">
                    <!-- button to open sidebar -->
                    <button @click="showSideBar = true" class="p-1 text-black hover:text-primary">
                        <Bars3Icon class="w-6 " />
                    </button>
                    <!-- sidebar overlay -->
                    <FadeInTransition>
                        <div v-show="showSideBar" @click="showSideBar = false" @touchend="showSideBar = false"
                            class="absolute inset-0 z-10 bg-stone-400/50">
                        </div>
                    </FadeInTransition>
                    <!-- sidebar on small screen -->
                    <SlideInTransition>
                        <div v-show="showSideBar"
                            class="absolute top-0 right-0 z-20 flex flex-col h-full px-6 py-3 bg-white gap-y-3 ">
                            <div class="flex justify-end ">

                                <button @click="showSideBar = false"
                                    class="p-1 text-black rounded-full hover:ring-2 hover:ring-primary hover:text-primary">
                                    <XMarkIcon class="w-5 " />
                                </button>
                            </div>
                            <slot name="sidebar"></slot>
                        </div>
                    </SlideInTransition>
                </div>

            </div>
            <!-- main section -->
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
import { XMarkIcon, Bars3Icon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';
import SlideInTransition from '../Components/SlideInTransition.vue';
import FadeInTransition from '../Components/FadeInTransition.vue';
const todayDate = ref(new Date().now)
const showSideBar = ref(false)
</script>

<style lang="scss" scoped></style>
