<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import GuestTwoColumnLayout from "@/Layouts/Partials/GuestTwoColumnLayout.vue";
import { RadioGroup, RadioGroupOption } from "@headlessui/vue";
import InputLabel from "@/Components/InputLabel.vue";
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { CheckIcon, StarIcon } from "@heroicons/vue/24/outline";
import { CheckCircleIcon } from "@heroicons/vue/20/solid";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FadeInTransition from "@/Components/FadeInTransition.vue";
import { computed, ref, onMounted } from "vue";

const props = defineProps(["template"]);

let form = useForm({
    payment_plan: null,
});
let loading = ref(false);
function send() {
    form.post(route("membership.upgrade"), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            state.value = "Premium";
        },
        onFinish: () => {
            loading.value = false;
        },
    });
}
const date = new Date();
const locale = usePage().props.locale;
const state = ref(usePage().props.user.state_name);
let day = date.getDate();
let month = date.getMonth();
let year = date.getFullYear();
let months = [
    { en: "January", ar: "يناير" },
    { en: "February", ar: "فبراير" },
    { en: "March", ar: "مارس" },
    { en: "April", ar: "ابريل" },
    { en: "May", ar: "مايو" },
    { en: "June", ar: "يونيو" },
    { en: "July", ar: "يوليو" },
    { en: "August", ar: "اغسطس" },
    { en: "September", ar: "سيتمبر" },
    { en: "October", ar: "اكتوبر" },
    { en: "November", ar: "نوفمبر" },
    { en: "December", ar: "ديسمبر" },
];

const currentDate = `${day} ${months[month][locale]} ${year}`;

let expaireDate = computed(() => {
    if (form.payment_plan == "yearly")
        return `${day} ${months[month][locale]} ${year + 1}`;
    else return `${day} ${months[month + 1][locale]} ${year}`;
});

const upgradeContent = computed(() =>
    JSON.parse(props.template.upgrade_content)
);

