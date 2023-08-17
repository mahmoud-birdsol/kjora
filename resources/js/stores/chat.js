import { defineStore } from "pinia";
import axios from "axios";
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";

export const useChat = defineStore("chat", () => {
   const messages = ref([]);
   const page = ref(1);
   const lastPage = ref(0);
   const showLastPageNotice = ref(false);
   const loading = ref(false);
   const container = ref(null);
   const conversation = ref(null);
   const search = ref("");
   const replyToMessage = ref(null);
   const currentUserId = ref(null);
   const interval = ref(null);
   const filesData = ref(null);
   const isSendingMsg = ref(false);
   const formCreateMessage = useForm({
      parent_id: null,
      body: "",
      attachments: null,
   });

   /**
    * Get store messages.
    *
    * @param state
    * @returns {Array}
    */
   const messageList = computed(() => {
      return messages.value;
   });
   /**
    * Check if the last page is reached.
    *
    * @param state
    * @returns {boolean}
    */
   const lastPageReached = computed(() => {
      return page.value === lastPage.value;
   });

   /**
    * Get the loading state of the store.
    *
    * @param state
    * @returns {*}
    */
   const isLoading = computed(() => {
      return loading.value;
   });

   /**
    * Get the messages seleced for reply.
    *
    * @param state
    * @returns {null|*}
    */
   const repliedMessage = computed(() => {
      return replyToMessage.value;
   });

   // actions
   /**
    * Initialize the store.
    *
    * @param conversation
    * @param messagesContainer
    * @private
    */
   function initialize({
      conversation: conversationParam,
      container: containerParam,
      currentUserId: currentUserIdParam,
   }) {
      conversation.value = conversationParam;
      container.value = containerParam;
      currentUserId.value = currentUserIdParam;
      subscribeToConversation();
      messages.value = [];
      fetchMessages();
      //fetch messages every 30 sec for case pusher doesn't work well
      interval.value = setInterval(fetchNewMessages, 30000);
      // Add event listener for the container
      // scroll to load more messages.
      setTimeout(() => {
         registerScrollListener();
      }, 3000);
   }
   /**
    * Subscribe to the conversation channel.
    */
   function subscribeToConversation() {
      Echo.private(`users.chat.${conversation.value.id}`)
         .listen(".message-sent", (event) => {
            if (currentUserId.value !== event.sender_id) {
               messages.value.unshift({ ...event, new: true });
               scrollToMessagesBottom();
               axios.post(route("api.message.mark-as-read", event.id));
            }
         })
         .listen(".message-read", (event) => {
            setMessageAsRead(event);
         });
   }

   /**
    * Fetch the conversation messages from api.
    *
    * @returns {Promise<*>}
    */
   async function fetchMessages() {
      loading.value = true;
      try {
         let response = await axios.get(
            route(`api.messages.index`, conversation.value),
            {
               params: {
                  page: page.value,
                  search: search.value,
               },
            }
         );
         messages.value = messages.value.concat(response.data.data);
         lastPage.value = response.data.meta.last_page;
         loading.value = false;

         //mark messages that not read as read on fetch
         messages.value.forEach((m) => {
            if (m.read_at == null && m.sender_id !== currentUserId.value) {
               axios.post(route("api.message.mark-as-read", m.id));
            }
         });

         page.value === 1 ? scrollToMessagesBottom() : null;
      } catch (error) {
         loading.value = false;
         return error;
      }
   }

   /**
    * Fetch the new conversation  messages from api .
    *
    * @returns {Promise<*>}
    */
   async function fetchNewMessages() {
      try {
         let response = await axios.get(
            route(`api.messages.new`, conversation.value)
         );

         let newMessages = response.data.data;
         newMessages.forEach((newM) => {
            // check if the pusher didn't work correctly then the message will not be in the messages array
            if (!messages.value.some((m) => m.id === newM.id)) {
               messages.value.unshift({ ...newM, new: true });
               scrollToMessagesBottom();
            }
         });
      } catch (error) {
         loading.value = false;
         return error;
      }
   }

   /**
    * Search conversation messages.
    *
    * @returns {Promise<void>}
    */
   async function searchMessages() {
      page.value = 1;
      messages.value = [];
      await fetchMessages();
   }
   function deleteMessage(id) {
      let index = messages.value.findIndex((m) => m.id === id);
      messages.value.splice(index, 1);
   }
   /**
    * mark message as read in ui
    * @param msg
    */
   function setMessageAsRead(msg) {
      let oldMessageIndex = messages.value.findIndex((m) => m.id === msg.id);
      messages.value[oldMessageIndex].read_at = msg.read_at;
   }

   /**
    * Register the container scroll listener.
    */
   function registerScrollListener() {
      container.value
         ? container.value.addEventListener("scroll", handleScroll)
         : null;
   }

   /**
    * Un register the container scroll listener.
    */
   function unRegisterScrollListener() {
      container.value
         ? container.value.removeEventListener("scroll", handleScroll)
         : null;
   }

   /**
    * Unsubscribe from chat channel.
    */
   function UnsubscribeFromChatChannel() {
      Echo.leave(`users.chat.${conversation.value?.id}`);
   }
   /**
    * clear fetch new message interval.
    */
   function clearFetchNewMessages() {
      clearInterval(interval.value);
   }

   /**
    * Select a message to reply to
    *
    * @param message
    */
   function setMessageToReplyTo(message) {
      replyToMessage.value = message;
   }
   /**
    * Push a new message.
    *
    * @param message
    */
   function pushNewMessage(msg) {
      messages.value?.unshift(msg);
      scrollToMessagesBottom();
      replyToMessage.value = null;
   }
   /**
    * SCROLL FUNCTIONALITY.
    */

   function scrollToMessagesBottom() {
      setTimeout(() => {
         container.value.scrollTo({
            top: container.value.scrollHeight,
            left: 0,
            behavior: "smooth",
         });
      }, 200);
   }
   function scrollToMessagesTop() {
      setTimeout(() => {
         container.value.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth",
         });
      }, 200);
   }
   function handleScroll(e) {
      let element = e.target;

      if (lastPageReached.value) {
         // Do nothing.
         showLastPageNotice.value = true;
         return;
      }

      if (element.scrollTop === 0) {
         page.value += 1;
         fetchMessages();
      }
   }
   function addFiles(files, filesUrls) {
      if (formCreateMessage.attachments) {
         formCreateMessage.attachments = [
            ...formCreateMessage.attachments,
            ...files,
         ];
         filesData.value = [...filesData.value, ...filesUrls];
      } else {
         formCreateMessage.attachments = files;
         filesData.value = filesUrls;
      }
   }
   const sendMsg = () => {
      if (isSendingMsg.value) {
         return;
      }

      if (
         formCreateMessage.body === "" &&
         !formCreateMessage.attachments.length
      ) {
         return;
      }

      isSendingMsg.value = true;
      if (repliedMessage.value) {
         formCreateMessage.parent_id = repliedMessage.value.id;
      }

      axios
         .post(
            route("api.messages.store", conversation.value.id),
            formCreateMessage.data(),
            {
               headers: {
                  "Content-Type": "multipart/form-data",
               },
            }
         )
         .then((response) => {
            pushNewMessage(response.data.data);
         })
         .catch((error) => {
            console.error(error);
         })
         .finally(() => {
            formCreateMessage.reset();
            filesData.value = [];
            isSendingMsg.value = false;
         });
   };
   return {
      // state
      messages,
      page,
      lastPage,
      showLastPageNotice,
      loading,
      container,
      conversation,
      search,
      replyToMessage,
      currentUserId,
      interval,
      filesData,
      formCreateMessage,
      isSendingMsg,

      //   getter
      lastPageReached,
      messageList,
      isLoading,
      repliedMessage,

      //   actions
      initialize,
      subscribeToConversation,
      fetchMessages,
      fetchNewMessages,
      searchMessages,
      deleteMessage,
      setMessageAsRead,
      registerScrollListener,
      unRegisterScrollListener,
      UnsubscribeFromChatChannel,
      clearFetchNewMessages,
      setMessageToReplyTo,
      pushNewMessage,
      scrollToMessagesBottom,
      scrollToMessagesTop,
      handleScroll,
      addFiles,
      sendMsg,
   };
});
