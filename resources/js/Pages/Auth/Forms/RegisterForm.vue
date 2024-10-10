<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import PasswordInput from '@/Components/PasswordInput.vue'
import RichSelectInput from '@/Components/RichSelectInput.vue'
import PhoneInput from '@/Components/PhoneInput.vue'
import UploadImageField from '@/Components/UploadImageField.vue'
import Avatar from '@/Components/Avatar.vue'

import { ElDatePicker } from 'element-plus'
import { computed, onMounted, ref } from 'vue'

const props = defineProps([
	'countries',
	'positions',
	'defaultClub',
	'defaultCountryId',
])

const value = ref('2021-10-29')
const form = useForm({
	first_name: '',
	last_name: '',
	username: '',
	email: '',
	password: '',
	country_id: props.defaultCountryId ?? 121,
	club_id: props.defaultClub?.id ?? 1,
	password_confirmation: '',
	date_of_birth: '2002-01-01',
	terms: true,
	phone: '',
	position_id: '',
	gender: '',
	preferred_foot: '',
	photo: null,
})

const showUploadAvatarModal = ref(false)
const avatarPreview = ref(null)

const setAvatarPreview = (photo) => {
	avatarPreview.value = photo
}

const submit = () => {
	form.post(route('register'), {
		onFinish: () => form.reset('password'),
	})
}

onMounted(() => {
	console.log(props.positions)
})

const locale = usePage().props.locale
</script>

