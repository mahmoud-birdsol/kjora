import { defineStore, acceptHMRUpdate } from "pinia";
import { ref, computed } from "vue";
import { useUserStore } from "./user";
import { useForm } from "@inertiajs/vue3";
import { useCommentStore } from "./comment";

export const usePostStore = defineStore("post", () => {
   const POST_MODEL_TYPE = "App\\Models\\Post";
   /* -------------------------------------------------------------------------- */
   /*                                  state                                     */
   /* -------------------------------------------------------------------------- */
   const userStore = useUserStore();
   const commentStore = useCommentStore();
   const post = ref({});
   const postUser = ref({});
   const comments = ref([]);
   const commentsContainer = ref(null);
   const usersCanBeMentioned = ref([]);
   const isEditingCaption = ref(false);
   const isAddingComment = ref(false);
   const newComment = ref("");
   /**
    * !check if this work reactive
    */
   const captionForm = useForm({
      caption: post.value?.caption ?? "",
   });
   /* -------------------------------------------------------------------------- */
   /*                                 getters                                    */
   /* -------------------------------------------------------------------------- */
   const parentComments = computed(() =>
      comments.value.filter((c) => !c.parent_id)
   );
   const parentCommentsCount = computed(
      () => parentComments.value?.length ?? 0
   );
   const commentsContainerOffset = computed(() => {
      return (
         commentsContainer.value?.getBoundingClientRect().top + window.scrollY
      );
   });
   const isPostUserTheCurrentUser = computed(() =>
      userStore.isCurrentUser(postUser)
   );
   /* -------------------------------------------------------------------------- */
   /*                                 actions                                    */
   /* -------------------------------------------------------------------------- */
   const initialize = ({
      post: postParam,
      commentsContainer: commentsContainerParam,
   }) => {
      post.value = postParam;
      postUser.value = postParam.user;
      commentsContainer.value = commentsContainerParam;
      getComments();
      usersCanBeMentioned.value = userStore.getUsers();
   };

   const getComments = () => {
      commentStore.getComments(
         {
            commentable_id: postUser.value.id,
            commentable_type: POST_MODEL_TYPE,
         },
         {
            onSuccess: () => {
               if (!route().params?.commentId) {
                  scrollCommentsContainerToBottom();
               }
            },
         }
      );
   };
   const addComment = (params) => {
      if (
         isAddingComment.value ||
         !newComment.value ||
         newComment.value.trim() === ""
      ) {
         return;
      }
      isAddingComment.value = true;
      commentStore.storeComment(
         {
            commentable_id: post.value.id,
            commentable_type: "App\\Models\\Post",
            body: newComment.value,
            user_id: userStore.currentUser.value.id,
            parent_id: null,
         },
         {
            onSuccess: () => {
               getComments();
            },
            onFinish: () => {
               isAddingComment.value = false;
               newComment.value = "";
            },
         }
      );
   };
   const addReply = (params) => {};
   const handleAddedReply = (params) => {};
   const scrollCommentIntoView = (params) => {};
   /** @description  helper function to scroll comments container to bottom */
   const scrollCommentsContainerToBottom = (params) => {
      setTimeout(() => {
         commentsContainer.value.scrollTo({
            top: commentsContainer.value.scrollHeight,
            left: 0,
            behavior: "smooth",
         });
      }, 100);
   };

   /* -------------------------- post caption actions -------------------------- */
   const submitEditCaption = () => {
      captionForm.patch(route("posts.update", props.post), {
         preserveScroll: true,
         preserveState: true,
      });
      isEditingCaption.value = false;
   };

   const cancelEditCaption = () => {
      captionForm.reset();
      isEditingCaption.value = false;
   };

   return {
      //state
      post,
      postUser,
      comments,
      usersCanBeMentioned,
      //getters
      parentComments,
      parentCommentsCount,
      commentsContainerOffset,
      isPostUserTheCurrentUser,
      //actions
      initialize,
      addComment,
      getComments,
      sendComment,
      addReply,
      handleAddedReply,
      scrollCommentIntoView,
      scrollCommentsContainerToBottom,
   };
});

if (import.meta.hot) {
   import.meta.hot.accept(acceptHMRUpdate(usePostStore, import.meta.hot));
}
