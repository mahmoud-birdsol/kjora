<script setup lang="ts">
import { cn } from '@/Utils'

import { Primitive } from 'radix-vue'
import { buttonVariants, buttonIconVariants, type ButtonProps } from '.'

import { Link, type InertiaLinkProps } from '@inertiajs/vue3'
import { useId } from 'vue'

const props = withDefaults(
	defineProps<Partial<ButtonProps & { href?: InertiaLinkProps['href'] }>>(),
	{
		as: 'button',
		type: 'button',
		loadingIcon: 'i-app-loading',
	}
)

const slots = useSlots()

const isString = (value: any): value is string => typeof value === 'string'
const isDisabled = computed(() => props.disabled || props.loading)
const isLink = computed(
	() => (isString(props.as) && props.as?.toLowerCase() === 'link') || props.href
)

const LinkWithAsProps = computed(() =>
	h(
		Link,
		{
			as: props.linkAs as string,
			href: props.href,
		} as InertiaLinkProps,
		{
			default: slots?.default,
		}
	)
)

const resolvedAs = computed(() =>
	isLink.value && props.as !== 'a' ? LinkWithAsProps.value : props.as
)

const isLeading = computed(() => {
	return (
		(props.icon && props.leading) ||
		(props.icon && !props.trailing) ||
		props.leadingIcon
	)
})

const isTrailing = computed(() => {
	return (props.icon && props.trailing) || props.trailingIcon
})
const isTrailingOnly = computed(() => isTrailing.value && !isLeading.value)
const hasIcon = computed(() => {
	return isTrailing.value || isLeading.value
})

const iconOnly = computed(() => {
	return hasIcon.value && !props.label?.length && !slots?.default
})

const leadingIconName = computed(() => {
	return props.loading ? props.loadingIcon : props.leadingIcon || props.icon
})

const trailingIconName = computed(() => {
	return props.loading && isTrailingOnly.value
		? props.loadingIcon
		: props.trailingIcon || props.icon
})

const leadingIconClass = computed(() => {
	return buttonIconVariants({ size: props.size })
})

const trailingIconClass = computed(() => {
	return buttonIconVariants({ size: props.size })
})
const buttonId = props.id ?? `${useId()}-button`
</script>

<template>
	<Primitive
		:aria-disabled="isDisabled"
		:aria-busy="loading"
		:data-variant="props.variant"
		:disabled="isDisabled"
		:type="type"
		:as="resolvedAs"
		:as-child="props.asChild"
		:id="buttonId"
		:class="
			cn(
				buttonVariants({ variant, size, color, roundness }),
				block && 'flex w-full',
				disabled && 'cursor-not-allowed',
				isLink && 'p-0',
				props.class
			)
		">
		<div
			v-if="props.loading && !hasIcon"
			class="absolute inset-0 grid place-items-center">
			<span class="i-app-loading-dots h-3 w-1/2 max-w-[90%]" />
		</div>
		<span
			v-if="(isLeading && leadingIconName) || $slots.leading"
			:class="cn('inline-flex items-center', leadingIconWrapperClass)">
			<slot
				name="leading"
				:disabled="props.disabled"
				:loading="loading">
				<span
					:class="cn(leadingIconClass, leadingIconName)"
					aria-hidden="true" />
			</slot>
		</span>
		<span
			v-if="label || $slots.default"
			:class="
				cn('inline-flex items-center', [
					props.loading && !hasIcon && 'invisible',
					props.ui?.label,
				])
			">
			<slot>
				<span
					v-if="label"
					:class="
						cn('first-letter:capitalize', {
							'line-clamp-1 break-all text-left': truncate,
						})
					">
					{{ label }}
				</span>
			</slot>
		</span>
		<span
			v-if="(isTrailing && trailingIconName) || $slots.trailing"
			:class="cn('inline-flex items-center', trailingIconWrapperClass)">
			<slot
				name="trailing"
				:disabled="props.disabled"
				:loading="loading">
				<span
					:class="cn(trailingIconClass, trailingIconName)"
					aria-hidden="true" />
			</slot>
		</span>
	</Primitive>
</template>
