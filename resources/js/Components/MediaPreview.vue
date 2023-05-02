<script setup>
import { onMounted } from 'vue';
import { ArrowDownCircleIcon, DocumentArrowUpIcon } from '@heroicons/vue/24/outline'
const props = defineProps({
    fileType: String,
    filePreview: String,
    fileName: String
})
</script>
<template>
    <img v-if="fileType.startsWith('image')" class="rounded-lg w-full h-32 object-cover object-center "
        :src="filePreview" />
    <div v-else-if="fileType.startsWith('video')" class="rounded-lg overflow-hidden">
        <video :src="filePreview"  class="h-full">
        </video>
    </div>


    <div v-else-if="fileType.endsWith('.document') || fileType.startsWith('application/msword')" class="">
        <img class="w-5 h-7 object-contain mx-auto" src="/images/doc.png" />
        <p class="truncate">{{ fileName }}</p>

    </div>
    <div v-else-if="fileType.startsWith('application/pdf')" class="">
        <img class="w-7 h-7 object-contain mx-auto" src="/images/pdf.png" />
        <p class="truncate break-words">{{ fileName }}</p>

    </div>
</template>
