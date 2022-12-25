<script setup>
import { onMounted, ref } from 'vue';
import { ChevronDownIcon, CheckIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    modelValue: [String, Number],
    valueName: String,
    textName: String,
    imageName: String,
    options: {
        required: true,
        type: Array,
    }
});

onMounted(() => {
    if (props.modelValue) {
        selected.value = props.options.filter((option) => {
            return option[props.valueName] == props.modelValue;
        })[0];
    }else{
        selected.value = props.options[0];
    }
});

const showDropDown = ref(false);

const selected = ref(null);

const emit = defineEmits(['update:modelValue']);

const select = (option) => {
    selected.value = option;
    emit('update:modelValue', selected.value[props.valueName]);
    showDropDown.value = false;
};
</script>

<template>
    <div>
        <div class="relative mt-1">
            <button type="button" @click="showDropDown = ! showDropDown"
                    class="relative w-full cursor-pointer rounded-full border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary sm:text-sm"
                    aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                <span class="flex items-center" v-if="selected">
                    <img :src="selected[imageName]" alt="" class="h-6 w-6 flex-shrink-0 rounded-full">
                    <span class="ml-3 block truncate">{{ selected[textName] }}</span>
                </span>
                <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                    <ChevronDownIcon class="h-5 w-5 text-gray-400"/>
                </span>
            </button>

            <transition
                enter-active-class="transition ease-in duration-100"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ul v-if="showDropDown"
                    class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-lg bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                    tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                    aria-activedescendant="listbox-option-3">
                    <li v-for="option in options" @click="select(option)"
                        class="text-gray-900 relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-primary hover:text-white" id="listbox-option-0"
                        role="option">
                        <div class="flex items-center">
                            <img :src="option[imageName]" alt="" class="h-6 w-6 flex-shrink-0 rounded-full">
                            <span class="font-normal ml-3 block truncate" :class="{'font-semibold': option[valueName] == selected[valueName], 'font-normal': option[valueName] != selected[valueName]}">{{ option[textName] }}</span>
                        </div>

                        <span class="absolute inset-y-0 right-0 flex items-center pr-4" :class="{'text-primary': option[valueName] == selected[valueName], 'text-white': option[valueName] != selected[valueName]}">
                            <CheckIcon class="h-5 w-5"/>
                        </span>
                    </li>
                </ul>
            </transition>
        </div>
    </div>
</template>
