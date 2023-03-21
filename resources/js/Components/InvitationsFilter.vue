<script setup>
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue'
import { ElDatePicker } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import FixedWrapper from '@/Components/FixedWrapper.vue';
const props = defineProps({
    url: String,
})

let showFiltersModal = ref(false)
let loading = ref(false);
const form = useForm({
    dateFrom: null,
    dateTo: null,
    search: null,
});

const filter = () => {
    loading.value = true;
    form.get(route(props.url), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
            showFiltersModal.value = false;
        }
    });
};
const reset = () => {
    form.dateFrom = null,
        form.dateTo = null,
        form.search = ''
    filter();
}
</script>
<template>
    <FixedWrapper>
        <button class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full shadow-xl"
            @click="showFiltersModal = !showFiltersModal">
            <AdjustmentsHorizontalIcon class="w-10 h-10 text-white" />
        </button>
        <Modal :show="showFiltersModal" max-width="sm" @close="showFiltersModal = false" :closeable="false">
            <div class="p-6 bg-black" v-loading="loading">
                <div class="grid">
                    <button @click="showFiltersModal = false" class="justify-self-end">
                        <XMarkIcon class="w-4 h-4 text-white" />
                    </button>
                    <p class="text-sm text-white">{{$t('filter')}} </p>
    
                </div>
    
                <form @submit.prevent="filter">
                    <div class="my-6">
                        <InputLabel>{{$t('date from')}}: </InputLabel>
                        <ElDatePicker v-model="form.dateFrom" class="w-full" type="datetime" :placeholder="$t('pick a date')"
                            format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss" />
                    </div>
                    <div class="my-6">
                        <InputLabel>{{$t('date to') }}:</InputLabel>
                        <ElDatePicker v-model="form.dateTo" class="w-full" type="datetime" :placeholder="$t('pick a date')"
                            format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss" />
                    </div>
                    <div class="my-6">
                        <InputLabel>{{$t('search')}}</InputLabel>
                        <div>
                            <input type="search" name="search" id="search" v-model="form.search"
                                class="block w-full text-center text-white bg-black border-white rounded-full focus:border-primary focus:ring-primary sm:text-sm placeholder:center"
                                :placeholder="$t('search by name or username')" />
                        </div>
                    </div>
                    <div class="my-6 mt-4">
                        <SecondaryButton @click="filter">{{$t('apply')}}</SecondaryButton>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <button class="text-primary" @click="reset">
                            <!-- <XMarkIcon class="inline w-4 h-4 mr-4" /> -->
                            {{$t('reset')}}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </FixedWrapper>
</template>
