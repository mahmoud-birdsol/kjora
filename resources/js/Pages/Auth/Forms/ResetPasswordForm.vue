<script setup>
import { useForm } from '@inertiajs/vue3';
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
    <form @submit.prevent="submit" class="w-full">
        <div class="mt-4">
            <InputLabel color="primary" for="password" value="Password" />
            <PasswordInput v-model="form.password" />
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel color="primary" for="password_confirmation" value="Confirm Password" />
            <PasswordInput v-model="form.password_confirmation" />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Reset
            </PrimaryButton>
        </div>
    </form>
</template>
