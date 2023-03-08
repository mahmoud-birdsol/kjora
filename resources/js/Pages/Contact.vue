<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {
    PlusCircleIcon,
    CameraIcon
} from "@heroicons/vue/24/outline";
const form = useForm({
    firstName: "",
    surName: "",
    email: "",
    subject: "",
    message: "",
});
</script>
<template>
    <Head title="Contact" />
    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <CardContent :title="$t('contact')">
                    <template #body>
                        <form class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <InputLabel color="text-primary"> {{$t('first-name')}} </InputLabel>
                                <TextInput type="text" v-model="form.firstName" :placeholder="$t('enter') + $t('first-name')"
                                    auto-complete="given-name" aria-required="true" />
                            </div>
                            <div class="col-span-1">
                                <InputLabel color="text-primary"> {{$t('last-name')}} </InputLabel>
                                <TextInput type="text" v-model="form.surName" :placeholder="$t('enter') + $t('last-name')"
                                    auto-complete="family-name" aria-required="true" />
                            </div>
                            <div class="col-span-2">
                                <InputLabel color="text-primary"> {{$t('email')}} </InputLabel>
                                <TextInput type="text" v-model="form.email" :placeholder="$t('enter') + $t('email')" auto-complete="email"
                                    aria-required="true" />
                            </div>
                            <div class="col-span-2">
                                <InputLabel color="text-primary"> {{$t('subject')}} </InputLabel>
                                <TextInput type="text" v-model="form.subject" :placeholder="$t('enter') + $t('subject')" />
                            </div>
                            <div class="col-span-2 relative">
                                <InputLabel color="text-primary"> {{$t('message')}} </InputLabel>

                                <textarea :placeholder="$t('please write a message or briefly what happen')" class="
                                block
                                w-full
                                rounded-2xl
                                border-gray-300
                                px-4
                                shadow-sm
                                focus:border-primary focus:ring-primary
                                sm:text-sm
                                disabled:bg-gray-100
                                h-[20ch]
                              " v-model="form.message"></textarea>
                                <div class="absolute bottom-0 right-0 ">
                                    <PlusCircleIcon
                                        class="w-8 h-8 m-2 rounded-full text-white bg-black p-1 cursor-pointer" />
                                    <CameraIcon class="w-8 h-8 m-2 rounded-full text-white bg-black p-1 cursor-pointer" />
                                </div>
                            </div>
                            <PrimaryButton class="col-span-2">{{$t('submit')}}</PrimaryButton>
                        </form>
                    </template>
                </CardContent>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>
