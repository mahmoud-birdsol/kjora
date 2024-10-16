<script setup>
import { computed } from 'vue'

const emit = defineEmits(['update:checked'])

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
    rounded:{
        type: Boolean,
        default: false,
    }
});

const proxyChecked = computed({
	get() {
		return props.checked
	},

	set(val) {
		emit('update:checked', val)
	},
})
</script>

<template>
    <input
        v-model="proxyChecked"
        type="checkbox"
        :value="value"
        :class="['mx-1 border-gray-300  shadow-sm focus:border-indigo-300 focus:ring focus:ring-primary focus:ring-opacity-50',
        rounded ? '' : 'rounded-full'
        ]">
</template>
