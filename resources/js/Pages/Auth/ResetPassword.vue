<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import ResetPasswordForm from '@/Pages/Auth/Forms/ResetPasswordForm.vue';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';

const props = defineProps({
    email: String,
    token: String,
});
</script>

<template>
    <Head title="Reset Password"/>

    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <CardContent title="Reset password">
                    <template #body>
                        <div class="flex justify-center items-center">
                            <p class="text-xs text-gary-900">
                                Please enter your  new password to reset. Make sure you remember this password .
                            </p>
                        </div>

                        <div class="flex justify-center items-center w-full mt-12">
                            <ResetPasswordForm :email="email" :token="token"/>
                        </div>
                    </template>
                </CardContent>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>
