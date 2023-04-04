<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
import { inject, onMounted , ref } from 'vue';

const greetings = inject('greetings')

function resize_to_fit(name ,container) {
    let fontSize = window.getComputedStyle(name).fontSize;
    if (name.clientWidth >= container.clientWidth) {
        name.style.fontSize = (parseFloat(fontSize) - 1) + 'px';
        resize_to_fit(name , container)
    }
}
onMounted(() => {
    const name = document.querySelector('.name');
    const container = document.querySelector('.container');
    let fontSize = window.getComputedStyle(name).fontSize;
    resize_to_fit(name , container)
    window.addEventListener('resize',()=>{
        name.style.fontSize=fontSize
        resize_to_fit(name , container)
    })
})
</script>

<template>
    <p class="text-2xl font-light">{{ greetings[$page.props.locale] ??  $t('hello') }} ,</p>
    <div class="container flex items-center w-[calc(100vw-3rem)] md:w-full">
        <p class="font-bold name whitespace-nowrap text-5xl">{{ $page.props.auth.user.first_name }} {{
            $page.props.auth.user.last_name }}</p>
    </div>
    <p class="text-base font-semibold">
        <DateTranslation />
    </p>
</template>
<style scoped>

</style>