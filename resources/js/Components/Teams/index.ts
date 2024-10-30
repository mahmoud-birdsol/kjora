import { cva, type VariantProps } from 'class-variance-authority'

export const teamAvatarVariants = cva('', {
	variants: {
		direction: {
			vertical: 'flex-col gap-1 ',
			horizontal: 'gap-3 justify-between',
		},
	},
	defaultVariants: {
		direction: 'vertical',
	},
})
export type TeamAvatarProps = VariantProps<typeof teamAvatarVariants>
