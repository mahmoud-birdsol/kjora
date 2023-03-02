<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import UploadImageField from '@/Components/UploadImageField.vue';
import Avatar from '@/Components/Avatar.vue';

import { ElDatePicker } from 'element-plus';
import { ref } from 'vue';

const props = defineProps(['countries', 'positions']);

const form = useForm({
    first_name: '',
    last_name: '',
    username: '',
    email: '',
    password: '',
    country_id: 121,
    club_id: 11,
    password_confirmation: '',
    date_of_birth: '',
    terms: true,
    phone: '',
    position_id: '',
    gender: '',
    preferred_foot: '',
    photo: null,
});

const showUploadAvatarModal = ref(false);
const avatarPreview = ref(null);

const setAvatarPreview = (photo) => {
    avatarPreview.value = photo;
};

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="flex justify-center sm:justify-end items-center sm:-mt-12">
            <button class="mt-2" @click.prevent="showUploadAvatarModal = true">
                <Avatar :image-url="avatarPreview" size="lg" />
            </button>

            <UploadImageField :should-upload="false" :show="showUploadAvatarModal" v-model="form.photo"
                @close="showUploadAvatarModal = false" @selected="setAvatarPreview" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
            <div>
                <InputLabel color="primary" for="first_name" value="First Name" />
                <TextInput type="text" v-model="form.first_name" placeholder="Please enter your first name"
                    auto-complete="given-name" aria-required="true" autofocus />
                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>
            <div>
                <InputLabel color="primary" for="last_name" value="Surname" />
                <TextInput type="text" v-model="form.last_name" placeholder="Please enter your last name"
                    auto-complete="sur-name" aria-required="true" />
                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>
            <div>
                <InputLabel color="primary" for="email" value="Email Address" />
                <TextInput type="text" v-model="form.email" placeholder="Please enter your email address"
                    auto-complete="email" aria-required="true" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <!-- TODO: change the icon  -->
                <InputLabel color="primary" for="password" value="Password" />
                <PasswordInput v-model="form.password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div>
                <InputLabel color="primary" for="country" value="Country" />
                <RichSelectInput :options="countries" value-name="id" text-name="name" image-name="flag"
                    v-model="form.country_id" />
                <InputError class="mt-2" :message="form.errors.country_id" />
            </div>
            <div>
                <InputLabel color="primary" for="club" value="Favorite Club" />
                <RichSelectInput source="/api/clubs" value-name="id" text-name="name" image-name="logo"
                    v-model="form.club_id" />
                <InputError class="mt-2" :message="form.errors.club_id" />
            </div>
            <div>
                <InputLabel color="primary" for="date_of_birth" value="Date of birth" />
                <ElDatePicker v-model="form.date_of_birth" class="w-full" placeholde="DD/MM/YYYY" />
                <InputError class="mt-6" :message="form.errors.date_of_birth" />
            </div>
            <div>
                <InputLabel color="primary" for="phone" value="Phone" />
                <PhoneInput :options="countries" value-name="id" text-name="name" image-name="flag" v-model="form.phone" />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>
            <div class="sm:col-span-2">
                <InputLabel color="primary" for="username" value="Username" />
                <TextInput type="text" v-model="form.username" placeholder="@" auto-complete="username"
                    aria-required="true" />
                <InputError class="mt-2" :message="form.errors.username" />
            </div>
        </div>

        <div class="sm:flex sm:justify-between mt-4">
            <div class="w-full sm:w-1/3 mt-4 sm:mt-0">
                <div>
                    <InputLabel color="primary" value="Gender" />

                    <div class="ml-4">
                        <div class="flex items-center space-x-2">
                            <input type="radio" id="male" value="male" v-model="form.gender"
                                class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                            <label for="male" class="text-sm text-black font-medium">Male</label>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="radio" id="female" value="female" v-model="form.gender"
                                class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                            <label for="female" class="text-sm text-black font-medium">Female</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-1/3 mt-4 sm:mt-0">
                <InputLabel color="primary" value="Position" />

                <div class="ml-4">
                    <div class="flex items-center space-x-2" v-for="position in positions">
                        <input type="radio" :id="position.name" :value="position.id" v-model="form.position_id"
                            class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                        <label :for="position.name" class="text-sm text-black font-medium">{{ position.name }}</label>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-1/3 mt-4 sm:mt-0">
                <InputLabel color="primary" value="Preferred Foot" />

                <div class="ml-4">
                    <div class="flex items-center space-x-2">
                        <input type="radio" id="left" value="left" v-model="form.preferred_foot"
                            class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                        <label for="left" class="text-sm text-black font-medium">Left</label>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="radio" id="right" value="right" v-model="form.preferred_foot"
                            class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary" />
                        <label for="right" class="text-sm text-black font-medium">Right</label>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
            <p class="text-xs text-black font-light">
                By signing up, you agree to the <a target="_blank" :href="route('terms.show')"
                    class="text-sky-500 hover:text-sky-700">Terms of Service</a> and
                <a target="_blank" :href="route('policy.show')" class="text-sky-500 hover:text-sky-700">Privacy Policy</a>
                including
                <Link class="text-sky-500 hover:text-sky-700">Cookie use</Link>
            </p>
        </div>

        <div class="mt-4">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </PrimaryButton>
        </div>
    </form>
</template>
