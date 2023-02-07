<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import dayjs from 'dayjs';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import Pagination from '@/Components/Pagination.vue';
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    players: Object,
    positions: Array,
});

const form = useForm({
    position: usePage().props.value.queryParams.position,
    age: usePage().props.value.queryParams.age ?? 18,
    rating: usePage().props.value.queryParams.rating ?? 0,
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
</script>

<template>
    <Head title="Home"/>

    <AppLayout title="Home">
        <template #header>
            <p class="text-2xl font-light">Hello,</p>
            <p class="text-7xl font-black">{{ $page.props.auth.user.first_name }}</p>
            <p class="text-lg font-semibold">{{ dayjs().format('dddd, DD MMMM YYYY') }}</p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Position Filters...
                =====================================================-->
                <div class="grid grid-cols-5 gap-4 my-8">
                    <SecondaryButton @click="filterByPosition(null)">
                        <span class="w-full text-center"
                              :class="{'text-black': form.position == null, 'text-gray-400': form.position != null}">
                            All positions
                        </span>
                    </SecondaryButton>
                    <template v-for="position in positions" :key="position.id">
                        <SecondaryButton @click="filterByPosition(position.id)">
                            <span class="w-full text-center"
                                  :class="{'text-black': form.position == position.id, 'text-gray-400': form.position != position.id}">
                                {{ position.name }}
                            </span>
                        </SecondaryButton>
                    </template>
                </div>

                <!-- Current list...
                =====================================================-->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6" v-loading="loading">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                        <template v-for="player in players.data" :key="player.id">
                            <div class="rounded-xl p-4"
                                 style="background: url('/images/player_bg_sm.png'); background-size: cover; background-position: center;">
                                <div class="flex justify-between items-start">
                                    <div class="flex justify-start space-x-2 mb-2">
                                        <img :src="player.avatar" :alt="player.name"
                                             class="h-14 w-14 rounded-full border-2 border-white">
                                        <div>
                                            <Link :href="route('player.profile', player.id)">
                                                <h2 class="text-sm text-white font-bold">
                                                    {{ player.first_name }} {{ player.last_name }}
                                                </h2>
                                            </Link>

                                            <p class="text-xs text-white opacity-50">@{{ player.username }}</p>
                                            <p class="text-sm text-white flex items-center space-x-2">
                                                <ElRate v-model="player.rating" size="small"/>
                                                {{ player.rating }}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">$ {{ player.hourly_rate }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-4 gap-4 border-b border-white">
                                    <div>
                                        <p class="text-xs text-white opacity-50 text-light text-center">Age</p>
                                        <p class="text-sm text-white text-center font-semi-bold">{{ player.age }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-white opacity-50 text-light text-center">Played</p>
                                        <p class="text-sm text-white text-center font-semi-bold">0</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-white opacity-50 text-light text-center">Missed</p>
                                        <p class="text-sm text-white text-center font-semi-bold">0</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-white opacity-50 text-light text-center">Position</p>
                                        <p class="text-sm text-white text-center font-semi-bold">{{ player.position.name }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-white text-sm flex items-center">
                                        <MapPinIcon class="inline h-4 w-4 text-white"/>
                                        Cairo
                                    </p>

                                    <Link :href="route('invitation.create', player.id)" class="text-sm text-white">Send Invitation
                                        <ChevronDoubleRightIcon class="inline h-4 w-4 text-white"/>
                                    </Link>
                                </div>

                                <div class="flex justify-between items-center mt-6">
                                    <div>
                                        <div class="flex justify-center items-center rounded-full bg-black h-10 w-10">
                                            <span class="text-xs text-white">70KM</span>
                                        </div>
                                    </div>
                                    <div>
                                        <FlagIcon class="h-6 w-6 text-red-500"/>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-center items-center my-4">
                        <Pagination :links="players.links"/>
                    </div>
                </div>

                <!-- Filters Modal...
                =====================================================-->
                <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
                    <button
                        class="rounded-full h-16 w-16 bg-black shadow-xl text-center flex justify-center items-center"
                        @click="showFiltersModal = ! showFiltersModal">
                        <AdjustmentsHorizontalIcon class="text-white h-10 w-10"/>
                    </button>

                    <Modal :show="showFiltersModal" max-width="sm" @close="showFiltersModal = false">
                        <div class="bg-black p-6">
                            <div class="flex justify-between items-center">
                                <p class="text-white text-sm">Filter </p>

                                <button @click="showFiltersModal = false">
                                    <XMarkIcon class="h-4 w-4 text-white"/>
                                </button>
                            </div>

                            <form @submit.prevent="filter">
                                <div class="my-6">
                                    <InputLabel>Age</InputLabel>
                                    <div class="rounded-full px-4 py-2 mx-4 border border-white">
                                        <el-slider v-model="form.age" :min="18" :max="70"/>
                                    </div>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Rating</InputLabel>
                                    <div class="rounded-full px-4 py-1 mx-4 border border-white">
                                        <el-slider v-model="form.rating" :min="0" :max="5"/>
                                    </div>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Price</InputLabel>
                                    <div class="rounded-full px-4 py-1 mx-4 border border-white">
                                        <el-slider v-model="form.price" :min="0" :max="500"/>
                                    </div>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Search</InputLabel>
                                    <div class="px-4">
                                        <input type="search" name="search" id="search"
                                               v-model="form.search"
                                               class="block w-full rounded-full border-white px-4 focus:border-primary focus:ring-primary sm:text-sm bg-black text-white placeholder:center text-center"
                                               placeholder="Search by name or username"/>
                                    </div>
                                </div>

                                <div class="my-6">
                                    <InputLabel>Position</InputLabel>
                                    <div class="px-4">
                                        <select id="location" name="location"
                                                v-model="form.position_id"
                                                class="mt-1 block w-full rounded-full border-white py-2 pl-3 pr-10 text-base focus:border-primary focus:outline-none focus:ring-primary sm:text-sm text-white placeholder:center text-center bg-black">
                                            <option :value="null">All Positions</option>
                                            <option v-for="position in positions" :key="position.id"
                                                    :value="position.id">{{ position.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="my-6 mt-4">
                                    <SecondaryButton @click="filter">Apply</SecondaryButton>
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
