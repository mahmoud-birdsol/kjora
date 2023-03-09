<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import { Inertia } from "@inertiajs/inertia";
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import FiltersModel from '@/Components/FiltersModel.vue';
const showFiltersModal = ref(false);
const props = defineProps({
    players: Object,
    positions: Array,
    advertisements: Array,
    countries: Array,
});
const form = useForm({
    position: usePage().props.value.queryParams.position ?? null,
    ageFrom: 18,
    ageTo: 60,
    ratingFrom: 0,
    ratingTo: 5,
    search: usePage().props.value.queryParams.search ?? '',
    country_id: usePage().props.value.queryParams.country_id ?? null
});
const loading = ref(false);
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
    form.ageForm = 18;
    form.ageto = 0;
    form.search = '';
    form.country_id = null
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
const filterByPosition = (position) => {
    form.position = position;
    filter();
};
</script>
<template>
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader />
        </template>
        <template #ads>

            <Splide dir="ltr" class=" h-full w-[32rem] max-w-full self-end overflow-hidden  rounded-full md:ml-auto" :options="options">
                <template v-for="(advertisement, i) in advertisements" :key="i">
                    <SplideSlide class="h-full">
                        <a :href="route('advertisements.show', advertisement)" class="block" target="_blank">
                            <img class="object-cover h-full " :src="advertisement.media[0].original_url" alt="">
                        </a>
                    </SplideSlide>
                </template>
            </Splide>


        </template>
        <div class="">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Position Filters...
                                                                                                    =====================================================-->
                <div class="flex gap-4 mt-4 mb-8 overflow-x-auto hideScrollBar">
                    <button @click="filterByPosition(null)" class="py-2 px-4  min-w-[215px] w-1/5 font-bold  text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs  text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
                    :class="{ 'border-primary': form.position == null, 'border-none': form.position != null }"
                    >
                        <span class="w-full text-center"
                            :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                            {{ position.name }}
                        </span>
                    </button>
                    <template v-for="position in positions" :key="position.id">
                        <button @click="filterByPosition(position.id)" class="py-2 px-4 min-w-[215px] w-1/5 text-center font-bold items-center bg-white border-2 border-gray-300 rounded-full  text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap">
                            <span class="w-full text-center"
                                :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                                {{ position.name }}
                            </span>
                        </button>
                    </template>
                </div>
                    <div class="flex items-center justify-center my-4">
                        <Pagination :links="players.links" />
                    </div>
                </div>
                <!-- Filters Modal...
                                                                                                                              =====================================================-->
                <FiltersModel :positions="positions" :countries="countries" v-model:form="form" @reset="reset"
                    @filter="filter" :showFiltersModal="showFiltersModal" />
                <!-- <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
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
                                                            <InputLabel>nationality</InputLabel>
                                                            <div class="px-4 py-1">
                                                                <RichSelectInput :options="countries" value-name="id" text-name="name"
                                                                    image-name="img" v-model="form.country_id" bgColor="black" txtColor="white" />
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
                                                                 <XMarkIcon class="inline w-4 h-4 mr-4" />
                                                                Reset
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </Modal>
                                        </div> -->
            </div>
        </div>
    </AppLayout>
</template>
