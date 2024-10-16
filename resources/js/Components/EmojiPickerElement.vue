<script setup>
const emits = defineEmits(["selectedEmoji"]);

const onSelectEmoji = (e) => {
   emits("selectedEmoji", e.i);
};
</script>
<template>
   <EmojiPicker @select="onSelectEmoji" />
</template>
