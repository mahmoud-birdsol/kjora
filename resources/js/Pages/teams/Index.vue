<script setup lang="ts">
import type { TTab } from '@/Components/App/AppTabs.vue'
import { useBrowserLocation } from '@vueuse/core'

const props = defineProps<{
	teams: PaginationData<Team>
	myTeams: PaginationData<Teams>
	topRatingPlayer: Resource<Users>
}>()
console.log(props.topRatingPlayer)
const location = useBrowserLocation()
// [TODO] remove
const user: User = {
	id: 123,
	username: 'johndoe',
	email: 'johndoe@example.com',
	email_verified_at: new Date('2024-01-01T00:00:00.000Z'),
	two_factor_confirmed_at: new Date('2024-02-02T00:00:00.000Z'),
	current_team_id: null,
	profile_photo_path: 'https://example.com/profile_photo.jpg',
	joined_platform_at: new Date('2023-12-31T00:00:00.000Z'),
	created_at: new Date('2023-12-31T00:00:00.000Z'),
	updated_at: new Date('2024-02-02T00:00:00.000Z'),
	country_id: 1,
	club_id: 2,
	position_id: 3,
	first_name: 'John',
	last_name: 'Doe',
	phone: '123-456-7890',
	gender: 'male',
	avatar: 'https://example.com/avatar.jpg',
	identity_issue_country: 'USA',
	identity_type: "Driver's License",
	identity_front_image: 'https://example.com/identity_front.jpg',
	identity_back_image: 'https://example.com/identity_back.jpg',
	identity_selfie_image: 'https://example.com/identity_selfie.jpg',
	accepted_terms_and_conditions_version: '1.0',
	accepted_privacy_policy_version: '1.0',
	accepted_cookie_policy_version: '1.0',
	date_of_birth: new Date('1990-01-01T00:00:00.000Z'),
	identity_verified_at: new Date('2024-02-02T00:00:00.000Z'),
	phone_verified_at: new Date('2024-02-02T00:00:00.000Z'),
	accepted_terms_and_conditions_at: new Date('2023-12-31T00:00:00.000Z'),
	accepted_privacy_policy_at: new Date('2023-12-31T00:00:00.000Z'),
	accepted_cookie_policy_at: new Date('2023-12-31T00:00:00.000Z'),
	preferred_foot: 'right',
	rating: '4.5',
	last_seen_at: new Date('2024-02-02T00:00:00.000Z'),
	last_known_ip: '123.45.67.89',
	current_country: 'USA',
	current_region: 'California',
	current_city: 'Los Angeles',
	current_latitude: '34.052235',
	current_longitude: '-118.243683',
	locale: 'en_US',
	state: 'CA',
	geo_location: 12345,
	accepted_chat_regulations_at: new Date('2024-02-02T00:00:00.000Z'),
	avatar_url:
		'https://gravatar.com/avatar/f6b6ccaf0f410e24b61897bdb687a921?s=400&d=robohash&r=x',
	avatar_thumb_url:
		'https://gravatar.com/avatar/f6b6ccaf0f410e24b61897bdb687a921?s=400&d=robohash&r=x',
	identity_front_image_url:
		'https://gravatar.com/avatar/f6b6ccaf0f410e24b61897bdb687a921?s=400&d=robohash&r=x',
	identity_back_image_url:
		'https://gravatar.com/avatar/f6b6ccaf0f410e24b61897bdb687a921?s=400&d=robohash&r=x',
	identity_selfie_image_url:
		'https://gravatar.com/avatar/f6b6ccaf0f410e24b61897bdb687a921?s=400&d=robohash&r=x',
	has_verified_identity: true,
	age: 34,
	name: {
		first: 'John',
		last: 'Doe',
	},
	is_favorite: false,
	identity_status: 'verified',
	state_name: 'California',
	played: 10,
	missed: 2,
	latest_conversation: {
		// ...conversation data
	},
	position: {
		// ...position data
	},
	media: [
		// ...media data
	],
	favorites: [
		// ...favorite users
	],
	pivot: {
		user_id: 123,
		favorite_id: 456,
	},
	distance: 100,
	two_factor_enabled: true,
}

const tabs = computed<TTab[]>(() => [
	{
		label: 'Looking For Team',
		href: route('teams.index'),
		active: !route().params.tab,
		component: defineAsyncComponent({
			loader: () => import('@/Components/Teams/TeamsList.vue'),
		}),

		props: {
			teams: props.teams.data,
		},
	},
	{
		label: 'My Teams',
		href: route('teams.index', {
			tab: 'my_team',
		}),
		active: route().params.tab == 'my_team',
		component: defineAsyncComponent({
			loader: () => import('@/Components/Teams/MyTeamsList.vue'),
		}),
		props: {
			teams: props.myTeams.data,
		},
	},
])
</script>
<template>
	<Head :title="$t('teams')" />

	<AppLayout :title="$t('teams')">
		<div class="grid lg:grid-cols-[1fr_minmax(15rem,20rem)] gap-6 items-start">
			<div class="space-y-6">
				<p class="text-4xl font-black text-white md:text-7xl">
					{{ $t('teams') }}
				</p>
				<div class="flex items-center justify-between gap-2 flex-wrap">
					<AppTabs :tabs />
					<AppSearchInput />
					<TeamForm />
				</div>
				<template v-for="tab in tabs">
					<component
						v-bind="tab.props"
						v-if="tab.href === location.href"
						:is="tab.component" />
				</template>
			</div>
			<div class="space-y-6">
				<MatchAdvertise />
				<MatchesLatestList :matches="[]" />
				<PlayerTopRatingList :players="topRatingPlayer.data" />
			</div>
		</div>
	</AppLayout>
</template>
