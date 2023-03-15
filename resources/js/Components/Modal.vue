<script setup>
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    position: {
        required: false,
        type: String,
        default: 'center',
    },
    bodyScroll: {
        required: false,
        type: Boolean,
        default: false,
    },
    showCloseIcon: {
        required: false,
        type: Boolean,
        default: true,
    }
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show && !props.bodyScroll) {


        document.body.style.overflow = 'hidden';
    } else {

        document.body.style.overflow = null;
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
        '6xl': 'sm:max-w-6xl',
        '90': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200 ">
            <div v-show="show" class="fixed inset-0 z-50 grid items-center px-4 py-6 overflow-y-auto sm:px-0" scroll-region>
                <transition enter-active-class="duration-300 ease-out" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="duration-200 ease-in" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="show" class="fixed inset-0 transition-all transform" @click="close">
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </transition>

                <transition enter-active-class="duration-300 ease-out"
                    enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    enter-to-class="translate-y-0 opacity-100 sm:scale-100" leave-active-class="duration-200 ease-in"
                    leave-from-class="translate-y-0 opacity-100 sm:scale-100"
                    leave-to-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95">
                    <div v-show="show" class="">
                        <div v-show="position == 'center'"
                            class="mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:w-full sm:mx-auto"
                            :class="maxWidthClass">
                            <div class="flex justify-end px-6 py-6" v-if="closeable && showCloseIcon">
                                <button @click="$emit('close')">
                                    <XMarkIcon class="w-4 h-4 text-gray-900 hover:text-gray=500" />
                                </button>
                            </div>
                            <slot />
                        </div>

                        <div v-show="position == 'right'">
                            <div class="w-full mx-auto max-w-7xl">
                                <div class="flex justify-end">
                                    <div class="flex justify-center w-1/2">
                                        <div class="mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:w-full sm:mx-auto"
                                            :class="maxWidthClass">
                                            <div class="flex justify-end px-6 pt-6" v-if="closeable">
                                                <button @click="$emit('close')">
                                                    <XMarkIcon class="w-4 h-4 text-gray-900 hover:text-gray=500" />
                                                </button>
                                            </div>
                                            <slot v-if="show" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
