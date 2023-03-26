
<script setup>
import { CustomMarker, GoogleMap, InfoWindow, Marker, MarkerCluster } from "vue3-google-map";
import Avatar from '@/Components/Avatar.vue'
import MainPlayerCard from "../PlayerCards/MainPlayerCard.vue";
import { ref } from "vue";
const props = defineProps(['players'])

const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const filteredPlayers = props.players.data.filter(p => p.current_latitude != null || p.current_longitude != null)

const showInfoWindow = ref(false)
const infoOptions = ref(null)
const infoPlayer = ref(null)
function openInfoWindow(player, options) {
    infoOptions.value = options;
    infoPlayer.value = player
    showInfoWindow.value = !showInfoWindow.value
}
</script>


<template>
    <GoogleMap :api-key="apiKey" style="width: 100%; height:500px; " :center="{
        lat: parseFloat($page.props.auth.user.current_latitude),
        lng: parseFloat($page.props.auth.user.current_longitude)
    }" :zoom="5">

        <template v-for="(player, ) in filteredPlayers" :key="player.id">
            <CustomMarker class="relative" :options="{
                position: {
                    lat: parseFloat(player.current_latitude),
                    lng: parseFloat(player.current_longitude)
                }, anchorPoint: 'TOP_CENTER'
            }">
                <Avatar :id="player.id" :image-url="player.avatar_url" :size="'md'" :username="player.name" :border="true" borderColor="primary" :enableLightBox="false" />
                <button class="absolute inset-0 " @click.stop="openInfoWindow(player, {
                    position: {
                        lat: parseFloat(player.current_latitude),
                        lng: parseFloat(player.current_longitude)
                    }, anchorPoint: 'TOP_CENTER'
                })">
                </button>
            </CustomMarker>

        </template>
        <InfoWindow v-if="showInfoWindow" :options="infoOptions">
            <MainPlayerCard :player="infoPlayer" />
        </InfoWindow>

    </GoogleMap>
</template>



<style scoped></style>
