<script setup>
import GuestNavbar from '@/Layouts/Partials/GuestNavbar.vue'
import dayjs from 'dayjs'
</script>

<template>
	<div class="bg-gradient-to-b from-black to-primary">
		<GuestNavbar />
		<div
			class="min-h-screen flex flex-col justify-between items-center pt-6 sm:pt-0">
			<main class="w-full mt-6 px-6 py-4">
				<div class="flex justify-between">
					<div class="w-full flex justify-end p-6">
						<div class="my-8">
							<h2 class="text-white text-2xl font-light uppercase">
								Welcome to
							</h2>
							<h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
						</div>
					</div>
					<div class="w-full p-6 pt-16">
						<div class="bg-white p-6 rounded-lg">
							<slot />
						</div>
					</div>
				</div>
			</main>
			<footer>
				<div class="h-10 flex justify-center">
					<p class="text-white text-sm font-medium">
						Copyright &copy; {{ dayjs().format('YYYY') }} KJORA. All Rights
						Reserved.
					</p>
				</div>
			</footer>
		</div>
	</div>
</template>
