<script setup>
import {Head, Link , useForm} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import HireCard from "@/Pages/Hire/Partials/HireCard.vue";
import {ref} from 'vue'
import { ElDatePicker, ElTimePicker } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
const props = defineProps({
    invitations: Array,
});
let showFiltersModal = ref(false)
const form = useForm({
    dateFrom: null,
    dateTo: null,
});
let loading = ref(false);

const filter = () => {
    loading.value = true;

    form.get(route('hire.index'), {
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
    filter();
}
</script>

<template>
    <Head title="Invitations"/>
    <AppLayout title="Invitations">
        <template #header>
            <p class="text-7xl font-black">Invitations</p>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end items-center space-x-4">
                    <Link :href="route('invitation.index')">
                        <SecondaryButton>
                                <span
                                    :class="{'text-gray-500': !route().current('invitation.index'), 'text-black': route().current('invitation.index')}">
                                    Invitation
                                </span>
                        </SecondaryButton>
                    </Link>
                    <Link :href="route('hire.index')">
                        <SecondaryButton>
                                <span
                                    :class="{'text-gray-500': !route().current('hire.index'), 'text-black': route().current('hire.index')}">
                                    Hire
                                </span>
                        </SecondaryButton>
                    </Link>
                </div>

                <div class="bg-white rounded-xl mt-4 min-h-[500px] p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <template v-for="invitation in invitations" :key="invitation.id">
                            <HireCard :invitation="invitation"/>
                        </template>
                    </div>
                </div>
            </div>
        </div>
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
                            format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss"  />
                        </div>
                        <div class="my-6">
                            <InputLabel>Date To :</InputLabel>
                            <ElDatePicker v-model="form.dateTo" class="w-full" type="datetime" placeholder="Pick a Date"
                            format="YYYY/MM/DD hh:mm:ss" value-format="YYYY/MM/DD HH:mm:ss"  />
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
    </AppLayout>
</template>
