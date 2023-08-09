import { usePage } from "@inertiajs/vue3";
import { defineStore, acceptHMRUpdate } from "pinia";
import { computed } from "vue";

export const useUserStore = defineStore("User", () => {
   /* -------------------------------------------------------------------------- */
   /*                                  state                                     */
   /* -------------------------------------------------------------------------- */

   /* -------------------------------------------------------------------------- */
   /*                                 getters                                    */
   /* -------------------------------------------------------------------------- */
   const currentUser = computed(() => usePage().props.auth.user);
   /* -------------------------------------------------------------------------- */
   /*                                 actions                                    */
   /* -------------------------------------------------------------------------- */
   /** @description check if any user is the current logged-in user (auth user) */
   const isCurrentUser = (user) => currentUser.value.id === user.id;

   /**
    * @description get all users except the current user ,as {username,id}
    * @returns {{username:string,id:number}[]}
    */
   const getUsers = async () => {
      try {
         const response = await axios.get(route("api.user.get.users.name"));
         return response.data.data;
      } catch (error) {
         console.error(error);
      }
   };
   return {
      /* ------------------------------ exposed state ----------------------------- */
      /* ----------------------------- exposed getters ---------------------------- */
      currentUser,
      /* ----------------------------- exposed actions ---------------------------- */
      isCurrentUser,
      getUsers,
   };
});

if (import.meta.hot) {
   import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot));
}
