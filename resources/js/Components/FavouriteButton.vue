<template>
    <a href="javascript:;" @click="toggleFavorite" v-if="!isFavorite">
        <HeartIconOutline class="w-5 h-5 text-primary" />
    </a>
    <a href="javascript:;" @click="toggleFavorite" v-if="isFavorite">
        <HeartIcon class="w-5 h-5 text-primary" />
    </a>
</template>

<script setup>
import { HeartIcon } from '@heroicons/vue/20/solid'
import { HeartIcon as HeartIconOutline } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
const props = defineProps({
    user: null
})
const isFavorite = ref(props.user.is_favorite)
const isPending = ref(false)

const form = useForm({});
function toggleFavorite() {
    if (isPending.value) return

    if (!isFavorite.value) {
        form.post(route('favorites.store', { favorite: props.user.id }), {
            preserveState: false,
            preserveScroll: true,
            onStart: () => {
                isFavorite.value = true
                isPending.value = true
            },
            onFinish: () => {
                isPending.value = false
            }
        });
    } else {
        form.delete(route('favorites.destroy', { favorite: props.user.id }), {
            preserveState: false,
            preserveScroll: true,
            onStart: () => {
                isFavorite.value = false
                isPending.value = true
            },
            onFinish: () => {
                isPending.value = false
            }
        });
    }
}
</script>

<style lang="scss" scoped></style>