<script setup>
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import SystemMessage from '@/Components/SystemMessage.vue';
import CopyrightClaim from '@/Components/CopyrightClaim.vue';
import Navbar from '@/Layouts/Partials/Navbar.vue';
import RealtimeNotifications from '@/Layouts/Partials/RealtimeNotifications.vue';
import { onMounted, provide, ref } from 'vue';
import { loadLanguageAsync } from 'laravel-vue-i18n';
import axios from 'axios';
import { usePermission } from '@vueuse/core';
onMounted(() => {
    loadLanguageAsync(usePage().props.value.locale)
})

defineProps({
    title: String,
});


const height = ref(null)
onMounted(() => {


    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, { enableHighAccuracy: true });

    // navigator.permissions.query({ name: "geolocation" }).then((result) => {
    //     console.log(result);
    // });


})
const successCallback = (position) => {


    axios.post(route('api.location.store'), {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude
    }).catch(err => console.error(err))
};

const errorCallback = (error) => {
    console.log(error);
};
</script>

<template>
    <div :dir="$page.props.locale == 'ar' ? 'rtl' : 'ltr'">

        <Head :title="title" />

        <div
            class="min-h-screen bg-gradient-to-b from-black to-primaryDark before:bg-[url(/images/ballkjoura.png)]  relative before:absolute before:inset-0 before:bg-no-repeat before:mix-blend-overlay isolate before:-z-10">
            <div class="flex flex-col justify-between min-h-screen pt-6 space-y-4 sm:pt-0 ltr:font-sans rtl:font-tajawl">
                <Navbar />

                <header v-if="$slots.header" class="">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="flex gap-6 px-4 md:flex-row sm:px-6 lg:px-8">
                            <h1 class="text-2xl font-bold text-white uppercase sm:text-7xl">
                                <slot name="header" />
                            </h1>
                            <slot v-if="$slots.ads" name="ads" />
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="w-full px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot />
                </main>

                <!-- Footer -->
                <footer>
                    <div class="flex justify-center h-10">
                        <CopyrightClaim />
                    </div>
                </footer>
                <SystemMessage />
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

