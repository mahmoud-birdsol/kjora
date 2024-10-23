<script setup lang="ts">
import { cva, type VariantProps } from 'class-variance-authority'

const props = defineProps<{
	players: Users
}>()

const playerPositionsVariants = cva('', {
	variants: {
		position: {
			goalkeeper: 'top-0 start-1/2 -translate-x-1/2 rtl:translate-x-1/2',
			forward: 'top-3/4',
			defender: 'top-1/4',
			midfielder: 'top-1/2 -translate-y-1/2',
		},
	},
})
type PlayerPositionsVariants = typeof playerPositionsVariants
type PositionKeys = TProps['position']
type TProps = VariantProps<PlayerPositionsVariants>

const getPlayerPosition = (position: Position) => {
	return position.name['en'].toLowerCase() as PositionKeys
}
const groupPlayersByPosition = computed(() => {
	return props.players.reduce(
		(acc, player) => {
			const position = getPlayerPosition(player.position)

			if (!position) return acc

			if (position in acc) {
				acc[position].push(player)
			} else {
				acc[position] = [player]
			}
			return acc
		},
		{} as Record<PositionKeys, Users>
	)
})
</script>
<template>
	<div class="relative mx-auto bg-primary w-fit">
		<img
			alt="team places"
			src="/images/playground.svg"
			class="" />
		<div
			>
			<template v-for="(group, nameGroup) in groupPlayersByPosition">
				<div
					:class="[
						'absolute flex items-center justify-around w-full',
						playerPositionsVariants({
							position: nameGroup,
						}),
					]">
					<template v-for="(player, index) in group">
						<div
							:style="{
								'--player-index': index + 1,
							}">
							<Avatar
								:id="player.id"
								:username="player.username"
								:imageUrl="player.avatar_url"
								border />
						</div>
					</template>
				</div>
			</template>
		</div>
	</div>
</template>
