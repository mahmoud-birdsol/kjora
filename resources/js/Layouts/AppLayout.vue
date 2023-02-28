<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import SystemMessage from '@/Components/SystemMessage.vue';
import CopyrightClaim from '@/Components/CopyrightClaim.vue';
import Navbar from '@/Layouts/Partials/Navbar.vue';
import RealtimeNotifications from '@/Layouts/Partials/RealtimeNotifications.vue';
import { Splide, SplideSlide } from "@splidejs/vue-splide";


defineProps({
    title: String,
});


const options = {
    arrows: false,
    // rewind: true,
    pagination: true,
    // drag: "free",
    type: "loop",
    focus: "center",
    perPage: 1,
    perMove: 1,
    snap: true,
    autoplay: true,
    interval: 2000,
    autoScroll: {
        speed: 10,
        pagination: false,
    },
    breakpoints: {

    },
};
</script>

<template>
    <div>

        <Head :title="title" />

        <SystemMessage />

        <div class="min-h-screen bg-gradient-to-b from-black to-primaryDark">
            <div class="min-h-screen flex flex-col justify-between pt-6 sm:pt-0 space-y-4">
                <Navbar />

                <header v-if="$slots.header" class="">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row items-center  px-4 sm:px-6 lg:px-8 gap-6">
                            <h1 class="text-2xl sm:text-7xl font-bold text-white uppercase">
                                <slot name="header" />
                            </h1>
                            <div class="h-24 w-[28rem]  overflow-hidden rounded-full  bg-red-700 md:ml-auto ">

                                <Splide dir="ltr" class="w-full h-full" :options="options">
                                    <template v-for="(img, i) in 5" :key="i">
                                        <SplideSlide>
                                            <img class="object-cover w-full h-full object-center"
                                                src="/images/selfie_example.png" alt="">
                                        </SplideSlide>
                                    </template>
                                </Splide>

                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <slot />
                </main>

                <!-- Footer -->
                <footer>
                    <div class="h-10 flex justify-center">
                        <CopyrightClaim />
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <RealtimeNotifications />
</template>


<style>
.el-input__inner {
    height: 42px !important;
    color: black;
}

.el-form-item__label {
    color: rgb(0, 100, 0) !important;
}

.el-checkbox__label {
    color: rgb(0, 100, 0) !important;
}

.el-input__wrapper {
    width: 100%;
    height: 42px !important;
    border-radius: 25px;
    padding-left: 20px;
    padding-right: 20px;
}

.el-input {
    width: 100% !important;
}

.el-picker__popper {
    background-color: black !important;
    color: green !important;
}

.el-picker-panel {
    background-color: black !important;
    color: green !important;
    font-weight: bold !important;
}

.el-picker-panel__body-wrapper,
.el-date-picker__header-label,
.el-picker-panel__icon-btn,
.el-picker-panel__content,
.el-date-table>tbody>tr>th {
    color: green !important;
    font-weight: bold !important;
}

/*.el-picker-panel__body{*/
/*    color: green !important;*/
/*}*/

.el-date-table-cell__text {
    color: white !important;
    font-weight: bold !important;
}

.el-date-picker__header {
    color: green !important;
    font-weight: bold !important;
}

.el-date-picker__prev-btn {
    color: green !important;
}

.el-date-picker__next-btn {
    color: green !important;
}
</style>

