<script setup>
import FadeInTransition from '@/Components/FadeInTransition.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';
import PerformanceTab from '@/Components/PerformanceTab.vue';
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue';
import ProfileGallery from '@/Components/ProfileGallery.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    player: null,
    posts: Array,
    playerRating: Array,

});

const currentTabId = ref(2)

const tabs = computed(() => {
    return [
        { name: 'performance', id: 1, component: PerformanceTab, compProps: { playerRating: props.playerRating } },
        {
            name: 'gallery', id: 2, component: ProfileGallery, compProps:
                { user: props.player, posts: props.posts, }
        }]
})

function reloadMedia() {
    router.reload({ only: ['posts'] })
}


</script>

<template>
    <Head title="Home">
        <meta property="og:title" content="Kjora App" />
        <meta property="og:description" :content="`this is profile of ${player.name} on kjora website `" />
        <meta property="og:image" :content="player.avatar_url ?? 'images/logo.png'" />

    </Head>
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
                                $t(tab.name) }} </button>
                    </template>

                </div>
                <div class="min-h-[350px] md:min-h-[550px]">
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

