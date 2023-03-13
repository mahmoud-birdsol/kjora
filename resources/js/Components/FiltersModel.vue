<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import Modal from '@/Components/Modal.vue';
import { ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
let age = ref([18,70])
let rating = ref([0,5])
const props = defineProps({
    positions: Array,
    form: Object,
    showFiltersModal: Boolean,
    countries: Array
})
let emit = defineEmits(['filter', 'reset', 'update:form'])
function filter() {
    emit('update:form', props.form)
    emit('filter')
}
function reset() {
    emit('reset')
}

const distances = [5, 10, 20, 30, 40, 50];

</script>
<template>
    <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
        <button class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full shadow-xl"
            @click="showFiltersModal = !showFiltersModal">
            <AdjustmentsHorizontalIcon class="w-10 h-10 text-white" />
        </button>
        <Modal :show="showFiltersModal" max-width="sm" @close="showFiltersModal = false" :closeable="false">
            <div class="p-6 bg-black">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-white">Filter </p>
                    <button @click="showFiltersModal = false">
                        <XMarkIcon class="w-4 h-4 text-white" />
                    </button>
                </div>
                <form @submit.prevent="filter">
                    <div class="my-6">
                        <InputLabel>Age</InputLabel>
                        <div class="px-4 py-2 mx-4 border border-white  rounded-full">
                            <el-slider v-model="age" range class="" :min="18" :max="70" @change="form.ageFrom=age[0] ; form.ageTo= age[1]"/>
                        </div>
                    </div>
                    <div class="my-6">
                        <InputLabel>Rating</InputLabel>
                        <div class="px-4 py-1 mx-4 border border-white rounded-full">
                            <el-slider v-model="rating" range :min="0" :max="5"  @change="form.ratingFrom = rating[0]; form.ratingTo = rating[1]  " />
                        </div>
                    </div>
                    <div class="my-6">
                        <InputLabel>Search</InputLabel>
                        <div class="px-4">
                            <input type="search" name="search" id="search" v-model="form.search"
                                class="block w-full px-4 text-center text-white bg-black border-white rounded-full focus:border-primary focus:ring-primary sm:text-sm placeholder:center"
                                placeholder="Search by name or username" />
                        </div>
                    </div>
                    <div class="my-6">
                        <InputLabel>Location</InputLabel>
                        <div class="px-4">
                            <select id="location" name="location" v-model="form.location"
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-base text-center text-white bg-black border-white rounded-full focus:border-primary focus:outline-none focus:ring-primary sm:text-sm placeholder:center">
                                <option :value="null">Distance</option>
                                <option v-for="distance in distances" :key="distance" :value="distance">{{
                                    distance }} Km
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="my-6">
                        <InputLabel>Nationality</InputLabel>
                        <div class="px-4 py-1">
                            <RichSelectInput :options="countries" value-name="id" text-name="name" image-name="flag"
                                v-model="form.country_id" bgColor="black" txtColor="white" />
                        </div>
                    </div>
                    <div class="my-6">
                        <InputLabel>Position</InputLabel>
                        <div class="px-4">
                            <select id="location" name="location" v-model="form.position"
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-base text-center text-white bg-black border-white rounded-full focus:border-primary focus:outline-none focus:ring-primary sm:text-sm placeholder:center">
                                <option :value="null">All Positions</option>
                                <option v-for="position in positions" :key="position.id" :value="position.id">{{
                                    position.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="my-6 mt-4">
                        <SecondaryButton @click="filter">Apply</SecondaryButton>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <button class="text-primary" @click="reset">
                            <!-- <XMarkIcon class="inline w-4 h-4 mr-4" /> -->
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>
<style scoped>
.el-slider__button {
    border: 2px solid green;
}

.el-slider__bar {
    background-color: green;
    height: 0.15rem;
}

.el-slider__runway {
    height: 0.15rem;
}
</style>
