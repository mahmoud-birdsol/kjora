import { router } from "@inertiajs/vue3";
import axios from "axios";
import { defineStore, acceptHMRUpdate } from "pinia";

export const useCommentStore = defineStore("Comment", () => {
   const COMMENT_MODEL_TYPE = "App\\Models\\Comment";
   /* -------------------------------------------------------------------------- */
   /*                                  state                                     */
   /* -------------------------------------------------------------------------- */

   /* -------------------------------------------------------------------------- */
   /*                                 getters                                    */
   /* -------------------------------------------------------------------------- */

   /* -------------------------------------------------------------------------- */
   /*                                 actions                                    */
   /* -------------------------------------------------------------------------- */
   /** @description get comments for any model
    * @param {{  commentable_id: number,
               commentable_type: string,}} data
                   @param {{onSuccess: function,onError: function,onFinish: function}} options
    */
   // TODO refactor this to use useAxios composable
   const getComments = async (data, options) => {
      try {
         let response = await axios.get(route("api.gallery.comments"), {
            params: data,
         });
         options?.onSuccess?.();
         return response.data.data;
      } catch (err) {
         options?.onError?.();
         console.log(err);
      } finally {
         options?.onFinish?.();
      }
   };
   /** @description store comment in database
    * @param {{
    *   commentable_id: post.value.id,
            commentable_type: string,
            body: string,
            user_id: number,
            parent_id?: number,
    * }} comment
            @param {{onSuccess: function,onError: function,onFinish: function}} options
    */
   // TODO refactor this to use useAxios composable
   const storeComment = (comment, options = {}) => {
      axios
         .post(route("api.gallery.comments.store"), comment)
         .then((res) => {
            options?.onSuccess?.();
         })
         .catch((err) => {
            console.error(err);
            options?.onError?.();
         })
         .finally(() => {
            options?.onFinish?.();
         });
   };
   const addReply = () => {
      storeComment(
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
   /** @description delete comments
     @param {object} comment
     @param {{onSuccess: function,onError: function,onFinish: function}} options
    */
   const deleteComment = (comment, options) => {
      router.delete(route("comments.destroy", comment), {
         preserveScroll: true,
         preserveState: false,
         ...options,
      });
   };
   return {
      /* ------------------------------ exposed state ----------------------------- */
      /* ----------------------------- exposed getters ---------------------------- */
      /* ----------------------------- exposed actions ---------------------------- */
      storeComment,
      getComments,
      addReply,
      deleteComment,
   };
});

if (import.meta.hot) {
   import.meta.hot.accept(acceptHMRUpdate(useCommentStore, import.meta.hot));
}
