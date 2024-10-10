<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import PasswordInput from '@/Components/PasswordInput.vue';
const props = defineProps(['countries']);
let loading = ref(false)
const form = useForm({
    phone: null,
    password: null
})
function submit() {
    form.patch(route('phone.update'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    })
}
</script>
<template>
    <AppLayout :title="$t('update-phone')">
        <div class="flex gap-5 max-md:flex-wrap">
            <h1 class="text-2xl sm:text-7xl font-bold text-white uppercase md:w-1/2">
                {{$t('account')}}
            </h1>
            <Card class="md:w-1/2" v-loading="loading">
                <CardContent :title="$t('update-phone')">
                    <template #body>
                            <div class="text-sm text-gray-500 text-center py-10">
                                {{$t('please enter phone number associated with your account to receive a verification code')}}
                            </div>
                            <div class="flex flex-col gap-4 px-6">
                                <div>
                                    <InputLabel :value="$t('phone number')" color="primary" />
                                    <PhoneInput v-model="form.phone" :options="countries" value-name="id" text-name="name" image-name="flag" />
                                    <InputError class="mt-2" :message="form.errors.phone" />

                                </div>
                                <div>
                                    <InputLabel :value="$t('password')" color="primary" />
                                    <PasswordInput v-model="form.password" />
                                    <InputError class="mt-2" :message="form.errors.password" />
                                </div>
                            </div>
                    </template>
                    <template #footer>
                        <PrimaryButton @click="submit" class="align-bottom">{{ $t('update') }}</PrimaryButton>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
