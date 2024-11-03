<script lang="ts" setup>
import { Marker } from 'vue3-google-map'
import { type VisitOptions } from '@inertiajs/core'

const emit = defineEmits<{ (e: 'goToNext'): void; (e: 'goToPrevious'): void }>()
const props = defineProps<{
	stadiums: Stadiums
}>()
const form = useForm(() => ({
	date: null,
	time: null,
	stadium_id: null,
}))
const formId = `${uuid()}-form`
const selectedStadiumCenter = computed(() => {
	return props.stadiums.find((stadium) => stadium.id == form.stadium_id)
})
const distance = ref<number>(0)
const { currentUser } = useCurrentUser()
watch(selectedStadiumCenter, (stadium) => {
	distance.value = calculateDistance(
		currentUser.value.current_latitude,
		currentUser.value.current_longitude,
		selectedStadiumCenter.value.latitude,
		selectedStadiumCenter.value.longitude
	)
})
const showSuccessDialog = ref<boolean>(false)
const visitOptions: VisitOptions = {
	onSuccess: () => {
		emit('goToNext')
		showSuccessDialog.value = true
	},
}
const submit = () => {
	showSuccessDialog.value = true
}
</script>

<template>
	<Card>
		<CardContent>
			<template #body>
				<div class="flex flex-wrap justify-between gap-3">
					<h2 class="mb-5 card-title">
						{{
							$t('step-match-details-information', {
								step: String(2),
							})
						}}
					</h2>
				</div>
				<form
					:id="formId"
					@submit.prevent="submit">
					<div class="inputs-row">
						<FormField
							:label="$t('match-date')"
							:error="form.errors?.date">
							<InputDate v-model="form.date" />
						</FormField>
						<FormField
							:label="$t('match-time')"
							:error="form.errors?.time">
							<InputDate
								v-model="form.time"
								time-picker
								:timePickerInline="false" />
						</FormField>
					</div>
					<FormField
						:label="$t('match-stadium')"
						:error="form.errors.stadium_id">
						<RichSelectInput
							v-model="form.stadium_id"
							:options="stadiums"
							valueName="id"
							textName="name"
							flagName="flag" />
					</FormField>
					<div class="overflow-hidden rounded-xl">
						<AppMap
							class="mt-5 overflow-hidden rounded-md"
							style="height: 250px"
							:disableDefaultUi="true"
							:latitude="selectedStadiumCenter?.latitude"
							:longitude="selectedStadiumCenter?.longitude">
							<template #marker="{ position }">
								<Marker
									:options="{ position }"
									v-if="selectedStadiumCenter" />
							</template>
						</AppMap>
					</div>
				</form>
			</template>
		</CardContent>
		<div
			class="flex justify-between w-full max-md:flex-col-reverse max-md:items-stretch">
			<Button
				@click="$emit('goToPrevious')"
				:label="$t('Back')"
				variant="outline"
				color="black"
				icon="i-radix-icons-caret-left rtl:i-radix-icons-caret-right" />

			<Button
				:form="formId"
				type="submit"
				:label="$t('finish')" />
		</div>
	</Card>
	<AlertDialog
		:title="$t('your-match-created-successfully')"
		description="Please Select What you want to create team match or Friendly match"
		:solidLabel="$t('view-match-details-page')"
		:outlineLabel="$t('go-to-home-page')"
		:onClickSolid="() => router.visit(route('match.show', [1]))"
		:onClickOutline="() => router.visit(route('home'))"
		v-model:open="showSuccessDialog" />
</template>
