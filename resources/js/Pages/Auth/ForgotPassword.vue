<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestTwoColumnLayout from '@/Layouts/Partials/GuestTwoColumnLayout.vue';
import ForgotPasswordForm from '@/Pages/Auth/Forms/ForgotPasswordForm.vue';
import Card from '@/Components/Card.vue';
import CardContent from '@/Components/CardContent.vue';
import SuccessMessageModal from '@/Components/SuccessMessageModal.vue';

defineProps({
	status: String,
})

const showSuccessModal = ref(true)
</script>

<template>
	<Head title="Forgot Password" />

	<GuestLayout>
		<GuestTwoColumnLayout>
			<Card>
				<CardContent title="Forgot Password?">
					<template #body>
						<div class="flex justify-between h-full items-center">
							<p class="text-xs text-center text-gary-900">
								Enter the email address associated with your account and we will
								send you a link to reset your password.
							</p>
						</div>

						<div class="flex justify-center items-center w-full mt-12">
							<ForgotPasswordForm />
						</div>
					</template>

					<template #footer>
						<div class="flex justify-center items-center">
							<p class="text-xs text-gray-900 font-bold">
								Did you remember your password
								<Link
									:href="route('login')"
									class="text-primary hover:text-primaryDark underline"
									>Try Signing In
								</Link>
							</p>
						</div>
					</template>
				</CardContent>
			</Card>
		</GuestTwoColumnLayout>

        <SuccessMessageModal :show="status && showSuccessModal" @close="showSuccessModal = false" position="right" title="Forgot Password" :message="status" />
    </GuestLayout>
</template>
