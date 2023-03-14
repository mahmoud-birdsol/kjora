
<script setup>
import { CustomMarker, GoogleMap, InfoWindow, Marker } from "vue3-google-map";
import Avatar from '@/Components/Avatar.vue'
import MainPlayerCard from "../PlayerCards/MainPlayerCard.vue";
const props = defineProps(['players'])

const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const filteredPlayers = props.players.data.filter(p => p.current_latitude != null || p.current_longitude != null)

</script>


<template>
    <GoogleMap :api-key="apiKey" style="width: 100%; height:500px; " :center="{
        lat: parseFloat($page.props.auth.user.current_latitude),
        lng: parseFloat($page.props.auth.user.current_longitude)
    }" :zoom="5">
        <template v-for="(player, ) in filteredPlayers" :key="player.id">
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
