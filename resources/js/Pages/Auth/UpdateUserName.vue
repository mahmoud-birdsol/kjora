<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
let loading = ref(false)

const currentUser = usePage().props.value.auth.user
const form = useForm({
    username: currentUser.username,
    password: null
})
function submit() {
    loading.value = true
    form.patch(route('username.update'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    })
}
</script>
<template>
    <AppLayout title="update username">
        <div class="flex gap-5 max-md:flex-wrap">
            <h1 class="text-2xl font-bold text-white uppercase sm:text-7xl md:w-1/2">
                account
            </h1>
            <Card class="md:w-1/2" v-loading="loading">
                <CardContent title="update username">
                    <template #body>
                        <div class="py-10 text-sm text-center text-gray-500">
                            please enter new username and password to update your username
                        </div>
                        <div class="flex flex-col gap-4 my-10">
                            <div>
                                <InputLabel value="username" color="primary" />
                                <TextInput v-model="form.username" placeholder="username" />
                                <InputError class="mt-2" :message="form.errors.username" />

                            </div>
                            <div>
                                <InputLabel value="password" color="primary" />
                                <TextInput type="password" v-model="form.password" placeholder="enter your password" />
                                <InputError class="mt-2" :message="form.errors.password" />
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
