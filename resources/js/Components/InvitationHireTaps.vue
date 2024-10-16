<template>
	<div class="flex items-center justify-end gap-3 rtl:tracking-tighter">
		<Link
			:href="route('invitation.index')"
			preserveScroll>
			<button
				class="py-2 px-4 min-w-[120px] sm:min-w-[215px] font-bold text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs text-gray-700 uppercase ltr:tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
				:class="{
					'border-primary': route().current('invitation.index'),
					'border-none': !route().current('invitation.index'),
				}">
				<span
					:class="{
						'text-gray-500': !route().current('invitation.index'),
						'text-black': route().current('invitation.index'),
					}">
					{{ $t('invitation') }}
				</span>
			</button>
		</Link>
		<Link
			:href="route('hire.index')"
			preserveScroll>
			<button
				class="py-2 px-4 min-w-[120px] sm:min-w-[215px] font-bold text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs text-gray-700 uppercase ltr:tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
				:class="{
					'border-primary': route().current('hire.index'),
					'border-none': !route().current('hire.index'),
				}">
				<span
					:class="{
						'text-gray-500': !route().current('hire.index'),
						'text-black': route().current('hire.index'),
					}">
					{{ $t('hire') }}
				</span>
			</button>
		</Link>
	</div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

</script>

<style lang="scss" scoped></style>
