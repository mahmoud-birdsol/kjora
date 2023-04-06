<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login" />

    <GuestLayout>
        <div class="w-full px-6 py-4 mt-6 sm:max-w-md">

            <div class="my-8">
                <h2 class="text-2xl font-light text-white uppercase">{{ $t('Welcome to') }}</h2>
                <h1 class="text-6xl font-black text-white uppercase">KJORA</h1>
            </div>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <InputLabel for="email" :value="$t('sign in')" />
                        <TextInput type="text" v-model="form.email" :placeholder="$t('Please enter username or email address')" autoComplete="email" name="email" id="email" aria-required="true" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel for="password" :value="$t('password')" />
                        <PasswordInput v-model="form.password" :placeholder="$t('Please enter password')" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center gap-1 my-2">
                        <Checkbox id="remember" v-model:checked="form.remember" name="remember" />
                        <span class="text-xs font-semibold text-white uppercase">{{ $t('remember me') }}</span>
                    </div>

                    <div class="my-2">
                        <PrimaryButton type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ $t('sign in') }}
                        </PrimaryButton>
                    </div>
                </div>
            </form>

            <div class="flex justify-end py-2">
                <Link v-if="canResetPassword" :href="route('password.request')" class="text-xs font-bold text-white hover:text-gray-200">
                {{ $t('forgot') }} {{ $t('password') }}?
                </Link>
            </div>

            <div class="flex items-center justify-end">
                <span class="text-xs font-bold text-white">{{ $t("Don't have an account") }}</span> &nbsp;
                <Link :href="route('register')"><span class="text-xs font-bold text-sky-500">{{ $t('sign up') }}</span></Link>
            </div>
        </div>
    </GuestLayout>
</template>
