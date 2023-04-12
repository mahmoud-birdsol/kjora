<script setup>
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import {onMounted} from "vue";


const locale = usePage().props.value.locale;

const props = defineProps([
    'template'
]);

onMounted(() => {
    console.log(props.template)
})
</script>
<template>
    <Head title="About" />
    <GuestLayout>
        <GuestTwoColumnLayout>
            <Card>
                <div class="min-h-[500px] flex flex-col justify-start gap-y-8 ">

                    <div class="flex justify-center my-4">
                        <h2 class="text-xl text-primary font-bold uppercase" v-if="locale === 'en'">
                            {{template.title_en}}
                        </h2>
                        <h2 class="text-xl text-primary font-bold uppercase" v-if="locale === 'ar'">
                            {{template.title_ar}}
                        </h2>
                    </div>

                    <div class="mx-2 md:mx-8">
                        <div class="border border-gray-600  rounded-2xl w-full  text-justify p-4 md:p-16 text-gray-600 mb-9"
                            v-if="locale === 'en'" v-html="template.body_en"
                        >
                        </div>
                    </div>
                </div>
            </Card>
        </GuestTwoColumnLayout>
    </GuestLayout>
</template>
