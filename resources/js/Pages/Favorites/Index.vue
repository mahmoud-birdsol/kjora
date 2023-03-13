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
    form.age = 18;
    form.rating = 0;
    form.search = '';
    form.country_id=null;

    filter();
}
</script>

<template>
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <p class="font-black text-7xl">Favorites</p>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Position Filters...
                                                    =====================================================-->
                <div class="flex gap-4 my-8 overflow-x-auto hideScrollBar">
                    <SecondaryButton @click="filterByPosition(null)">
                        <span class="w-full text-center"
                            :class="{ 'text-black': form.position == null, 'text-gray-400': form.position != null }">
                            All positions
                        </span>
                    </SecondaryButton>
                    <template v-for="position in positions" :key="position.id">
                        <SecondaryButton @click="filterByPosition(position.id)">
                            <span class="w-full text-center"
                                :class="{ 'text-black': form.position == position.id, 'text-gray-400': form.position != position.id }">
                                {{ position.name }}
                            </span>
                        </SecondaryButton>
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
