<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {CameraIcon, PlusCircleIcon} from "@heroicons/vue/24/outline";
import {ref} from 'vue'

const form = useForm({
    first_name: null,
    last_name: null,
    email: null,
    subject: null,
    message: null,
});

const showSuccessMessage = ref(false);

function submit() {
    form.post(route('contacts.store'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            showSuccessMessage.value = true;
            form.reset()
        },
    });
}

</script>
<template>
    <Head title="Contact"/>
    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <CardContent :title="$t('contact')">
                    <template #body>

                        <div class="flex justify-center my-4" v-if="showSuccessMessage">
                            <p class="text-sm text-primary">Your message was successfully sent, we will get back to you shortly.</p>
                        </div>

                        <form class="grid grid-cols-2 gap-4" @submit.prevent="submit" v-loading="form.processing">
                            <div class="col-span-1">
                                <InputLabel color="text-primary"> {{$t('First-name')}}</InputLabel>
                                <TextInput type="text" v-model="form.first_name" :placeholder="$t('enter') + $t('First-Name')"
                                           auto-complete="given-name" aria-required="true"/>
                                <InputError :message="form.errors.first_name" class="px-4"/>
                            </div>
                            <div class="col-span-1">
                                <InputLabel color="text-primary"> {{$t('last-name')}} </InputLabel>
                                <TextInput type="text" v-model="form.surName" :placeholder="$t('enter') + $t('last-name')"
                                    auto-complete="family-name" aria-required="true" />
                                <InputError :message="form.errors.last_name" class="px-4"/>
                            </div>
                            <div class="col-span-2">
                                <InputLabel color="text-primary"> {{$t('email')}}</InputLabel>
                                <TextInput type="text" v-model="form.email" :placeholder="$t('Enter') + $t('Email')"
                                           auto-complete="email"
                                           aria-required="true"/>
                                <InputError :message="form.errors.email" class="px-4"/>
                            </div>
                            <div class="col-span-2">
                                <InputLabel color="text-primary"> {{$t('subject')}} </InputLabel>
                                <TextInput type="text" v-model="form.subject" :placeholder="$t('enter') + $t('subject')" />
                                <InputError :message="form.errors.subject" class="px-4"/>
                            </div>
                            <div class="col-span-2 relative">
                                <InputLabel color="text-primary"> {{$t('message')}}</InputLabel>
                                <textarea :placeholder="$t('Please write a message or briefly what happen')" class="
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
                                        class="w-8 h-8 m-2 rounded-full text-white bg-black p-1 cursor-pointer"/>
                                    <CameraIcon
                                        class="w-8 h-8 m-2 rounded-full text-white bg-black p-1 cursor-pointer"/>
                                </div>
                            </div>
                            <InputError :message="form.errors.subject"/>
                            <PrimaryButton class="col-span-2">{{$t('submit')}}</PrimaryButton>
                        </form>
                    </template>
                </CardContent>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>
