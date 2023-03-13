<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '../Layouts/AppLayout.vue';
import { ref } from 'vue';
import dayjs from 'dayjs';
import GuestLayout from "../Layouts/GuestLayout.vue";


const props = defineProps({
    cookies: Object,
});
const isDisabled = ref(true)
const form = useForm({
    cookiePolicy: props.cookies?.id ?? null
})
function submit() {
    form.patch(route('cookies.policy.store', form.cookiePolicy))
}
</script>

<template>
    <GuestLayout title="Cookie use">
        <template #header>
            Security
        </template>
        <div class="grid w-full lg:grid-cols-2 ">
            <div class="col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4">
                <div class="flex justify-center my-4">
                    <h2 class="text-2xl font-bold uppercase text-primary">cookie use</h2>
                </div>
                <div v-if="cookies" class="relative flex-grow p-4 border-2 rounded-lg border-stone-400">
                    <div class="w-full max-h-[400px] overflow-auto hideScrollBar " v-html="cookies.content" />
                    <div class="absolute z-20 p-2 text-xs font-bold uppercase bg-white -top-4 left-4 text-primary ">
                        updated {{ dayjs(cookies.created_at).format('DD MMMM YYYY') }}
                    </div>
                </div>
                <div class=""
                    v-if="$page.props.user && cookies && (cookies.version !== $page.props.auth.user.accepted_cookie_policy_version)">
                    <div class="flex flex-col justify-center gap-2">
                        <label for="cookies" class="text-sm font-medium text-primary">I Accept</label>
                        <input type="radio" :value="cookies.id" id="cookies" v-model="form.cookiePolicy" :checked="false"
                            @change="(e) => { e.target.checked ? isDisabled = false : isDisabled = true; }"
                            class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                    </div>
                    <div class="mt-2">
                        <PrimaryButton :disabled="isDisabled" @click="submit">
                            UPDATE
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </GuestLayout>
</template>
