<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ElDatePicker } from 'element-plus';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import SuccessMessageModal from '@/Components/SuccessMessageModal.vue';
import UploadImageField from '@/Components/UploadImageField.vue';
import Avatar from '@/Components/Avatar.vue';
import Title from '@/Components/Title.vue';
import { PencilIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    user: Object,
    countries: Array,
    positions: Array,
});

const locale = usePage().props.locale;

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
        preserveScroll: false,
        onSuccess: () => {
            showSuccessMessage.value = true;
        },
    });
};

const showUploadAvatarModal = ref(false);
</script>

<template>
    <div class="w-full mt-8 sm:flex sm:justify-between sm:space-x-4 lg:grid lg:grid-cols-2">

        <div class="w-full p-6 bg-white rounded-md lg:col-start-2 ">
            <Title class="my-4">
                {{ $t('update') }}
            </Title>

            <form @submit.prevent="updateProfileInformation">
                <div class="flex items-center justify-center sm:justify-end sm:-mt-12">
                    <button class="relative mt-2" @click.prevent="showUploadAvatarModal = true">
                        <Avatar :image-url="user.avatar_url" :username="user.name" :border="true" :borderColor="state !== 'Premium' ? 'primary' : 'golden'"
                            size="xlg" :id="user.id" :enableLightBox="false" />
                        <div class="absolute bottom-0 p-1 rounded-full ltr:right-0 rtl:left-0 "
                            :class="state !== 'Premium' ? 'text-white bg-primary hover:bg-white hover:text-primary' : 'text-white bg-golden hover:bg-white hover:text-golden'">
                            <PencilIcon class="w-3 [&+div]:hover:block " />
                        </div>
                    </button>

                    <UploadImageField :current-image-url="user.avatar_url" :show="showUploadAvatarModal" :model-name="'\\App\\Models\\User'" :model-id="user.id"
                        :should-upload="true" collection-name="avatar" @close="showUploadAvatarModal = false" />
                </div>

                <div class="grid grid-cols-1 gap-4 mt-12 sm:grid-cols-2">
                    <div>
                        <InputLabel color="primary" for="first_name" :value="$t('First Name')" />
                        <TextInput type="text" :value="user.first_name" placeholder="Please enter your first name" auto-complete="given-name" aria-required="true"
                            :disabled="true" autofocus />
                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="last_name" :value="$t('Surname')" />
                        <TextInput type="text" :value="user.last_name" placeholder="Please enter your last name" auto-complete="sur-name" aria-required="true"
                            :disabled="true" />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="email" :value="$t('Email Address')" />
                        <TextInput type="email" :value="user.email" placeholder="Please enter your email address" auto-complete="email" aria-required="true"
                            :disabled="true" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="country" :value="$t('Country')" />
                        <RichSelectInput :options="countries" value-name="id" text-name="name" image-name="flag" v-model="form.country_id" />
                        <InputError class="mt-2" :message="form.errors.country_id" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="club" :value="$t('Favorite Club')" />
                        <RichSelectInput source="/api/clubs" value-name="id" text-name="name" image-name="logo" :append="user.club" v-model="form.club_id" />
                        <InputError class="mt-2" :message="form.errors.club_id" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="date_of_birth" :value="$t('Date of birth')" :disabled="true" />
                        <ElDatePicker v-model="form.date_of_birth" class="w-full" placeholde="DD/MM/YYYY" :disabled="true" />
                        <InputError class="mt-2" :message="form.errors.date_of_birth" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="phone" :value="$t('Phone')" />
                        <TextInput type="tel" :disabled="true" :value="user.phone" />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>
                    <div>
                        <InputLabel color="primary" for="username" :value="$t('Username')" />
                        <TextInput type="text" :value="user.username" v-model="form.username" placeholder="@" auto-complete="username" aria-required="true"
                            :disabled="true" />
                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>
                </div>

                <div class="mt-4 sm:flex sm:justify-between">
                    <div class="mt-4 sm:mt-0">
                        <div>
                            <InputLabel color="primary" :value="$t('gender')" />

                            <div class="mis-4">
                                <div class="flex items-center gap-x-2">
                                    <input type="radio" checked :id="user.gender" :value="user.gender" disabled v-model="form.gender"
                                        class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
                                    <label :for="user.gender" class="text-sm font-medium text-black">{{ $t(user.gender)
                                    }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <InputLabel color="primary" :value="$t('position')" />

                        <div class="mis-4">
                            <div class="flex items-center gap-x-2" v-for="position in positions">
                                <input type="radio" :id="position.name[locale]" :value="position.id" v-model="form.position_id"
                                    class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
                                <label :for="position.name[locale]" class="text-sm font-medium text-black">{{ position.name[locale]
                                }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <InputLabel color="primary" :value="$t('Preferred Foot')" />

                        <div class="mis-4">
                            <div class="flex items-center gap-x-2">
                                <input type="radio" id="left" value="left" v-model="form.preferred_foot"
                                    class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
                                <label for="left" class="text-sm font-medium text-black">{{ $t('left') }}</label>
                            </div>

                            <div class="flex items-center gap-x-2">
                                <input type="radio" id="right" value="right" v-model="form.preferred_foot"
                                    class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
                                <label for="right" class="text-sm font-medium text-black">{{ $t('right') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ $t('Update') }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>

    <SuccessMessageModal :show="showSuccessMessage" position="right" :title="$t('account')" message="Congratulations your account has been successfully updated."
        @close="showSuccessMessage = false" />
</template>
