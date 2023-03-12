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
import FadeInTransition from "@/Components/FadeInTransition.vue";
import { computed} from 'vue'
let form = useForm({
    payment_plan: null
})
function send(){
    form.post(route('membership.upgrade'))
}
const date = new Date();

let day = date.getDate();
let month = date.getMonth() ;
let year = date.getFullYear();
let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
const currentDate = `${day} ${months[month]} ${year}`
let expaireDate = computed(()=>{
    if(form.payment_plan == 'yearly') return `${day} ${months[month+1]} ${year}`
    else  return `${day} ${months[month]} ${year+1}`
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
                        <ul class="flex flex-col gap-3 items-center text-xs text-gray-800">
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
                        <div class="text-gray-600 text-sm font-bold my-3">CHOOSE PLAN</div>
                        <RadioGroup v-model="form.payment_plan" class="flex flex-col gap-2">
                            <RadioGroupOption v-slot="{ checked }" value="monthly"
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="monthly" color="primary" />
                                <li  class="flex justify-between items-center">
                                    <span>$10</span>
                                    <CheckIcon class="w-6 rounded-full p-1 bg-golden text-black" v-if="form.payment_plan == 'monthly'"/>
                                </li>
                            </RadioGroupOption>
                            <RadioGroupOption v-slot="{ checked }" value="yearly"
                                class="[&_li]:py-3 [&_li]:pl-6 [&_li]:pr-3 [&_li]:rounded-full [&_li]:border-2 [&_li]:list-none text-stone-500  flex flex-col  text-sm font-medium cursor-pointer">
                                <InputLabel value="yearly" color="primary" />
                                <li  class="flex justify-between items-center">
                                    <span>$25</span>
                                    <CheckIcon class="w-6 text-black rounded-full p-1 bg-golden" v-if="form.payment_plan == 'yearly'"/>
                                </li>
                            </RadioGroupOption>
                        </RadioGroup>
                        <PrimaryButton class="my-3" @click="send" :disabled="!form.payment_plan">upgrade</PrimaryButton>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent title="subscription" class="justify-start">
                    <template #header>
                        <h1 class="text-7xl">subscription</h1>
                    </template>
                    <template #body>
                        <FadeInTransition
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        enter-active-class="transition-all duration-200"
                        >
                            <div class="relative  rounded-xl mx-auto w-full bg-no-repeat bg-cover max-w-sm text-sm text-black"
                            v-if="form.payment_plan==='monthly'"
                            >
                                <img src="/images/player_bg_sm_gold.png" class="absolute top-0 left-0 w-full h-full" />
                                <div class="bg-black rounded-full absolute top-0 right-0 m-4">
                                    <StarIcon class="w-4 h-4 fill-golden" />
                                </div>
                                <div class="p-8 font-bold z-10 relative"> 
                                    <div class="mt-5 mb-16">
                                        <h2 class="uppercase text-primary" v-if="form.payment_plan=='monthly'">monthly</h2>
                                        <span>10</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="uppercase text-primary">start</div>
                                            <div>{{ currentDate }}</div>
                                        </div>
                                        <div>
                                            <div class="uppercase text-primary">end</div>
                                            <div>{{ expaireDate }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative  rounded-xl mx-auto w-full bg-no-repeat bg-cover max-w-sm text-sm text-black"
                            v-else-if="form.payment_plan==='yearly'"
                            >
                                <img src="/images/player_bg_sm_gold.png" class="absolute top-0 left-0 w-full h-full" />
                                <div class="bg-black rounded-full absolute top-0 right-0 m-4">
                                    <StarIcon class="w-4 h-4 fill-golden" />
                                </div>
                                <div class="p-8 font-bold z-10 relative"> 
                                    <div class="mt-5 mb-16">
                                        <h2 class="uppercase text-primary">yearly</h2>
                                        <span>25$</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="uppercase text-primary">start</div>
                                            <div>{{ currentDate }}</div>
                                        </div>
                                        <div>
                                            <div class="uppercase text-primary">end</div>
                                            <div>{{ expaireDate }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mx-auto w-full bg-no-repeat bg-cover max-w-sm text-sm text-black"
                            v-else
                            >
                                <img src="/images/player_bg_sm.png" class="absolute  rounded-xl top-0 left-0 w-full h-full" />
                                <div class="bg-black rounded-full absolute top-0 right-0 m-4">
                                    <StarIcon class="w-4 h-4 fill-primary" />
                                </div>
                                <div class="p-8 font-bold z-10 relative"> 
                                    <div class="mt-5 mb-16">
                                        <h2 class="uppercase text-white">free plan</h2>
                                    </div>
                                </div>
                                <div class="flex justify-center py-6">
                                            <div class="uppercase text-white opacity-50">minimal features</div>
                                </div>
                            </div>
                        </FadeInTransition>
                    </template>
                </CardContent>
            </Card>

        </div>
    </AppLayout>
</template>
