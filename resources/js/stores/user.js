import { usePage } from "@inertiajs/vue3";
import { defineStore, acceptHMRUpdate } from "pinia";
import { computed, ref } from "vue";

export const useUserStore = defineStore("User", () => {
   /* -------------------------------------------------------------------------- */
   /*                                  state                                     */
   /* -------------------------------------------------------------------------- */
   /** @type {import("vue").Ref<{username:string,id:number}[]>} */
   const users = ref([]);
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
   const getUsers = () => {
      axios
         .get(route("api.user.get.users.name"))
         .then((response) => {
            users.value = response.data.data;
         })
         .catch((error) => {
            console.error(error);
         });
   };
   return {
      /* ------------------------------ exposed state ----------------------------- */
      users,
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
