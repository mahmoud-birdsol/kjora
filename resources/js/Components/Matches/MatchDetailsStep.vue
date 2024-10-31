<script lang="ts" setup>
const emit = defineEmits<{ (e: 'goToNext'): void; (e: 'goToPrevious'): void }>()
const form = useForm(() => ({
	date: null,
	time: null,
	stadium_id: null,
}))
</script>

<template>
	<Card>
		<CardContent>
			<div class="flex flex-wrap justify-between gap-3">
				<h2 class="mb-5">
					{{
						$t('step-match-details-information', {
							step: String(2),
						})
					}}
				</h2>
			</div>
			<form>
				<div class="inputs-row">
					<FormField
						:label="$t('match-date')"
						:error="form.errors?.date">
						<InputDate v-model="form.date" />
					</FormField>
					<FormField
						:label="$t('match-time')"
						:error="form.errors?.time">
						<InputDate v-model="form.time" />
					</FormField>
				</div>
				<FormField
					:label="$t('match-stadium')"
					:error="form.errors.stadium_id">
					<RichSelectInput
						v-model="form.stadium_id"
						:options="[]"
						valueName="id"
						textName="name" />
				</FormField>
				<div class="overflow-hidden rounded-xl">
					<AppMap />
				</div>
			</form>
		</CardContent>
		<div class="justify-between max-md:flex-col-reverse max-md:items-stretch">
			<Button
				:label="$t('back')"
				variant="outline"
				color="mute"
				icon="rtl:i-radix-icons-caret-right i-radix-icons-caret-left "
				@click="$emit('goToPrevious')" />

			<Button :label="$t('finish')" />
		</div>
	</Card>
</template>
