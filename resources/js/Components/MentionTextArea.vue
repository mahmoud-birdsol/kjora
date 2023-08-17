<script setup>
import { usePostStore } from "@/stores";
import { computed, ref, watch } from "vue";

const props = defineProps({
   newText: String,
   ref: String,
});
const emits = defineEmits(["send", "update:newText"]);

const postStore = usePostStore();
const showMentionList = ref(false);
const customTextAreaRef = ref();
const inputRef = ref(null);
const searchChars = ref("");
const users = ref(null);
const selectedUserId = ref(0);

const allMatchedWordsInText = computed(() =>
   props.newText.match(/\B@\w+|\B[@]/g)
);
const mentionSuggestions = computed(() => {
   // find users that match the characters that user write after @
   if (!Boolean(searchChars.value)) {
      return postStore.usersCanBeMentioned.filter(
         (user) => !allMatchedWordsInText.value.includes(`@${user.username}`)
      );
   } else {
      return postStore.usersCanBeMentioned.filter(
         (user) =>
            user.username
               .toLowerCase()
               .includes(searchChars.value.toLowerCase()) &&
            !allMatchedWordsInText.value.includes(`@${user.username}`)
      );
   }
});
const displayedComment = computed(() => {
   if (!Boolean(allMatchedWordsInText.value?.length)) return props.newText;
   return props.newText
      .split(" ")
      .map((word) => {
         if (checkIfUserExist(word)) {
            return `<span class="text-primary" dir="ltr">@${word.slice(
               1
            )}</span>`;
         } else return word;
      })
      .join(" ");
});

function addSelectedUserToTextarea(user) {
   // remove last characters and [@] from the end of comment
   let all = props.newText.split(" ");
   all.splice(-1, 1);
   emits("update:newText", `${all.join(" ")} @${user.username} `);
   showMentionList.value = false;
}
function syncScroll(e) {
   if (!customTextAreaRef) return;
   customTextAreaRef.value.scrollTop = e.target.scrollTop;
}
function goUp(e) {
   if (!showMentionList.value) return;
   e.preventDefault();

   if (selectedUserId.value <= 0) selectedUserId.value = users.value.length - 1;
   else selectedUserId.value -= 1;
}
function goDown(e) {
   if (!showMentionList.value) return;
   e.preventDefault();
   if (selectedUserId.value >= mentionSuggestions.value.length - 1)
      selectedUserId.value = 0;
   else selectedUserId.value += 1;
}
function sendOrSelect(e) {
   // if user press enter and mention list is closed then user want to sent comment
   if (!showMentionList.value) return emits("send");
   addSelectedUserToTextarea(mentionSuggestions.value[selectedUserId.value]);
}
function checkIfUserExist(words) {
   return postStore.usersCanBeMentioned.some(
      (user) => user.username === words.slice(1)
   );
}

watch(
   () => props.newText,
   (newVal) => {
      let lastWord = newVal.split(" ").slice(-1);
      if (lastWord[0].match(/\B@\w+|\B[@]/g)) {
         searchChars.value = lastWord[0].substring(1);
         showMentionList.value = true;
      } else {
         showMentionList.value = false;
      }
   }
);
watch(selectedUserId, () => {
   users.value[selectedUserId.value].scrollIntoView({
      behavior: "smooth",
      block: "center",
   });
});

defineExpose({
   focus: () => inputRef.value.focus(),
});
</script>
<template>
   <div class="relative flex items-center flex-grow">
      <div
         ref="customTextAreaRef"
         class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar break-all whitespace-pre-wrap placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary min-h-[2.5rem] overflow-auto max-h-[3.75rem]"
      >
         <span v-html="displayedComment" />
      </div>
      <textarea
         @keypress.enter.exact.prevent="sendOrSelect"
         @keydown.up.exact="goUp"
         @keydown.down.exact="goDown"
         @scroll="syncScroll"
         :value="newText"
         @input="$emit('update:newText', $event.target.value)"
         ref="inputRef"
         placeholder="Please write text ..."
         class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar break-all whitespace-pre-wrap placeholder:text-neutral-400 bg-transparent focus:ring-1 focus:ring-primary absolute text-transparent caret-black inset-y-0 max-h-[3.75rem] min-h-[2.5rem]"
      >
      </textarea>
      <ul
         class="absolute flex flex-col text-center bg-white border divide-y rounded bottom-full w-full max-h-[10vh] overflow-auto hideScrollBar"
         v-if="showMentionList && mentionSuggestions.length"
      >
         <li
            v-for="(user, i) in mentionSuggestions"
            class="p-1 text-sm transition-colors duration-300 cursor-pointer text-primary hover:bg-stone-300"
            :class="selectedUserId === i && 'bg-primary text-white'"
            @click="addSelectedUserToTextarea(user)"
            ref="users"
         >
            {{ user.username }}
         </li>
      </ul>
   </div>
</template>
