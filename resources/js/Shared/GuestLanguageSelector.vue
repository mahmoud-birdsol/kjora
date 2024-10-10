<template>
	<div class="ml-4 text-white rtl:mr-4">
		<button @click="setLocale">
			<span
				class="font-semibold"
				v-if="selectable_locale == 'ar'"
				>ع</span
			>
			<span
				class=""
				v-if="selectable_locale == 'en'"
				>EN</span
			>
		</button>
	</div>
</template>

<script>
import Icon from './Icon.vue'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

export default {
	components: {
		Icon,
		Link,
	},
	methods: {
		setLocale() {
			router.post(
				route('language', [this.selectable_locale]),
				{},
				{
					preserveState: false,
					preserveScroll: false,
					onSuccess: () => {
						window.location.reload()
					},
				}
			)
		},
	},

	mounted() {},
	computed: {
		selectable_locale() {
			if (this.$page.props.locale == 'ar') {
				return 'en'
			}
			return 'ar'
		},
	},
}
</script>
