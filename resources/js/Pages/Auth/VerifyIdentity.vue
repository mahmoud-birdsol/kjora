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
import { ref, onBeforeMount, onMounted, watch } from 'vue';
import UploadSelfieModal from '@/Components/UploadSelfieModal.vue';
import MegaButton from '@/Components/MegaButton.vue';
import { faAddressCard, faPassport, faCamera } from '@fortawesome/free-solid-svg-icons';
import CorrectText from '@/Components/CorrectText.vue';
import InCorrectText from '@/Components/InCorrectText.vue';
import UploadImageField from '@/Components/UploadImageField.vue';
import SuccessMessageModal from '@/Components/SuccessMessageModal.vue';

onBeforeMount(() => {
    library.add(faPassport);
    library.add(faAddressCard);
    library.add(faCamera);
});

onMounted(() => {

    if (
        usePage().props.value.auth.user.identity_front_image_url != null
    ) {
        identityFrontImagePreview.value = usePage().props.value.auth.user.identity_front_image_url;
    }

    if (
        usePage().props.value.auth.user.identity_back_image_url != null
    ) {
        identityBackImagePreview.value = usePage().props.value.auth.user.identity_back_image_url;
    }

    if (
        usePage().props.value.auth.user.identity_selfie_image_url != null
    ) {
        identitySelfieImagePreview.value = usePage().props.value.auth.user.identity_selfie_image_url;
    }
});

const props = defineProps({
    status: String,
    countries: Array,
});

const showIdentityFrontImageModal = ref(false);
const showIdentityBackImageModal = ref(false);
const showIdentitySelfieModal = ref(false);
const identityBackImagePreview = ref(null);
const identityFrontImagePreview = ref(null);
const identitySelfieImagePreview = ref(null);

const form = useForm({
    identity_issue_country: usePage().props.value.auth.user.identity_issue_country ?? 'Kuwait',
    identity_type: usePage().props.value.auth.user.identity_type,
    identity_front_image: usePage().props.value.auth.user.identity_front_image_url,
    identity_back_image: usePage().props.value.auth.user.identity_back_image_url,
    identity_selfie_image: usePage().props.value.auth.user.identity_selfie_image_url,
});
let identity_status = usePage().props.value.auth.user.identity_status
const setIdentityFrontImagePreview = (photo) => {
    identityFrontImagePreview.value = photo;
};

const setIdentityBackImagePreview = (photo) => {
    identityBackImagePreview.value = photo;
};

watch(() => form.identity_back_image, (photo) => {
    if (photo != null) {
        const reader = new FileReader();

        reader.onload = (e) => {
            identityBackImagePreview.value = e.target.result;
        };

        reader.readAsDataURL(photo);
    }
}, { deep: true });

watch(() => form.identity_front_image, (photo) => {
    if (photo != null) {
        const reader = new FileReader();

        reader.onload = (e) => {
            identityFrontImagePreview.value = e.target.result;
        };

        reader.readAsDataURL(photo);
    }
}, { deep: true });

const showSuccessMessage = ref(false);

const save = () => {
    form.post(route('identity.verification.store'), {
        preserveScroll: false,
        preserveState: true,
        onSuccess: () => {
            showSuccessMessage.value = true;
        }
    });
};
</script>

