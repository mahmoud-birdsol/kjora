<script setup>
import { onMounted, ref } from 'vue';
import { ChevronDownIcon, CheckIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    modelValue: String,
    valueName: String,
    textName: String,
    imageName: String,
    options: {
        required: true,
        type: Array,
    }
});

const filteredOptions = ref([]);

onMounted(() => {
    if (props.modelValue) {
        selected.value = props.options.filter((option) => {
            return option[props.valueName] == props.modelValue;
        })[0];
    } else {
        selected.value = props.options.filter((option) => {
            return option[props.valueName] == 84;
        })[0];

        emit('update:modelValue', '+' + selected.value.calling_code);
    }

    filteredOptions.value = props.options;
});

const showDropDown = ref(false);

const selected = ref(null);

const emit = defineEmits(['update:modelValue']);

const phone = ref('');

const select = (option) => {
    selected.value = option;
    showDropDown.value = false;
    emit('update:modelValue', '+' + selected.value.calling_code);
};

const searchValue = ref('');

const search = () => {
    filteredOptions.value = props.options.filter((option) => {
        return option.name
            .toUpperCase()
            .includes(searchValue.value.toUpperCase());
    });
};

const type = (event) => {
    emit('update:modelValue', event.target.value);

    props.options.forEach((country) => {
        if(event.target.value.toUpperCase().includes( '+' + country.calling_code.toUpperCase())){
            selected.value = country;
        }

        if(event.target.value.toUpperCase().includes( '00' + country.calling_code.toUpperCase())){
            selected.value = country;
        }
    });
};
</script>

<template>
    <div>
        <div class="relative mt-1">
            <button type="button"
                    class="relative w-full cursor-pointer rounded-full border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary sm:text-sm"
                    aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                <span class="flex items-center cursor-pointer" v-if="selected">
                    <img :src="selected[imageName]" alt="" class="h-6 w-6 flex-shrink-0 rounded cursor-pointer"
                         @click="showDropDown = ! showDropDown">
                    <input type="text" :value="modelValue" @input="type"
                           class="block w-full px-4 mx-4 py-0 my-0 border-none sm:text-sm disabled:bg-gray-100 focus:ring-none focus:border-none ring-transparent">
                </span>
                <span class="cursor-pointer absolute inset-y-0 right-0 ml-3 flex items-center pr-2"
                      @click="showDropDown = ! showDropDown">
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
                    <li>
                        <div class="flex p-4">
                            <input type="text"
                                   v-model="searchValue"
                                   class="block w-full rounded border-gray-300 px-4 shadow-sm focus:border-primary focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                   @input="search"
                                   placeholder="Search">
                        </div>
                    </li>

                    <li v-for="option in filteredOptions" @click="select(option)"
                        class="text-gray-900 relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-primary hover:text-white"
                        id="listbox-option-0"
                        role="option">
                        <div class="flex items-center">
                            <img :src="option[imageName]" alt="" class="h-6 w-6 flex-shrink-0 rounded">
                            <span class="font-normal ml-3 block truncate"
                                  :class="{'font-semibold': option[valueName] == selected[valueName], 'font-normal': option[valueName] != selected[valueName]}">{{ option[textName] }}</span>
                        </div>

                        <span class="absolute inset-y-0 right-0 flex items-center pr-4"
                              :class="{'text-primary': option[valueName] == selected[valueName], 'text-white': option[valueName] != selected[valueName]}">
                            <CheckIcon class="h-5 w-5"/>
                        </span>
                    </li>
                </ul>
            </transition>
        </div>
    </div>
</template>
