<script setup lang="ts">
import { calculateDistance } from '@/Utils'
import { CustomMarker } from 'vue3-google-map'
type Model = Match
const props = defineProps<{
	match: Model
}>()

const currentUser = usePage().props.auth.user

const distance = calculateDistance(
	currentUser.current_latitude,
	currentUser.current_longitude,
	props.match.stadium.latitude,
	props.match.stadium.longitude
)
</script>
<template>
	<div class="card">
		<div class="flex items-center justify-between gap-3">
			<TeamSimpleAvatar :team="match.team_1" />
			<p class="font-semibold whitespace-nowrap">
				{{
					$t('point1-vs-point2', {
						point1: String(match.point_team_1),
						point2: String(match.point_team_2),
					})
				}}
			</p>
			<TeamSimpleAvatar :team="match.team_2" />
		</div>
		<AppMap
			class="mt-5 overflow-hidden rounded-md"
			style="height: 100px"
			:disableDefaultUi="true"
			:latitude="match.stadium.latitude"
			:longitude="match.stadium.longitude">
			<template #marker="{ position }">
				<CustomMarker :options="{ position }">
					<Button
						size="sm"
						color="black"
						:label="
							$t('distance-km', {
								distance: distance,
							})
						" />
				</CustomMarker>
			</template>
		</AppMap>
	</div>
</template>
