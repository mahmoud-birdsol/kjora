<script setup>
import { onMounted } from 'vue';
import { ArrowDownCircleIcon, DocumentArrowUpIcon } from '@heroicons/vue/24/outline'
const props = defineProps({
    fileType: String,
    filePreview: String
    , fileName: String
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


    <div v-else-if="fileType.endsWith('.document') || fileType.startsWith('application/msword')"
        class="flex justify-between gap-2 items-center">
        <img class="w-5 h-7 object-contain" src="/images/doc.png" />
        <p class="truncate">{{ fileName }}</p>

    </div>
    <div v-else-if="fileType.startsWith('application/pdf')" class="flex justify-between gap-2 items-center">
        <img class="w-7 h-7 object-contain" src="/images/pdf.png" />
        <p class="truncate">{{ fileName }}</p>

    </div>
</template>
