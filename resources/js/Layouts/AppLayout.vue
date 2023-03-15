<script setup>
import {Head, usePage} from '@inertiajs/inertia-vue3';
import SystemMessage from '@/Components/SystemMessage.vue';
import CopyrightClaim from '@/Components/CopyrightClaim.vue';
import Navbar from '@/Layouts/Partials/Navbar.vue';
import RealtimeNotifications from '@/Layouts/Partials/RealtimeNotifications.vue';
import {onMounted, provide , ref} from 'vue';
import {loadLanguageAsync} from 'laravel-vue-i18n';
onMounted(()=>{
    loadLanguageAsync(usePage().props.value.locale)
})

defineProps({
    title: String,
});


const height = ref(null)
onMounted(()=> height.value = document.querySelector('#SysMessage').offsetHeight)

</script>

<template>
    <div :dir="$page.props.locale == 'ar' ? 'rtl' : 'ltr'" >

        <Head :title="title" />

        <div
            class="min-h-screen bg-gradient-to-b from-black to-primaryDark before:bg-[url(/images/ballkjoura.png)]  relative before:absolute before:inset-0 before:bg-no-repeat before:mix-blend-overlay isolate before:-z-10">
            <div class="min-h-screen flex flex-col justify-between pt-6 sm:pt-0 space-y-4 ltr:font-sans rtl:font-tajawl">
                <Navbar />

                <header v-if="$slots.header" class="">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row items-center  px-4 sm:px-6 lg:px-8 gap-6">
                            <h1 class="text-2xl sm:text-7xl font-bold text-white uppercase">
                                <slot name="header" />
                            </h1>
                            <slot v-if="$slots.ads" name="ads" />
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
                <div class="w-full" :style="`height:${height}px;`"></div>
                <SystemMessage id="SysMessage" />
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