<template>
    <Head title="Identity Verification" />

    <AppLayout>
        <template #header>{{ $t('verification') }}</template>

        <div class="grid grid-cols-1 gap-4 mt-8 sm:grid-cols-2">
            <!-- Step 1...
                                                		                                                                                                    =====================================================-->
            <Card>
                <CardContent :title="$t('verify identity')">
                    <template #body>
                        <div class="flex flex-col justify-between h-full ">
                            <div class="min-h-[200px]">
                                <div>
                                    <h3 class="mb-4 text-lg font-bold text-gray-900">{{ $t('use a valid government-issued document') }}
                                    </h3>
                                    <p class="text-xs text-gray-500">{{ $t('only-the-following-documents-listed-below-will-be-accepted-all-other-documents-will-be-rejected') }}</p>
                                </div>
                            <div class="mt-4">
                                    <InputLabel color="primary" for="country" :value="$t('country of issue')" />
                                    <RichSelectInput :options="countries" value-name="name" text-name="name" image-name="flag" v-model="form.identity_issue_country" />
                                    <InputError class="mt-2" :message="form.errors.identity_issue_country" />
                                </div>
                            </div>

                            <div>
                                <div class="grid grid-cols-1 gap-4 mt-12 sm:grid-cols-2">
                                    <MegaButton :active="form.identity_type == 'passport'" @click="form.identity_type = 'passport'">
                                        <template #icon>
                                            <font-awesome-icon icon="passport" class="w-12 h-auto text-center text-white" />
                                        </template>
                                        {{ $t('passport') }}
                                    </MegaButton>

                                    <MegaButton :active="form.identity_type == 'national_id'" @click="form.identity_type = 'national_id'">
                                        <template #icon>
                                            <font-awesome-icon icon="address-card" class="w-12 h-auto text-center text-white" />
                                        </template>
                                        {{ $t('government issue id') }}
                                    </MegaButton>
                                </div>
                                <InputError class="mt-2" :message="form.errors.identity_type" />
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>

            <!-- Step 2...==============-->
            <Card>
                <CardContent :title="$t('upload identity')">
                    <template #body>
                        <div class="flex flex-col justify-between h-full gap-2">
                            <div class="min-h-[200px]">
                                <div>
                                    <h3 class="mb-8 font-bold text-black uppercase">{{ $t('Take Selfie Photo') }}</h3>
                                </div>
                                <div>
                                    <div class="flex gap-4 max-md:flex-col ">
                                        <div class="md:w-1/4">
                                            <button @click="showIdentitySelfieModal = true" class="relative w-full h-full group">
                                                <img v-if="form.identity_selfie_image" :src="form.identity_selfie_image" alt="" class="w-full h-auto">
                                                <!-- <img v-if="identitySelfieImagePreview" :src="identitySelfieImagePreview"
                                                        alt="" class="w-full h-auto"> -->
                                                <span class="absolute inset-0 w-full h-full bg-transparent hover:bg-white hover:bg-opacity-50" :class="form.identity_selfie_image ? 'hidden group-hover:block ' : 'block'">
                                                    <span class="flex flex-col items-center justify-center h-full">
                                                        <font-awesome-icon icon="camera" class="w-12 h-auto text-center text-black" />
                                                    </span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="w-3/4">
                                            <CorrectText>{{ $t('Take a selfie of your self with a natural expression') }}.
                                            </CorrectText>
                                            <CorrectText>{{
                                                $t('Make sure your whole face is visible, centered and your eyes are open') }}.
                                            </CorrectText>
                                            <InCorrectText>
                                                {{ $t('Do not copy your ID or use screenshots of your ID') }}.
                                            </InCorrectText>
                                            <InCorrectText>
                                                {{ $t('Do not hide or alter pars of your face (No hats/beauty images / filters / headgear)') }}.
                                            </InCorrectText>
                                        </div>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.identity_selfie_image" />
                                </div>
                                <div>
                                    <p class="mt-2 text-sm font-bold text-black">
                                        {{ $t('File size must be between 10KB and 5120KB in jpg/jpeg/png format') }}.
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-10 sm:grid-cols-2">
                                <div>
                                    <MegaButton @click="showIdentityFrontImageModal = true">
                                        <template #icon>
                                            <img v-if="identityFrontImagePreview" :src="identityFrontImagePreview" class="h-full w-auto max-h-[110px]">
                                            <font-awesome-icon v-else icon="camera" class="w-12 h-auto text-center text-white" />
                                        </template>
                                        {{ $t('Front') }}
                                    </MegaButton>

                                    <InputError class="mt-2" :message="form.errors.identity_front_image" />
                                </div>

                                <div>
                                    <MegaButton @click="showIdentityBackImageModal = true">
                                        <template #icon>
                                            <img v-if="identityBackImagePreview" :src="identityBackImagePreview" class="h-full w-auto max-h-[110px]">
                                            <font-awesome-icon v-else icon="camera" class="w-12 h-auto text-center text-white" />
                                        </template>
                                        {{ $t('Back') }}
                                    </MegaButton>

                                    <InputError class="mt-2" :message="form.errors.identity_back_image" />
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #footer>
                        <div class="mt-4">
                            <PrimaryButton v-show="!(identity_status === 'Verified')" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save()">
                                {{ $t('Verify') }}
                            </PrimaryButton>
                        </div>
                    </template>
                </CardContent>
            </Card>
        </div>

        <!-- Upload image Modals...
                                                		                                                                                                                    =====================================================-->

        <UploadImageField :should-upload="false" :show="showIdentityFrontImageModal" :current-image-url="identityFrontImagePreview" v-model="form.identity_front_image" @close="showIdentityFrontImageModal = false" @selected="setIdentityFrontImagePreview" />

        <UploadImageField :should-upload="false" :show="showIdentityBackImageModal" :current-image-url="identityBackImagePreview" v-model="form.identity_back_image" @close="showIdentityBackImageModal = false" @selected="setIdentityBackImagePreview" />


        <UploadSelfieModal v-model="form.identity_selfie_image" :show="showIdentitySelfieModal" @close="showIdentitySelfieModal = false" />

        <SuccessMessageModal title="Congratulations" message="Your identity verification has been successfully sent. Please wait for approval." :show="showSuccessMessage" @close="showSuccessMessage = false" />
    </AppLayout>
</template>
