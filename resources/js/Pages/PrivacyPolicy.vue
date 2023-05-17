<script setup>
import DateTranslation from "@/Components/DateTranslation.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm , usePage} from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import GuestLayout from "../Layouts/GuestLayout.vue";

const props = defineProps({
    policy: Object,
});
const is_login = usePage().props?.value.auth?.user
const isDisabled = ref(true)
const form = useForm({
    privacyPolicy: props.policy?.id ?? null
})
function submit() {
    form.patch(route('privacy.policy.store', form.privacyPolicy))
}
</script>

<template>
    <component :is="is_login ? AppLayout : GuestLayout" :title="$t('Privacy policy')">

        <template #header>
            {{ $t('Security') }}
        </template>
        <div class="grid w-full lg:grid-cols-2">
            <div class="col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4">
                <div class="flex justify-center my-4">

                    <h2 class="text-2xl font-bold uppercase text-primary">{{ $t('Privacy And Policy') }}</h2>
                </div>
                <div v-if="policy" class="relative flex-grow p-4 border-2 rounded-lg border-stone-400">
                    <div class="w-full max-h-[400px] overflow-auto hideScrollBar " v-html="policy.content" />

                    <div class="absolute z-20 p-2 text-xs font-bold uppercase bg-white -top-4 left-4 text-primary ">
                        {{ $t('updated') }}
                        <DateTranslation format="DD MMMM YYYY" :start="policy.created_at" />
                    </div>
                </div>
                <div class=""
                    v-if="$page.props.user && policy && (policy.version !== $page.props.auth.user.accepted_privacy_policy_version)">
                    <div class="flex flex-col justify-center gap-2">
                        <label for="policy" class="text-sm font-medium text-primary">{{ $t('I agree') }}</label>
                        <input type="radio" :value="policy.id" id="policy" v-model="form.privacyPolicy" :checked="false"
                            @change="(e) => { e.target.checked ? isDisabled = false : isDisabled = true; }"
                            class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                    </div>
                    <div class="mt-2">
                        <PrimaryButton :disabled="isDisabled" @click="submit">
                            {{ $t('UPDATE') }}
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </div>

    </component></template>
