<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
import { inject, onMounted, onUnmounted, ref } from 'vue';
import { useResizeFont } from '@/Composables/useResizeFont';
const greetings = inject('greetings')

// function resize_to_fit(name ,container) {
//     if(!name || !container  ) return;
//     let fontSize = window.getComputedStyle(name).fontSize;
//     if (name.clientWidth >= container.clientWidth) {
//         name.style.fontSize = (parseFloat(fontSize) - 1) + 'px';
//         resize_to_fit(name , container)
//     }
// }
const container = ref(null)
const userName = ref(null)

let fontSize;


let { resizeFont } = useResizeFont()


onMounted(() => {
    if (!userName.value || !container.value) return

    fontSize = window.getComputedStyle(userName.value).fontSize;
    resizeFont(userName.value, container.value)
    window.addEventListener('resize', changeFontSize)
})
onUnmounted(() => {
    window.removeEventListener('resize', changeFontSize)
})

const changeFontSize = (e) => {
    userName.value.style.fontSize = fontSize
    resizeFont(userName.value, container.value)
}
</script>

<template>
    <p class="text-2xl font-light">{{ greetings[$page.props.locale] ?? $t('hello') }} ,</p>
    <div ref="container"
         class="container flex items-center w-[calc(100vw-3rem)] md:w-full">
        <p ref="userName"
           class="font-bold name whitespace-nowrap text-7xl">{{ $page.props.auth.user.name }}</p>
    </div>
    <p class="text-base font-semibold">
        <DateTranslation />
    </p>
</template>
<style scoped></style>