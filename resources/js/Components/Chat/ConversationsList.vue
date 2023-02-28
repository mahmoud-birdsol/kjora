<script setup>
import {ref, watch} from 'vue';
import ConversationCard from '@/Components/Chat/ConversationCard.vue';
import ListGroupTransition from '@/Components/ListGroupTransition.vue';
import TextInput from "@/Components/TextInput.vue";


const props = defineProps({
    conversations: Array,
})


const filteredConversations = ref(props.conversations);
const search = ref('');

/**
 * Watch the search value to
 * debounce the filter update.
 */
watch(search, () => _.debounce(filterConversations, 300)());

/**
 * Filter the conversations according
 * to the search value.
 */
function filterConversations() {
    filteredConversations.value = props.conversations.filter(conversation => {
        let contains = false;

        conversation.users.forEach((user) => {
            if (user.name.toLowerCase().includes(search.value.toLowerCase())) {
                contains = true;
            }
        });

        return contains;
    });
}
</script>

<template>
    <div class="grid grid-cols-1 gap-4 h-full">
        <div class="flex">
            <TextInput type="search" v-model="search" placeholder="Search"/>
        </div>

        <div class="">
            <p class="mb-3 font-bold text-black uppercase ">total ({{ filteredConversations.length }})</p>
            <div ref="conversationList"
                 class="flex self-end flex-col gap-3 hideScrollBar max-h-[500px] overflow-auto  lg:max-h-[50pxx] ">
                <ListGroupTransition>
                    <template v-for="conversation in filteredConversations" :key="conversation.id">
                        <ConversationCard :conversation="conversation"/>
                    </template>
                </ListGroupTransition>
            </div>
        </div>
    </div>
</template>
