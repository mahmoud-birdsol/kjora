<script setup>
import Avatar from "@/Components/Avatar.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RichSelectInput from "@/Components/RichSelectInput.vue";
import SuccessMessageModal from "@/Components/SuccessMessageModal.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Title from "@/Components/Title.vue";
import UploadImageField from "@/Components/UploadImageField.vue";
import { PencilIcon } from "@heroicons/vue/24/solid";
import { useForm, usePage } from "@inertiajs/vue3";
import { ElDatePicker } from "element-plus";
import { ref, computed } from "vue";
import { useUserStore } from "@/stores";
const props = defineProps({
   countries: Array,
   positions: Array,
});

const locale = usePage().props.locale;
const userStore = useUserStore();

const form = useForm({
   _method: "PUT",
   first_name: userStore.currentUser.first_name,
   last_name: userStore.currentUser.last_name,
   username: userStore.currentUser.username,
   email: userStore.currentUser.email,
   country_id: userStore.currentUser.country_id,
   club_id: userStore.currentUser.club_id,
   password_confirmation: userStore.currentUser.password_confirmation,
   date_of_birth: userStore.currentUser.date_of_birth,
   terms: true,
   phone: userStore.currentUser.phone,
   position_id: userStore.currentUser.position_id,
   gender: userStore.currentUser.gender,
   preferred_foot: userStore.currentUser.preferred_foot,
   avatar: userStore.currentUser.avatar_url,
});

const showSuccessMessage = ref(false);
const state = computed(() => userStore.currentUser.state_name);

const updateProfileInformation = () => {
   form.post(route("user-profile-information.update"), {
      errorBag: "updateProfileInformation",
      preserveScroll: false,
      onSuccess: () => {
         showSuccessMessage.value = true;
      },
   });
};

const showUploadAvatarModal = ref(false);
</script>

