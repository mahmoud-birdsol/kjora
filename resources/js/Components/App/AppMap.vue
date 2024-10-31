<script setup lang="ts">
import { Marker, GoogleMap } from 'vue3-google-map'
const props = defineProps<{
	latitude: String
	longitude: string
}>()
const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY
const { currentUser } = useCurrentUser()
const center = computed(() => {
	return {
		lat: parseFloat(props.latitude ?? currentUser.value?.current_latitude),
		lng: parseFloat(props.longitude ?? currentUser.value?.current_latitude),
	}
})
</script>

<template>
	<GoogleMap
		:api-key="apiKey"
		:center="center"
		style="width: 100%; height: 100px"
		:zoom="5">
		<slot
			name="marker"
			:position="center">
			<Marker :options="{ position: center }" />
		</slot>
	</GoogleMap>
</template>
