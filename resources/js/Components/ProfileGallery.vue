<template>
    <div>
        profile Gallery {{ user ? user.name : null }}
    </div>
</template>

<script setup>
defineProps({
    user: {
        required: false,
    }
})
</script>

<style lang="scss" scoped></style>