<template>
   <div
      class="w-full mt-8 sm:flex sm:justify-between sm:space-x-4 lg:grid lg:grid-cols-2"
   >
      <div class="w-full p-6 bg-white rounded-md lg:col-start-2">
         <Title class="my-4">
            {{ $t("update") }}
         </Title>

         <form @submit.prevent="updateProfileInformation">
            <div
               class="flex items-center justify-center sm:justify-end sm:-mt-12"
            >
               <button
                  class="relative mt-2"
                  @click.prevent="showUploadAvatarModal = true"
               >
                  <Avatar
                     :image-url="userStore.currentUser.avatar_url"
                     :username="userStore.currentUser.name"
                     :border="true"
                     :borderColor="state !== 'Premium' ? 'primary' : 'golden'"
                     size="xlg"
                     :id="userStore.currentUser.id"
                     :enableLightBox="false"
                  />
                  <div
                     class="absolute bottom-0 p-1 rounded-full ltr:right-0 rtl:left-0"
                     :class="
                        state !== 'Premium'
                           ? 'text-white bg-primary hover:bg-white hover:text-primary'
                           : 'text-white bg-golden hover:bg-white hover:text-golden'
                     "
                  >
                     <PencilIcon class="w-3 [&+div]:hover:block" />
                  </div>
               </button>

               <UploadImageField
                  :current-image-url="userStore.currentUser.avatar_url"
                  :show="showUploadAvatarModal"
                  :model-name="'\\App\\Models\\User'"
                  :model-id="userStore.currentUser.id"
                  :should-upload="true"
                  collection-name="avatar"
                  @close="showUploadAvatarModal = false"
               />
            </div>

            <div class="grid grid-cols-1 gap-4 mt-12 sm:grid-cols-2">
               <div>
                  <InputLabel
                     color="primary"
                     for="first_name"
                     :value="$t('First Name')"
                  />
                  <TextInput
                     type="text"
                     :value="userStore.currentUser.first_name"
                     placeholder="Please enter your first name"
                     auto-complete="given-name"
                     aria-required="true"
                     :disabled="true"
                     autofocus
                  />
                  <InputError class="mt-2" :message="form.errors.first_name" />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="last_name"
                     :value="$t('Surname')"
                  />
                  <TextInput
                     type="text"
                     :value="userStore.currentUser.last_name"
                     placeholder="Please enter your last name"
                     auto-complete="sur-name"
                     aria-required="true"
                     :disabled="true"
                  />
                  <InputError class="mt-2" :message="form.errors.last_name" />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="email"
                     :value="$t('Email Address')"
                  />
                  <TextInput
                     type="email"
                     :value="userStore.currentUser.email"
                     placeholder="Please enter your email address"
                     auto-complete="email"
                     aria-required="true"
                     :disabled="true"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="country"
                     :value="$t('Country')"
                  />
                  <RichSelectInput
                     :options="countries"
                     value-name="id"
                     text-name="name"
                     image-name="flag"
                     v-model="form.country_id"
                  />
                  <InputError class="mt-2" :message="form.errors.country_id" />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="club"
                     :value="$t('Favorite Club')"
                  />
                  <RichSelectInput
                     source="/api/clubs"
                     value-name="id"
                     text-name="name"
                     image-name="logo"
                     :append="userStore.currentUser.club"
                     v-model="form.club_id"
                  />
                  <InputError class="mt-2" :message="form.errors.club_id" />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="date_of_birth"
                     :value="$t('date-of-birth')"
                     :disabled="true"
                  />
                  <ElDatePicker
                     v-model="form.date_of_birth"
                     class="w-full"
                     placeholde="DD/MM/YYYY"
                     :disabled="true"
                  />
                  <InputError
                     class="mt-2"
                     :message="form.errors.date_of_birth"
                  />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="phone"
                     :value="$t('Phone')"
                  />
                  <TextInput
                     type="tel"
                     :disabled="true"
                     :value="userStore.currentUser.phone"
                  />
                  <InputError class="mt-2" :message="form.errors.phone" />
               </div>
               <div>
                  <InputLabel
                     color="primary"
                     for="username"
                     :value="$t('Username')"
                  />
                  <TextInput
                     type="text"
                     :value="userStore.currentUser.username"
                     v-model="form.username"
                     placeholder="@"
                     auto-complete="username"
                     aria-required="true"
                     :disabled="true"
                  />
                  <InputError class="mt-2" :message="form.errors.username" />
               </div>
            </div>

            <div class="mt-4 sm:flex sm:justify-between">
               <div class="mt-4 sm:mt-0">
                  <div>
                     <InputLabel color="primary" :value="$t('gender')" />

                     <div class="mis-4">
                        <div class="flex items-center gap-x-2">
                           <input
                              type="radio"
                              checked
                              :id="userStore.currentUser.gender"
                              :value="userStore.currentUser.gender"
                              disabled
                              v-model="form.gender"
                              class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"
                           />
                           <InputLabel
                              :for="userStore.currentUser.gender"
                              color="black"
                              >{{
                                 $t(userStore.currentUser.gender)
                              }}</InputLabel
                           >
                        </div>
                     </div>
                  </div>
               </div>
               <div class="mt-4 sm:mt-0">
                  <InputLabel color="primary" :value="$t('position')" />

                  <div class="mis-4">
                     <div
                        class="flex items-center gap-x-2"
                        v-for="position in positions"
                     >
                        <input
                           type="radio"
                           :id="position.name[locale]"
                           :value="position.id"
                           v-model="form.position_id"
                           class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"
                        />
                        <InputLabel
                           :for="position.name[locale]"
                           color="black"
                           >{{ position.name[locale] }}</InputLabel
                        >
                     </div>
                  </div>
               </div>
               <div class="mt-4 sm:mt-0">
                  <InputLabel color="primary" :value="$t('preferred-foot')" />

                  <div class="mis-4">
                     <div class="flex items-center gap-x-2">
                        <input
                           type="radio"
                           id="left"
                           value="left"
                           v-model="form.preferred_foot"
                           class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"
                        />
                        <InputLabel for="left" color="black">{{
                           $t("left")
                        }}</InputLabel>
                     </div>

                     <div class="flex items-center gap-x-2">
                        <input
                           type="radio"
                           id="right"
                           value="right"
                           v-model="form.preferred_foot"
                           class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"
                        />
                        <InputLabel for="right" color="black">{{
                           $t("right")
                        }}</InputLabel>
                     </div>
                  </div>
               </div>
            </div>

            <div class="mt-4">
               <PrimaryButton
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
               >
                  {{ $t("Update") }}
               </PrimaryButton>
            </div>
         </form>
      </div>
   </div>

   <SuccessMessageModal
      :show="showSuccessMessage"
      position="right"
      :title="$t('account')"
      :message="
         $t('congratulations-your-account-has-been-successfully-updated')
      "
      @close="showSuccessMessage = false"
   />
</template>
