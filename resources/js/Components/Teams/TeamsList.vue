<script setup lang="ts">
const props = defineProps<{
    teams:Teams ,
}>()
</script>
<template>
    <section v-if="teams.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <template
            v-for="team in teams"
            :key="team.id">
            <TeamCard :team="team" />
        </template>
    </section>
    <Empty v-else />
</template>
