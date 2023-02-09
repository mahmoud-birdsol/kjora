<script setup>
import { ref } from 'vue';
import { Inertia, Head } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ElDatePicker } from 'element-plus';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import AvatarInput from '@/Components/AvatarInput.vue';

const props = defineProps({
    user: Object,
    countries: Array,
    positions: Array,
});

const form = useForm({
    _method: 'PUT',
    // username: props.user.username,
    // email: props.user.email,
    // avatar: null,

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

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.avatar = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    Inertia.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <div class="w-full sm:flex sm:justify-between sm:space-x-4 mt-8">
        <div class="w-full sm:flex sm:justify-end sm:w-1/2">
            <div>
                <!--                <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>-->
                <!--                <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>-->
            </div>
        </div>
        <div class="bg-white rounded-md p-6 w-full sm:w-1/2">
            <div class="flex justify-center my-4">
                <h2 class="text-xl text-primary font-bold uppercase">My Account</h2>
            </div>

            <form @submit.prevent="updateProfileInformation">
                <div class="flex justify-center sm:justify-end items-center sm:-mt-12">
                    <AvatarInput v-model="form.avatar"/>
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
    <!--    <FormSection @submitted="updateProfileInformation">-->
    <!--        <template #title>-->
    <!--            Profile Information-->
    <!--        </template>-->

    <!--        <template #description>-->
    <!--            Update your account's profile information and email address.-->
    <!--        </template>-->

    <!--        <template #form>-->
    <!--            &lt;!&ndash; Profile Photo &ndash;&gt;-->
    <!--            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">-->
    <!--                &lt;!&ndash; Profile Photo File Input &ndash;&gt;-->
    <!--                <input-->
    <!--                    ref="photoInput"-->
    <!--                    type="file"-->
    <!--                    class="hidden"-->
    <!--                    @change="updatePhotoPreview"-->
    <!--                >-->

    <!--                <InputLabel for="photo" value="Photo" />-->

    <!--                &lt;!&ndash; Current Profile Photo &ndash;&gt;-->
    <!--                <div v-show="! photoPreview" class="mt-2">-->
    <!--                    <img :src="'/' + user.avatar" :alt="user.username" class="rounded-full h-20 w-20 object-cover">-->
    <!--                </div>-->

    <!--                &lt;!&ndash; New Profile Photo Preview &ndash;&gt;-->
    <!--                <div v-show="photoPreview" class="mt-2">-->
    <!--                    <span-->
    <!--                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"-->
    <!--                        :style="'background-image: url(\'' + photoPreview + '\');'"-->
    <!--                    />-->
    <!--                </div>-->

    <!--                <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">-->
    <!--                    Select A New Photo-->
    <!--                </SecondaryButton>-->

    <!--                <SecondaryButton-->
    <!--                    v-if="user.avatar"-->
    <!--                    type="button"-->
    <!--                    class="mt-2"-->
    <!--                    @click.prevent="deletePhoto"-->
    <!--                >-->
    <!--                    Remove Photo-->
    <!--                </SecondaryButton>-->

    <!--                <InputError :message="form.errors.avatar" class="mt-2" />-->
    <!--            </div>-->

    <!--            &lt;!&ndash; Name &ndash;&gt;-->
    <!--            <div class="col-span-6 sm:col-span-4">-->
    <!--                <InputLabel for="username" value="Username" />-->
    <!--                <TextInput-->
    <!--                    id="username"-->
    <!--                    v-model="form.username"-->
    <!--                    type="text"-->
    <!--                    class="mt-1 block w-full"-->
    <!--                    autocomplete="username"-->
    <!--                />-->
    <!--                <InputError :message="form.errors.username" class="mt-2" />-->
    <!--            </div>-->

    <!--            &lt;!&ndash; Email &ndash;&gt;-->
    <!--            <div class="col-span-6 sm:col-span-4">-->
    <!--                <InputLabel for="email" value="Email" />-->
    <!--                <TextInput-->
    <!--                    id="email"-->
    <!--                    v-model="form.email"-->
    <!--                    type="email"-->
    <!--                    class="mt-1 block w-full"-->
    <!--                />-->
    <!--                <InputError :message="form.errors.email" class="mt-2" />-->

    <!--                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">-->
    <!--                    <p class="text-sm mt-2">-->
    <!--                        Your email address is unverified.-->

    <!--                        <Link-->
    <!--                            :href="route('verification.send')"-->
    <!--                            method="post"-->
    <!--                            as="button"-->
    <!--                            class="underline text-gray-600 hover:text-gray-900"-->
    <!--                            @click.prevent="sendEmailVerification"-->
    <!--                        >-->
    <!--                            Click here to re-send the verification email.-->
    <!--                        </Link>-->
    <!--                    </p>-->

    <!--                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">-->
    <!--                        A new verification link has been sent to your email address.-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </template>-->

    <!--        <template #actions>-->
    <!--            <ActionMessage :on="form.recentlySuccessful" class="mr-3">-->
    <!--                Saved.-->
    <!--            </ActionMessage>-->

    <!--            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
    <!--                Save-->
    <!--            </PrimaryButton>-->
    <!--        </template>-->
    <!--    </FormSection>-->
</template>
