<script setup>
import { computed, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import GuestTwoColumnLayout from "@/Layouts/Partials/GuestTwoColumnLayout.vue";
import Card from "@/Components/Card.vue";
import CardContent from "@/Components/CardContent.vue";
import VerifyEmailForm from "@/Pages/Auth/Forms/VerifyEmailForm.vue";
import SuccessMessageModal from "@/Components/SuccessMessageModal.vue";

const props = defineProps({
   status: String,
});

const showSuccessModal = ref(true)

const verificationLinkSent = computed(
   () => props.status === "verification-link-sent"
);
</script>

<template>
   <Head title="Email Verification" />

   <GuestLayout>
      <GuestTwoColumnLayout>
         <Card>
            <CardContent :title="$t('Verify Email Address')">
               <template #body>
                  <div class="flex items-center justify-center">
                     <p class="text-xs text-gary-900">
                        {{
                           $t(
                              "we-have-sent-you-an-email-please-click-on-the-provided-link-to-verify-your-email-address"
                           )
                        }}.
                     </p>
                  </div>
               </template>

               <template #footer>
                  <div
                     class="flex items-center self-end justify-center w-full mt-12"
                  >
                     <VerifyEmailForm />
                  </div>
               </template>
            </CardContent>
         </Card>
      </GuestTwoColumnLayout>

      <SuccessMessageModal
         :show="verificationLinkSent && showSuccessModal"
         @close="showSuccessModal = false"
         position="right"
         :title="$t('email-verification')"
         :message="
            $t(
               'a-new-verification-link-has-been-sent-to-the-email-address-you-provided-in-your-profile-settings'
            ) + '.'
         "
      />
   </GuestLayout>
</template>
