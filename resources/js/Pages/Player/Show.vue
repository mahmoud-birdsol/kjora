<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import AppLayout from '@/Layouts/AppLayout.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import Avatar from '@/Components/Avatar.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';

import {
    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    player: Object,
});
</script>

<template>
    <Head title="Home"/>

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader/>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <MainPlayerCard :player="player" size="lg" :show-report="false"/>
            </div>
        </div>
    </AppLayout>
</template>
