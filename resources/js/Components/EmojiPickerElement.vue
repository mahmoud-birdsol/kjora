<template>
    <div>
        <EmojiPicker :native="true" @select="onSelectEmoji" />
    </div>
</template>

<script>
import EmojiPicker from "vue3-emoji-picker";
// import 'vue3-emoji-picker/css'
// import '../../../node_modules/vue3-emoji-picker/dist/style.css'
export default {
    setup() {
        const onSelectEmoji = (e) => {
            console.log(e);
        };
        return {
            onSelectEmoji,
        };
    },
    components: {
        EmojiPicker,
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
    margin: 40px 0 0;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    display: inline-block;
    margin: 0 10px;
}

a {
    color: #42b983;
}
</style>
