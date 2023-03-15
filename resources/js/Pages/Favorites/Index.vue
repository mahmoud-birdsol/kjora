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
import FiltersModel from '@/Components/FiltersModel.vue';
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';


const props = defineProps({
    players: Object,
    positions: Array,
    countries: Array,
});

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

const loading = ref(false);
const showFiltersModal = ref(false);

const filterByPosition = (position) => {
    form.position = position;
    filter();
};

const filter = () => {
    loading.value = true;

    form.get(route('favorites.index'), {
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
</script>

<template>
    <Head :title="$t('home')" />

    <AppLayout :title="$t('home')">
        <template #header>
            <p class="font-black sm:text-7xl">{{ $t('favorites') }}</p>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Position Filters...
                                                                        =====================================================-->
                <div class="flex gap-4 mt-4 mb-8 overflow-x-auto hideScrollBar">
                    <button @click="filterByPosition(null)"
                        class="py-2 px-4 min-w-[215px] w-1/5 text-center font-bold items-center bg-white border-2 border-gray-300 rounded-full  text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap">
                        <span class="w-full text-center"
                            :class="{ 'text-black': form.position == null, 'text-gray-400': form.position != null }">
                            {{ $t('All positions') }}
                        </span>
                    </button>
                    <template v-for="position in positions" :key="position.id">
                        <button @click="filterByPosition(position.id)"
                            class="py-2 px-4 min-w-[215px] w-1/5 text-center font-bold items-center bg-white border-2 border-gray-300 rounded-full  text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap">
                            <span class="w-full text-center"
                                :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                                {{ $t(position.name) }}
                            </span>
                        </button>
                    </template>
                </div>

                <!-- Current list...
                                                                        =====================================================-->
                <div class="bg-white min-h-[500px] overflow-hidden shadow-xl sm:rounded-lg p-6" v-loading="loading">

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
