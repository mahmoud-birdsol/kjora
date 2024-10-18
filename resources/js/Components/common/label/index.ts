import { cva, type VariantProps } from 'class-variance-authority'
export const labelVariants = cva(
	'block font-medium text-xs uppercase ml-4 mb-1',
	{
		variants: {
			color: {
				white: 'text-white',
				black: 'text-black',
			},
		},
		defaultVariants: {
			color: 'white',
		},
	}
)
export type LabelProps = VariantProps<typeof labelVariants>
