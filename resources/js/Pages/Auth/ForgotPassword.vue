<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password"/>

    <GuestLayout>
        <div class="w-full sm:flex sm:justify-between sm:space-x-4 px-4 sm:px-8">
            <div class="w-full sm:flex sm:justify-end sm:w-1/2">
                <div>
                    <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>
                    <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
                </div>
            </div>
            <div class="bg-white rounded-md p-6 w-full sm:w-1/2 min-h-[500px]">
                <div class="flex justify-center my-4">
                    <div>
                        <h2 class="text-xl text-primary font-bold uppercase text-center my-4">Forgot password</h2>
                        <p class="text-gray-800 text-xs font-light">
                            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                        </p>
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
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Email Password Reset Link
                        </PrimaryButton>
                    </div>
                </form>

                <div v-if="status" class="mt-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
