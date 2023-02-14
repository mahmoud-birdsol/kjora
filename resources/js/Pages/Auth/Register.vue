<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import RegisterForm from '@/Pages/Auth/Forms/RegisterForm.vue';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';

const props = defineProps(['countries', 'positions']);
</script>

<template>
    <Head title="Register"/>

    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <CardContent title="Create an account">
                    <template #body>
                        <RegisterForm :countries="countries" :positions="positions"/>
                    </template>
                </CardContent>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
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

.el-picker-panel__body-wrapper, .el-date-picker__header-label, .el-picker-panel__icon-btn, .el-picker-panel__content, .el-date-table > tbody > tr > th {
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
