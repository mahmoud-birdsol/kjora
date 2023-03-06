<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import { Inertia } from "@inertiajs/inertia";
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import Pagination from '@/Components/Pagination.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import { Splide, SplideSlide } from "@splidejs/vue-splide";

import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';


const props = defineProps({
    players: Object,
    positions: Array,
    advertisements: Array
});

const form = useForm({
    position: usePage().props.value.queryParams.position ?? null,
    age: parseInt(usePage().props.value.queryParams.age ?? 18),
    rating: parseInt(usePage().props.value.queryParams.rating ?? 0),
    search: usePage().props.value.queryParams.search ?? '',
});

const loading = ref(false);
const showFiltersModal = ref(false);

const filterByPosition = (position) => {
    form.position = position;
    filter();
};

const filter = () => {
    loading.value = true;

    form.get(route('home'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
            showFiltersModal.value = false;
        }
    });
};


const reset = () => {
    form.position = null;
    form.age = 18;
    form.rating = 0;
    form.search = '';

    filter();
}
const options = {
    arrows: false,
    // rewind: true,
    pagination: true,
    // drag: "free",
    type: props.advertisements.length > 1 ? "loop" : 'slide',
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
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader />
        </template>
        <template #ads>

            <Splide dir="ltr" class=" h-[4rem] w-[32rem] max-w-full self-end overflow-hidden  rounded-full md:ml-auto" :options="options">
                <template v-for="(advertisement, i) in advertisements" :key="i">
                    <SplideSlide class="h-full">
                        <img class="object-cover h-full " :src="advertisement" alt="">
                    </SplideSlide>
                </template>
            </Splide>


        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Position Filters...
                                                                                                    =====================================================-->
                <div class="flex gap-4 my-8 overflow-x-auto hideScrollBar">
                    <button @click="filterByPosition(null)" class="py-2 w-full text-center items-center bg-white border-2 border-gray-300 rounded-full font-semibold text-xs lg:text-[0.875rem] text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                    :class="{ 'border-primary': form.position == null, 'border-none': form.position != null }"
                    >
                        <span class="w-full text-center"
                            :class="{ 'text-black': form.position == null, 'text-gray-400': form.position != null }">
                            All positions
                        </span>
                    </button>
                    <template v-for="position in positions" :key="position.id">
                        <button @click="filterByPosition(position.id)" class="py-2 w-full text-center items-center bg-white border-2 border-gray-300 rounded-full font-semibold text-xs lg:text-[0.875rem] text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                            <span class="w-full text-center"
                                :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                                {{ position.name }}
                            </span>
                        </button>
                    </template>
                </div>

                <!-- Current list...
                                                                                                    =====================================================-->
                <div class="bg-white min-h-[500px] overflow-hidden shadow-xl sm:rounded-lg p-6" v-loading="loading">

                    <div class="flex items-start justify-start my-6">
                        <p class="text-sm font-bold">Total ({{ players.total }})</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        <template v-for="player in players.data" :key="player.id">
                            <MainPlayerCard :player="player" />
                        </template>
                    </div>

                    <div class="flex items-center justify-center my-4">
                        <Pagination :links="players.links" />
                    </div>
                </div>

                <!-- Filters Modal...
                                                                                                    =====================================================-->
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
                                        <el-slider v-model="form.age" class="" :min="18" :max="70" />
                                    </div>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Rating</InputLabel>
                                    <div class="px-4 py-1 mx-4 border border-white rounded-full">
                                        <el-slider v-model="form.rating" :min="0" :max="5" />
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
            </div>
        </div>
    </AppLayout>
</template>

<style>
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
