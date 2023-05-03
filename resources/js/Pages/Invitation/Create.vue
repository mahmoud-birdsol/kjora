<script setup>
import { computed, ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElAutocomplete, ElDatePicker, ElTimePicker } from 'element-plus';
import dayjs from 'dayjs';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import MainPlayerCard from "@/Components/PlayerCards/MainPlayerCard.vue";
import AddStadiumModal from '../../Components/AddStadiumModal.vue';
import RichSelectInput from '@/Components/RichSelectInput.vue';

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
const date = new Date();
const isDisabled = ref(false)
const currentStadium = ref(null);
const currentUser = usePage().props.value.auth.user

const createInvitation = () => {
    if (isDisabled.value) return

    form.date = dayjs(form.date).add(1).format('YYYY-MM-DD');
    form.time = (new Date(form.time)).toISOString()
    form.post(route('invitation.store'), {
        onStart: () => {
            isDisabled.value = true
            console.log('creating');
        },
        onSuccess: () => {
            showSuccessModal.value = true;

        },
        onError: () => {
            isDisabled.value = false
        },
        preserveScroll: true,
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
    if (dayjs(form.date).format('dddd, DD MMMM YYYY') === dayjs(date).format('dddd, DD MMMM YYYY')) {
        let hour = date.getHours();
        return makeRange(0, hour + 1)
    }
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
const querySearch = (queryString, cb) => {
    const results = queryString
        ? props.stadiums.filter((stadium) => stadium.name.includes(queryString))
        : props.stadiums
    // call callback function to return suggestions
    cb(results)
}

</script>

<template>
    <Head :title="$t('send-invitation')" />

    <AppLayout :title="$t('send-invitation')">
        <template #header>
            <p class="text-4xl font-black md:text-7xl">{{ $t('send-invitation') }}</p>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    <div class="col-span-1">
                        <div class="p-6 bg-black rounded-xl">
                            <MainPlayerCard :player="invited" :show-report="false" :show-invite="false" />

                            <form @submit.prevent="">
                                <div class="my-6">
                                    <InputLabel>{{ $t('Date') }}</InputLabel>
                                    <div class="px-4">
                                        <ElDatePicker type="date" :disabled-date="disabledDate" style="background-color: black;" v-model="form.date"
                                            @change="disabledHours()" class="w-full" placeholde="DD/MM/YYYY" />
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.date" />
                                </div>

                                <div class="my-6">
                                    <InputLabel>{{ $t('Time') }}</InputLabel>
                                    <div class="px-4">
                                        <ElTimePicker placeholder="Pick the time " format="HH:mm" v-model="form.time" :disabled-hours="disabledHours" />
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.time" />
                                </div>

                                <div class="my-6">
                                    <InputLabel>{{ $t('Stadium') }}</InputLabel>
                                    <div class="px-4 ">
                                        <RichSelectInput :options="stadiums" value-name="id" text-name="name" :image-name="null" v-model="form.stadium_id"
                                            bgColor="black" txtColor="white" @selected="changeMapMarker" />
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.stadium_id" />
                                </div>

                                <div class="my-6 mt-4">
                                    <InputError class="my-2" :message="form.errors.review" />

                                    <SecondaryButton @click="createInvitation">{{ $t('Send') }}</SecondaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- staduim map -->
                    <div class="overflow-hidden text-white lg:col-span-2 md:col-span-1 rounded-xl">
                        <GMapMap :center="centerPosition" :zoom="15" style="width: 100%; height:100%; min-height: 500px; ">
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
        <div class="px-4">
            <Modal :show="showSuccessModal" max-width="md" @close="showSuccessModal = false">
                <div class="bg-white rounded-xl p-6 md:min-h-[300px]">
                    <div class="flex flex-col justify-between items-center h-56 md:min-h-[300px]">
                        <div class="flex justify-center">
                            <h2 class="text-xl font-bold uppercase text-primary">{{ $t('Invitation Sent') }}</h2>
                        </div>
                        <p class="">
                            {{ $t('Your invitation will be sent and you will receive an email updating you on the status of your request') }}.</p>

                        <Link :href="route('home')" class="flex w-full min-w-full">
                        <PrimaryButton class="w-full" @click="showSuccessModal = false">{{ $t('Ok') }}</PrimaryButton>
                        </Link>
                    </div>
                </div>
            </Modal>
        </div>
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

.disabled>.el-date-table-cell {
    background-color: black !important;
}

.disabled>.el-date-table-cell>.el-date-table-cell__text {
    color: gray !important;
}

.prev-month>.el-date-table-cell>.el-date-table-cell__text {
    color: darkgray !important;
}

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
