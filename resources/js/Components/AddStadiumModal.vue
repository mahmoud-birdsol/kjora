<script setup>
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue'
import { ElDatePicker } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { PlusCircleIcon } from '@heroicons/vue/24/outline';



const emits = defineEmits(['close', 'open'])
let showAddStadiumModal = ref(false)
let showPlacesInput = ref(false)
let loading = ref(false);
const form = useForm({
    name: null,
    longitude: null,
    latitude: null,
    google_place_id: null
});

function addStadium() {

    form.post(route('stadiums.store'))
    showPlacesInput.value = false
    showAddStadiumModal.value = false
    emits('close')
}
function setPlace(e) {
    form.google_place_id = e.place_id
    form.latitude = e.geometry.location.lat()
    form.longitude = e.geometry.location.lng()
}
function openModal() {
    showAddStadiumModal.value = true
    // emits('open')
    // showPlacesInput.value = true
}
function closeModal() {
    showAddStadiumModal.value = false
    // setTimeout(() => {
    //     showPlacesInput.value = false
    //     emits('close')
    // }, 100);
}
</script>
<template>
    <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
        <button class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full shadow-xl"
            @click="openModal">
            <PlusCircleIcon class="w-8 h-8 text-white" />
        </button>
        <Modal :show="showAddStadiumModal" max-width="sm" @close="closeModal" :closeable="true" :show-close-icon="false">
            <div class="p-6 bg-black">
                <div class="flex items-center justify-between">
                    <p class="text-lg text-white">{{$t('Add new Stadium')}} </p>

                    <button @click="showAddStadiumModal = false">
                        <XMarkIcon class="w-4 h-4 text-white" />
                    </button>
                </div>

                <form @submit.prevent="addStadium">
                    <div class="my-6">
                        <InputLabel>{{$t('Stadium Name')}}</InputLabel>
                        <input type="text" name="search" id="search" v-model="form.name"
                            class="block w-full px-4  text-white bg-black border-white rounded-full focus:border-primary focus:ring-primary sm:text-sm placeholder:center"
                            :placeholder=" $t('Stadium Name') + '...'" />
                    </div>
                    <div class="my-6">
                        <InputLabel>{{$t('choose stadium place')}} </InputLabel>
                        <GMapAutocomplete :placeholder="$t('choose from map')" @place_changed="setPlace"
                            class="block w-full px-4  text-white bg-black border-white border p-2 rounded-full focus:border focus:border-primary focus:ring-primary sm:text-sm placeholder:center">
                        </GMapAutocomplete>
                    </div>
                    <div class="my-6 mt-4">
                        <SecondaryButton @click="addStadium">{{$t('Add')}}</SecondaryButton>
                    </div>

                </form>
            </div>
        </Modal>
    </div>
</template>
