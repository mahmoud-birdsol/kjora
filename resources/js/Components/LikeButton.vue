<template>
    <button @click="toggleLike" class="p-1">
        <slot name="button" :isLiked="isLiked" />
    </button>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    likeable_id: {
        required: true,
        type: Number,
    },
    likeable_type: {
        required: true,
        type: Number,
    }
})
const emits = defineEmits(['toggleLike'])
const isLiked = ref(false)

const form = useForm({
    likeable_id: props.likeable_id,
    likeable_type: props.likeable_type
})
function toggleLike() {
    if (!isLiked) {
        form.post(route('like.store'), {
            preserveState: false,
            preserveScroll: true,
        });
    } else {
        form.post(route('like.store'), {
            preserveState: false,
            preserveScroll: true,
        });
    }
}
</script>

<style lang="scss" scoped></style>
