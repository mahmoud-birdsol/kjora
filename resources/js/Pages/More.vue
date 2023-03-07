<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import RichSelectInput from "@/Components/RichSelectInput.vue";
import PhoneInput from "@/Components/PhoneInput.vue";
import { identity } from 'lodash';
const props = defineProps(['countries', 'positions']);
let paymentForm = useForm({
    merchant: null
})

const currentUser = usePage().props.value.auth.user
</script>
<template>
    <Head title="More" />
    <AppLayout>
        <template #header>
            <p class="text-7xl">More</p>
            <p class="text-lg font-semibold">
                {{ dayjs().format("dddd, DD MMMM YYYY") }}
            </p>
        </template>
        <div class="grid grid-cols-1 gap-5 my-3 md:grid-cols-2 lg:grid-cols-3">
            <Card>
                <CardContent title="payment">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">merchant account</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="Update merchant account" />
                            </div>
                            <div>
                                <InputLabel color="black">payment details</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="payment overflow" />
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent title="security">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <InputLabel color="black">verification</InputLabel>
                            <Link :href="route('identity.verification.create')"
                                v-if="currentUser.identity_status === 'Waiting for documents'"
                                class="w-full p-2 border border-gray-500 rounded-full text-stone-500 active:border-primary hover:border-primary hover:text-primary sm:text-sm disabled:bg-gray-100 cursor-pointer ">
                            {{ currentUser.identity_status }}
                            </Link>
                            <div v-else
                                class="w-full p-2 border border-gray-500 rounded-full text-stone-500 focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100">
                                {{ currentUser.identity_status }}
                            </div>

                            <div>
                                <InputLabel color="black">terms of service</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="place read" />
                            </div>
                            <div>
                                <InputLabel color="black">privacy policy</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="place read" />
                            </div>
                            <div>
                                <InputLabel color="black">cookie use</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="place read" />
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
            <Card>
                <CardContent title="account">
                    <template #body>
                        <div class="flex flex-col gap-4">
                            <div>
                                <InputLabel color="black">update profile</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="update details" />
                            </div>
                            <div>
                                <InputLabel color="black">update password</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="update password" />
                            </div>
                            <div>
                                <InputLabel color="black">update email</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="update email address" />
                            </div>
                            <div>
                                <InputLabel color="black">update phone</InputLabel>
                                <PhoneInput :options="countries" value-name="id" text-name="name" image-name="flag" />
                            </div>
                            <div>
                                <InputLabel color="black">language</InputLabel>
                                <RichSelectInput :options="countries" value-name="id" text-name="name" image-name="flag" />
                            </div>
                            <div>
                                <InputLabel color="black">help</InputLabel>
                                <input type="text"
                                    class="w-full border border-gray-500 rounded-full focus:border-none focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                    placeholder="breifly explain what happened" />
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
