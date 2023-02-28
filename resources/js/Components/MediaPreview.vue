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
    <span v-if="fileType.startsWith('image')" class="block bg-center bg-no-repeat bg-cover rounded-lg"
        :style="'background-image: url(\'' + filePreview + '\');'" />
    <div v-else-if="fileType.startsWith('video')" class="rounded-lg overflow-hidden">
        <video controls class="h-full">
            <source :src="filePreview" :type="fileType">
        </video>
    </div>


    <div v-else-if="fileType.endsWith('.document') || fileType.startsWith('application/msword')"
        class="">
        <img class="w-5 h-7 object-contain mx-auto" src="/images/doc.png" />
        <p class="truncate">{{ fileName }}</p>

    </div>
    <div v-else-if="fileType.startsWith('application/pdf')" class="">
        <img class="w-7 h-7 object-contain mx-auto" src="/images/pdf.png" />
        <p class="truncate">{{ fileName }}</p>

    </div>
</template>
