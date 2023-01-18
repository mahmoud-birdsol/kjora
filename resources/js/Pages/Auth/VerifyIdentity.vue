<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faPassport } from '@fortawesome/free-solid-svg-icons';
import { faAddressCard } from '@fortawesome/free-solid-svg-icons';
import { ref, onBeforeMount } from 'vue';
import UploadImageModal from '@/Components/UploadImageModal.vue';

onBeforeMount(() => {
    library.add(faPassport);
    library.add(faAddressCard);
});

const props = defineProps({
    status: String,
    countries: Array,
});

const showUploadPassportModal = ref(false);

const form = useForm({
    country_id: 84,
});

const submit = () => {

};
</script>

<template>
    <Head title="Identity Verification"/>

    <AppLayout>
        <div class="my-8">
            <h1 class="text-7xl font-bold text-white uppercase">Security</h1>
        </div>

        <div class="w-full sm:flex sm:justify-between sm:space-x-4 mt-8">
            <div class="w-full">
                <form @submit.prevent="submit">
                    <div class="bg-white rounded-md p-6 w-full min-h-[500px]">
                        <div class="min-h-[500px] flex flex-col justify-between">
                            <div class="flex justify-center my-4">
                                <h2 class="text-xl text-primary font-bold uppercase">Verify Identity</h2>
                            </div>
                            <div class="mx-8">
                                <h3 class="text-gray-900 text-lg font-bold mb-4">Use a valid government-issued document</h3>
                                <p class="text-gray-500 text-xs">Only the following documents listed below will be accepted, all other documents will be rejected.</p>

                                <div class="mt-4">
                                    <InputLabel color="primary" for="country" value="Country of issue"/>
                                    <RichSelectInput :options="countries"
                                                     value-name="id"
                                                     text-name="name"
                                                     image-name="flag"
                                                     v-model="form.country_id"/>
                                    <InputError class="mt-2" :message="form.errors.country_id"/>
                                </div>

                                <div class="mt-4 flex justify-between space-x-4 px-4">

                                    <div class="bg-primary rounded-lg p-6 w-full flex items-center justify-center min-h-[200-px]">
                                        <button role="button" type="button"
                                                @click="showUploadPassportModal = ! showUploadPassportModal">
                                            <div class="flex justify-center mb-4">
                                                <font-awesome-icon icon="passport" class="w-12 h-auto text-white text-center"/>
                                            </div>
                                            <p class="text-white font-bold uppercase">Passport</p>
                                        </button>
                                    </div>

                                    <div
                                        class="bg-primary rounded-lg p-6 w-full flex items-center justify-center min-h-[200-px]">
                                        <div>
                                            <div class="flex justify-center mb-4">
                                                <font-awesome-icon icon="address-card"
                                                                   class="w-12 h-auto text-white text-center"/>
                                            </div>
                                            <p class="text-white font-bold uppercase">Government issue id</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Continue
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="w-full">
                <div class="bg-white rounded-md p-6 w-full min-h-[500px]">

                </div>
            </div>
        </div>

        <!-- Upload image Modals...
        =====================================================-->

        <UploadImageModal :show="showUploadPassportModal" @close="showUploadPassportModal = false"/>
    </AppLayout>
</template>
