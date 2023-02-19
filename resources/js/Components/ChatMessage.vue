<script setup>
import { computed, ref } from '@vue/reactivity';
import ReplyIcon from './Icons/ReplyIcon.vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
import { TrashIcon } from '@heroicons/vue/24/outline'
import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';
import dayjs from 'dayjs';



const props = defineProps({
    message: Object,
    player: null
})
const emits = defineEmits(['reply'])
onMounted(() => {
    // props.message.media.media !== [] && console.log(props.message.media)
})
const currentUser = usePage().props.value.auth.user
const showOptions = ref(false)

function handleReply(e) {
    emits('reply', props.message)
    showOptions.value ? showOptions.value = false : null

}

const isCurrentUser = computed(() => { return props.message.sender_id === currentUser.id })
const alignmentClass = computed(() => {
    return isCurrentUser.value ? 'self-end  ' : 'self-start   ';
})
const parentClasses = computed(() => {
    return isCurrentUser.value ? 'relative flex justify-end   pie-8 ' : 'flex gap-2 items-center  ';
})

const bodyClass = computed(() => {
    return isCurrentUser.value ? ' bg-primary text-white rounded-br-none' : ' bg-stone-200 text-black rounded-bl-none';
})
const repliedClasses = computed(() => {
    return isCurrentUser.value ? 'bg-white text-black  ' : 'bg-primary text-white  ';
})



</script>

<template>
    <div :class="alignmentClass + parentClasses" class="w-full  ">
        <!-- avatar for non current user message -->
        <div v-if='!isCurrentUser'>
            <div><img :src="'https://ui-avatars.com/api/?name=' + player.name + '&color=094609FF&background=E2E2E2'" alt=""
                    class="object-cover w-10 h-10 rounded-full border-primary border-2">
            </div>
        </div>
        <!-- message body -->
        <div class="max-w-[60%]">
            <div :class="bodyClass" class="   p-4 rounded-2xl ">
                <!-- replied message -->
                <div v-if="message.parent_id" :class="repliedClasses" class="text-xs p-3 mb-2 rounded-lg">
                    <div class="mb-2  capitalize font-semibold">
                        <h4 v-if="isCurrentUser" class="text-primary">{{ currentUser.name }}</h4>
                        <h4 v-else>{{ player.name }}</h4>
                    </div>
                    <span class="">{{ message.parent?.body }}</span>
                </div>
                <div v-if="message.media">
                    <img class="w-52 object-contain" :src="message.media.original_url" alt="">
                </div>
                <span class="whitespace-pre-wrap">
                    {{ message.body }}
                </span>
            </div>

            <!-- date -->
            <div class="text-xs mt-2 " :class="isCurrentUser ? 'text-end' : null"> <span>{{ message.read_at ?
                dayjs(message.read_at).format('hh:mm A') : dayjs(message.created_at).format('hh:mm A') }}</span> | <span
                    class="text-primary capitalize">{{ message.read_at ? 'r' : 's' }}</span></div>
        </div>

        <!-- options menu if message of the current user -->
        <div v-if="isCurrentUser" class="absolute top-0 right-0">
            <button @click="showOptions = !showOptions">
                <EllipsisVerticalIcon class="w-6  text-neutral-500" />
            </button>
            <div v-if="showOptions" class="inset-0 fixed w-full h-full z-10 cursor-pointer  " @click="showOptions = false">
            </div>
            <Transition enterFromClass="opacity-0" enterToClass="opacity-100" leaveFromClass="opacity-100"
                leaveToClass="opacity-0" leave-active-class="transition-all duration-150 ease-in"
                enterActiveClass="transition-all duration-150 ease-out">
                <div v-show="showOptions"
                    class=" text-xs bg-black text-white z-20  rounded-xl border border-neutral-500 py-2 px-6 pie-10 z-2 absolute right-7  -top-2">
                    <ul class="flex flex-col gap-y-2 justify-center">
                        <button class="hover:text-gray-400 ">
                            <li class="flex gap-x-2 items-center justify-center">
                                <TrashIcon class="w-4" />
                                <span> delete</span>
                            </li>
                        </button>
                        <button class="hover:text-gray-400 group" @click="handleReply">
                            <li class="flex gap-x-2 items-center justify-center">
                                <ReplyIcon
                                    class="fill-transparent group-hover:stroke-gray-400 cursor-pointer stroke-white ">
                                </ReplyIcon>
                                <span>Quote</span>
                            </li>
                        </button>
                    </ul>
                </div>
            </Transition>
        </div>
        <!-- reply icon for non current user message -->
        <button v-if="!isCurrentUser" @click="handleReply">
            <ReplyIcon class="fill-transparent hover:fill-black  stroke-black "></ReplyIcon>

        </button>

    </div>
</template>



<style  scoped></style>
