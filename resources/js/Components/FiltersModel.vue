<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import {
    XMarkIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import RichSelectInput from '@/Components/RichSelectInput.vue';
import Modal from '@/Components/Modal.vue';
import { ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import FixedActionBtn from '@/Components/FixedActionBtn.vue';
let age = ref([18, 70])
let rating = ref([0, 5])
const props = defineProps({
    positions: Array,
    form: Object,
    showFiltersModal: Boolean,
    countries: Array
})
let emit = defineEmits(['filter', 'reset', 'update:form'])
function filter() {
    emit('update:form', props.form)
    emit('filter')
}
function reset() {
    age.value = [18, 70]
    rating.value = [0, 5]
    emit('reset')
}

const locale = usePage().props.value.locale;

const distances = [5, 10, 20, 30, 40, 50];

</script>
<template>
    <FixedActionBtn @click="showFiltersModal = !showFiltersModal">
        <AdjustmentsHorizontalIcon class="w-10 h-10 text-white" />
    </FixedActionBtn>
    <Modal :show="showFiltersModal"
           max-width="sm"
           @close="showFiltersModal = false"
           :closeable="false">
        <div class="grid bg-black">
            <button class="p-1 justify-self-end"
                    @click="showFiltersModal = false">
                <XMarkIcon class="w-4 h-4 text-white" />
            </button>
            <div class="p-6">
                <div class="flex flex-col justify-end">
                    <p class=" text-sm text-white inset-4">{{ $t('filter') }} </p>
                    <button class="text-primary self-end"
                            @click="reset">
                        <!-- <XMarkIcon class="inline w-4 h-4 mr-4" /> -->
                        {{ $t('reset') }}
                    </button>
                </div>
                <form @submit.prevent="filter"
                      @keydown.enter.exact="filter">
                    <div class="px-4 my-6">
                        <InputLabel>{{ $t('age') }}</InputLabel>
                        <div class="py-2 border border-white rounded-full ">
                            <el-slider v-model="age"
                                       range
                                       class="p-4"
                                       :min="18"
                                       :max="70"
                                       @change="form.ageFrom = age[0] ; form.ageTo = age[1]" />
                        </div>
                    </div>
                    <div class="px-4 my-6">
                        <InputLabel>{{ $t('rating') }}</InputLabel>
                        <div class="py-1 border border-white rounded-full ">
                            <el-slider class="p-4"
                                       v-model="rating"
                                       range
                                       :min="0"
                                       :max="5"
                                       @change="form.ratingFrom = rating[0]; form.ratingTo = rating[1]  " />
                        </div>
                    </div>
                    <div class="px-4 my-6">
                        <InputLabel>{{ $t('search') }}</InputLabel>
                        <div class="p-1">
                            <input type="search"
                                   name="search"
                                   id="search"
                                   v-model="form.search"
                                   class="block w-full px-4 text-center text-white bg-black border-white rounded-full focus:border-primary focus:ring-primary sm:text-sm placeholder:center"
                                   :placeholder="$t('search by name or username')" />
                        </div>
                    </div>
                    <div class="px-4 my-6">
                        <InputLabel>{{ $t('location') }}</InputLabel>
                        <div class="">
                            <select id="location"
                                    name="location"
                                    v-model="form.location"
                                    class="block w-full py-2 pl-3 pr-10 mt-1 text-base text-center text-white bg-black border-white rounded-full focus:border-primary focus:outline-none focus:ring-primary sm:text-sm placeholder:center">
                                <option :value="null">{{ $t('distance') }}</option>
                                <option v-for="distance in distances"
                                        :key="distance"
                                        :value="distance">{{
                                            distance }} {{ $t('Km') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="px-4 my-6">
                        <InputLabel>{{ $t('nationality') }}</InputLabel>
                        <div class="py-1 ">
                            <RichSelectInput :options="countries"
                                             value-name="id"
                                             text-name="name"
                                             image-name="flag"
                                             v-model="form.country_id"
                                             bgColor="black"
                                             txtColor="white" />
                        </div>
                    </div>
                    <div class="px-4 my-6">
                        <InputLabel>{{ $t('position') }}</InputLabel>
                        <div class="p-1">
                            <select id="location"
                                    name="location"
                                    v-model="form.position"
                                    class="block w-full py-2 pl-3 pr-10 mt-1 text-base text-center text-white bg-black border-white rounded-full focus:border-primary focus:outline-none focus:ring-primary sm:text-sm placeholder:center">
                                <option :value="null">{{ $t('All positions') }}</option>
                                <option v-for="position in positions"
                                        :key="position.id"
                                        :value="position.id">{{
                                            position.name[locale] }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="my-6 mt-4">
                        <SecondaryButton @click="filter">{{ $t('apply') }}</SecondaryButton>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                    </div>
                </form>
            </div>
        </div>
    </Modal>
</template>
<style scoped>
.el-slider__button {
    border: 2px solid green;
}

.el-slider__bar {
    background-color: green;
    height: 0.15rem;
}

.el-slider__runway {
    height: 0.15rem;
}</style>
