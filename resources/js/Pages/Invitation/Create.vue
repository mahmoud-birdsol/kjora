<script setup>
import { computed, ref, watch } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate, ElTimePicker } from 'element-plus';
import dayjs from 'dayjs';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { CustomMarker, GoogleMap, Marker } from "vue3-google-map";
import Avatar from '@/Components/Avatar.vue';
import {
    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';

import { ElDatePicker } from 'element-plus';
import MainPlayerCard from "@/Components/PlayerCards/MainPlayerCard.vue";
import AddStadiumModal from '../../Components/AddStadiumModal.vue';

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
const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const showSuccessModal = ref(false);
const showMap = ref(true)
const d = new Date();
const currentStadium = ref(null);
const currentUser = usePage().props.value.auth.user
const createInvitation = () => {
    form.post(route('invitation.store'), {
        onSuccess: () => {
            showSuccessModal.value = true;
        },
    });
};
const makeRange = (start, end) => {
    const result = []
    for (let i = start; i <= end; i++) {
        result.push(i)
    }
    return result
}
const disabledDate = (time) => {
    return dayjs(time).isBefore(dayjs().subtract(1, 'day'));
}
const disabledHours = () => {
    let hour = d.getHours();
    return makeRange(0, hour)
}
const disabledMinutes = (hour) => {
    let minutes = d.getMinutes();
    return makeRange(0, minutes)
}

let centerPosition = computed(() => {
    let lat
    let lng
    if (currentStadium.value) {
        lat = parseFloat(currentStadium.value?.latitude)
        lng = parseFloat(currentStadium.value?.longitude)
    } else {
        lat = parseFloat(currentUser.current_latitude)
        lng = parseFloat(currentUser.current_longitude)
    }
    return {
        lat,
        lng,
    }
})
let MarkerPosition = computed(() => {
    return {
        lat: parseFloat(currentStadium.value?.latitude),
        lng: parseFloat(currentStadium.value?.longitude),
    }
})


function changeMapMarker(e) {
    let std = props.stadiums.find(s => s.id === form.stadium_id)
    currentStadium.value = std

}


</script>

<template>
    <Head title="Send Invitation" />

    <AppLayout title="Send Invitation">
        <template #header>
            <p class="text-7xl font-black">Send Invitation</p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="col-span-1">
                        <div class="bg-black rounded-xl p-6">
                            <MainPlayerCard :player="invited" :show-report="false" :show-invite="false" />

                            <form @submit.prevent="">
                                <div class="my-6">
                                    <InputLabel>Date</InputLabel>
                                    <div class="px-4">
                                        <ElDatePicker stype="date" :disabled-date="disabledDate"
                                            style="background-color: black;" v-model="form.date" class="w-full"
                                            placeholde="DD/MM/YYYY" />
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.date" />
                                </div>

                                <div class="my-6">
                                    <InputLabel>Time</InputLabel>
                                    <div class="px-4">
                                        <ElTimePicker placeholder="Pick the time " v-model="form.time"
                                            :disabled-hours="disabledHours" :disabled-minutes="disabledMinutes" />
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.time" />
                                </div>

                                <div class="my-6">
                                    <InputLabel>Stadium</InputLabel>
                                    <div class="px-4">
                                        <select id="stadium" name="stadium" v-model="form.stadium_id"
                                            @change="changeMapMarker"
                                            class="mt-1 block w-full rounded-full border-white py-2 pl-3 pr-10 text-base focus:border-primary focus:outline-none focus:ring-primary sm:text-sm text-white placeholder:center text-center bg-black">
                                            <option v-for="stadium in stadiums" :key="stadium.id" :value="stadium.id">{{
                                                stadium.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.stadium_id" />
                                </div>

                                <div class="my-6 mt-4">
                                    <SecondaryButton @click="createInvitation">Send</SecondaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- staduim map -->
                    <div class="lg:col-span-2 md:col-span-1 text-white rounded-xl overflow-hidden">
                        <!-- map with vue3-google-map lib  -->
                        <!-- <GoogleMap v-if="showMap" :api-key="apiKey" style="width: 100%; height: 100%"
                                                           :center="centerPosition" :zoom="15">
                                                           <Marker v-if="currentStadium" :options="{ position: MarkerPosition }" />
                                                           <CustomMarker v-if="currentStadium"
                                                               :options="{ position: MarkerPosition, anchorPoint: 'TOP_RIGHT' }">
                                                               <div class="text-center rounded-md bg-white/90 ">
                                                                   <div class="p-2 text-xs font-bold text-stone-800">{{ currentStadium.name }}</div>
                                                               </div>
                                                           </CustomMarker>
                                                       </GoogleMap> -->

                        <!-- map with  vue 3 google map lib -->
                        <GMapMap :center="centerPosition" :zoom="15">
                            <GMapMarker v-if="currentStadium" :position="MarkerPosition" :clickable="true">
                                <GMapInfoWindow :opened="true">
                                    <div class="text-xs font-bold text-stone-800">{{ currentStadium.name }}</div>
                                </GMapInfoWindow>
                            </GMapMarker>
                        </GMapMap>
                    </div>
                </div>
            </div>
        </div>
        <AddStadiumModal />
        <Modal :show="showSuccessModal" max-width="md">
            <div class="bg-white rounded-xl p-6 min-h-[500px]">
                <div class="flex flex-col justify-between items-center min-h-[500px]">
                    <div class="flex justify-center my-4">
                        <h2 class="text-xl text-primary font-bold uppercase">Invitation Sent</h2>
                    </div>

                    <p class="">Your invitation will be sent and you will receive an email updating you on the status of
                        your request.</p>

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

.el-input__wrapper {
    background-color: black;
}

.el-input__inner {
    color: white;
}
</style>
