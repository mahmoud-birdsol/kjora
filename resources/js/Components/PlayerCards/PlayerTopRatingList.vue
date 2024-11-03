<script setup lang="ts">
import { useAxios } from '@vueuse/integrations/useAxios.mjs'
import axios from 'axios'

const { data: players = { data: [] } } = useAxios<Resource<Users>>(
	route('api.user.top-rating-players'),
	axios,
	{
		immediate: true,
	}
)
</script>
<template>
	<div class="space-y-4 card">
		<h2 class="text-xl font-semibold">{{ $t('top-rating-players') }}</h2>
		<ul
			class="space-y-3"
			v-if="players?.data.length">
			<template
				v-for="player in players.data"
				:key="player.id">
				<PlayerSimpleCard :player="player" />
			</template>
		</ul>
		<Empty v-else />
	</div>
</template>
