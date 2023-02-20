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

import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import UserCard from '../Components/UserCard.vue';

const props = defineProps({
    players: Object,
    positions: Array,
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
</script>

<template>
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader />
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

                    <div class="flex justify-start items-start my-6">
                        <p class="text-sm font-bold">Total ({{ players.total }})</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
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
                        <div class="bg-black p-6">
                            <div class="flex justify-between items-center">
                                <p class="text-white text-sm">Filter </p>

                                <button @click="showFiltersModal = false">
                                    <XMarkIcon class="w-4 h-4 text-white" />
                                </button>
                            </div>

                            <form @submit.prevent="filter">
                                <div class="my-6">
                                    <InputLabel>Age</InputLabel>
                                    <div class="px-4 py-2 mx-4 border border-white rounded-full">
                                        <el-slider v-model="form.age" :min="18" :max="70" />
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
                                            class="mt-1 block w-full rounded-full border-white py-2 pl-3 pr-10 text-base focus:border-primary focus:outline-none focus:ring-primary sm:text-sm text-white placeholder:center text-center bg-black">
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
                                <div class="flex justify-center items-center mt-4">
                                    <button class="text-primary" @click="reset">
                                        <XMarkIcon class="h-4 w-4 inline mr-4" />
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
