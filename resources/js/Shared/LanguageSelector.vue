<script setup>
import { ref } from 'vue'

const value = ref('')

const languages = [
    {
        value: 'en',
        label: 'English',
    },
    {
        value: 'ar',
        label: 'العربيه',
    },

]
</script>
<template>
    <div class="ml-4 rtl:mr-4">
        <el-select v-model="selectedLocale" class="m-2" placeholder="Select" @change="setLocale" size="large">
            <el-option
                v-for="item in languages"
                :key="item.value"
                :label="item.label"
                :value="item.value"
            />
        </el-select>

    </div>
</template>

<script>
import Icon from './Icon.vue'
import { Link } from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        Icon,
        Link
    },
    data(){
        return{
            selectedLocale : this.$page.props.locale
        }
    },
    methods:{
        setLocale() {
            Inertia.post(route('language', [this.selectedLocale]) , {}, {
                preserveState:false,
                preserveScroll:false,
                onSuccess : () => {
                    window.location.reload()
                }
            })
        },
    },

    mounted() {
    },

}
</script>
