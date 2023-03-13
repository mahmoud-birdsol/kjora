<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '../Layouts/AppLayout.vue';
import { ref } from 'vue';
import dayjs from 'dayjs';
import GuestLayout from "../Layouts/GuestLayout.vue";


const props = defineProps({
    terms: Object,
});
const isDisabled = ref(true)
const form = useForm({
    termsAndConditions: props.terms.id
})
function submit() {
    form.patch(route('terms.and.condition.store', form.termsAndConditions))
}
</script>

<template>
    <GuestLayout :title="$t('Terms of Service')">
        <template #header>
            Security
        </template>
        <div class="grid lg:grid-cols-2 w-full ">
            <div class="col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4">
                <div class="flex justify-center my-4">
                    <h2 class="text-2xl text-primary font-bold uppercase">{{$t('Terms of Service')}}</h2>
                </div>
                <div class="relative  flex-grow border-2 border-stone-400 p-4 rounded-lg">
                    <div class="w-full max-h-[400px] overflow-auto hideScrollBar " v-html="terms.content" />
                    <div class="absolute -top-4 z-20 left-4 bg-white p-2 text-primary uppercase text-xs font-bold ">
                        {{$t('updated')}} {{ dayjs(terms.created_at).format('DD MMMM YYYY') }}
                    </div>
                </div>
                <div class="" v-if="$page.props.user">
                    <div class="flex flex-col gap-2 justify-center">
                        <label for="terms" class="text-sm  font-medium text-primary">{{$t('I Accept')}}</label>
                        <input type="radio" :value="terms.id" id="terms" v-model="form.termsAndConditions" :checked="false"
                            @change="(e) => { e.target.checked ? isDisabled = false : isDisabled = true; }"
                            class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                    </div>
                    <div class="mt-2">
                        <PrimaryButton :disabled="isDisabled" @click="submit">
                            {{$t('UPDATE')}}
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </GuestLayout>
</template>
