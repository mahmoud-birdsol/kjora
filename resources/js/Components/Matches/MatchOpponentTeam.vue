<script lang="ts" setup>
const props = defineProps<{
	teams: Teams
}>()
const emit = defineEmits<{ (e: 'goToNext'): void; (e: 'goToPrevious'): void }>()
const form = useForm(() => ({ team_id: '' }))
</script>

<template>
	<Card>
		<CardContent>
			<template #body>
				<div class="space-y-6">
					<div>
						<h2 class="card-title">
							{{
								$t('step-invite-opponent-team', {
									step: String(2),
								})
							}}
						</h2>
						<span class="ms-auto" />
						<AppFilterDropdown :data="{}" />
						<AppSearchInput />
					</div>
					<ElRadioGroup
						class="grid lg:grid-cols-3 gap-6"
						v-model="form.team_id">
						<template
							v-for="team in teams"
							:key="team.id">
							<MyTeamCard :team="team">
								<template #top-actions>
									<ElRadio
										:aria-label="team.name"
										:value="team.id" />
								</template>
							</MyTeamCard>
						</template>
					</ElRadioGroup>
				</div>
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
				@click="$emit('goToNext')"
				:label="$t('send-invitation-and-continue')" />
		</div>
	</Card>
</template>
