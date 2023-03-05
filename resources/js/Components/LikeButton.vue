<template>
    <button @click="toggleLike" class="p-1">
        <slot :isLiked="isLiked" />
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
        type: String,
    },
    isLiked: {
        required: true,
        type: Boolean,
        default: false,
    }
})
const emits = defineEmits(['toggleLike'])
const isLiked = ref(props.isLiked)

const form = useForm({
    likeable_id: props.likeable_id,
    likeable_type: props.likeable_type
})
function toggleLike() {
    if (!isLiked.value) {
        isLiked.value = true
        form.post(route('like.store'), {
            preserveState: false,
            preserveScroll: true,
        });
    } else {
        isLiked.value = false
        form.post(route('like.store'), {
            preserveState: false,
            preserveScroll: true,
        });
    }
}
</script>

<style lang="scss" scoped></style>
