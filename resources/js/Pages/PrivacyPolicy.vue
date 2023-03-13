<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '../Layouts/AppLayout.vue';
import { ref } from 'vue';
import dayjs from 'dayjs';
import GuestLayout from "../Layouts/GuestLayout.vue";
import DateTranslation from "@/Components/DateTranslation.vue"

const props = defineProps({
    policy: Object,
});
const isDisabled = ref(true)
const form = useForm({
    privacyPolicy: props.policy.id
})
function submit() {
    form.patch(route('privacy.policy.store', form.privacyPolicy))
}
</script>

<template>
    <GuestLayout title="Privacy policy">
        <template #header>
            {{$t('Security')}}
        </template>
        <div class="grid lg:grid-cols-2 w-full">
            <div class="col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4">
                <div class="flex justify-center my-4">
                    <h2 class=" text-primary font-bold uppercase text-2xl">{{$t('Privacy And Policy')}}</h2>
                </div>
                <div class="relative flex-grow border-2 border-stone-400 p-4 rounded-lg">
                    <div class="w-full max-h-[400px] overflow-auto hideScrollBar " v-html="policy.content" />
                    <div class="absolute -top-4 z-20 left-4 bg-white p-2 text-primary uppercase text-xs font-bold ">
                        {{$t('updated')}} <DateTranslation format="DD MMMM YYYY" :start="policy.created_at"/>
                    </div>
                </div>
                <div class="" v-if="$page.props.user">
                    <div class="flex flex-col gap-2 justify-center">
                        <label for="policy" class="text-sm  font-medium text-primary">{{$t('I Accept')}}</label>
                        <input type="radio" :value="policy.id" id="policy" v-model="form.privacyPolicy" :checked="false"
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
