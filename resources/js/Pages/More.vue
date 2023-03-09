<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import RichSelectInput from "@/Components/RichSelectInput.vue";
import PhoneInput from "@/Components/PhoneInput.vue";
import MoreBtn from "@/Components/MoreBtn.vue";
import LanguageSelector from '@/Shared/LanguageSelector.vue';
import DateTranslation from '@/Components/DateTranslation.vue';
const props = defineProps(['countries', 'positions']);
let paymentForm = useForm({
    merchant: null
})
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 my-3">
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
                            <div>
                                <InputLabel color="black">{{ $t('verification') }}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('verified')" />
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('terms-of-service')}}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('pleace-read')" />
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('privacy-policy')}}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('pleace-read')" />
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('cookie-use')}}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('pleace-read')" />
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent :title="$t('account')">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">{{$t('update-profile')}}</InputLabel>
                                <MoreBtn>{{$t('update-details')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('update-password')}}</InputLabel>
                                <MoreBtn :url="route('password.edit')">{{$t('update-password')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('update-email')}}</InputLabel>
                                <MoreBtn>{{$t('update-email')}}</MoreBtn>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('update-phone')}}</InputLabel>
                                <PhoneInput :options="countries" value-name="id" text-name="name" image-name="flag" />
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('language')}}</InputLabel>
                                <LanguageSelector class="w-full"/>
                            </div>
                            <div>
                                <InputLabel color="black">{{$t('help')}}</InputLabel>
                                <input type="text"
                                    class="w-full rounded-full border border-gray-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    :placeholder="$t('breifly-explain-what-happened')" />
                            </div>
                            

                        </div>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
