<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import PasswordInput from '@/Components/PasswordInput.vue';
let loading = ref(false)
const form = useForm({
    email: null,
    password: null
})
function submit() {
    form.patch(route('email.update'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    })
}
</script>
<template>
    <AppLayout :title="$t('update email')">
        <div class="flex gap-5 max-md:flex-wrap">
            <h1 class="text-2xl sm:text-7xl font-bold text-white uppercase md:w-1/2">
                {{ $t('account') }}
            </h1>
            <Card class="md:w-1/2" v-loading="loading">
                <CardContent :title="$t('update email')">
                    <template #body>
                        <div class="text-sm text-gray-500 text-center py-10">
                            {{ $t('please-enter-phone-number-associated-with-your-account-to-receive-a-verification-code') }}
                        </div>
                        <div class="flex flex-col gap-4 px-6">
                            <div>
                                <InputLabel :value="$t('email')" color="primary" />
                                <TextInput type="email" v-model="form.email" />
                                <InputError class="mt-2" :message="form.errors.email" />

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
