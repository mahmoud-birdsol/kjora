<script setup>
import {ref} from 'vue';
import {Head, useForm, usePage} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import {Splide, SplideSlide} from "@splidejs/vue-splide";
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
    location: usePage().props.value.queryParams.location ?? null,
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
    breakpoints: {},
};
const filterByPosition = (position) => {
    form.position = position;
    filter();
};
</script>
<template>
    <Head title="Home"/>

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader/>
        </template>
        <template #ads>

            <Splide dir="ltr" class=" h-full w-[32rem] max-w-full self-end overflow-hidden  rounded-full md:ml-auto"
                    :options="options">
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
                <div class="flex gap-4 mt-4 mb-8 overflow-x-auto hideScrollBar">
                    <button @click="filterByPosition(null)"
                            class="py-2 px-4 min-w-[215px] w-1/5 text-center font-bold items-center bg-white border-2 border-gray-300 rounded-full  text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap">
                    <span class="w-full text-center"
                          :class="{ 'text-black': form.position == null, 'text-gray-400': form.position != null }">
                        All Position
                    </span>
                    </button>
                    <template v-for="position in positions" :key="position.id">
                        <button @click="filterByPosition(position.id)"
                                class="py-2 px-4 min-w-[215px] w-1/5 text-center font-bold items-center bg-white border-2 border-gray-300 rounded-full  text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap">
                        <span class="w-full text-center"
                              :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                            {{ position.name }}
                        </span>
                        </button>
                    </template>
                </div>

                <!-- Current list-->
                <div class="bg-white min-h-[500px] overflow-hidden shadow-xl sm:rounded-lg p-6" v-loading="loading">

                    <div class="flex items-start justify-start my-6">
                        <p class="text-sm font-bold">Total ({{ players.total }})</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        <template v-for="player in players.data" :key="player.id">
                            <MainPlayerCard :player="player"/>
                        </template>
                    </div>

                    <div class="flex items-center justify-center my-4">
                        <Pagination :links="players.links"/>
                    </div>
                </div>
            </div>
            <!-- Filters Modal -->
            <FiltersModel :positions="positions" :countries="countries" v-model:form="form" @reset="reset"
                          @filter="filter"
                          :showFiltersModal="showFiltersModal"/>
        </div>
    </AppLayout>
</template>
