import type { ClassValue } from 'clsx'
import type { InputHTMLAttributes } from 'vue'

export interface InputProps extends /* @vue-ignore */ InputHTMLAttributes {
	defaultValue?: string | number
	modelValue?: string | number
	leadingIconWrapperClass?: ClassValue
	trailingIconWrapperClass?: ClassValue
	hasFocus?: boolean
}
