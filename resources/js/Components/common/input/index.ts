import type { ClassValue } from 'clsx'
import type { InputHTMLAttributes } from 'vue'

export interface InputProps {
	defaultValue?: string | number
	modelValue?: string | number
	leadingIconWrapperClass?: ClassValue
	trailingIconWrapperClass?: ClassValue
	hasFocus?: boolean
	disabled?: InputHTMLAttributes['disabled']
	readonly?: InputHTMLAttributes['readonly']
	autocomplete?: InputHTMLAttributes['autocomplete']
	placeholder?: InputHTMLAttributes['placeholder']
	type?: InputHTMLAttributes['type']
}
