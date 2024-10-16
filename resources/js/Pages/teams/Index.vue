<script setup lang='ts'>
const props = defineProps<{
    teams:Teams ,
}>()
</script>
<template>
    <Head :title="$t('teams')" />

	<AppLayout :title="$t('teams')">
        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <template v-for="(team) in teams" :key="team.id">
                <TeamCard :team="team" />
            </template>
        </section>
    </AppLayout>
</template>
