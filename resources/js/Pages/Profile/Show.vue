<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import PerformanceTab from '@/Components/PerformanceTab.vue';
import ProfileGallery from '@/Components/ProfileGallery.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';
import { ref } from 'vue';

const props = defineProps({
    user: null,
    media: Array
});

// const media = [{ id: 1, type: "photo", url: '' }]
const tabs = [
    { name: 'performance', id: 1, component: PerformanceTab },
    {
        name: 'photos', id: 2, component: ProfileGallery, compProps:
            { user: props.user, media: props.media, shouldPreview: 'photos' }
    },
    {
        name: 'videos', id: 3, component: ProfileGallery, compProps:
            { user: props.user, media: props.media, shouldPreview: 'videos' }
    }]
const currentTabId = ref(2)

</script>

<template>
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <HelloUserHeader />
        </template>

        <div class="py-12">
            <div class="flex flex-col max-w-5xl mx-auto gap-y-6 sm:px-6 lg:px-8">
                <MainPlayerCard :player="user" size="lg" :show-report="false" />
                <div class="flex justify-center p-2 bg-white rounded-full gap-x-3 ">
                    <template v-for="(tab, index) in tabs" :key="index">
                        <button @click="currentTabId = tab.id" :data-tab="tab.name"
                            class="text-sm font-semibold uppercase transition-colors duration-150 ease-in hover:text-stone-600 "
                            :class="tab.id === currentTabId ? 'text-stone-800' : 'text-stone-400'">{{
                                tab.name }} </button>
                    </template>

                </div>
                <div>
                    <template v-for="(tab, index) in tabs" :key="index">
                        <div v-if="tab.id === currentTabId">
                            <component v-bind="tab.compProps" :is="tab.component"></component>
                        </div>
                    </template>
                    <!-- <component :user="user" :is="tab.component"></component> -->
                </div>

            </div>
        </div>
    </AppLayout>
</template>

