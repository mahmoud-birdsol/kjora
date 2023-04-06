<script setup>
import Modal from '@/Components/Modal.vue';
import { ref, onMounted } from 'vue';
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import {
    RadioGroup,
    RadioGroupOption,
} from '@headlessui/vue'
const props = defineProps({
    reportableType: {
        required: true,
        type: String,
    },
    reportableId: {
        required: true,
        type: Number,
    }
});

const options = usePage().props.value.reportOptions;
const show = ref(false);
const form = useForm({
    user_id: usePage().props.value.auth.user.id,
    reportable_type: props.reportableType,
    reportable_id: props.reportableId,
    report_option_id: null,
});
const submit = () => {
    form.post(route('report.store'), {
        preserveState: false,
        preserveScroll: false,
        onSuccess: () => {
            show.value = false;
        }
    });
}
</script>

<template>
    <div @click="show = true">
        <slot name="trigger" />
    </div>

    <Modal :show="show" @close="show = false" max-width="lg">

        <div class="flex flex-col p-4 pt-0 text-center gap-y-6">
            <div class="font-bold uppercase text-primary">
                {{ $t('report') }}
            </div>

            <form @submit.prevent="submit()">
                <ul class="px-4">
                    <RadioGroup v-model="form.report_option_id" class=" [&_li]:py-3 [&_li]:rounded-full [&_li]:border-2 text-stone-500  flex flex-col gap-4 text-sm font-medium cursor-pointer">
                        <template v-for="option in options">
                            <RadioGroupOption v-slot="{ checked }" :value="option.id">
                                <li class="text-black px-4 min-h-[60px]  flex items-center justify-center text-[10px]" :class="checked ? 'border-primary text-primary ' : 'border-black'"><div class="first-letter:capitalize text-justify">{{ option.body[$page.props.locale] }}</div></li>
                            </RadioGroupOption>
                        </template>
                    </RadioGroup>
                </ul>
                <button class="w-full p-2 px-6 my-4 text-white uppercase bg-black rounded-full">
                    {{ $t('report') }}
                </button>
            </form>

        </div>
    </Modal>
</template>
