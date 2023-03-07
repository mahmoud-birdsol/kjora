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
            interval: null,
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
            this.interval = setInterval(this.fetchNewMessages, 30000);
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
         * Fetch the new conversation  messages from api .
         *
         * @returns {Promise<*>}
         */
        async fetchNewMessages() {
            // this.loading = true;
            try {
                let response = await axios.get(
                    route(`api.messages.new`, this.conversation)
                );
                console.log(response.data.data);
                let newMessages = response.data.data;
                newMessages.forEach((newM) => {
                    if (!this.messages.some((m) => m.id === newM.id)) {
                        this.messages.unshift(newM);
                    }
                });
                // this.messages = this.messages.concat(response.data.data);
                // this.loading = false;
                this.page === 1 ? this.scrollToMessagesBottom() : null;
            } catch (error) {
                this.loading = false;
                return error;
            }
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
            Echo.private(`users.chat.${this.conversation.id}`).listen(
                ".message-sent",
                (event) => {
                    if (this.currentUserId !== event.sender_id) {
                        this.messages.unshift(event);
                        this.scrollToMessagesBottom();
                    }
                }
            );
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
         * clear fetch new message interval.
         */
        clearFetchNewMessages() {
            clearInterval(this.interval);
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
