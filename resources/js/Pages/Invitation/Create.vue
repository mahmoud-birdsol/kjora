<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import dayjs from 'dayjs';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import {
    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';

import { ElDatePicker } from 'element-plus';

const props = defineProps({
    invited: Object,
    stadiums: Array,
});

const form = useForm({
    date: null,
    time: null,
    stadium_id: null,
    invited_player_id: props.invited.id,
});

const showSuccessModal = ref(false);

const createInvitation = () => {
    form.post(route('invitation.store'), {
        onSuccess: () => {
            showSuccessModal.value = true;
        },
    });
};

</script>

<template>
    <Head title="Send Invitation"/>

    <AppLayout title="Send Invitation">
        <template #header>
            <p class="text-7xl font-black">Send Invitation</p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="col-span-1">
                        <div class="bg-black rounded-xl p-6">
                            <div class="rounded-xl p-4"
                                 style="background: url('/images/player_bg_sm.png'); background-size: cover; background-position: center;">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="text-sm text-white uppercase font-bold">{{ dayjs().format('d MMMM YYYY, HH:MM A') }}</p>
                                    </div>
                                    <div>
                                        <div class="flex justify-center items-center rounded-full bg-black h-10 w-10">
                                            <span class="text-xs text-white">$ {{ invited.hourly_rate }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between items-start">
                                    <div class="flex justify-start space-x-2 mb-2">
                                        <img :src="invited.avatar_url" :alt="invited.name"
                                             class="h-14 w-14 rounded-full border-2 border-white">
                                        <div>
                                            <h2 class="text-sm text-white font-bold">
                                                {{ invited.first_name }} {{ invited.last_name }}
                                            </h2>

                                            <p class="text-xs text-white opacity-50">@{{ invited.username }}</p>
                                            <p class="text-sm text-white flex items-center space-x-2">
                                                <ElRate v-model="invited.rating" size="small"/>
                                                {{ invited.rating }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <p class="text-xs text-white opacity-50 text-light text-center">Position</p>
                                        <p class="text-sm text-white text-center font-semi-bold">{{ invited.position.name }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-8 mb-4 border-t border-white">
                                    <p class="text-white text-sm flex items-center">
                                        <MapPinIcon class="inline h-4 w-4 text-white"/>
                                        Cairo
                                    </p>
                                </div>
                            </div>

                            <form @submit.prevent="">
                                <div class="my-6">
                                    <InputLabel>Date</InputLabel>
                                    <div class="px-4">
                                        <ElDatePicker style="background-color: black;" v-model="form.date"
                                                      class="w-full" placeholde="DD/MM/YYYY"/>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.date"/>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Time</InputLabel>
                                    <div class="px-4">
                                        <input type="time" name="time" id="time"
                                               v-model="form.time"
                                               class="block w-full rounded-full border-white px-4 focus:border-primary focus:ring-primary sm:text-sm bg-black text-white placeholder:center text-center"
                                               placeholder="Search by name or username"/>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.time"/>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Stadium</InputLabel>
                                    <div class="px-4">
                                        <select id="stadium" name="stadium"
                                                v-model="form.stadium_id"
                                                class="mt-1 block w-full rounded-full border-white py-2 pl-3 pr-10 text-base focus:border-primary focus:outline-none focus:ring-primary sm:text-sm text-white placeholder:center text-center bg-black">
                                            <option v-for="stadium in stadiums" :key="stadium.id"
                                                    :value="stadium.id">{{ stadium.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.stadium_id"/>
                                </div>

                                <div class="my-6 mt-4">
                                    <SecondaryButton @click="createInvitation">Send</SecondaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="showSuccessModal" max-width="md">
            <div class="bg-white rounded-xl p-6 min-h-[500px]">
                <div class="flex flex-col justify-between items-center min-h-[500px]">
                    <div class="flex justify-center my-4">
                        <h2 class="text-xl text-primary font-bold uppercase">Invitation Sent</h2>
                    </div>

                    <p class="">Your invitation will be sent and you will receive an email updating you on the status of your request.</p>

                    <Link :href="route('home')" class="flex min-w-full w-full">
                        <PrimaryButton class="w-full">Ok</PrimaryButton>
                    </Link>
                </div>
            </div>
        </Modal>
    </AppLayout>
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

.el-input__wrapper {
    background-color: black;
}

.el-input__inner{
    color: white;
}
</style>
