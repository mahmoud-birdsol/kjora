<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import GuestTwoColumnLayout from "@/Layouts/Partials/GuestTwoColumnLayout.vue";
import {
    RadioGroup,
    RadioGroupOption,
} from '@headlessui/vue'
import InputLabel from "@/Components/InputLabel.vue";
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { CheckIcon ,StarIcon } from '@heroicons/vue/24/outline';
import PrimaryButton from '@/Components/PrimaryButton.vue'
let form = useForm({
    plan: null
})
</script>
<template>
    <Head title="upgrade" />
    <AppLayout>
        <template #header>upgrade</template>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-5">
            <Card>
                <CardContent title="Upgrade account">
                    <template #header>
                        <h1 class="text-7xl">Upgrade account</h1>
                    </template>
                    <template #body>
                        <ul class="flex flex-col gap-3 items-center text-xs text-gray-500">
                            <li class="flex gap-5">
                                <CheckIcon class="w-5 text-primary" />
                                <span>Lorem ipsum dolor sit amet </span>
                            </li>
                            <li class="flex gap-5">
                                <CheckIcon class="w-5 text-primary" />
                                <span>Lorem ipsum dolor sit amet </span>
                            </li>
                            <li class="flex gap-5">
                                <CheckIcon class="w-5 text-primary" />
                                <span>Lorem ipsum dolor sit amet </span>
                            </li>
                            <li class="flex gap-5">
                                <CheckIcon class="w-5 text-primary" />
                                <span>Lorem ipsum dolor sit amet </span>
                            </li>
                            <li class="flex gap-5">
                                <CheckIcon class="w-5 text-primary" />
                                <span>Lorem ipsum dolor sit amet </span>
                            </li>
                        </ul>
                        <div class="text-gray-600 text-sm font-bold my-3 ">CHOOSE PLAN</div>
                        <RadioGroup v-model="form.plan" class="flex flex-col gap-2">
                            <RadioGroupOption v-slot="{ checked }" value="10"
                                class="[&_li]:py-3 [&_li]:px-6 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="one month" color="primary" />
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">$10</li>
                            </RadioGroupOption>
                            <RadioGroupOption v-slot="{ checked }" value="25"
                                class="[&_li]:py-3 [&_li]:px-6 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="three month" color="primary" />
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">$25</li>
                            </RadioGroupOption>
                            <RadioGroupOption v-slot="{ checked }" value="55"
                                class="[&_li]:py-3 [&_li]:px-6 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="six month" color="primary" />
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">$55</li>
                            </RadioGroupOption>
                        </RadioGroup>
                        <PrimaryButton class="my-3">upgrade</PrimaryButton>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent title="subscription" class="justify-start">
                    <template #header>
                        <h1 class="text-7xl">subscription</h1>
                    </template>
                    <template #body>
                        <div class="relative md:mx-8">
                            <div class="bg-black rounded-full absolute top-0 right-0 m-4">
                                <StarIcon class="w-4 h-4 fill-[#CFC27A] " />
                            </div>
                            <img src="/images/player_bg_sm.png" class="rounded mx-auto w-full" />
                        </div>
                    </template>
                </CardContent>
            </Card>

        </div>
</AppLayout></template>