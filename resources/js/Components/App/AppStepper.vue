<script
	lang="ts"
	setup
	generic="
		T extends Record<
			string,
			{
				step: keyof T
				title: string
				subtitle?: string
				show: boolean
			}
		>
	">
const props = defineProps<{
	steps: T
	currentStep: keyof T
}>()
const stepsValues = computed(() => {
	return Object.values(props.steps)
})
const currentIndex = computed(() => {
	return stepsValues.value.findIndex((step) => step.step === props.currentStep)
})
</script>
<template>
	<Card class="min-h-0 px-0">
		<ul class="space-y-6">
			<template
				v-for="(step, index) in stepsValues"
				:key="step.title">
				<li
					v-if="step.show"
					:class="[
						'text-sm flex gap-2 relative items-center',
						{
							'before:absolute before:h-full before:w-0.5 before:z-0 before:bg-gray-100 before:start-3.5 before:top-4 before:rounded-full':
								index !== stepsValues.length - 1,
						},
					]">
					<div
						:class="[
							' size-8 rounded-full flex items-center justify-center relative z-50',
							index < currentIndex ? 'bg-primary ' : 'bg-gray-100',
						]">
						<span
							v-if="index < currentIndex"
							class="text-white i-heroicons-check" />
						<div
							v-else
							:class="[
								'size-2 rounded-full',
								{
									'ring-[7px] ring-primary': index == currentIndex,
									' bg-white ': index > currentIndex,
								},
							]"></div>
					</div>
					<div>
						<h2 class="font-medium text-clr-title">{{ step.title }}</h2>
						<p class="text-secondary-500">{{ step.subtitle }}</p>
					</div>
				</li>
			</template>
		</ul>
	</Card>
</template>
