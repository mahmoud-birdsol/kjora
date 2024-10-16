<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { computed } from "vue";
import DateTranslation from "./DateTranslation.vue";
dayjs.extend(relativeTime);

const props = defineProps({
   notification: Object,
});

const borderColor = computed(() => {
   return {
      success: "border-green-500",
      warning: "border-amber-500",
      danger: "border-red-500",
      info: "border-sky-500",
   }[props.notification.data.state.toString()];
});

const readForm = useForm({})

const markAsRead = () => {
   readForm.patch(
      route("notification.read", { notificationId: props.notification.id }),
      {
         preserveState: true,
         preserveScroll: true,
      }
   );
};

const deleteForm = useForm({})

const deleteNotification = () => {
   deleteForm.delete(
      route("notification.delete", { notificationId: props.notification.id }),
      {
         preserveState: true,
         preserveScroll: true,
      }
   );
};
</script>

<template>
   <!--
                border-green-500
                border-amber-500
                border-red-500
                border-sky-500
            -->
   <li
      class="relative px-2 py-4 bg-white border-l-2 hover:bg-gray-50"
      :class="borderColor"
   >
      <div class="flex justify-between space-x-3">
         <div class="">
            <Link
               :href="notification.data.actionData.route"
               class="block focus:outline-none"
            >
               <p
                  class="text-sm truncate"
                  :class="{
                     'font-medium text-gray-700': notification.read_at == null,
                     'text-gray-500': notification.read_at != null,
                  }"
               >
                  {{ notification.data.title }}
               </p>
            </Link>
         </div>
         <div>
            <time
               :datetime="notification.created_at"
               class="flex-shrink-0 text-sm text-gray-500 whitespace-nowrap"
            >
               <DateTranslation type="range" :start="notification.created_at" />
            </time>
         </div>
      </div>
      <div class="mt-1">
         <p class="text-xs text-gray-500 line-clamp-2">
            {{ notification.data.subtitle }}
         </p>
      </div>
   </li>
</template>
