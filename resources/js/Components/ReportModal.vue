<script setup>
import Modal from '@/Components/Modal.vue';
import {ref , onMounted} from 'vue';
import {useForm, usePage} from "@inertiajs/inertia-vue3";
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
    report_option_id:null,
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
        <slot name="trigger"/>
    </div>

    <Modal :show="show" @close="show = false" max-width="sm">

        <div class="flex flex-col p-4 text-center uppercase gap-y-6">
        <div class="mb-4 font-bold text-primary">
            {{$t('report')}}
        </div>
            <!-- TODO:make it radio buttons group -->
            <form @submit.prevent="submit()">
                <ul class="px-6">
                    <RadioGroup v-model="form.report_option_id"
                        class=" [&_li]:py-3 [&_li]:rounded-full [&_li]:border-2 text-stone-500  flex flex-col gap-4 text-sm font-medium cursor-pointer">
                        <template v-for="option in options">
                            <RadioGroupOption v-slot="{ checked }" :value="option.id">
                                <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">{{ option.body[$page.props.locale] }}</li>
                            </RadioGroupOption>
                        </template>
                    </RadioGroup>
                </ul>
                <button class="w-full p-2 px-6 text-white uppercase bg-black rounded-full my-4">
                    {{$t('report')}}
                </button>
            </form>

    </div>
    </Modal>
</template>