<template>
	<form
		@submit.prevent="submit"
		@keypress.enter.exact.prevent="submit"
		class="tracking-tight">
		<div class="flex items-center justify-center sm:justify-end sm:-mt-12">
			<button
				class="mt-2"
				@click.prevent="showUploadAvatarModal = true">
				<Avatar
					:image-url="avatarPreview"
					size="lg"
					:id="0"
					:enableLightBox="false" />
			</button>

			<UploadImageField
				:should-upload="false"
				:show="showUploadAvatarModal"
				v-model="form.photo"
				:currentImageUrl="avatarPreview"
				@close="showUploadAvatarModal = false"
				@selected="setAvatarPreview" />
		</div>

		<div class="grid grid-cols-1 gap-4 mt-12 tracking-tight sm:grid-cols-2">
			<div>
				<InputLabel
					color="primary"
					for="first_name"
					:value="$t('first-name')" />
				<TextInput
					type="text"
					v-model="form.first_name"
					:placeholder="$t('please enter your first name')"
					auto-complete="given-name"
					name="sur-name"
					aria-required="true"
					autofocus />
				<InputError
					class="mt-2"
					:message="form.errors.first_name" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="last_name"
					:value="$t('surname')" />
				<TextInput
					type="text"
					v-model="form.last_name"
					:placeholder="$t('please enter your last name')"
					auto-complete="sur-name"
					name="sur-name"
					aria-required="true" />
				<InputError
					class="mt-2"
					:message="form.errors.last_name" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="email"
					:value="$t('email')" />
				<TextInput
					type="text"
					v-model="form.email"
					:placeholder="$t('please enter your email address')"
					auto-complete="email"
					name="email"
					aria-required="true" />
				<InputError
					class="mt-2"
					:message="form.errors.email" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="password"
					:value="$t('password')" />
				<PasswordInput
					v-model="form.password"
					:placeholder="$t('please enter a password')" />
				<InputError
					class="mt-2"
					:message="form.errors.password" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="country"
					:value="$t('nationality')" />
				<RichSelectInput
					:options="countries"
					value-name="id"
					text-name="name"
					image-name="flag"
					v-model="form.country_id" />
				<InputError
					class="mt-2"
					:message="form.errors.country_id" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="club"
					:value="$t('favorite-club')" />
				<RichSelectInput
					source="/api/clubs"
					value-name="id"
					text-name="name"
					image-name="logo"
					:append="defaultClub"
					v-model="form.club_id" />
				<InputError
					class="mt-2"
					:message="form.errors.club_id" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="date_of_birth"
					:value="$t('Date of birth')" />
				<ElDatePicker
					class="w-full"
					v-model="form.date_of_birth"
					type="date"
					placeholder="Pick a day"
					format="YYYY / MM / DD"
					value-format="YYYY-MM-DD" />
				<InputError
					class="mt-6"
					:message="form.errors.date_of_birth" />
			</div>
			<div>
				<InputLabel
					color="primary"
					for="phone"
					:value="$t('phone')" />
				<PhoneInput
					:options="countries"
					value-name="id"
					text-name="name"
					image-name="flag"
					v-model="form.phone" />
				<InputError
					class="mt-2"
					:message="form.errors.phone" />
			</div>
			<div class="sm:col-span-2">
				<div>
					<InputLabel
						color="primary"
						id="username"
						for="username"
						:value="$t('username')" />
					<TextInput
						type="text"
						v-model="form.username"
						placeholder="username"
						autocomplete="username"
						name="username"
						aria-labelledby="username"
						aria-required="true" />
					<InputError
						class="mt-2"
						:message="form.errors.username" />
				</div>
			</div>
		</div>

		<div class="mt-4 sm:flex sm:justify-between">
			<div class="mt-4 sm:mt-0">
				<div>
					<InputLabel
						color="primary"
						:value="$t('gender')" />

					<div class="mis-5">
						<div class="flex items-center gap-x-2">
							<input
								type="radio"
								id="male"
								value="male"
								v-model="form.gender"
								class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
							<label
								for="male"
								class="text-sm font-medium text-black"
								>{{ $t('male') }}</label
							>
						</div>

						<div class="flex items-center gap-x-2">
							<input
								type="radio"
								id="female"
								value="female"
								v-model="form.gender"
								class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
							<label
								for="female"
								class="text-sm font-medium text-black"
								>{{ $t('female') }}</label
							>
						</div>
					</div>
				</div>
			</div>
			<div class="mt-4 sm:mt-0">
				<InputLabel
					color="primary"
					:value="$t('position')" />

				<div class="mis-5">
					<div
						class="flex items-center gap-x-2"
						v-for="position in positions">
						<input
							type="radio"
							:id="position?.name[locale]"
							:value="position.id"
							v-model="form.position_id"
							class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
						<label
							:for="position?.name[locale]"
							class="text-sm font-medium text-black"
							>{{ position?.name[locale] }}</label
						>
					</div>
				</div>
			</div>
			<div class="mt-4 sm:mt-0">
				<InputLabel
					color="primary"
					:value="$t('Preferred Foot')" />

				<div class="mis-5">
					<div class="flex items-center gap-x-2">
						<input
							type="radio"
							id="left"
							value="left"
							v-model="form.preferred_foot"
							class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
						<label
							for="left"
							class="text-sm font-medium text-black"
							>{{ $t('left') }}</label
						>
					</div>

					<div class="flex items-center gap-x-2">
						<input
							type="radio"
							id="right"
							value="right"
							v-model="form.preferred_foot"
							class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
						<label
							for="right"
							class="text-sm font-medium text-black"
							>{{ $t('right') }}</label
						>
					</div>
				</div>
			</div>
		</div>

		<div
			v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
			class="mt-4">
			<p class="text-xs font-light text-black">
				{{ $t('By signing up, you agree to the') }}
				<a
					target="_blank"
					:href="route('terms.and.condition.index')"
					class="font-bold text-blue-500 hover:text-blue-700"
					>{{ $t('Terms of Service') }}</a
				>
				{{ $t('and') }}
				<a
					target="_blank"
					:href="route('privacy.policy.index')"
					class="font-bold text-blue-500 hover:text-blue-700"
					>{{ $t('Privacy Policy') }}</a
				>
				{{ $t('including') }}
				<a
					target="_blank"
					:href="route('cookies.policy.index')"
					class="font-bold text-blue-500 hover:text-blue-700"
					>{{ $t('cookies') }}</a
				>
			</p>
		</div>

		<div class="mt-4">
			<PrimaryButton
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing">
				{{ $t('register') }}
			</PrimaryButton>
		</div>
	</form>
</template>
