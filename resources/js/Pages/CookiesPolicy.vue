<script setup>
import DateTranslation from "@/Components/DateTranslation.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    cookies: Object,
});
const isDisabled = ref(true)
const is_login = usePage().props?.auth?.user
const form = useForm({
    cookiePolicy: props.cookies?.id ?? null
})
function submit() {
    form.patch(route('cookies.policy.store', form.cookiePolicy))
}
</script>

<template>
    <Head title="Cookie use" />
    <component :is="is_login ? AppLayout : GuestLayout" :title="$t('cookie use')">
        <template #header>
            {{ $t('Security') }}
        </template>
        <div class="grid w-full px-8 lg:grid-cols-2 ">
            <div class="col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4">
                <div class="flex justify-center my-4">
                    <h2 class="text-2xl font-bold uppercase text-primary">{{ $t('cookie use') }}</h2>
                </div>
                <div v-if="cookies" class="relative flex-grow p-4 border-2 rounded-lg border-stone-400">
                    <div class="w-full max-h-[400px] overflow-auto hideScrollBar " v-html="cookies.content" />

                    <div class="absolute z-20 p-2 text-xs font-bold uppercase bg-white -top-4 left-4 text-primary ">
                        {{ $t('updated') }}
                        <DateTranslation format="DD MMMM YYYY" :start="cookies.created_at" />

                    </div>
                </div>
                <div class="" v-if="$page.props.user && cookies && (cookies.version !== $page.props.auth.user.accepted_cookie_policy_version)">
                    <div class="flex flex-col justify-center gap-2 mt-4">
                        <label for="cookies" class="text-sm font-medium text-primary">{{ $t('i-agree') }}</label>
                        <input type="radio" :value="cookies.id" id="cookies" v-model="form.cookiePolicy" :checked="false" @change="(e) => { e.target.checked ? isDisabled = false : isDisabled = true; }" class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                    </div>
                    <div class="mt-2">
                        <PrimaryButton :disabled="isDisabled" @click="submit">
                            {{ $t('update') }}
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </div>

    </component>
</template>
