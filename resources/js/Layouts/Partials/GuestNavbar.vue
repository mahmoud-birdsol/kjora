<script setup>
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const showMobileMenu = ref(false);
</script>

<template>
    <nav class="bg-transparent">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between items-center">
                <div class="hidden lg:block sm:w-1/3"></div>
                <div class="sm:w-1/3 sm:flex sm:justify-center sm:items-center">
                    <img class="block h-20 mt-8 w-auto lg:hidden"
                         src="/images/logo.png" alt="Your Company">
                    <img class="hidden h-20 mt-8 w-auto lg:block"
                         src="/images/logo.png" alt="Your Company">
                </div>

                <div class="hidden sm:w-1/3 sm:ml-6 sm:flex sm:justify-end sm:space-x-8">
                    <NavLink :href="route('welcome')"
                             :active="route().current('login') || route().current('welcome')">Home
                    </NavLink>
                    <NavLink href="#">About</NavLink>
                    <NavLink href="#">Contact</NavLink>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                            aria-controls="mobile-menu" aria-expanded="false" @click="showMobileMenu = !showMobileMenu">
                        <span class="sr-only">Open main menu</span>

                        <!-- Menu Closed -->
                        <span v-if="!showMobileMenu">
                            <Bars3Icon class="block h-6 w-6"/>
                        </span>

                        <!-- Menu Open -->
                        <span v-if="showMobileMenu">
                            <XMarkIcon class="block h-6 w-6"/>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div class="sm:hidden" id="mobile-menu" v-if="showMobileMenu">
            <div class="space-y-1 pt-2 pb-3">
                <ResponsiveNavLink :href="route('welcome')"
                                   :active="route().current('login') || route().current('welcome')">Home
                </ResponsiveNavLink>
                <ResponsiveNavLink href="#">About</ResponsiveNavLink>
                <ResponsiveNavLink href="#">Contact</ResponsiveNavLink>
            </div>
        </div>
    </nav>
</template>
