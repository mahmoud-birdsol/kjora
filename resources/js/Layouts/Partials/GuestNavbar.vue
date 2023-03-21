<script setup>
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import GuestLanguageSelector from "../../Shared/GuestLanguageSelector.vue";
const showMobileMenu = ref(false);
</script>

<template>
    <nav class="bg-transparent">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between items-center">
                <div class="hidden lg:block sm:w-1/3">
                    <GuestLanguageSelector class="w-full" />
                </div>
                <div class="sm:w-1/3 sm:flex sm:justify-center sm:items-center">
                    <img class="block h-20 mt-4 w-auto lg:hidden" src="/images/logo.png" alt="Your Company">
                    <img class="hidden h-20 mt-4 w-auto lg:block" src="/images/logo.png" alt="Your Company">
                </div>

                <div class="hidden min-h-[2rem] sm:w-1/3 sm:ml-6 sm:flex sm:justify-end sm:gap-8">
                    <NavLink :href="route('welcome')" :active="route().current('login') || route().current('welcome')">
                        {{$t('home')}}
                    </NavLink>
                    <NavLink :href="route('about')" :active="route().current('about')">{{$t('about')}}</NavLink>
                    <NavLink :href="route('contact')" :active="route().current('contact')">{{$t('contact')}}</NavLink>

                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                        aria-controls="mobile-menu" aria-expanded="false" @click="showMobileMenu = !showMobileMenu">
                        <span class="sr-only">Open main menu</span>

                        <!-- Menu Closed -->
                        <span v-if="!showMobileMenu">
                            <Bars3Icon class="block h-6 w-6" />
                        </span>

                        <!-- Menu Open -->
                        <span v-if="showMobileMenu">
                            <XMarkIcon class="block h-6 w-6" />
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <Transition
        enter-from-class="h-0"
        enter-to-class="h-44"
        enter-active-class="transition-all duration-500 overflow-hidden"
        leave-to-class="h-0"
        leave-from-class="h-44"
        leave-active-class="transition-all duration-500 overflow-hidden">
        <div class="relative h-" id="mobile-menu" v-if="showMobileMenu">
            <div class="space-y-1 pt-2 pb-3 mt-8 bg-transparent">
                <ResponsiveNavLink :href="route('welcome')"
                    :active="route().current('login') || route().current('welcome')">{{$t('home')}}
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('about')">{{$t('about')}}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('contact')">{{$t('contact')}}</ResponsiveNavLink>

            </div>
        </div>
    </Transition>
    </nav>
</template>
