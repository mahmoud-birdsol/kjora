<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
</script>
<template>
    <Head title="About" />
    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <div class="min-h-[500px] flex flex-col justify-start gap-y-8 ">

                    <div class="flex justify-center my-4">
                        <h2 class="text-xl text-primary font-bold uppercase">{{$t('about')}}</h2>
                    </div>

                    <div class="mx-8">
                        <div class="border border-gray-600  rounded-2xl w-full  text-justify p-16 text-gray-600 mb-9">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Excepturi hic laboriosam facere,
                            voluptas ipsum at sint accusantium iste velit facilis, porro nostrum accusamus eveniet dolorem
                            sapiente id autem dignissimos soluta dicta voluptate fugit tempora repellat eius. In cum iure
                            distinctio?
                        </div>
                    </div>
                </div>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>
