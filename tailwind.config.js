const defaultTheme = require('tailwindcss/defaultTheme')
import { appPlugin } from './resources/js/tailwind'
import formsPlugin from '@tailwindcss/forms'
import typographyPlugin from '@tailwindcss/typography'
import logicalPlugin from 'tailwindcss-logical'
import dirPlugin from 'tailwindcss-dir'

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./vendor/laravel/jetstream/**/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.vue',
	],

	theme: {
		extend: {
			fontFamily: {
				sans: ['Roboto', ...defaultTheme.fontFamily.sans],
				tajawl: ['Tajawal', 'sans-serif'],
				tahoma: 'Tahoma, Verdana, Segoe, sans-serif;',
			},
			colors: {
				primary: 'rgb(0, 100, 0)',
				primaryDark: 'rgb(9, 70, 9)',
				golden: '#D1C37A',
				gold: '#FF9900',
			},
		},
		screens: {
			xs: '475px',
			...defaultTheme.screens,
		},
	},

	plugins: [formsPlugin, typographyPlugin, logicalPlugin, dirPlugin, appPlugin],
}
