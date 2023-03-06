<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
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
    form.patch(route('password.update'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
        }
    })
    loading.value = false;
}
</script>
<template>
    <AppLayout title="update Password">
        <div class="flex gap-5 max-md:flex-wrap">
            <h1 class="text-2xl sm:text-7xl font-bold text-white uppercase md:w-1/2">
                account
            </h1>
            <Card class="md:w-1/2" v-loading="loading">
                <CardContent title="update Password">
                    <template #body>
                        <div class="text-sm text-gray-500 text-center py-10">
                            please enter your current and new password to update your password
                        </div>
                        <div class="flex flex-col gap-4 my-10">
                            <div>
                                <InputLabel value="current password" color="primary" />
                                <PasswordInput v-model="form.current_password" placeholder="enter your current password" />
                                <InputError class="mt-2" :message="form.errors.current_password" />
                            </div>
                            <div>
                                <InputLabel value="new password" color="primary" />
                                <PasswordInput v-model="form.new_password" placeholder="enter your new password" />
                                <InputError class="mt-2" :message="form.errors.new_password" />
                                <div class="text-gray-400 text-xs m-2" v-if="!form.password && !form.errors.password">
                                    The password must be at least 8 characters and at least one uppercase, one lowercase
                                    letter , one symbol and one number
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #footer>
                        <PrimaryButton @click="submit" class="align-bottom">Upload</PrimaryButton>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>