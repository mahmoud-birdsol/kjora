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
export function toRadians(degree: number) {
	return degree * (Math.PI / 180)
}
export function calculateDistance(
	lat1Str: string,
	lng1Str: string,
	lat2Str: string,
	lng2Str: string
) {
	let lat1 = parseFloat(lat1Str)
	let lng1 = parseFloat(lng1Str)
	let lat2 = parseFloat(lat2Str)
	let lng2 = parseFloat(lng2Str)
	const radius = 6371 // Earth’s radius in km
	const dLat = toRadians(lat2 - lat1)
	const dLng = toRadians(lng2 - lng1)
	const a =
		Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		Math.cos(toRadians(lat1)) *
			Math.cos(toRadians(lat2)) *
			Math.sin(dLng / 2) *
			Math.sin(dLng / 2)
	const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a))
	const distance = radius * c
	return distance.toFixed(1)
}
