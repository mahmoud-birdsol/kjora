<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

const form = useForm({
	email: '',
})

const submit = () => {
	form.post(route('password.email'))
}
</script>

<template>
	<form
		@submit.prevent="submit"
		class="w-full mt-6">
		<div>
			<InputLabel
				color="primary"
				for="email"
				value="Email Address" />
			<TextInput
				id="email"
				v-model="form.email"
				type="email"
				class="mt-1 block w-full"
				placeholder="Please enter your email address."
				required
				autofocus />
			<InputError
				class="mt-2"
				:message="form.errors.email" />
		</div>

		<div class="flex items-center justify-end mt-4">
			<PrimaryButton
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing">
				Send
			</PrimaryButton>
		</div>
	</form>
</template>
