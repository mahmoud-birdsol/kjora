<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

import { ref } from 'vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';

defineProps(['positions']);


// const positions = [{ name: 'goalkeeper' }, { name: 'defender' }, { name: 'midfielder' }, { name: 'forward' }]
const players = { data: [] }
const loading = ref(false)
const form = useForm({
    position: usePage().props.value.queryParams.position ?? null,
    age: parseInt(usePage().props.value.queryParams.age ?? 18),
    rating: parseInt(usePage().props.value.queryParams.rating ?? 0),
    search: usePage().props.value.queryParams.search ?? '',
});
const filterByPosition = (position) => {
    form.position = position;
    filter();
};
const filter = () => {
    loading.value = true;
    form.get(route('favorite'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
            // showFiltersModal.value = false;
        }
    });
};
</script>
<template>
    <Head title="Favorite" />
    <AppLayout>
        <template #header>
            <p class="font-black text-7xl">Favorite</p>
            <p class="text-lg font-semibold">{{ dayjs().format('dddd, DD MMMM YYYY') }}</p>
        </template>
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
        <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg" v-loading="loading">
            <template v-if="players.data.length">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                    <template v-for="player in players.data" :key="player.id">
                        <MainPlayerCard :player="player" />
                    </template>
                </div>
            </template>
            <template v-else>
                <div class="text-sm text-center text-gray-500 capitalize">you have not added any player in your favourite
                    list yet</div>
            </template>
            <div class="flex items-center justify-center my-4">
                <!-- <Pagination :links="players.links" /> -->
            </div>
        </div>
    </AppLayout>
</template>
