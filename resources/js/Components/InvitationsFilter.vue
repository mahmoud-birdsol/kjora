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
import {Head, Link , useForm} from '@inertiajs/inertia-vue3';
let showFiltersModal = ref(false)
let loading = ref(false);
const form = useForm({
    dateFrom: null,
    dateTo: null,
});

const filter = () => {
    loading.value = true;
    form.get(route('invitation.index'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
            showFiltersModal.value = false;
        }
    });
    console.log(showFiltersModal.value)
};
const reset = () => {
    form.dateFrom = null,
        form.dateTo = null,

        filter();
}
</script>
<template>
    <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
            <button class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full shadow-xl"
                @click="showFiltersModal = !showFiltersModal">
                <AdjustmentsHorizontalIcon class="w-10 h-10 text-white" />
            </button>
            <Modal :show="showFiltersModal" max-width="sm" @close="showFiltersModal = false" :closeable="false">
                <div class="p-6 bg-black">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-white">Filter </p>

                        <button @click="showFiltersModal = false">
                            <XMarkIcon class="w-4 h-4 text-white" />
                        </button>
                    </div>

                    <form @submit.prevent="filter">
                        <div class="my-6">
                            <InputLabel>Date From : </InputLabel>
                            <ElDatePicker v-model="form.dateFrom" class="w-full" type="datetime" placeholder="Pick a Date"
                                format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss" />
                        </div>
                        <div class="my-6">
                            <InputLabel>Date To :</InputLabel>
                            <ElDatePicker v-model="form.dateTo" class="w-full" type="datetime" placeholder="Pick a Date"
                                format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss" />
                        </div>

                        <div class="my-6 mt-4">
                            <SecondaryButton @click="filter">Apply</SecondaryButton>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <button class="text-primary" @click="reset">
                                <!-- <XMarkIcon class="inline w-4 h-4 mr-4" /> -->
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
</template>