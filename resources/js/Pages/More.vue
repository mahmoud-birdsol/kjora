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
            <p class="text-7xl"> {{$t('more') }} </p>
            <p class="text-lg font-semibold pt-2">
                <DateTranslation/>
            </p>
        </template>
        <div class="grid grid-cols-1 gap-5 my-3 md:grid-cols-2 lg:grid-cols-3">
            <Card>
                <CardContent :title="$t('payment')">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">{{$t('merchant-account')}}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('update-merchant-account')" />
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('payment-details')}}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('payment-overflow')" />

                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent :title="$t('security')">
                    <template #body>
                        <div class="flex flex-col gap-4">

                            <InputLabel color="black">{{  $t('verification') }}</InputLabel>
                            <Link :href="route('identity.verification.create')"
                                v-if="currentUser.identity_status === 'Waiting for documents'"
                                class="w-full p-2 border border-gray-500 rounded-full cursor-pointer text-stone-500 active:border-primary hover:border-primary hover:text-primary sm:text-sm disabled:bg-gray-100 ">
                            {{ $t(currentUser.identity_status) }}
                            </Link>
                            <div v-else
                                class="w-full p-2 border border-gray-500 rounded-full text-stone-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100">
                                {{ $t(currentUser.identity_status) }}
                            </div>


                            <InputLabel color="black">{{$t('terms-of-service')}}</InputLabel>
                            <Link :href="route('terms.and.condition.index')"
                                class="w-full p-2 border border-gray-500 rounded-full cursor-pointer text-stone-500 active:border-primary hover:border-primary hover:text-primary sm:text-sm disabled:bg-gray-100 ">
                                {{$t('terms-of-service')}}
                            </Link>


                            <InputLabel color="black">{{ $t('privacy-policy') }}</InputLabel>
                            <Link :href="route('privacy.policy.index')"
                                class="w-full p-2 border border-gray-500 rounded-full cursor-pointer text-stone-500 active:border-primary hover:border-primary hover:text-primary sm:text-sm disabled:bg-gray-100 ">
                                {{ $t('privacy-policy') }}
                            </Link>


                            <InputLabel color="black">{{$t('cookie-use')}}</InputLabel>
                            <Link :href="route('cookies.policy.index')"
                                class="w-full p-2 border border-gray-500 rounded-full cursor-pointer text-stone-500 active:border-primary hover:border-primary hover:text-primary sm:text-sm disabled:bg-gray-100 ">
                                {{$t('cookie-use')}}
                            </Link>

                        </div>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent :title="$t('account')">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">{{$t('update username')}}</InputLabel>
                                <MoreBtn :url="route('username.edit')">{{$t('update username')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('update-password')}}</InputLabel>
                                <MoreBtn :url="route('password.edit')">{{$t('update-password')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('update-email')}}</InputLabel>
                                <MoreBtn :url="route('email.edit')">{{$t('update-email')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('update-phone')}}</InputLabel>
                                <MoreBtn :url="route('phone.edit')">{{$t('update-phone')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('language')}}</InputLabel>
                                <LanguageSelector class="w-full"/>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('help')}}</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('breifly-explain-what-happened')" />
                            </div>


                        </div>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
