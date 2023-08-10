import { defineStore, acceptHMRUpdate } from "pinia";
import { ref, computed, watch } from "vue";
import { useUserStore } from "./user";
import { router, useForm } from "@inertiajs/vue3";
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
      post.value?.comments?.filter?.((c) => !c.parent_id)
   );
   const parentCommentsCount = computed(
      () => parentComments.value?.length ?? 0
   );
   const PostMediaCount = computed(() => post.value?.media?.length ?? 0);
   const commentsContainerOffset = computed(() => {
      return (
         commentsContainer.value?.getBoundingClientRect().top + window.scrollY
      );
   });
   const isPostUserTheCurrentUser = computed(() =>
      userStore.isCurrentUser(postUser.value)
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
      captionForm.caption = postParam.caption;
      commentsContainer.value = commentsContainerParam;
      usersCanBeMentioned.value = userStore.getUsers();
   };
   const updatePostObject = (newPost) => {
      post.value = newPost;
   };
   const getComments = async () => {
      router.reload({
         only: ["post"],
         onSuccess: () => {
            if (!route().params?.commentId) {
               scrollCommentsContainerToBottom();
               console.log("success loading comments");
            }
         },
         preserveState: true,
         preserveScroll: true,
      });
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
            user_id: userStore.currentUser.id,
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
   /**
    * @description delete the post
    */
   function deletePost() {
      router.delete(route("posts.destroy", post.value), {});
   }
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
      captionForm.patch(route("posts.update", post.value), {
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
      //constants
      POST_MODEL_TYPE,
      //state
      post,
      postUser,
      comments,
      usersCanBeMentioned,
      newComment,
      captionForm,
      isEditingCaption,
      isAddingComment,
      //getters
      parentComments,
      parentCommentsCount,
      commentsContainerOffset,
      isPostUserTheCurrentUser,
      PostMediaCount,
      //actions
      initialize,
      updatePostObject,
      addComment,
      getComments,
      scrollCommentsContainerToBottom,
      cancelEditCaption,
      submitEditCaption,
      deletePost,
   };
});

if (import.meta.hot) {
   import.meta.hot.accept(acceptHMRUpdate(usePostStore, import.meta.hot));
}
