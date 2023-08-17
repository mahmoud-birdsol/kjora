<template>
   <EmojiPicker @select="onSelectEmoji" />
</template>

<script setup>
const emits = defineEmits(["selectedEmoji"]);

const onSelectEmoji = (e) => {
   emits("selectedEmoji", e.i);
};
</script>
