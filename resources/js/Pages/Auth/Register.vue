<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';

import { ElDatePicker } from 'element-plus';

const props = defineProps(['countries', 'clubs', 'positions']);

const form = useForm({
    first_name: '',
    last_name: '',
    username: '',
    email: '',
    password: '',
    country_id: '',
    club_id: '',
    password_confirmation: '',
    date_of_birth: '',
    terms: true,
    phone: '',
    position_id: '',
    gender: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register"/>

    <GuestLayout>
        <div class="w-full sm:flex sm:justify-between sm:space-x-4 px-4 sm:px-8">
            <div class="w-full sm:flex sm:justify-end sm:w-1/2">
                <div>
                    <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>
                    <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
                </div>
            </div>
            <div class="bg-white rounded-md p-6 w-full sm:w-1/2">
                <div class="flex justify-center my-4">
                    <h2 class="text-xl text-primary font-bold uppercase">Create an account</h2>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                            <TextInput type="text"
                                       v-model="form.email"
                                       placeholder="Please enter your email address"
                                       auto-complete="email"
                                       aria-required="true"
                            />
                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>
                        <div>
                            <InputLabel color="primary" for="password" value="Password"/>
                            <PasswordInput v-model="form.password"/>
                            <InputError class="mt-2" :message="form.errors.password"/>
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
                            <RichSelectInput :options="clubs"
                                             value-name="id"
                                             text-name="name"
                                             image-name="logo"
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
                            <PhoneInput :options="countries"
                                        value-name="id"
                                        text-name="name"
                                        image-name="flag"
                                        v-model="form.phone"/>
                            <InputError class="mt-2" :message="form.errors.phone"/>
                        </div>
                        <div class="sm:col-span-2">
                            <InputLabel color="primary" for="username" value="Username"/>
                            <TextInput type="text"
                                       v-model="form.username"
                                       placeholder="@"
                                       auto-complete="username"
                                       aria-required="true"
                            />
                            <InputError class="mt-2" :message="form.errors.username"/>
                        </div>
                    </div>

                    <div class="sm:flex sm:space-x-6 mt-4">
                        <div>
                            <InputLabel color="primary" value="Gender"/>

                            <div class="sm:flex sm:justify-start items-center sm:space-x-4">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" id="male" value="male" v-model="form.gender" class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                    <label for="male" class="text-sm text-black font-medium">Male</label>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <input type="radio" id="female" value="Female" v-model="form.gender"  class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                    <label for="female" class="text-sm text-black font-medium">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 sm:mt-0">
                            <InputLabel color="primary" value="Position"/>

                            <div class="sm:flex sm:justify-start items-center sm:space-x-4">
                                <div class="flex items-center space-x-2" v-for="position in positions">
                                    <input type="radio" :id="position.name" :value="position.id" v-model="form.position_id" class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"/>
                                    <label :for="position.name" class="text-sm text-black font-medium">{{ position.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                        <p class="text-xs text-black font-light">
                            By signing up, you agree to the <a target="_blank" :href="route('terms.show')" class="text-sky-500 hover:text-sky-700">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="text-sky-500 hover:text-sky-700">Privacy Policy</a> including <Link class="text-sky-500 hover:text-sky-700">Cookie use</Link>
                        </p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            Already registered?
                        </Link>
                    </div>

                    <div class="mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style>

.el-input__inner {
    height: 42px !important;
}

.el-form-item__label {
    color: rgb(0, 100, 0) !important;
}

.el-checkbox__label {
    color: rgb(0, 100, 0) !important;
}

.el-input__wrapper {
    width: 100%;
    height: 42px !important;
    border-radius: 25px;
    padding-left: 20px;
    padding-right: 20px;
}

.el-input {
    width: 100% !important;
}

.el-picker__popper {
    background-color: black !important;
    color: green !important;
}

.el-picker-panel{
    background-color: black !important;
    color: green !important;
}

.el-picker-panel__body-wrapper, .el-date-picker__header-label, .el-picker-panel__icon-btn, .el-picker-panel__content, .el-date-table > tbody > tr > th {
    color: green !important;
}

.el-picker-panel__body{
    color: green !important;
}

.el-date-picker__header{
    color: green !important;
}

.el-date-picker__prev-btn {
    color: green !important;
}

.el-date-picker__next-btn{
    color: green !important;
}
</style>
