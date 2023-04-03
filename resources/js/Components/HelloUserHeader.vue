<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
import { inject, onMounted , ref } from 'vue';

// const greetings = inject('greetings')

function resize_to_fit(name ,container) {
    let fontSize = window.getComputedStyle(name).fontSize;
    name.style.fontSize = (parseFloat(fontSize) - 1) + 'px';
    if (name.clientHeight >= container.clientHeight) {
        resize_to_fit(name , container)
    }
}
onMounted(() => {
    const name = document.querySelector('.name');
    const container = document.querySelector('.container');
    resize_to_fit(name , container)
    container.style.height='fit-content'
    // name.style.fontSize = `clamp(30px, calc(1.875rem + ((1vw - 3.8px) * 2.7273)), ${window.getComputedStyle(name).fontSize}px);`
})
</script>

<template>
    <p class="text-2xl font-light">{{ $t('hello') }} ,</p>
    <div class="container w-full h-16">
        <p class="text-3xl font-bold name max-sm:whitespace-nowrap md:text-7xl">ahmed alshardahskdl</p>
            <!-- <p class="text-3xl font-bold name max-sm:whitespace-nowrap md:text-7xl">{{ $page.props.auth.user.first_name }} {{
            $page.props.auth.user.last_name }}</p> -->
    </div>
    <p class="text-base font-semibold">
        <DateTranslation />
    </p>
</template>
<style scoped>

</style>