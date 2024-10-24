<script setup lang="ts">
const props = defineProps<{
	teams: PaginationData<Teams>
}>()
</script>
<template>
	<AppLayout>
		<pre>
            {{ props.teams }}
        </pre
		>
	</AppLayout>
</template>
