<template>
    <button @click="toggleLike" :disabled="isPending" class="p-1">
        <slot :isLiked="isLiked" />
    </button>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
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
    },
    canLiked:{
        required: true,
        type: Boolean,
        default: true,
    }
})

const emits = defineEmits(['like', 'disLike'])

const isLiked = ref(props.isLiked)
const isPending = ref(false)
const form = useForm({
    likeable_id: props.likeable_id,
    likeable_type: props.likeable_type
})
function toggleLike() {
    if (isPending.value || !canLiked.value) return

    if (!isLiked.value) {

        form.post(route('like.store'), {
            preserveState: true,
            preserveScroll: true,
            onStart: () => {
                isLiked.value = true
                isPending.value = true
            },
            onSuccess: () => {
                emits('like')
                isPending.value = false
            }

        });
    } else {

        form.delete(route('like.destroy'), {
            preserveState: true,
            preserveScroll: true,
            onStart: () => {
                isLiked.value = false
                isPending.value = true
            },
            onSuccess: () => {
                emits('disLike')
                isPending.value = false
            }
        });
    }
}
</script>

<style lang="scss" scoped></style>
