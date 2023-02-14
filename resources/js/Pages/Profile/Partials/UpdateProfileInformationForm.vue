<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ElDatePicker } from 'element-plus';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import SuccessMessageModal from '@/Components/SuccessMessageModal.vue';
import UploadImageField from '@/Components/UploadImageField.vue';
import Avatar from '@/Components/Avatar.vue';

const props = defineProps({
    user: Object,
    countries: Array,
    positions: Array,
});

const form = useForm({
    _method: 'PUT',
    first_name: props.user.first_name,
    last_name: props.user.last_name,
    username: props.user.username,
    email: props.user.email,
    country_id: props.user.country_id,
    club_id: props.user.club_id,
    password_confirmation: props.user.password_confirmation,
    date_of_birth: props.user.date_of_birth,
    terms: true,
    phone: props.user.phone,
    position_id: props.user.position_id,
    gender: props.user.gender,
    preferred_foot: props.user.preferred_foot,
    avatar: props.user.avatar_url,
});

const showSuccessMessage = ref(false);

const updateProfileInformation = () => {
    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => {
            showSuccessMessage.value = true;
        },
    });
};

const showUploadAvatarModal = ref(false);
</script>

<template>
    <div class="w-full sm:flex sm:justify-between sm:space-x-4 mt-8">
        <div class="w-full sm:flex sm:justify-end sm:w-1/2">
        </div>
        <div class="bg-white rounded-md p-6 w-full sm:w-1/2">
            <div class="flex justify-center my-4">
                <h2 class="text-xl text-primary font-bold uppercase">My Account</h2>
            </div>

            <form @submit.prevent="updateProfileInformation">
                <div class="flex justify-center sm:justify-end items-center sm:-mt-12">
                    <button class="mt-2" @click.prevent="showUploadAvatarModal = true">
                        <Avatar
                            :image-url="user.avatar_url"
                            :username="user.name"
                            size="lg"/>
                    </button>

                    <UploadImageField
                        :current-image-url="user.avatar_url"
                        :show="showUploadAvatarModal"
                        :model-name="'\\App\\Models\\User'"
                        :model-id="user.id"
                        :should-upload="true"
                        collection-name="avatar"
                        @close="showUploadAvatarModal = false"
                    />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
                    <div>
                        <InputLabel color="primary" for="first_name" value="First Name"/>
                        <TextInput type="text"
                                   v-model="form.first_name"
                                   placeholder="Please enter your first name"
                                   auto-complete="given-name"
                                   aria-required="true"
                                   autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.first_name"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="last_name" value="Surname"/>
                        <TextInput type="text"
                                   v-model="form.last_name"
                                   placeholder="Please enter your last name"
                                   auto-complete="sur-name"
                                   aria-required="true"
                        />
                        <InputError class="mt-2" :message="form.errors.last_name"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="email" value="Email Address"/>
                        <TextInput type="email"
                                   v-model="form.email"
                                   placeholder="Please enter your email address"
                                   auto-complete="email"
                                   aria-required="true"
                                   :disabled="true"
                        />
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="country" value="Country"/>
                        <RichSelectInput :options="countries"
                                         value-name="id"
                                         text-name="name"
                                         image-name="flag"
                                         v-model="form.country_id"/>
                        <InputError class="mt-2" :message="form.errors.country_id"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="club" value="Favorite Club"/>
                        <RichSelectInput source="/api/clubs"
                                         value-name="id"
                                         text-name="name"
                                         image-name="logo"
                                         :append="user.club"
                                         v-model="form.club_id"/>
                        <InputError class="mt-2" :message="form.errors.club_id"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="date_of_birth" value="Date of birth"/>
                        <ElDatePicker v-model="form.date_of_birth" class="w-full" placeholde="DD/MM/YYYY"/>
                        <InputError class="mt-2" :message="form.errors.date_of_birth"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="phone" value="Phone"/>
                        <TextInput type="tel"
                                   :disabled="true"
                                   v-model="form.phone"/>
                        <InputError class="mt-2" :message="form.errors.phone"/>
                    </div>
                    <div>
                        <InputLabel color="primary" for="username" value="Username"/>
                        <TextInput type="text"
                                   v-model="form.username"
                                   placeholder="@"
                                   auto-complete="username"
                                   aria-required="true"
                                   :disabled="true"
                        />
                        <InputError class="mt-2" :message="form.errors.username"/>
                    </div>
                </div>

                <div class="sm:flex sm:justify-between mt-4">
                    <div class="w-full sm:w-1/3 mt-4 sm:mt-0">
                        <div>
                            <InputLabel color="primary" value="Gender"/>

                            <div class="ml-4">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" id="male" value="male" v-model="form.gender"
                                           class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                    <label for="male" class="text-sm text-black font-medium">Male</label>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <input type="radio" id="female" value="female" v-model="form.gender"
                                           class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                    <label for="female" class="text-sm text-black font-medium">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/3 mt-4 sm:mt-0">
                        <InputLabel color="primary" value="Position"/>

                        <div class="ml-4">
                            <div class="flex items-center space-x-2" v-for="position in positions">
                                <input type="radio" :id="position.name" :value="position.id"
                                       v-model="form.position_id"
                                       class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                <label :for="position.name"
                                       class="text-sm text-black font-medium">{{ position.name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/3 mt-4 sm:mt-0">
                        <InputLabel color="primary" value="Preferred Foot"/>

                        <div class="ml-4">
                            <div class="flex items-center space-x-2">
                                <input type="radio" id="left" value="left" v-model="form.preferred_foot"
                                       class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                <label for="left" class="text-sm text-black font-medium">Left</label>
                            </div>

                            <div class="flex items-center space-x-2">
                                <input type="radio" id="right" value="right" v-model="form.preferred_foot"
                                       class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                <label for="right" class="text-sm text-black font-medium">Right</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                   :disabled="form.processing">
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>

    <SuccessMessageModal
        :show="showSuccessMessage"
        position="right"
        title="Account"
        message="Congratulations your account has been successfully updated."
        @close="showSuccessMessage = false"
    />
</template>
