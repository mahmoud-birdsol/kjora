import plugin from 'tailwindcss/plugin'

export const appPlugin = plugin(function ({
	matchUtilities,
	theme,
	addUtilities,
	addComponents,
}) {
	addUtilities({
		'.text-truncate': {
			'@apply break-all text-start line-clamp-1': {},
		},
		'.text-truncate-2': {
			'@apply overflow-hidden text-ellipsis whitespace-nowrap': {},
		},
	})
	addComponents({
		'.page-wrapper': {
			'@apply space-y-6': {},
		},
		'.card': {
			'@apply p-4 bg-white rounded-2xl shadow text-card-foreground': {},
		},
		'.card-title': {
			'@apply text-xl font-semibold': {},
		},
		'.card-subtitle': {
			'@apply text-sm': {},
		},
		'.inputs-row': {
			'@apply grid lg:grid-cols-2 gap-4': {},
		},
		'.page-title': {
			'@apply text-4xl font-black md:text-7xl': {},
		},
	})
}, {})
