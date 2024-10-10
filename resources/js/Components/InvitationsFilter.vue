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
import { Head, Link, useForm } from '@inertiajs/vue3';
import FixedActionBtn from '@/Components/FixedActionBtn.vue';
const props = defineProps({
    url: String,
})
const emits = defineEmits(['filter'])

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
            emits('filter', form.dateFrom, form.dateTo)
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
    <FixedActionBtn @click="showFiltersModal = !showFiltersModal">
        <AdjustmentsHorizontalIcon class="w-10 h-10 text-white" />
    </FixedActionBtn>
    <Modal :show="showFiltersModal" max-width="sm" @close="showFiltersModal = false" :closeable="false">
        <div class="bg-black " v-loading="loading">
            <div class="grid ">
                <button @click="showFiltersModal = false" class="p-1 justify-self-end">
                    <XMarkIcon class="w-4 h-4 text-white" />
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between gap-2">
                    <p class="text-sm text-white rtl:text-start ">{{ $t('filter') }} </p>
                    <button class="text-primary" @click="reset">
                        <!-- <XMarkIcon class="inline w-4 h-4 mr-4" /> -->
                        {{ $t('reset') }}
                    </button>
                </div>
                <form @submit.prevent="filter" @keydown.enter.exact="filter" class="rtl:text-start">
                    <div class="my-6">
                        <InputLabel>{{ $t('date from') }}: </InputLabel>
                        <ElDatePicker v-model="form.dateFrom" class="w-full" type="datetime" :placeholder="$t('date')" format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss" />
                    </div>
                    <div class="my-6">
                        <InputLabel>{{ $t('date to') }}:</InputLabel>
                        <ElDatePicker v-model="form.dateTo" class="w-full" type="datetime" :placeholder="$t('date')" format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss" />
                    </div>
                    <div class="my-6">
                        <InputLabel>{{ $t('search') }}</InputLabel>
                        <div>
                            <input type="search" name="search" id="search" v-model="form.search" class="block w-full text-center text-white bg-black border-white rounded-full focus:border-primary focus:ring-primary sm:text-sm placeholder:center" :placeholder="$t('search by name or username')" />
                        </div>
                    </div>
                    <div class="my-6 mt-4">
                        <SecondaryButton @click="filter">{{ $t('apply') }}</SecondaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Modal>
</template>
