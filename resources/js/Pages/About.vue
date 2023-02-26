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
                <CardContent title="about">
                    <template #body>
                            <div class="border border-gray-600  rounded-2xl w-full h-96 text-justify p-16 text-gray-600 mb-9" >
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Excepturi hic laboriosam facere, voluptas ipsum at sint accusantium iste velit facilis, porro nostrum accusamus eveniet dolorem sapiente id autem dignissimos soluta dicta voluptate fugit tempora repellat eius. In cum iure distinctio?
                            </div>
                    </template>
                </CardContent>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>