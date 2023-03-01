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
import { CheckIcon, StarIcon  } from '@heroicons/vue/24/outline';
import { CheckCircleIcon } from  "@heroicons/vue/20/solid"
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
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="six month" color="primary" />
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'" class="flex justify-between items-center">
                                    <span>$10</span>
                                    <CheckIcon class="w-6 text-black rounded-full p-1 bg-primary" v-if="form.plan == '10'"/>
                                </li>
                            </RadioGroupOption>
                            <RadioGroupOption v-slot="{ checked }" value="25"
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="six month" color="primary" />
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'" class="flex justify-between items-center">
                                    <span>$25</span>
                                    <CheckIcon class="w-6 text-black rounded-full p-1 bg-golden" v-if="form.plan == '25'"/>
                                </li>
                            </RadioGroupOption>
                            <RadioGroupOption v-slot="{ checked }" value="55"
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="six month" color="primary" />
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'" class="flex justify-between items-center">
                                    <span>$55</span>
                                    <CheckIcon class="w-6 text-black rounded-full p-1 bg-golden" v-if="form.plan == '55'"/>
                                </li>
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
                            <div class="relative bg-[url('/images/player_bg_sm.png')] rounded-xl mx-auto w-full bg-no-repeat bg-cover max-w-sm text-sm">
                                <div class="bg-black rounded-full absolute top-0 right-0 m-4">
                                    <StarIcon class="w-4 h-4 fill-primary " :class="form.plan=='55' ? 'fill-' : form.plan=='25' ? 'fill-golden' : 'fill-primary' " />
                                </div>
                                <div class="p-8 font-bold">
                                    <div class="mt-5 mb-16">
                                        <h2 class="uppercase text-primary" v-if="form.plan=='25'">three months plan</h2>
                                        <h2 class="uppercase text-primary" v-else-if="form.plan=='25'">three months plan</h2>
                                        <h2 class="uppercase text-primary" v-else="form.plan=='10'">one month plan</h2>
                                        <span v-text="form.plan == 25 ? '$25':form.plan == 55 ? '$55':'$10'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="uppercase text-primary">start</div>
                                            <div>1 november 2021</div>
                                        </div>
                                        <div>
                                            <div class="uppercase text-primary">end</div>
                                            <div>1 februar 2022</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </template>
                </CardContent>
            </Card>

        </div>
    </AppLayout>
</template>