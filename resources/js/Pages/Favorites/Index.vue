<script setup>
import Pagination from "@/Components/Pagination.vue";
import MainPlayerCard from "@/Components/PlayerCards/MainPlayerCard.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

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
   search: "",
   location: null,
   country_id: null,
});

const loading = ref(false);
const showFiltersModal = ref(false);
</script>

<template>
   <Head :title="$t('home')" />

   <AppLayout :title="$t('home')">
      <template #header>
         <p class="font-black sm:text-7xl">{{ $t("favorites") }}</p>
      </template>

      <div class="py-12">
         <div class="">
            <div
               class="bg-white min-h-[500px] overflow-hidden shadow-xl sm:rounded-lg p-6"
               v-loading="loading"
            >
               <div class="flex items-start justify-start my-6">
                  <p class="text-sm font-bold">
                     {{ $t("total ( :count )", { count: players.total }) }}
                  </p>
               </div>

               <div
                  class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3"
               >
                  <template v-for="player in players.data" :key="player.id">
                     <MainPlayerCard :player="player" />
                  </template>
               </div>

               <div class="flex items-center justify-center my-4">
                  <Pagination :links="players.links" />
               </div>
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
