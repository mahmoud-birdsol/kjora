<script setup>
import {computed, ref} from 'vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import GuestTwoColumnLayout from "../../Layouts/Partials/GuestTwoColumnLayout.vue";
import Card from '@/Components/Card.vue';
import CardContent from "../../Components/CardContent.vue";

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
    console.log(form.code)
    form.post(route('phone.verify.store'),{
        onFinish: () => {
            form.reset()
        }
    });
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
    <Head :title="$t('Phone Verification')"/>

    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <CardContent :title="$t('Verify Phone Number')">
                    <template #body>
                        <div class="text-sm text-gray-500 text-center py-10">
                            {{$t("Before continuing, could you verify your phone number by entering the 4 digit code sent to you in an SMS ? If you didn't receive the SMS, we will gladly send you another")}}
                        </div>
                        <div class="flex flex-col gap-4 px-6">
                            <div class="flex justify-center gap-6 " dir="ltr">
                                <template v-for="(input, index) in inputs" :key="index">
                                    <input @input="handleInput(index, $event);" @keydown="changeFocus(index, $event)"
                                           maxlength="1"
                                           type="text" :placeholder="index" ref="codeInputs"
                                           class="p-4 text-lg font-bold text-center text-white bg-black rounded-md focus:border-primary focus:ring-0 w-14 aspect-square">
                                </template>
                            </div>

                            <InputError :message="form.errors.code"/>
                            <div class="flex justify-center gap-2">
                                <Link :href="route('verification.phone.send')"
                                      class="text-sm text-gray-600 underline hover:text-gray-900">
                                    {{ $t('Resend Code') }}
                                </Link>

                                <Link :href="route('profile.edit')" class="text-sm text-gray-600 underline hover:text-gray-900">
                                    {{ $t('Edit Profile') }}
                                </Link>

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
                    </template>
                </CardContent>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>
