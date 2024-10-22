<script setup lang="ts">
const props = withDefaults(
	defineProps<{
		starsCount?: number
		starsActiveColor?: string
		starsHoverColor?: string
		disabled?: boolean
		showRatingValue?: boolean
	}>(),
	{
		starsCount: 5,
		starsActiveColor: "var('--star-color')",
		starsHoverColor: "var('--star-hover-color')",
	}
)
const rating = defineModel<number>({
	default: 0,
})
const updateRating = (i: number) => {
	if (props.disabled) return
	rating.value = i
}
</script>

<template>
	<div
		:class="'relative flex gap-0.5 items-center'"
		:data-disabled="props.disabled">
		<template v-for="i in props.starsCount">
			<svg
				viewBox="0 0 13 12"
				xmlns="http://www.w3.org/2000/svg"
				:class="[
					`has-[&[data-disabled='false']]:hover:fill-gold/50 has-[&[data-disabled='false']]:hover:stroke-gold/50 cursor-pointer stroke-gold w-3`,
					i <= rating ? 'fill-gold' : 'fill-transparent',
				]"
				@click="updateRating(i)">
				<path
					d="M6.34164 1.01368C6.47609 0.741301 6.54331 0.60511 6.63457 0.561597C6.71398 0.523739 6.80623 0.523739 6.88563 0.561597C6.97689 0.60511 7.04411 0.7413 7.17856 1.01368L8.45413 3.59783C8.49382 3.67824 8.51367 3.71845 8.54267 3.74967C8.56835 3.77731 8.59915 3.7997 8.63336 3.81561C8.672 3.83358 8.71636 3.84006 8.8051 3.85303L11.6583 4.27008C11.9588 4.31399 12.109 4.33595 12.1785 4.40934C12.239 4.47318 12.2675 4.56092 12.256 4.64812C12.2427 4.74834 12.134 4.85427 11.9165 5.06614L9.8526 7.07633C9.78827 7.13899 9.7561 7.17032 9.73534 7.2076C9.71696 7.24061 9.70517 7.27687 9.70062 7.31438C9.69549 7.35674 9.70308 7.40099 9.71826 7.48951L10.2052 10.3288C10.2566 10.6283 10.2823 10.778 10.234 10.8669C10.192 10.9442 10.1174 10.9984 10.0309 11.0144C9.93146 11.0329 9.79699 10.9622 9.52807 10.8207L6.97731 9.47932C6.89784 9.43752 6.8581 9.41662 6.81623 9.40841C6.77916 9.40114 6.74104 9.40114 6.70397 9.40841C6.6621 9.41662 6.62237 9.43752 6.54289 9.47932L3.99213 10.8207C3.72321 10.9622 3.58875 11.0329 3.48932 11.0144C3.40282 10.9984 3.32818 10.9442 3.28619 10.8669C3.23792 10.778 3.26361 10.6283 3.31497 10.3288L3.80194 7.48951C3.81712 7.40099 3.82471 7.35674 3.81958 7.31438C3.81503 7.27687 3.80324 7.24061 3.78486 7.2076C3.7641 7.17032 3.73194 7.13899 3.6676 7.07632L1.60375 5.06614C1.38623 4.85427 1.27747 4.74834 1.26423 4.64812C1.25272 4.56092 1.28116 4.47318 1.34165 4.40934C1.41118 4.33595 1.56141 4.31399 1.86187 4.27008L4.71511 3.85303C4.80384 3.84006 4.8482 3.83358 4.88684 3.81561C4.92105 3.7997 4.95185 3.77731 4.97753 3.74967C5.00654 3.71845 5.02638 3.67824 5.06608 3.59783L6.34164 1.01368Z"
					stroke-linecap="round"
					stroke-linejoin="round" />
			</svg>
		</template>
		<span
			v-if="showRatingValue"
			class="text-xs font-medium text-gold ms-2 shrink-0"
			>( {{ rating }} )</span
		>
	</div>
</template>
