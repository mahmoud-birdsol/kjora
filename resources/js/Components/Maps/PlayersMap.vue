
<script setup>
import { CustomMarker, GoogleMap, InfoWindow, Marker } from "vue3-google-map";
import Avatar from '@/components/Avatar.vue'
import MainPlayerCard from "../PlayerCards/MainPlayerCard.vue";
const props = defineProps(['players'])

const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

</script>


<template>
    <GoogleMap :api-key="apiKey" style="width: 100%; height:500px; " :center="{
        lat: parseFloat(players.data[0].current_latitude),
        lng: parseFloat(players.data[0].current_longitude)
    }" :zoom="15">
        <template v-for="(player, ) in players.data" :key="player.id">
            <Marker :options="{
                position: {
                    lat: parseFloat(player.current_latitude),
                    lng: parseFloat(player.current_longitude)
                }, anchorPoint: 'TOP_CENTER'
            }">
                <InfoWindow>
                    <MainPlayerCard :player="player" />
                </InfoWindow>
            </Marker>
            <CustomMarker :options="{
                position: {
                    lat: parseFloat(player.current_latitude),
                    lng: parseFloat(player.current_longitude)
                }, anchorPoint: 'TOP_CENTER'
            }">
                <Avatar :image-url="player.avatar_url" :size="'md'" :username="player.name" :border="true"
                    borderColor="primary" :enableLightBox="false" />

            </CustomMarker>

        </template>
    </GoogleMap>
</template>



<style scoped></style>
