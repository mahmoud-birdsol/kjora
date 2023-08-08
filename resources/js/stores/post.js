const { defineStore } = require("pinia");

export const usePostStore = defineStore("post", () => {
   /* ---------------------------------- state --------------------------------- */
   const post = ref({});
   const comments = ref([]);
   const users = ref([]);

   /* --------------------------------- actions -------------------------------- */
   const addComment = (params) => {};
   const getComments = (params) => {};
   const sendComment = (params) => {};
   const addReply = (params) => {};
   const handleAddedReply = (params) => {};
   const scrollCommentIntoView = (params) => {};
   const scrollCommentsContainerToBottom = (params) => {};
   return {};
});
