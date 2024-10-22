<script setup lang="ts">
import { PencilIcon } from '@heroicons/vue/24/outline'
import { type VisitOptions } from '@inertiajs/core'
type Model = Team
const props = defineProps<{
	team?: Model
	countries: Countries
}>()

const isUpdate = computed(() => {
	return !!props.team
})

type TFormModel = Partial<Omit<Model, 'id'> & { country_id: number }>

const form = useForm<Prettify<TFormModel>>(() => ({
	name: props.team?.name ?? '',
	code: props.team?.code ?? '',
	type: props.team?.type ?? '',
	country_id: props.team?.country.id,
	number: props.team?.number,
	image: props.team?.image ?? '',
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
		console.log(e)
		form.reset()
		closeForm()
		showInvitationForm.value = true
	},
}
const store = () => {
	form.post(route('teams.store'), submitOption)
}
const update = () => {
	form.patch(route('teams.update'), submitOption)
}
const submit = () => {
	if (isUpdate.value) {
		update()
	} else {
		store()
	}
}
const showUploadAvatarModal = ref<boolean>(false)
const previewImage = ref<string>()
</script>
<template>
	<PrimaryButton
		class="w-fit"
		@click="openForm"
		>{{ $t('build-team') }}</PrimaryButton
	>
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
					:id="team?.id"
					:enableLightBox="false" />
				<div class="absolute bottom-0 p-1 bg-black rounded-full end-0">
					<PencilIcon class="w-3 text-white" />
				</div>
			</button>
			<InputError :message="form.errors.image" />
			<FormField
				:label="$t('team-name')"
				:error="form.errors.name">
				<TextInput v-model="form.name" />
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
					:append="team?.country"
					v-model="form.country_id" />
			</FormField>

			<FormField
				:label="$t('number')"
				:error="form.errors.number">
				<TextInput v-model="form.number" />
			</FormField>
			<PrimaryButton :disabled="form.processing">{{
				$t('build')
			}}</PrimaryButton>
		</ElForm>
		<UploadImageField
			:should-upload="false"
			:show="showUploadAvatarModal"
			v-model="form.image"
			:currentImageUrl="previewImage"
			@close="showUploadAvatarModal = false"
			@selected="(photo: string) => (previewImage = photo)" />
	</Modal>
	<TeamInvitationForm v-model:open="showInvitationForm" />
</template>
