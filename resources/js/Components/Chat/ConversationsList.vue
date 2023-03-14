<script setup>
import { ref, watch } from 'vue';
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
    <div class="flex flex-col h-full gap-4">
        <div class="flex">
            <TextInput type="search" v-model="search" :placeholder="$t('search')" />
        </div>

        <div class="flex-grow">
            <p class="mb-3 font-bold text-black uppercase ">{{$t('total ( :count )', {count:filteredConversations.length })}}</p>
            <div ref="conversationList"
                class="flex self-end hideScrollBar flex-col gap-3 h-full max-h-[500px] overflow-auto  ">
                <ListGroupTransition>
                    <template v-for="conversation in filteredConversations" :key="conversation.id">
                        <ConversationCard :conversation="conversation" />
                    </template>
                </ListGroupTransition>
            </div>
        </div>
    </div>
</template>
