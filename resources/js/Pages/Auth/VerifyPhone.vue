<script setup>
import { computed, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    user: null
});
const inputs = Array(4)
const codeInputs = ref(null)

const form = useForm({
    code: '',
    user_id: props.user.id
});

const submit = () => {
    console.log(form.code);
    form.post(route('phone.verify.store'));
};
function changeFocus(index, e) {
    if (e.key.toString() === 'Backspace') {
        e.target.value = ''
        if (index > 0) {
            codeInputs.value[index - 1].focus()
        }
    }

}
function handleInput(index, e) {
    let value = e.target.value.trim()
    form.code += value
    if (index < inputs.length - 1 && value !== '') {
        codeInputs.value[index + 1].focus()
    }
}
const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

    <GuestLayout>
        <div class="w-full sm:flex sm:justify-between sm:space-x-4 px-4 sm:px-8">
            <div class="w-full sm:flex sm:justify-end sm:w-3/5">
                <div>
                    <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>
                    <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
                </div>
            </div>

            <div class="flex flex-col gap-2  justify-between bg-white rounded-md p-6 w-full sm:w-2/5 min-h-[500px]">
                <div class="flex justify-center my-4">
                    <div>
                        <h2 class="text-xl text-primary font-bold uppercase text-center">Verify Phone Number</h2>
                        <div class="mb-4 text-center text-sm text-gray-600">
                            Before continuing, could you verify your phone number by entering the 4 digit code sent to you
                            in an SMS? If you didn't receive the SMS, we will gladly send you another.
                        </div>
                    </div>
                </div>
                <div class="flex flex-row gap-6 justify-center ">
                    <template v-for="(input, index) in inputs" :key="index">
                        <input @input="handleInput(index, $event);" @keydown="changeFocus(index, $event)" maxlength="1"
                            type="text" :placeholder="index" ref="codeInputs"
                            class="bg-black p-4 focus:border-primary focus:ring-0 rounded-md text-lg text-white font-bold text-center w-14 aspect-square">
                    </template>
                </div>
                <InputError :message="form.errors.code" />
                <div class="flex justify-center gap-2">
                    <Link :href="route('verification.phone.send')" method="post"
                        class="underline text-sm text-gray-600 hover:text-gray-900">
                    Resend Code</Link>

                    <Link :href="route('profile.edit')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Edit Profile</Link>

                    <Link :href="route('logout')" method="post" as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 ">
                    Log Out
                    </Link>
                </div>


                <form @submit.prevent="submit">
                    <div class="mt-4 flex items-center justify-between">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Verify
                        </PrimaryButton>
                    </div>
                </form>

                <div v-if="verificationLinkSent" class="mt-4 font-medium text-sm text-green-600">
                    A new verification code has been sent to the phone number you provided in your profile settings.
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
