<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import RichSelectInput from "@/Components/RichSelectInput.vue";
import PhoneInput from "@/Components/PhoneInput.vue";
import { identity } from 'lodash';
import MoreBtn from "@/Components/MoreBtn.vue";
import LanguageSelector from '@/Shared/LanguageSelector.vue';
import DateTranslation from '@/Components/DateTranslation.vue';
const props = defineProps(['countries', 'positions']);
let paymentForm = useForm({
    merchant: null
})

const currentUser = usePage().props.value.auth.user
</script>
<template>
    <Head title="More" />
    <AppLayout>
        <template #header>
            <p class="text-7xl"> {{ $t('more') }} </p>
            <p class="pt-2 text-lg font-semibold">
                <DateTranslation />
            </p>
        </template>
        <div class="grid grid-cols-1 gap-5 my-3 md:grid-cols-2 lg:grid-cols-3">

            <Card class="lg:col-start-2">
                <CardContent :title="$t('security')">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">{{ $t('verification') }}</InputLabel>
                                <MoreBtn :url="route('identity.verification.create')" v-if="currentUser.identity_status === 'Waiting for documents'"> {{
                                    $t(currentUser.identity_status) }}</MoreBtn>
                                <div v-else class="block w-full px-6 py-2 text-gray-500 transition duration-150 border border-gray-500 rounded-full sm:text-sm disabled:bg-gray-100 text-start ">
                                    {{ $t(currentUser.identity_status) }}
                                </div>

                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('terms-of-service') }}</InputLabel>
                                <MoreBtn :url="route('terms.and.condition.index')">{{ $t('terms-of-service') }}</MoreBtn>

                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('privacy-policy') }}</InputLabel>
                                <MoreBtn :url="route('privacy.policy.index')"> {{ $t('privacy-policy') }}</MoreBtn>

                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('cookie-use') }}</InputLabel>
                                <MoreBtn :url="route('cookies.policy.index')"> {{ $t('cookie-use') }}</MoreBtn>
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
            <Card class="lg:col-start-3">
                <CardContent :title="$t('account')">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">{{ $t('update username') }}</InputLabel>
                                <MoreBtn :url="route('username.edit')">{{ $t('update username') }}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('update-password') }}</InputLabel>
                                <MoreBtn :url="route('password.edit')">{{ $t('update-password') }}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('update-email') }}</InputLabel>
                                <MoreBtn :url="route('email.edit')">{{ $t('update-email') }}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('update-phone') }}</InputLabel>
                                <MoreBtn :url="route('phone.edit')">{{ $t('update-phone') }}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{ $t('language') }}</InputLabel>
                                <LanguageSelector class="w-full" />
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
