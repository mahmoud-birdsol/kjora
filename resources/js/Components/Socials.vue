<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3';
import Facebook from "@/Components/Icons/Facebook.vue";
import Twitter from "@/Components/Icons/Twitter.vue";
import Linkedin from "@/Components/Icons/Linkedin.vue";
import { ShareIcon, LinkIcon, PlayCircleIcon } from '@heroicons/vue/24/outline'
import ToolTip from "@/Components/ToolTip.vue";
const props = defineProps({
    shareUrl: {
        required: true,
    },
    position: {
        default: 'top-0'
    },

})
const emits = defineEmits(['showCopied'])
const showSocials = ref(false)
const show = ref(false)
const url = usePage().props.value.ziggy.url + '/' + props.shareUrl

function copy() {
    navigator.clipboard.writeText(url).then(() => {
        showSocials.value = false
        emits('showCopied')
    })
}

console.log(url);
</script>
<template>
    <onClickOutside @trigger="showSocials = false">

        <Transition enter-from-class="scale-0" enter-to-class="scale-100" enter-active-class="transition-all duration-300" leave-to-class="scale-0" leave-active-class="transition-all duration-300">
            <div v-if="showSocials" class="absolute z-30 flex flex-col gap-3 p-3 text-xs text-white bg-black border rounded-lg ltr:-right-1 rtl:-left-1 border-neutral-500" :class="position">
                <a :data-href="'https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=' + url" :href="'https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=' + url" target="_blank" class="relative flex items-center gap-2 [&>div]:hover:block"
                    @click="showSocials = false">
                    <Facebook class="w-4 h-4" />
                    <span class="whitespace-nowrap">{{ $t('share-to-facebook') }}</span>
                </a>
                <a :href="'https://twitter.com/intent/tweet?hashtags=kjora&text=' + url" target="_blank" class="relative flex items-center gap-2 [&>div]:hover:block" @click="showSocials = false">
                    <Twitter class="w-4 h-4" />
                    <span class="whitespace-nowrapp">{{ $t('share-to-twitter') }}</span>
                </a>
                <div class=" flex items-center gap-2 [&>div]:hover:block cursor-pointer" @click="copy">
                    <LinkIcon class="w-4 h-4 text-white" />
                    <span class="whitespace-nowrap">{{ $t('copy-link') }}</span>
                </div>
            </div>
        </Transition>
    </onClickOutside>
    <button class="flex items-center justify-center gap-x-2" @click="showSocials = !showSocials">
        <ShareIcon class="w-4 h-4" />
        <slot v-if="$slots.label" name="label">

        </slot>
    </button>
</template>
