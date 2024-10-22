import colors from 'tailwindcss/colors'
const getColorCssVariables = (colorName: string) => {
	return Object.keys(colors.red).reduce((obj, shade) => {
		return (obj = {
			...obj,
			[shade]: `hsl(var(--${colorName}-${shade}) / <alpha-value>)`,
		})
	}, {})
}
export default getColorCssVariables
