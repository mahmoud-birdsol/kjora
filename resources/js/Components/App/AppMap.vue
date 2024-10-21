<script setup lang="ts">
import { Marker, GoogleMap } from 'vue3-google-map'
const props = defineProps<{
	latitude: String
	longitude: string
}>()
const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY

const center = computed(() => {
	return {
		lat: parseFloat(props.latitude),
		lng: parseFloat(props.longitude),
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
