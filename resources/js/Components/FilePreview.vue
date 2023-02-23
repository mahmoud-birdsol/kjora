<template>
    <Modal :show="show" @close="$emit('close')" :showCLoseIcon="false">

        <div class="w-full grid lg:grid-cols-2">


            <div>image and caption</div>
            <div>comment and replies</div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from './Modal.vue';

const props = defineProps({
    show: {
        required: true,
        type: Boolean,
        default: false,

    },
    file: {
        required: true,
    }
})
const emits = defineEmits(['close'])
</script>

<style  scoped></style>
