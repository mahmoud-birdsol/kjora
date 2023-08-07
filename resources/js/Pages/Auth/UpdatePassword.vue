<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import { ref } from 'vue';
let loading = ref(false)
const form = useForm({
    new_password: null,
    current_password: null
})
function submit() {
    loading.value = true
    form.patch(route('password.change'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    })
}
</script>
<template>
    <AppLayout :title="$t('update password')">
        <div class="flex gap-5 max-md:flex-wrap">
            <h1 class="text-2xl font-bold text-white uppercase sm:text-7xl md:w-1/2">
                {{ $t('account') }}
            </h1>
            <Card class="md:w-1/2" v-loading="loading">
                <CardContent :title="$t('update password')">
                    <template #body>
                        <div class="py-10 text-sm text-center text-gray-500">
                            {{ $t('please enter your current and new password to update your password') }}
                        </div>
                        <div class="flex flex-col gap-4 my-10">
                            <div>
                                <InputLabel :value="$t('current password')" color="primary" />
                                <PasswordInput v-model="form.current_password" :placeholder="$t('enter your current password')" />
                                <InputError class="mt-2" :message="form.errors.current_password" />
                            </div>
                            <div>
                                <InputLabel :value="$t('new password')" color="primary" />
                                <PasswordInput v-model="form.new_password" :placeholder="$t('enter your new password')" />
                                <div class="m-2 text-xs text-gray-400">
                                    {{ $t('The password must be at least 8 characters and at least one uppercase, one lowercase letter , one symbol and one number') }}
                                </div>
                                <InputError class="mt-2" :message="form.errors.new_password" />
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
