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
    <Head :title="$t('Phone Verification')" />

    <GuestLayout>
        <div class="w-full px-4 sm:flex sm:justify-between sm:space-x-4 sm:px-8">
            <div class="w-full sm:flex sm:justify-end sm:w-3/5">
                <div>
                    <h2 class="text-2xl font-light text-white uppercase">{{ $t('Welcome to') }}</h2>
                    <h1 class="text-6xl font-black text-white uppercase">KJORA</h1>
                </div>
            </div>

            <div class="flex flex-col gap-2  justify-between bg-white rounded-md p-6 w-full sm:w-2/5 min-h-[500px]">
                <div class="flex justify-center my-4">
                    <div>
                        <h2 class="text-xl font-bold text-center uppercase text-primary">{{ $t('Verify Phone Number') }}
                        </h2>
                        <div class="mb-4 text-sm text-center text-gray-600">
                            {{ $t("Before continuing, could you verify your phone number by entering the 4 digit code sent
                                                        to you in an SMS ? If you didn't receive the SMS, we will gladly send you another")}}.
                        </div>
                    </div>
                </div>
                <div class="flex flex-row justify-center gap-6 ">
                    <template v-for="(input, index) in inputs" :key="index">
                        <input @input="handleInput(index, $event);" @keydown="changeFocus(index, $event)" maxlength="1"
                            type="text" :placeholder="index" ref="codeInputs"
                            class="p-4 text-lg font-bold text-center text-white bg-black rounded-md focus:border-primary focus:ring-0 w-14 aspect-square">
                    </template>
                </div>
                <InputError :message="form.errors.code" />
                <div class="flex justify-center gap-2">
                    <Link :href="route('verification.phone.send')"
                        class="text-sm text-gray-600 underline hover:text-gray-900">
                    {{ $t('Resend Code') }}</Link>

                    <Link :href="route('profile.edit')" class="text-sm text-gray-600 underline hover:text-gray-900">
                    {{ $t('Edit Profile') }}</Link>

                    <Link :href="route('logout')" method="post" as="button"
                        class="text-sm text-gray-600 underline hover:text-gray-900 ">
                    {{ $t('log-out') }}
                    </Link>
                </div>


                <form @submit.prevent="submit">
                    <div class="flex items-center justify-between mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{ $t('Verify') }}
                        </PrimaryButton>
                    </div>
                </form>

                <div v-if="verificationLinkSent" class="mt-4 text-sm font-medium text-green-600">
                    {{
                        $t('A new verification code has been sent to the phone number you provided in your profile settings')
                    }}.
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
