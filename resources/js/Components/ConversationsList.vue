<script setup >

import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
import ConversationCard from './ConversationCard.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';


const props = defineProps({
    conversations: Array,
    currentConvId: Number,
    lastActiveAt: null,
})
const emit = defineEmits(['fetchMore'])
const conversationList = ref(null)

onMounted(() => {
    conversationList.value ? conversationList.value.addEventListener('scroll', throttledHandleScroll) : null
    // console.log(props.conversations)
});
onUnmounted(() => {
    conversationList.value ? conversationList.value.removeEventListener('scroll', throttledHandleScroll) : null

});
const throttledHandleScroll = window._.throttle(handleScroll, 1000)
function handleScroll(e) {
    let element = e.target
    //console.log(element.scrollTop)
    element.scrollTop + element.offsetHeight >= element.scrollHeight ? emit('fetchMore') : null
    element.scrollTop + element.offsetHeight >= element.scrollHeight ? console.log('fetchMore') : null
}

const searchFriendsForm = useForm({
    query: null
})
const debouncedSubmitSearchFriends = window._.debounce(submitSearchFriends, 500)
function submitSearchFriends() {
    //console.log('send query and recive fitlerd data')
    //console.log(searchFriendsForm.query)
}
</script>

<template>
    <div class="flex flex-col h-full justify-between gap-2">
        <!-- search input -->
        <div class="grid items-center w-full grid-cols-1 ">
            <input type="search" v-model="searchFriendsForm.query" @input="debouncedSubmitSearchFriends"
                class="w-full col-start-1 row-start-1 pis-10 rounded-3xl">
            <div class="col-start-1 row-start-1 justify-self-start pis-3">
                <MagnifyingGlassIcon class="w-5 h-5 text-primary">
                </MagnifyingGlassIcon>
            </div>
        </div>
        <!-- conversations list -->
        <div class="grid items-end gap-2">
            <p class=" mb-3 font-bold text-black uppercase">total (3)</p>
            <div ref="conversationList"
                class="flex self-end flex-col gap-3 hideScrollBar max-h-[40vh] overflow-auto  lg:max-h-[70vh] ">
                <template v-for="conversation in conversations" :key="conversation.id">
                    <ConversationCard :conversation="conversation" :lastActiveAt="lastActiveAt"
                        :active="conversation.id === currentConvId" />
                </template>
            </div>
        </div>
    </div>
</template>



<style  ></style>
