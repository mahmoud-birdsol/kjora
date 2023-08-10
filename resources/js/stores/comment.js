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

   /* -- general comments actions that can be used with any model has comments - */

   /** @description get comments for any model
    * @param {{  commentable_id: number,
               commentable_type: string,}} data
                   @param {{onSuccess: function,onError: function,onFinish: function}} options
    */

   // TODO refactor this to use useAxios composable
   const getComments = async (data, options) => {
      let comments;
      try {
         let response = await axios.get(route("api.gallery.comments"), {
            params: data,
         });
         options?.onSuccess?.();
         comments = response.data.data;
      } catch (err) {
         options?.onError?.();
         console.log(err);
      } finally {
         options?.onFinish?.();
      }
      return comments;
   };
   /** @description store comment in database
    * @param {{
    *   commentable_id: post.value.id,
            commentable_type: string,
            body: string,
            user_id: number,
            parent_id?: number,
    * }} comment
            @param {import("@inertiajs/core/types/types").VisitOptions} options
    */
   // TODO refactor this to use useAxios composable
   const storeComment = (comment, options = {}) => {
      console.log("storing comment");
      router.post(route("comments.store"), comment, {
         preserveScroll: true,
         preserveState: true,
         ...options,
      });
   };
   /** @description delete comments
     @param {object} comment
     @param {import("@inertiajs/core/types/types").VisitOptions} options
    */
   const deleteComment = (comment, options) => {
      router.delete(route("comments.destroy", comment), {
         preserveScroll: true,
         preserveState: true,
         ...options,
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

   const scrollCommentIntoView = (params) => {};
   return {
      /* ------------------------------ exposed state ----------------------------- */
      /* ----------------------------- exposed getters ---------------------------- */
      /* ----------------------------- exposed actions ---------------------------- */
      storeComment,
      getComments,
      addReply,
      deleteComment,
      scrollCommentIntoView,
   };
});

if (import.meta.hot) {
   import.meta.hot.accept(acceptHMRUpdate(useCommentStore, import.meta.hot));
}
