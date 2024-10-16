<script lang="ts" setup></script>

<template>
	<section class="p-6 bg-primary rounded-2xl">
		<img
			src="/images/cup.webp"
			role="presentation"
			:preload="true"
			class="w-16 mb-4" />
		<p class="text-sm text-white">
			{{ $t('be-the-next-winner') }}
		</p>
		<h2 class="my-3 text-xl font-semibold text-white">
			{{ $t('create-your-match-now') }}
		</h2>
		<p class="text-xs text-white">
			{{
				$t(
					'join-us-in-an-exciting-football-match-and-compete-with-others-our-event-offers-a-fun-and-challenging-experience-for-players-of-all-levels-dont-miss-this-opportunity-to-showcase-your-skills-and-team-spirit'
				)
			}}
		</p>
	</section>
</template>
