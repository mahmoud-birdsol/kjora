<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PerformanceTab from '@/Components/PerformanceTab.vue';
import ProfileGallery from '@/Components/ProfileGallery.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';
import { computed, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import FadeInTransition from '../../Components/FadeInTransition.vue';
import Modal from '../../Components/Modal.vue';
import { ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    player: null,
    media: Array,
    playerRating: Array

});

const currentTabId = ref(2)

const tabs = computed(() => {
    return [
        { name: 'performance', id: 1, component: PerformanceTab, compProps: { playerRating: props.playerRating } },
        {
            name: 'photos', id: 2, component: ProfileGallery, compProps:
                { user: props.player, media: props.media, shouldPreview: 'photos' }
        },
        {
            name: 'videos', id: 3, component: ProfileGallery, compProps:
                { user: props.player, media: props.media, shouldPreview: 'videos' }
        }]
})

function reloadMedia() {
    Inertia.reload({ only: ['media'] })
}


</script>

<template>
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader />
        </template>

        <div class="py-12">
            <div class="flex flex-col max-w-5xl mx-auto gap-y-6 sm:px-6 lg:px-8">
                <MainPlayerCard :player="player" size="lg" :show-report="false" />
                <div class="flex justify-center p-2 bg-white rounded-full gap-x-3 ">
                    <template v-for="(tab, index) in tabs" :key="index">
                        <button @click="currentTabId = tab.id" :data-tab="tab.name"
                            class="text-sm font-semibold uppercase transition-colors duration-150 ease-in hover:text-stone-600 "
                            :class="tab.id === currentTabId ? 'text-stone-800' : 'text-stone-400'">{{
                                tab.name }} </button>
                    </template>

                </div>
                <div>
                    <FadeInTransition>
                        <template v-for="(tab, index) in tabs" :key="index">
                            <div v-if="tab.id === currentTabId">
                                <component v-bind="tab.compProps" :is="tab.component" @reload="reloadMedia"></component>
                            </div>
                        </template>
                    </FadeInTransition>
                </div>

            </div>
        </div>


    </AppLayout>
</template>

