<script setup lang="ts">
import { PencilIcon } from '@heroicons/vue/24/outline'
import { type VisitOptions } from '@inertiajs/core'
import axios from 'axios'
import { Primitive } from 'radix-vue'
type Model = Team
const props = defineProps<{
	team?: Model
}>()

const isUpdate = computed(() => {
	return !!props.team
})

type TFormModel = Partial<
	Omit<Model, 'id'> & { country_id: number; team_logo: File | undefined }
>

const form = useForm<Prettify<TFormModel>>(() => ({
	name: props.team?.name ?? '',
	description: props.team?.description ?? '',
	code: props.team?.code ?? '',
	type: props.team?.type ?? '',
	country_id: props.team?.country.id ?? 121,
	team_number: props.team?.team_number,
	team_logo: props.team?.team_logo,
}))

const showForm = defineModel<boolean>('open', {
	default: false,
})
const showInvitationForm = ref<boolean>(false)

const openForm = () => {
	showForm.value = true
}
const closeForm = () => {
	showForm.value = false
}
const submitOption: Partial<VisitOptions> = {
	preserveState: true,
	onSuccess: (e) => {
		console.log('e:', e)
		form.reset()
		closeForm()
	},
}
const store = () => {
	form.post(route('teams.store'), submitOption)
}
const update = () => {
	form.patch(route('teams.update', [props.team]), submitOption)
}
const submit = () => {
	console.log(form.data())
	if (isUpdate.value) {
		update()
	} else {
		store()
	}
}
const showUploadAvatarModal = ref<boolean>(false)
const previewImage = ref<string>(props.team?.team_logo_url)
const defaultCountry = ref()

axios.get(route('api.countries.show', [121])).then((res) => {
	defaultCountry.value = res.data.data
})
</script>
<template>
	<Primitive
		as-child
		@click="openForm">
		<slot name="trigger">
			<Button :label="$t('build-team')" />
		</slot>
	</Primitive>
	<Modal
		@close="closeForm"
		:show="showForm">
		<ElForm
			@submit.prevent="submit"
			label-position="top"
			class="p-6">
			<button
				class="relative block mx-auto mt-2 w-fit"
				@click.prevent="showUploadAvatarModal = true">
				<Avatar
					:image-url="previewImage"
					:border="true"
					size="xlg"
					:enableLightBox="false" />
				<div class="absolute bottom-0 p-1 bg-black rounded-full end-0">
					<PencilIcon class="w-3 text-white" />
				</div>
			</button>
			<InputError :message="form.errors.team_logo" />
			<FormField
				:label="$t('team-name')"
				:error="form.errors.name">
				<TextInput v-model="form.name" />
			</FormField>
			<FormField
				:label="$t('team-description')"
				:error="form.errors.description">
				<TextInput v-model="form.description" />
			</FormField>
			<FormField
				:label="$t('team-code')"
				:error="form.errors.code">
				<TextInput v-model="form.code" />
			</FormField>

			<FormField
				:label="$t('country')"
				:error="form.errors.country_id">
				<RichSelectInput
					:source="route('api.countries.index')"
					value-name="id"
					text-name="name"
					image-name="flag"
					:append="team?.country ?? defaultCountry"
					v-model="form.country_id" />
			</FormField>

			<FormField
				:label="$t('number')"
				:error="form.errors.team_number">
				<TextInput v-model="form.team_number" />
			</FormField>
			<PrimaryButton :disabled="form.processing">{{
				$t('build')
			}}</PrimaryButton>
		</ElForm>
		<UploadImageField
			:should-upload="false"
			:show="showUploadAvatarModal"
			v-model="form.team_logo"
			:currentImageUrl="previewImage"
			@close="showUploadAvatarModal = false"
			@selected="(photo: string) => (previewImage = photo)" />
	</Modal>
</template>
