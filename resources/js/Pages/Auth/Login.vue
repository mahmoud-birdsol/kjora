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
    <Head title="Log in"/>

    <GuestLayout>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4">
            <div class="my-8">
                <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>
                <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <InputLabel for="email" value="Email Address"/>
                        <TextInput type="text"
                                   v-model="form.email"
                                   placeholder="Please enter your email address"
                                   auto-complete="email"
                                   aria-required="true"
                        />
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>
                    <div>
                        <InputLabel for="password" value="Password"/>
                        <PasswordInput v-model="form.password"/>
                        <InputError class="mt-2" :message="form.errors.password"/>
                    </div>

                    <div class="flex items-center space-x-2 my-2">
                        <Checkbox id="remember" v-model:checked="form.remember" name="remember"/>
                        <span class="text-xs text-white font-semibold uppercase">Remember me</span>
                    </div>

                    <div class="my-2">
                        <PrimaryButton type="submit" :loading="form.processing" :disabled="form.processing">
                            Sign In
                        </PrimaryButton>
                    </div>
                </div>
            </form>

            <div class="flex justify-end my-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                      class="underline text-sm text-white hover:text-gray-200">
                    Forgot your password?
                </Link>
            </div>

            <div class="flex justify-end items-center">
                <span class="text-white text-sm font-light">Don't have an account</span> &nbsp;
                <Link :href="route('register')"><span class="text-blue-500 text-sm font-light">Sign up</span></Link>
            </div>
        </div>
    </GuestLayout>
</template>