onMounted(() => {});
</script>
<template>
    <Head :title="$t('upgrade')" />
    <AppLayout>
        <template #header>{{ $t("subscribe") }}</template>
        <div class="grid grid-cols-1 gap-8 my-5 md:grid-cols-2">
            <Card v-loading="loading">
                <CardContent :title="$t('subscribe')">
                    <template #header>
                        <h1 class="text-7xl">{{ $t("subscribe") }}</h1>
                    </template>
                    <template #body>
                        <ul
                            class="flex flex-col items-start gap-3 text-xs text-gray-800"
                        >
                            <li
                                class="flex w-full gap-5 items-center"
                                v-for="content in upgradeContent"
                            >
                                <span v-if="locale == 'en'">{{
                                    content.attributes.content_en
                                }}</span>
                                <span v-if="locale == 'ar'">{{
                                    content.attributes.content_ar
                                }}</span>
                                <div
                                    class="shrink-0 grow mie-auto flex justify-end"
                                >
                                    <CheckIcon
                                        class="w-5 text-primary stroke-current stroke-[3]"
                                    />
                                </div>
                            </li>
                        </ul>

                        <div
                            class="my-3 text-sm font-bold text-gray-600 uppercase"
                        >
                            {{ $t("choose plan") }}
                        </div>
                        <RadioGroup
                            v-model="form.payment_plan"
                            class="flex flex-col gap-2"
                        >
                            <RadioGroupOption
                                v-slot="{ checked }"
                                value="monthly"
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500 flex flex-col text-sm font-medium cursor-pointer"
                            >
                                <InputLabel
                                    :value="$t('monthly')"
                                    color="primary"
                                />
                                <li class="flex items-center justify-between">
                                    <span>$10</span>
                                    <CheckIcon
                                        class="w-6 p-1 text-black rounded-full bg-golden"
                                        :class="
                                            form.payment_plan == 'monthly'
                                                ? 'visible'
                                                : 'invisible'
                                        "
                                    />
                                </li>
                            </RadioGroupOption>
                            <RadioGroupOption
                                v-slot="{ checked }"
                                value="yearly"
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500 flex flex-col text-sm font-medium cursor-pointer"
                            >
                                <InputLabel
                                    :value="$t('yearly')"
                                    color="primary"
                                />
                                <li class="flex items-center justify-between">
                                    <span>$25</span>
                                    <CheckIcon
                                        class="w-6 p-1 text-black rounded-full bg-golden"
                                        :class="
                                            form.payment_plan == 'yearly'
                                                ? 'visible'
                                                : 'invisible'
                                        "
                                    />
                                </li>
                            </RadioGroupOption>
                        </RadioGroup>

                        <PrimaryButton
                            class="my-3"
                            @click="send"
                            :disabled="
                                !form.payment_plan | (state == 'Premium')
                            "
                            >{{ $t("upgrade") }}</PrimaryButton
                        >
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent :title="$t('subscribe')" class="justify-start">
                    <template #header>
                        <h1 class="text-7xl">{{ $t("subscription") }}</h1>
                    </template>
                    <template #body>
                        <FadeInTransition
                            enter-from-class="opacity-0"
                            enter-to-class="opacity-100"
                            enter-active-class="transition-all duration-200"
                        >
                            <div
                                class="relative w-full max-w-sm mx-auto text-sm text-black bg-no-repeat bg-cover rounded-xl"
                                v-if="form.payment_plan === 'monthly'"
                            >
                                <img
                                    src="/images/player_bg_sm_gold.png"
                                    class="absolute top-0 left-0 w-full h-full rounded-xl"
                                />
                                <div
                                    class="absolute top-0 right-0 m-4 bg-black rounded-full"
                                >
                                    <StarIcon class="w-4 h-4 fill-golden" />
                                </div>
                                <div class="relative z-10 p-8 font-bold">
                                    <div class="mt-5 mb-16">
                                        <h2
                                            class="uppercase text-primary"
                                            v-if="
                                                form.payment_plan == 'monthly'
                                            "
                                        >
                                            {{ $t("monthly") }}
                                        </h2>

                                        <span>10$</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="uppercase text-primary">
                                                {{ $t("start") }}
                                            </div>
                                            <div>{{ currentDate }}</div>
                                        </div>
                                        <div>
                                            <div class="uppercase text-primary">
                                                {{ $t("end") }}
                                            </div>
                                            <div>{{ expaireDate }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="relative w-full max-w-sm mx-auto text-sm text-black bg-no-repeat bg-cover rounded-xl"
                                v-else-if="form.payment_plan === 'yearly'"
                            >
                                <img
                                    src="/images/player_bg_sm_gold.png"
                                    class="absolute top-0 left-0 w-full h-full rounded-xl"
                                />
                                <div
                                    class="absolute top-0 right-0 m-4 bg-black rounded-full"
                                >
                                    <StarIcon class="w-4 h-4 fill-golden" />
                                </div>
                                <div class="relative z-10 p-8 font-bold">
                                    <div class="mt-5 mb-16">
                                        <h2 class="uppercase text-primary">
                                            {{ $t("yearly") }}
                                        </h2>

                                        <span>25$</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="uppercase text-primary">
                                                {{ $t("start") }}
                                            </div>
                                            <div>{{ currentDate }}</div>
                                        </div>
                                        <div>
                                            <div class="uppercase text-primary">
                                                {{ $t("end") }}
                                            </div>

                                            <div>{{ expaireDate }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="relative w-full max-w-sm mx-auto text-sm text-black bg-no-repeat bg-cover"
                                v-else
                            >
                                <img
                                    src="/images/player_bg_sm.png"
                                    class="absolute top-0 left-0 w-full h-full rounded-xl"
                                />
                                <div
                                    class="absolute top-0 right-0 m-4 bg-black rounded-full"
                                >
                                    <StarIcon class="w-4 h-4 fill-primary" />
                                </div>
                                <div class="relative z-10 p-8 font-bold">
                                    <div class="mt-5 mb-16">
                                        <h2 class="text-white uppercase">
                                            {{ $t("free plan") }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="flex justify-center py-6">
                                    <div
                                        class="text-white uppercase opacity-50"
                                    >
                                        {{ $t("minimal features") }}
                                    </div>
                                </div>
                            </div>
                        </FadeInTransition>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
