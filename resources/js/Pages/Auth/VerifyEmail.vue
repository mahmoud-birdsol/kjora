<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    status: String,
});

const form = useForm();

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

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
                        <h2 class="text-xl text-primary font-bold uppercase text-center">Verify Email Address</h2>
                        <div class="mb-4 text-sm text-gray-600">
                            Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <Link
                        :href="route('profile.show')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Edit Profile</Link>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 ml-2"
                    >
                        Log Out
                    </Link>
                </div>

                <form @submit.prevent="submit">
                    <div class="mt-4 flex items-center justify-between">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Resend Verification Email
                        </PrimaryButton>
                    </div>
                </form>

                <div v-if="verificationLinkSent" class="mt-4 font-medium text-sm text-green-600">
                    A new verification link has been sent to the email address you provided in your profile settings.
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
