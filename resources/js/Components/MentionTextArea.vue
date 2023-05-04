<template>
    <div class="relative flex items-center flex-grow">
        
        <div
            ref="customTextArea"
            class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar break-all whitespace-pre-wrap placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary min-h-[2.5rem] overflow-auto max-h-[3.75rem]"
        >
            <span v-html="CommentInDiv" />
        </div>
        <textarea
            @keypress.enter.exact.prevent="sendOrSelect"
            @keydown.up.exact="goUp"
            @keydown.down.exact="goDown"
            @scroll="syncScroll"
            :value="newText"
            @input = "$emit('update:newText',$event.target.value)"
            placeholder="Please Write Text ..."
            class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar break-all whitespace-pre-wrap placeholder:text-neutral-400 bg-transparent focus:ring-1 focus:ring-primary absolute text-transparent caret-black inset-y-0 max-h-[3.75rem] min-h-[2.5rem]"
        >
        </textarea>
        <ul
            class="absolute flex flex-col text-center bg-white border divide-y rounded bottom-full w-full max-h-[10vh] overflow-auto hideScrollBar"
            v-if="showMentionList && suggestion.length"
        >
            <li
                v-for="(user, i) in suggestion"
                class="p-1 text-sm transition-colors duration-300 cursor-pointer text-primary hover:bg-stone-300"
                :class="currentOption=== i && 'bg-primary text-white'"
                @click="addToDiv(user)"
                ref="options"
            >
                {{ user.username }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import axios from "axios";
const props = defineProps({
    newText:String,
    ref:String,
})
const emits = defineEmits(['addText','update:newText'])


const showMentionList = ref(false);
const customTextArea = ref();
const users = ref([]);
const searchChars = ref("");
const options = ref(null);
const currentOption = ref(0);
const suggestion = computed(() => {
    return users.value.filter((username) =>
        username.username.includes(searchChars.value)
    );
});
const CommentInDiv = computed(() => {
    if (!props.newText.match(/@\w+/g)) return props.newText;
    let allComment = props.newText.split(" ");
    let comment = []
    comment = allComment.map((word) => {
        if (users.value.some(user=> user.username === word.slice(1))) return `<span class="text-primary">@${word.slice(1)}</span>`;
        else return word
    });
    return comment.join(' ');
});

function addToDiv(user) {
    let all = props.newText.split(" ");
    all.splice(-1, 1);
    emits('update:newText',`${all.join(" ")} @${user.username} `)
    users.value = users.value.filter(usr=>usr.id !== user.id)
    showMentionList.value = false;
}
function syncScroll(e) {
    if (!customTextArea) return;
    customTextArea.value.scrollTop = e.target.scrollTop;
}
function goUp(e){
    if(!showMentionList.value) return ;
    e.preventDefault();
    console.log(currentOption.value)
    if(currentOption.value < 0 ) currentOption.value = suggestion.value.length-1
    else currentOption.value -=1
    
}
function goDown(e){
    if(!showMentionList.value) return ;
    e.preventDefault();
    console.log(currentOption.value)
    if(currentOption.value >= suggestion.value.length ) currentOption.value = 0
    else currentOption.value +=1

    
}
function sendOrSelect(e){
    if(!showMentionList.value) emits('addText')
    addToDiv(users.value[currentOption.value])

}
async function fetchUsername() {
    await axios
        .get(route("api.user.get.users.name"))
        .then((res) => {users.value = res.data.data});
}
watch(
    () => props.newText,
    (newVal, oldVal) => {
        let lastWord = newVal.split(" ").slice(-1).join();
        if (lastWord.match(/@\w+/g)) {
            searchChars.value = lastWord.substring(1);
            showMentionList.value = true;
        }else{
            showMentionList.value = false;
        }
    }
);
watch(currentOption,()=>{
    options.value[currentOption.value].scrollIntoView()
})
onMounted(()=>fetchUsername())
</script>

