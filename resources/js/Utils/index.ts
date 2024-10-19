import { twMerge } from 'tailwind-merge'
import { clsx, type ClassValue } from 'clsx'

export function cn(...inputs: ClassValue[]) {
	return twMerge(clsx(inputs))
}

export function removeUrlParameter(url: string, paramKey: string) {
	const parsedUrl = new URL(url)
	parsedUrl.searchParams.delete(paramKey)
	return parsedUrl.href
}
