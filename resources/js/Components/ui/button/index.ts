import { cva, type VariantProps } from 'class-variance-authority'
import type { ClassValue } from 'clsx'
import { type PrimitiveProps } from 'radix-vue'
import type { Component, HTMLAttributes } from 'vue'

export { default as Button } from './Button.vue'

export const buttonVariants = cva(
	'relative whitespace-nowrap inline-flex items-center justify-center gap-2 font-medium transition-all duration-500 first-letter:capitalize focus-visible:outline-none focus-visible:ring focus-visible:ring-[--soft-color] text-sm group/btn border',
	{
		variants: {
			size: {
				default:
					'[&:not([data-variant="link"])]:h-[2.25rem] [&:not([data-variant="link"])]:px-4 [&:not([data-variant="link"])]:py-2',
				xs: '[&:not([data-variant="link"])]:h-7 [&:not([data-variant="link"])]:px-2 text-xs',
				sm: '[&:not([data-variant="link"])]:h-8 [&:not([data-variant="link"])]:px-2 text-xs',
				icon: 'items-center size-[2.25rem] p-0.5',
				'icon-sm': 'items-center size-[2rem] p-0.5',
			},
			color: {
				black: [
					'[--bg-color:theme(colors.black)]',
					'[--text-color:theme(colors.white)]',
					'[--solid-hover-color:theme(colors.gray.900)]',
					'[--solid-active-color:theme(colors.gray.800)]',
					'[--soft-color:theme(colors.gray.400)]',
				],
				primary: [
					'[--bg-color:theme(colors.primary.DEFAULT)]',
					'[--text-color:theme(colors.white)]',
					'[--solid-hover-color:theme(colors.primary.700)]',
					'[--solid-active-color:theme(colors.primary.600)]',
					'[--soft-color:theme(colors.primary.500)]',
				],
				white: [
					'[--bg-color:theme(colors.white)]',
					'[--text-color:theme(colors.black)]',
					'[--solid-hover-color:theme(colors.gray.500)]',
					'[--solid-active-color:theme(colors.gray.600)]',
					'[--soft-color:theme(colors.gray.400)]',
				],
				mute: [
					'[--bg-color:theme(colors.white)]',
					'[--text-color:theme(colors.muted.foreground)]',
					'[--solid-hover-color:theme(colors.gray.200)]',
					'[--solid-active-color:theme(colors.gray.600)]',
					'[--soft-color:theme(colors.gray.400)]',
				],
			},
			variant: {
				solid:
					'border-[--bg-color] bg-[--bg-color] text-[--text-color] hover:bg-[--solid-hover-color] hover:border-[--solid-hover-color] active:bg-[--solid-active-color] active:border-[--solid-active-color]',
				outline:
					'border-[--bg-color] text-[--bg-color] hover:bg-[--soft-color] hover:border-[--soft-color] active:bg-[--solid-active-color] active:border-[--solid-active-color]',
				ghost:
					'border-transparent text-[--bg-color] hover:bg-[--solid-hover-color] active:bg-[--solid-active-color] active:border-[--solid-active-color]',
				soft: 'border-[--soft-color] bg-[--soft-color] text-[--bg-color] active:bg-[--solid-active-color] active:border-[--solid-active-color]',
				link: 'border-transparent text-[--bg-color] hover:underline active:text-[--solid-active-color]',
			},
			roundness: {
				full: 'rounded-full',
				circle: 'rounded-full aspect-square',
				sm: 'rounded-sm',
				base: 'rounded',
			},
		},
		defaultVariants: {
			variant: 'solid',
			color: 'black',
			size: 'default',
			roundness: 'full',
		},
	}
)

export const buttonIconVariants = cva('shrink-0', {
	variants: {
		size: {
			default: 'size-5',
			sm: 'size-3',
			lg: 'size-6',
			icon: 'size-5',
			'icon-sm': 'size-4',
		},
	},
	defaultVariants: {
		size: 'default',
	},
})
export type ButtonVariants = VariantProps<typeof buttonVariants>

export interface ButtonProps {
	as: PrimitiveProps['as'] | Component | 'link'
	asChild: PrimitiveProps['asChild']
	variant?: ButtonVariants['variant']
	color?: ButtonVariants['color']
	size?: ButtonVariants['size']
	roundness?: ButtonVariants['roundness']
	class?: HTMLAttributes['class']
	type: 'button' | 'submit' | 'reset'
	linkAs: PrimitiveProps['as'] | Component
	loading: boolean
	disabled: boolean
	label: string
	truncate: boolean
	block: boolean
	loadingIcon: string
	icon: ClassValue
	trailing: boolean
	leading: boolean
	leadingIcon: ClassValue
	leadingIconWrapperClass: ClassValue
	trailingIcon: ClassValue
	trailingIconWrapperClass: ClassValue
	ui: {
		label: ClassValue
	}
}
