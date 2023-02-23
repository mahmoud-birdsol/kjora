<script setup>
import { onMounted } from 'vue';
import { DocumentArrowUpIcon } from '@heroicons/vue/24/outline'
const props = defineProps({
    fileType: String,
    filePreview: String
})
</script>
<template>
    <span v-if="fileType.startsWith('image')" class="block w-20 h-20 bg-center bg-no-repeat bg-contain rounded-lg"
        :style="'background-image: url(\'' + filePreview + '\');'" />
    <div v-else-if="fileType.startsWith('video')" class="w-60 h-36  rounded-lg">
        <video controls class="h-full">
            <source :src="filePreview" :type="fileType">
        </video>
    </div>
    <div v-else-if="fileType.endsWith('document')" class="block w-20 h-20 rounded-lg">
        <img class="h-full" src="/images/doc.png"/>
    </div>
    <div v-else-if="fileType.startsWith('application')" class="block w-20 h-20 rounded-lg">
        <img class="h-full" src="/images/pdf.png"/>
    </div>
    
</template>