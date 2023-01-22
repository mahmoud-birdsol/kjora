<script setup>
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { ref, onBeforeMount, onMounted } from 'vue';
import UploadImageModal from '@/Components/UploadImageModal.vue';
import UploadSelfieModal from '@/Components/UploadSelfieModal.vue';
import { CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { faAddressCard, faPassport, faCamera } from '@fortawesome/free-solid-svg-icons';

onBeforeMount(() => {
    library.add(faPassport);
    library.add(faAddressCard);
    library.add(faCamera);
});

onMounted(() => {
    if (
        usePage().props.value.auth.user.identity_type != null &&
        usePage().props.value.auth.user.identity_issue_country !== null
    ) {
        completedFirstStep.value = true;
    }
});

const props = defineProps({
    status: String,
    countries: Array,
});

const showIdentityFrontImageModal = ref(false);
const showIdentityBackImageModal = ref(false);
const showIdentitySelfieModal = ref(false);
const completedFirstStep = ref(false);

const form = useForm({
    identity_issue_country: usePage().props.value.auth.user.identity_issue_country ?? 'Kuwait',
    identity_type: usePage().props.value.auth.user.identity_type,
    identity_front_image: usePage().props.value.auth.user.identity_front_image,
    identity_back_image: usePage().props.value.auth.user.identity_back_image,
    identity_selfie_image: usePage().props.value.auth.user.identity_selfie_image,
});

const save = () => {
    form.post(route('identity.verification.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            completedFirstStep.value = true;
        }
    });
};
</script>

<template>
    <Head title="Identity Verification"/>

    <AppLayout>
        <template #header>Verification</template>

        <div class="w-full sm:flex sm:justify-between sm:space-x-4 mt-8">
            <div class="w-full">
                <Card>
                    <CardContent title="Verify Identity">
                        <template #body>
                            <h3 class="text-gray-900 text-lg font-bold mb-4">Use a valid government-issued document</h3>
                            <p class="text-gray-500 text-xs">Only the following documents listed below will be accepted, all other documents will be rejected.</p>

                            <div class="mt-4">
                                <InputLabel color="primary" for="country" value="Country of issue"/>
                                <RichSelectInput :options="countries"
                                                 value-name="name"
                                                 text-name="name"
                                                 image-name="flag"
                                                 v-model="form.identity_issue_country"/>
                                <InputError class="mt-2" :message="form.errors.identity_issue_country"/>
                            </div>

                            <div class="mt-12 flex justify-between space-x-4">
                                <div class="rounded-lg p-6 w-full flex items-center justify-center min-h-[200-px]"
                                     :class="{'bg-primary': form.identity_type == null || form.identity_type  == 'national_id', 'bg-primaryDark': form.identity_type == 'passport'}"
                                >
                                    <button role="button"
                                            type="button"
                                            @click="form.identity_type = 'passport'">
                                        <div class="flex justify-center mb-4">
                                            <font-awesome-icon icon="passport"
                                                               class="w-12 h-auto text-white text-center"/>
                                        </div>
                                        <p class="text-white font-bold uppercase">Passport</p>
                                    </button>
                                </div>

                                <div class="rounded-lg p-6 w-full flex items-center justify-center min-h-[200-px]"
                                     :class="{'bg-primary': form.identity_type == null || form.identity_type  == 'passport', 'bg-primaryDark': form.identity_type == 'national_id'}"
                                >
                                    <button
                                        role="button"
                                        type="button"
                                        @click="form.identity_type = 'national_id'">
                                        <div class="flex justify-center mb-4">
                                            <font-awesome-icon icon="address-card"
                                                               class="w-12 h-auto text-white text-center"/>
                                        </div>
                                        <p class="text-white font-bold uppercase">Government issue id</p>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <PrimaryButton v-if="completedFirstStep == false" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing || form.identity_type == null || form.identity_issue_country == null"
                                           @click="save()"
                            >
                                Continue
                            </PrimaryButton>
                        </template>
                    </CardContent>
                </Card>
            </div>

            <div class="w-full">
                <Card>
                    <CardContent title="Upload Identity">
                        <template #body>
                            <h3 class="text-black font-bold uppercase mb-8">Take Selfie Photo</h3>
                            <h3 class="text-black text-sm font-bold capitalize">Example</h3>

                            <div class="flex space-x-4">
                                <div class="w-1/4">
                                    <button @click="showIdentitySelfieModal = true">
                                        <img src="/images/selfie_example.png" alt="" class="w-full h-auto">
                                    </button>
                                </div>
                                <div class="w-3/4">
                                    <p class="text-xs text-gray-900 font-light">
                                        <span class="inline">
                                            <CheckIcon class="h-5 w-5 text-green-500 inline"/>
                                        </span>
                                        Take a selfie of your self with a natural expression.
                                    </p>
                                    <p class="text-xs text-gray-900 font-light">
                                        <span class="inline">
                                            <CheckIcon class="h-5 w-5 text-green-500 inline"/>
                                        </span>
                                        Make sure your whole face is visible, centered and your eyes are open.
                                    </p>
                                    <p class="text-xs text-gray-900 font-light">
                                        <span class="inline">
                                            <XMarkIcon class="h-5 w-5 text-red-500 inline"/>
                                        </span>
                                        Do not copy your ID or use screenshots of your ID.
                                    </p>
                                    <p class="text-xs text-gray-900 font-light">
                                        <span class="inline">
                                            <XMarkIcon class="h-5 w-5 text-red-500 inline"/>
                                        </span>
                                        Do not hide or alter pars of your face (No hats/beauty images/filters/headgear).
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-black font-bold mt-2">
                                    File size must be between 10KB and 5120KB in jpg/jpeg/png format.
                                </p>
                            </div>
                            <div class="mt-4 flex justify-between space-x-4">
                                <div
                                    class="bg-primary rounded-lg p-6 w-full flex items-center justify-center min-h-[200-px]">
                                    <button role="button"
                                            type="button"
                                            @click="showIdentityFrontImageModal = true"
                                    >
                                        <div class="flex justify-center mb-4">
                                            <font-awesome-icon icon="camera"
                                                               class="w-12 h-auto text-white text-center"/>
                                        </div>
                                        <p class="text-white font-bold uppercase">Front</p>
                                    </button>
                                </div>

                                <div
                                    class="bg-primary rounded-lg p-6 w-full flex items-center justify-center min-h-[200-px]">
                                    <button
                                        role="button"
                                        type="button"
                                        @click="showIdentityBackImageModal = true"
                                    >
                                        <div class="flex justify-center mb-4">
                                            <font-awesome-icon icon="camera"
                                                               class="w-12 h-auto text-white text-center"/>
                                        </div>
                                        <p class="text-white font-bold uppercase">Back</p>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <PrimaryButton v-show="completedFirstStep == true"
                                           :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing"
                                           @click="save()"
                            >
                                Verify
                            </PrimaryButton>
                        </template>
                    </CardContent>
                </Card>
            </div>
        </div>

        <!-- Upload image Modals...
        =====================================================-->

        <UploadSelfieModal :show="showIdentitySelfieModal"
                           @close="showIdentitySelfieModal = false"
                           v-model="form.identity_selfie_image"/>

        <UploadImageModal :show="showIdentityFrontImageModal"
                          @close="showIdentityFrontImageModal = false"
                          v-model="form.identity_front_image"/>

        <UploadImageModal :show="showIdentityBackImageModal"
                          @close="showIdentityBackImageModal = false"
                          v-model="form.identity_back_image"/>
    </AppLayout>
</template>
