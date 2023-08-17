<script setup>
import { usePage } from "@inertiajs/vue3";
defineProps({
   type: {
      type: String,
      default: "submit",
   },
   disabled: Boolean,
});
</script>

<template>
   <button
      :type="type"
      :disabled="disabled"
      class="flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-center text-white uppercase transition border border-transparent rounded-full focus:ring ltr:tracking-widest focus:outline-none"
      :class="[
         'bg-black enabled:hover:bg-stone-800 active:bg-gray-900  focus:border-gray-900  disabled:bg-stone-500',
         'user-premium:bg-golden user-premium:enabled:hover:bg-golden/50 user-premium:focus:border-golden/90 user-premium:focus:ring-golden user-premium:disabled:bg-golden/30 disabled:bg-opacity-50',
      ]"
   >
      <slot />
   </button>
</template>
