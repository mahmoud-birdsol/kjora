<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm();

const submit = () => {
    form.post(route('verification.send'), {
        preserveState: false,
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="w-full">
        <div class="mt-4 flex items-center justify-between w-full">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{$t('Resend Email')}}
            </PrimaryButton>
        </div>
    </form>
</template>
