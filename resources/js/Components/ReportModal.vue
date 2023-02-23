<script setup>
import Modal from '@/Components/Modal.vue';
import {ref} from 'vue';
import {useForm, usePage} from "@inertiajs/inertia-vue3";

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
    reportable_type: props.reportableType,
    reportable_id: props.reportableId,
    report_option_id: null,
});

const submit = () => {
    form.post(route('report.store'), {
        preserveState: false,
        preserveScroll: false,
    });
}
</script>

<template>
    <div @click="show = true">
        <slot name="trigger"/>
    </div>

    <Modal :show="show" @close="show = false" max-width="sm">
        <p v-for="option in options">{{ option.body }}</p>
    </Modal>
</template>
