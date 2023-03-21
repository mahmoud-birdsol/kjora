<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3';
import Facebook from "@/Components/Icons/Facebook.vue";
import Twitter from "@/Components/Icons/Twitter.vue";
import Linkedin from "@/Components/Icons/Linkedin.vue";
import { ShareIcon, LinkIcon } from '@heroicons/vue/24/outline'
import ToolTip from "@/Components/ToolTip.vue";
let props = defineProps({
    id: {
        required: true,
    },shareUrl: {
        required: true,
    },

})
let showSocials = ref(false)
let show = ref(false)
let url = usePage().props.value.ziggy.url + '/'+ props.shareUrl +'/' + props.id
function copy() {
    navigator.clipboard.writeText(url).then((

    ) => {
        show.value = true

        setTimeout(() => { show.value = false }, 3000)
    })
}
</script>
<template>
    <div class="fixed top-0 left-0 w-full h-full z-20" @click="showSocials = false" v-if="showSocials"></div>
    <div class="relative">
        <Transition enter-from-class="scale-0" enter-to-class="scale-100" enter-active-class="transition-all duration-300" leave-to-class="scale-0" leave-active-class="transition-all duration-300">
            <div v-if="showSocials" class="bg-black bg-opacity-70 rounded-full p-1 flex gap-3 absolute -top-full ltr:right-1/2 rtl:left-1/2 z-30">
                <a :data-href="'https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=' + url" :href="'https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=' + url" target="_blank"
                class="relative"
                >
                    <Facebook class="h-4 w-4 [&+div]:hover:block" />
                    <ToolTip :value="$t('facebook')" right="left-0" />
                </a>
                <a :href="'https://twitter.com/intent/tweet?hashtags=kjora&original_referer=' + url" target="_blank"
                class="relative"
                >
                    <Twitter class="h-4 w-4 [&+div]:hover:block" />
                    <ToolTip :value="$t('twitter')"  right="left-0"/>
                </a>
                <div class="relative">
                    <span class="bg-white text-black text-[8px] font-bold rounded absolute ltr:right-0 rtl:left-0 bottom-[110%] p-1" v-if="show">{{ $t('copied') }}!</span>
                    <LinkIcon class="h-4 w-4 text-white [&+div]:hover:block" @click="copy" />
                    <ToolTip :value="$t('copy link')" right="left-0" />
                </div>
            </div>
        </Transition>
        <button class="flex items-center justify-center gap-x-2" @click="showSocials = !showSocials">
            <ShareIcon class="h-4 w-4"  />
            <slot v-if="$slots.label" name="label">

            </slot>
        </button>
    </div>
</template>
