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
import PlayersMap from '@/Components/Maps/PlayersMap.vue'; import FiltersModel from '@/Components/FiltersModel.vue';
import {
    RadioGroup,
    RadioGroupOption,
} from '@headlessui/vue'
const showFiltersModal = ref(false);
const props = defineProps({
    players: Object,
    positions: Array,
    advertisements: Array,
    countries: Array,
});


const currentTabId = ref(1)
const loading = ref(false);

const form = useForm({
    position: null,
    ageFrom: 18,
    ageTo: 60,
    ratingFrom: 0,
    ratingTo: 5,
    search: '',
    location: null,
    country_id: null
});

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
    form.ageFrom = null;
    form.ageTo = null;
    form.ratingFrom = null;
    form.ratingTo = null;
    form.location = null;
    form.search = null;
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
                <!-- Position Filters...
                                                                                                                                                                                                                                                                                                    =====================================================-->
                <div class="flex gap-4 mt-4 mb-8 overflow-x-auto hideScrollBar">
                    <button @click="filterByPosition(null)"
                        class="py-2 px-4  min-w-[215px] w-1/5 font-bold  text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs  text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
                        :class="{ 'border-primary': form.position == null, 'border-none': form.position != null }">
                        <span class="w-full text-center rtl:tracking-tight"
                            :class="{ 'text-black': form.position == null, 'text-gray-400': form.position != null }">
                            {{ $t('All positions') }}
                        </span>
                    </button>
                    <template v-for="position in positions" :key="position.id">
                        <button @click="filterByPosition(position.id)"
                            class="py-2 px-4 min-w-[215px] w-1/5 text-center font-bold items-center bg-white border-2 border-gray-300 rounded-full  text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap">
                            <span class="w-full text-center rtl:tracking-tight"
                                :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                                {{ $t(position.name) }}
                            </span>
                        </button>
                    </template>
                </div>
                <RadioGroup v-model="currentTabId" class="flex items-center justify-end mb-2 w-full rounded-sm">
                    <RadioGroupOption v-slot="{ checked }" :value="1"
                        class="p-2 px-2 text-xs font-bold leading-none uppercase bg-white cursor-pointer hover:bg-stone-200 active:scale-95 "
                        :class="currentTabId == 1 ? 'bg-primary bg-opacity-80' : ''">{{ $t('grid') }}</RadioGroupOption>
                    <RadioGroupOption v-slot="{ checked }" :value="2"
                        class="p-2 px-2 text-xs font-bold leading-none uppercase bg-white cursor-pointer hover:bg-stone-200 active:scale-95 "
                        :class="currentTabId == 2 ? ' bg-primary bg-opacity-80' : ''">{{ $t('map') }}</RadioGroupOption>

                </RadioGroup>
                <!-- Current list...-->
                <div v-show="currentTabId == 1" class="bg-white min-h-[500px] overflow-hidden shadow-xl sm:rounded-lg p-6"
                    v-loading="loading">
                    <div>
                        <div class="flex items-start justify-start my-6">
                            <p class="text-sm font-bold">{{ $t('total ( :count )', { count: players.total }) }}</p>
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
                </div>
                <div v-show="currentTabId == 2" class="w-full overflow-hidden bg-white shadow-xl sm:rounded-lg ">
                    <PlayersMap :players="players" />
                </div>

                <!-- Filters Modal...
                                                                                                                                                                                                                                                                                                    =====================================================-->
                <FiltersModel :positions="positions" :countries="countries" v-model:form="form" @reset="reset"
                    @filter="filter" :showFiltersModal="showFiltersModal" />
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
