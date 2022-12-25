<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PasswordInput from '@/Components/PasswordInput.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <GuestLayout>
        <div class="w-full sm:flex sm:justify-between sm:space-x-4 px-4 sm:px-8">
            <div class="w-full sm:flex sm:justify-end sm:w-1/2">
                <div>
                    <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>
                    <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
                </div>
            </div>
            <div class="bg-white rounded-md p-6 w-full sm:w-1/2">
                <div class="flex justify-center my-4">
                    <div>
                        <h2 class="text-xl text-primary font-bold uppercase text-center my-4">Reset password</h2>
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel color="primary" for="email" value="Email Address"/>
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            placeholder="Please enter your email address."
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel color="primary" for="password" value="Password" />
                        <PasswordInput v-model="form.password"/>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel color="primary" for="password_confirmation" value="Confirm Password" />
                        <PasswordInput v-model="form.password_confirmation"/>
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Reset Password
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
