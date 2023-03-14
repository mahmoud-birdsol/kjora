<script setup>
import {onMounted, ref} from 'vue';
import {CheckIcon, ChevronDownIcon} from '@heroicons/vue/24/solid';


const props = defineProps({
    modelValue: [String, Number],
    valueName: String,
    textName: String,
    imageName: String,
    options: {
        required: false,
        type: Array,
        default: []
    },
    source: {
        required: false,
        type: String,
        default: '',
    },
    append: {
        required: false,
        type: Object,
    },
    bgColor:{
        default:'white'
    },
    txtColor:{
        default:'black'
    }
});

const nextPageUrl = ref(null);

const filteredOptions = ref([]);

onMounted(() => {
    if (props.options.length) {
        filteredOptions.value = props.options;

        if (props.modelValue) {
            selected.value = props.options.filter((option) => {
                return option[props.valueName] == props.modelValue;
            })[0];
        } else {
            selected.value = props.options[0];
        }
    } else {
        axios.get(props.source).then(response => {
            filteredOptions.value = response.data.data;
            nextPageUrl.value = response.data.next_page_url;

            if (props.append) {
                let exists = false;

                filteredOptions.value.forEach((item) => {
                    if (item[props.valueName] == props.append[props.valueName]) {
                        exists = true;
                    }
                });

                if (!exists) {
                    filteredOptions.value.push(props.append);
                }
            }

            if (props.modelValue) {
                selected.value = filteredOptions.value.filter((option) => {
                    return option[props.valueName] == props.modelValue;
                })[0];
            } else {
                selected.value = response.data.data[0];
            }
        }).catch(error => console.log(error));
    }
});

const showDropDown = ref(false);

const selected = ref(null);

const emit = defineEmits(['update:modelValue']);

const select = (option) => {
    selected.value = option;
    emit('update:modelValue', selected.value[props.valueName]);
    if (props.options.length) {
        searchValue.value = '';
        filteredOptions.value = props.options;
    }
    showDropDown.value = false;
};

const searchValue = ref('');

const search = () => {
    if (props.options.length) {
        filteredOptions.value = props.options.filter((option) => {
            return option.name
                .toUpperCase()
                .includes(searchValue.value.toUpperCase());
        });
    } else {
        axios.get(props.source, {
            params: {
                search: searchValue.value,
            }
        }).then(response => {
            filteredOptions.value = response.data.data;
            nextPageUrl.value = response.data.next_page_url;
        }).catch(error => console.log(error.response));
    }

};

const loading = ref(false);

const loadMore = () => {
    loading.value = true;

    if (props.options.length) {
        loading.value = false;
        return;
    }

    if (nextPageUrl.value == null) {
        loading.value = false;
        return;
    }

    console.log(nextPageUrl.value);

    axios.get(nextPageUrl.value).then(response => {
        filteredOptions.value = filteredOptions.value.concat(response.data.data);
        loading.value = false;
        nextPageUrl.value = response.data.next_page_url;
    }).catch(error => console.log(error.response));
};
</script>

<template>
    <div>
        <!--        <div class="fixed top-0 left-0 w-full h-full z-20" @click="showDropDown = false" v-if="showDropDown"></div>-->
        <div class="relative mt-1">
            <button type="button" @click="showDropDown = ! showDropDown"
                    class="relative w-full cursor-pointer rounded-full border border-gray-300  py-2 pl-3 pr-10 text-left shadow-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary sm:text-sm"
                    :class="`bg-${bgColor} text-${txtColor}`"
                    aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                <span class="flex items-center" v-if="selected">
                    <img :src="selected[imageName]" alt="" class="h-6 w-6 flex-shrink-0 rounded">
                    <span class="ml-3 block truncate">{{ selected[textName] }}</span>
                </span>
                <span class="pointer-events-none absolute inset-y-0 ltr:right-0 rtl:left-0 ml-3 flex items-center pr-2">
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
                    v-infinite-scroll="loadMore"
                    v-loading="loading"
                    class="absolute z-30 mt-1 max-h-56 w-full overflow-auto rounded-lg  py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                    :class="`bg-${bgColor}`"
                    tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                    aria-activedescendant="listbox-option-3">
                    <li>
                        <div class="flex p-4">
                            <input type="search"
                                   v-model="searchValue"
                                   class="block w-full rounded border-gray-300 px-4 shadow-sm focus:border-primary focus:ring-primary sm:text-sm disabled:bg-gray-100"
                                   @input="search"
                                   placeholder="Search">
                        </div>
                    </li>

                    <li v-if="filteredOptions.length" v-for="option in filteredOptions" @click="select(option)"
                        class="relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-primary hover:text-white"
                        :class="`text-${txtColor}`"
                        id="listbox-option-0"
                        role="option">
                        <div class="flex items-center">
                            <img :src="option[imageName]" alt="" class="h-6 w-6 flex-shrink-0 rounded">
                            <span class="font-normal ml-3 block truncate"
                                  :class="{'font-semibold': option[valueName] == selected[valueName], 'font-normal': option[valueName] != selected[valueName]}">{{
                                    option[textName]
                                }}</span>
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
