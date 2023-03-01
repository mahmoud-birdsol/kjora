<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3';
import Facebook from "@/Components/Icons/Facebook.vue";
import Twitter from "@/Components/Icons/Twitter.vue";
import Linkedin from "@/Components/Icons/Linkedin.vue";
import { ShareIcon, LinkIcon } from '@heroicons/vue/24/outline'
let props = defineProps({
    id: {
        required: true,
    }
})
let showSocials = ref(false)
let show = ref(false)
let url = usePage().props.value.ziggy.url + '/player/' + props.id
function copy() {
    navigator.clipboard.writeText(url).then((

    ) => {
        show.value = true

        setTimeout(() => { show.value = false }, 1000)
    })
}
</script>
<template>
    <div class="fixed top-0 left-0 w-full h-full" @click="showSocials = false" v-if="showSocials"></div>
    <div class="relative mt-2">
        <Transition enter-from-class="scale-0" enter-to-class="scale-100" enter-active-class="transition-all duration-300"
            leave-to-class="scale-0" leave-active-class="transition-all duration-300">
            <div v-if="showSocials" class="bg-black bg-opacity-70 rounded-full p-1 flex gap-3 absolute -top-full right-1/2">
                <a :href="'https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=' + url"
                    target="_blank">
                    <Facebook class="h-4 w-4 " />
                </a>
                <a :href="'https://twitter.com/intent/tweet?hashtags=kjora&original_referer=' + url" target="_blank">
                    <Twitter class="h-4 w-4 " />
                </a>
                <a :href="'https://www.linkedin.com/sharing/share-offsite/?url=' + url" target="_blank">
                    <Linkedin class="h-4 w-4 " />

                </a>
                <div class="relative">
                    <LinkIcon class="h-4 w-4 text-white" @click="copy" />
                    <span class="bg-white text-black text-[8px] font-bold rounded absolute bottom-full p-1"
                        v-if="show">Copied!</span>
                </div>
            </div>
        </Transition>
        <button>

            <ShareIcon class="h-4 w-4 text-white" @click="showSocials = !showSocials" />
        </button>
    </div>
</template>
