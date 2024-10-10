<script setup>
import { ref } from "vue";
import Icon from "./Icon.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
const value = ref("");

const languages = [
    {
        value: "en",
        label: "English",
    },
    {
        value: "ar",
        label: "العربيه",
    },
];

let selectedLocale = ref(usePage().props.locale);
let loading = ref(false);
function setLocale() {
    loading.value = true;
    router.post(
        route("language", [selectedLocale.value]),
        {},
        {
            preserveState: false,
            preserveScroll: false,
            onSuccess: () => {
                window.location.reload();
            },
            onFinish: () => {
                loading.value = false;
            },
        }
    );
}
</script>
<template>
    <!-- <div class="ml-4 rtl:mr-4"> -->
    <el-select
        v-model="selectedLocale"
        class=""
        placeholder="Select"
        @change="setLocale"
    >
        <el-option
            v-for="item in languages"
            :key="item.value"
            :label="item.label"
            :value="item.value"
            :loading="true"
        />
    </el-select>

    <!-- </div> -->
</template>
<style>
.el-input {
    --el-select-input-focus-border-color: rgb(0, 100, 0);
    --el-input-border-radius: 30px;
    --el-input-border-color: rgb(107 114 128);
}
:root {
    --el-color-primary: rgb(0, 100, 0);
}
.el-input__inner:focus,
.el-input__inner {
    box-shadow: none;
    padding-left: 1rem;
    padding-right: 1rem;
}
</style>
