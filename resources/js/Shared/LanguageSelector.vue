<template>
    <div class=" text-white">
        <button @click="setLocale">
<!--            <icon :lang="selectable_locale" class="w-5 h-5" :name="selectable_locale" />-->
            <span class="font-semibold" v-if="selectable_locale == 'ar'">العربية</span>
            <span class="font-semibold" v-if="selectable_locale == 'en'">EN</span>
        </button>
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
    methods:{
        setLocale() {
            Inertia.post(route('language', [this.selectable_locale]) , {}, {
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
    computed: {
        selectable_locale() {
            if(this.$page.props.locale == 'ar') {
                return 'en';
            }
            return 'ar';
        }
    },
}
</script>
