<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";

const props = defineProps({
   user: Object,
   token: String,
});

const form = useForm({
   name: props.user.name,
   email: props.user.email,
   password: "",
   password_confirmation: "",
   terms: true,
});

const submit = () => {
   form.post(route("join-platform.store", props.token), {
      onFinish: () => form.reset("password", "password_confirmation"),
   });
};
</script>

<template>
   <Head title="Accept Invitation" />

   <GuestLayout>
      <div class="w-full px-4 sm:flex sm:justify-between sm:space-x-4 sm:px-8">
         <div class="w-full sm:flex sm:justify-end sm:w-1/2">
            <div>
               <h2 class="text-2xl font-light text-white uppercase">
                  Welcome to
               </h2>
               <h1 class="text-6xl font-black text-white uppercase">KJORA</h1>
            </div>
         </div>
         <div class="w-full p-6 bg-white rounded-md sm:w-1/2">
            <div class="flex justify-center my-4">
               <h2 class="text-xl font-bold uppercase text-primary">
                  Create an account
               </h2>
            </div>

            <form @submit.prevent="submit">
               <div>
                  <InputLabel color="primary" for="name" value="Name" />
                  <TextInput
                     id="name"
                     v-model="form.name"
                     type="text"
                     class="block w-full mt-1"
                     required
                     autofocus
                     autocomplete="name"
                  />
                  <InputError class="mt-2" :message="form.errors.name" />
               </div>

               <div class="mt-4">
                  <InputLabel color="primary" for="email" value="Email" />
                  <TextInput
                     id="email"
                     v-model="form.email"
                     type="email"
                     class="block w-full mt-1"
                     disabled="true"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
               </div>

               <div class="mt-4">
                  <InputLabel color="primary" for="password" value="Password" />
                  <PasswordInput v-model="form.password" />
                  <InputError class="mt-2" :message="form.errors.password" />
               </div>

               <div class="mt-4">
                  <InputLabel
                     color="primary"
                     for="password_confirmation"
                     value="Confirm Password"
                  />
                  <PasswordInput v-model="form.password_confirmation" />
                  <InputError
                     class="mt-2"
                     :message="form.errors.password_confirmation"
                  />
               </div>

               <div
                  v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                  class="mt-4"
               >
                  <p class="text-xs font-light text-black">
                     {{ $("by-signing-up-you-agree-to-the") }}
                     <a
                        target="_blank"
                        :href="route('terms.and.condition.index')"
                        class="text-sky-500 hover:text-sky-700"
                        >terms-of-service</a
                     >
                     and
                     <a
                        target="_blank"
                        :href="route('privacy.policy.index')"
                        class="text-sky-500 hover:text-sky-700"
                        >privacy-policy</a
                     >
                     including
                     <Link
                        class="text-sky-500 hover:text-sky-700"
                        :href="route('cookies.policy.index')"
                        >Cookie use</Link
                     >
                  </p>
               </div>

               <div class="mt-4">
                  <PrimaryButton
                     :class="{ 'opacity-25': form.processing }"
                     :disabled="form.processing"
                  >
                     Join
                  </PrimaryButton>
               </div>
            </form>
         </div>
      </div>
   </GuestLayout>
</template>
