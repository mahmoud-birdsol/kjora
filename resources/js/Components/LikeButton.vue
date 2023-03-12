<template>
    <button @click="toggleLike" :disabled="isPending" class="p-1">
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

const isLiked = ref(props.isLiked)
const isPending = ref(false)
const form = useForm({
    likeable_id: props.likeable_id,
    likeable_type: props.likeable_type
})
function toggleLike() {
    if (isPending.value) return
    console.log('sending request')
    if (!isLiked.value) {
        isLiked.value = true
        isPending.value = true
        form.post(route('like.store'), {
            preserveState: false,
            preserveScroll: true,
            onSuccess: () => {
                isPending.value = false
            }
        });
    } else {
        isLiked.value = false
        isPending.value = true
        form.delete(route('like.destroy'), {
            preserveState: false,
            preserveScroll: true,
            onSuccess: () => {
                isPending.value = false
            }
        });
    }
}
</script>

<style lang="scss" scoped></style>
