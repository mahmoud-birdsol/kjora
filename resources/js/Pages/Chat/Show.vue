<script setup>
import { provide } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import ChatLayout from "@/Layouts/ChatLayout.vue";
import ChatMessagesContainer from "./Partials/ChatMessagesContainer.vue";
import ChatHeader from "./Partials/ChatHeader.vue";
import ChatForm from "./Partials/ChatForm.vue";

const props = defineProps({
   conversation: null,
   conversations: null,
   player: null,
});

provide("conversation", props.conversation);
</script>

<template>
   <AppLayout title="Chat">
      <template #header>
         {{ $t("chat") }}
      </template>

      <ChatLayout :conversations="conversations">
         <template #header>
            <ChatHeader :conversation="conversation" :player="player" />
         </template>
         <template #main>
            <ChatMessagesContainer
               :conversation="conversation"
               :player="player"
            />
         </template>
         <template #footer>
            <ChatForm :conversation="conversation" :player="player"></ChatForm>
         </template>
      </ChatLayout>
   </AppLayout>
</template>
