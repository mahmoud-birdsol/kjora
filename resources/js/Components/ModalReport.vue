<script setup>
import Modal from "@/Components/Modal.vue"
import {
    RadioGroup,
    RadioGroupOption,
} from '@headlessui/vue'
import { emit } from "process";
import { ref } from "vue"
defineProps({
    showReportModal:{
        default:false,
    }
})
// defineEmits(['update:showReportModal'])
function close(){
    console.log('aml walaed')
    // emit('update:showReportModal', false)
}
const reportReason = ref(null) 
function submitForm(){
    console.log(reportReason.value)
}
</script>
<template>
    <Modal :show="showReportModal" @close="showReportModal= flase" max-width="sm" :closeable="true" :bodyScroll="false">
    <div class="flex flex-col p-4 text-center uppercase gap-y-6">
        <div class="mb-4 font-bold text-primary">
            report
        </div>
            <!-- TODO:make it radio buttons group -->
            <form @submit.prevent="submitForm()">
                <ul>
                    <RadioGroup v-model="reportReason"
                        class=" [&_li]:py-3 [&_li]:rounded-full [&_li]:border-2 text-stone-500  flex flex-col gap-4 text-sm font-medium cursor-pointer">
                        <RadioGroupOption v-slot="{ checked }" value="spam">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">spam</li>
                        </RadioGroupOption>
                        <RadioGroupOption v-slot="{ checked }" value="hate speech, or uncivil">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">hate speech, or uncivil
                            </li>
                        </RadioGroupOption>
                        <RadioGroupOption v-slot="{ checked }" value="sexual activity">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">sexual activity</li>
                        </RadioGroupOption>
                        <RadioGroupOption v-slot="{ checked }" value="scam, or fraud">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">scam, or fraud</li>
                        </RadioGroupOption>
                        <RadioGroupOption v-slot="{ checked }" value="bullying or harassment">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">bullying or harassment
                            </li>
                        </RadioGroupOption>
                        <RadioGroupOption v-slot="{ checked }" value="violence, or threats">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">violence, or threats
                            </li>
                        </RadioGroupOption>
                        <RadioGroupOption v-slot="{ checked }" value="racism, discrimination, or insults">
                            <li :class="checked ? 'border-primary text-primary' : 'border-gray-400'">racism, discrimination,
                                or insults</li>
                        </RadioGroupOption>
                    </RadioGroup>
                </ul>
                <button class="w-full p-2 px-6 text-white uppercase bg-black rounded-full my-4">
                    report
                </button>
            </form>

    </div>
</Modal></template>