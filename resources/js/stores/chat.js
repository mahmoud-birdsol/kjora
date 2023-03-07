import { defineStore } from "pinia";
import axios from "axios";

export const useChat = defineStore("chat", {
    state() {
        return {
            messages: [],
            page: 1,
            lastPage: 0,
            loading: false,
            container: null,
            conversation: null,
            search: "",
            replyToMessage: null,
            currentUserId: null,
        };
    },

    getters: {
        /**
         * Get store messages.
         *
         * @param state
         * @returns {Array}
         */
        messageList(state) {
            return state.messages;
        },

        /**
         * Check if the last page is reached.
         *
         * @param state
         * @returns {boolean}
         */
        lastPageReached(state) {
            return state.page === state.lastPage;
        },

        /**
         * Get the loading state of the store.
         *
         * @param state
         * @returns {*}
         */
        isLoading(state) {
            return state.loading;
        },

        /**
         * Get the messages seleced for reply.
         *
         * @param state
         * @returns {null|*}
         */
        repliedMessage(state) {
            return state.replyToMessage;
        },
    },

    actions: {
        /**
         * Initialize the store.
         *
         * @param conversation
         * @param messagesContainer
         * @private
         */
        initialize({ conversation, container, currentUserId }) {
            this.conversation = conversation;
            this.container = container;
            this.currentUserId = currentUserId;
            this.subscribeToConversation();
            this.fetchMessages();

            // Add event listener for the container
            // scroll to load more messages.
            this.registerScrollListener();
        },

        /**
         * Fetch the conversation messages from api.
         *
         * @returns {Promise<*>}
         */
        async fetchMessages() {
            this.loading = true;
            try {
                let response = await axios.get(
                    route(`api.messages.index`, this.conversation),
                    {
                        params: {
                            page: this.page,
                            search: this.search,
                        },
                    }
                );

                this.messages = this.messages.concat(response.data.data);
                this.lastPage = response.data.meta.last_page;
                this.loading = false;

                this.page === 1 ? this.scrollToMessagesBottom() : null;
            } catch (error) {
                this.loading = false;
                return error;
            }
        },
        /**
         *
         */
        setMessageAsRead(message) {
            // let oldMessage = this.messages.filter(
            //     (m) => m.id === message.id
            // )[0];
            // let oldMessageIndex = this.messages.indexOf(oldMessage);
            let oldMessageIndex = this.messages.findIndex(
                (m) => m.id === message.id
            );

            this.messages[oldMessageIndex].read_at = message.read_at;
            // this.messages.splice(oldMessageIndex, 1, message);
        },
        /**
         * Search conversation messages.
         *
         * @returns {Promise<void>}
         */
        async searchMessages() {
            this.page = 1;
            this.messages = [];
            await this.fetchMessages();
        },

        /**
         * Subscribe to the conversation channel.
         */
        subscribeToConversation() {
            Echo.private(`users.chat.${this.conversation.id}`)
                .listen(".message-sent", (event) => {
                    if (this.currentUserId !== event.sender_id) {
                        this.messages.unshift(event);
                        this.scrollToMessagesBottom();
                        axios.post(route("api.message.mark-as-read", event.id));
                    }
                })
                .listen(".message-read", (event) => {
                    console.log("message-read");
                    console.log(event);
                    this.setMessageAsRead(event);
                });
        },

        /**
         * Register the container scroll listener.
         */
        registerScrollListener() {
            this.container
                ? this.container.addEventListener("scroll", this.handleScroll)
                : null;
        },

        /**
         * Un register the container scroll listener.
         */
        unRegisterScrollListener() {
            this.container
                ? this.container.removeEventListener(
                      "scroll",
                      this.handleScroll
                  )
                : null;
        },

        /**
         * Select a message to reply to
         *
         * @param message
         */
        setMessageToReplyTo(message) {
            this.replyToMessage = message;
        },

        /**
         * Push a new message.
         *
         * @param message
         */
        pushNewMessage(message) {
            this.messages.unshift(message);
            this.scrollToMessagesBottom();
            this.replyToMessage = null;
        },

        /**
         * SCROLL FUNCTIONALITY.
         */

        scrollToMessagesBottom() {
            let vm = this;
            setTimeout(() => {
                vm.container.scrollTo({
                    top: vm.container.scrollHeight,
                    left: 0,
                    behavior: "smooth",
                });
            }, 200);
        },

        scrollToMessagesTop() {
            let vm = this;
            setTimeout(() => {
                vm.container.scrollTo({
                    top: 0,
                    left: 0,
                    behavior: "smooth",
                });
            }, 200);
        },

        handleScroll(e) {
            let element = e.target;

            if (this.lastPageReached) {
                // Do nothing.
                return;
            }

            if (element.scrollTop === 0) {
                this.page++;
                this.fetchMessages();
            }
        },
    },
});
