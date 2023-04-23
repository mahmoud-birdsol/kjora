<script setup>
import {PlusCircleIcon, XMarkIcon,} from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import {ref} from 'vue'
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import FixedActionBtn from '@/Components/FixedActionBtn.vue';


const emits = defineEmits(['close', 'open'])
let showAddStadiumModal = ref(false)
let showPlacesInput = ref(false)
let loading = ref(false);
const form = useForm({
    name: null,
    longitude: null,
    latitude: null,
    street_address: null,
    country: null,
    city: null,
    google_place_id: null
});

function addStadium() {

    form.post(route('stadiums.store'))
    showPlacesInput.value = false
    showAddStadiumModal.value = false
    emits('close')
}

function setPlace(e) {
    console.log(e.place_id);
    form.google_place_id = e.place_id;
    form.street_address = e.address_components[1].long_name;
    form.country = e.address_components[5].long_name;
    form.city = e.address_components[4].long_name;
    form.latitude = e.geometry.location.lat();
    form.longitude = e.geometry.location.lng();
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
    <FixedActionBtn @click="openModal">
        <PlusCircleIcon class="w-8 h-8 text-white"/>
    </FixedActionBtn>
    <Modal :show="showAddStadiumModal" max-width="sm" @close="closeModal" :closeable="true" :show-close-icon="false">
        <div class="p-6 bg-black">
            <div class="flex items-center justify-between">
                <p class="text-lg text-white">{{ $t('Add new Stadium') }} </p>

                <button @click="showAddStadiumModal = false">
                    <XMarkIcon class="w-4 h-4 text-white"/>
                </button>
            </div>

            <form @submit.prevent="addStadium">
                <div class="my-6">
                    <InputLabel>{{ $t('Stadium Name') }}</InputLabel>
                    <input type="text" name="search" id="search" v-model="form.name"
                           class="block w-full px-4 text-white bg-black border-white rounded-full focus:border-primary focus:ring-primary sm:text-sm placeholder:center"
                           :placeholder="$t('Stadium Name') + '...'"/>
                </div>
                <div class="my-6">
                    <InputLabel>{{ $t('Choose stadium place') }}</InputLabel>
                    <GMapAutocomplete :placeholder="$t('Choose from map')" @place_changed="setPlace"
                                      class="block w-full p-2 px-4 text-white bg-black border border-white rounded-full focus:border focus:border-primary focus:ring-primary sm:text-sm placeholder:center">
                    </GMapAutocomplete>
                </div>
                <div class="my-6 mt-4">
                    <SecondaryButton @click="addStadium">{{ $t('Add') }}</SecondaryButton>
                </div>

            </form>
        </div>
    </Modal>
</template>
