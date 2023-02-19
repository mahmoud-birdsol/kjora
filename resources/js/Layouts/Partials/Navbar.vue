<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NotificationComponent from '@/Components/NotificationComponent.vue';
import {
    BellIcon,
    Bars3Icon,
} from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <nav class="bg-transparent">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <NavLink :href="route('home')" :active="route().current('home')">
                            Home
                        </NavLink>

                        <NavLink :href="route('invitation.index')" :active="route().current('invitation.idnex')">
                            Invitation
                        </NavLink>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                         :src="$page.props.user.avatar_url ? $page.props.user.avatar_url : 'https://ui-avatars.com/api/?name=' + $page.props.user.first_name + ' ' + $page.props.user.last_name + '&color=094609FF&background=E2E2E2'"
                                         :alt="$page.props.user.name">
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.show')">
                                    Profile
                                </DropdownLink>

                                <DropdownLink :href="route('identity.verification.create')">
                                    Identity Verification
                                </DropdownLink>

                                <div class="border-t border-gray-100"/>

                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        Log Out
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Notifications Dropdown -->
                    <div class="ml-3 relative">
                        <Dropdown width="96">
                            <template #trigger>
                                <button>
                                    <BellIcon class="h-6 w-6 text-white"></BellIcon>
                                </button>
                            </template>

                            <template #content>
                                <!-- Notifications -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Notifications
                                </div>

                                <div v-if="$page.props.notifications.length">
                                    <ul role="list" class="divide-y divide-gray-200">
                                        <template v-for="notification in $page.props.notifications">
                                            <NotificationComponent :notification="notification"/>
                                        </template>
                                    </ul>
                                </div>

                                <div v-else>
                                    <div class="block px-4 py-2 text-xs text-gray-500 text-center">
                                        You don't have any new notifications.
                                    </div>
                                </div>

                                <div class="block px-4 py-2 text-xs text-sky-500 text-center">
                                    <Link :href="route('notification.index')"
                                          class="text-sky-500 hover:text-sky-700">View all
                                    </Link>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden space-x-2">
                    <div class="ml-3 relative">
                        <Dropdown width="96">
                            <template #trigger>
                                <button>
                                    <BellIcon class="h-6 w-6 text-white"></BellIcon>
                                </button>
                            </template>

                            <template #content>
                                <!-- Notifications -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Notifications
                                </div>

                                <div v-if="$page.props.notifications.length">
                                    <ul role="list" class="divide-y divide-gray-200">
                                        <template v-for="notification in $page.props.notifications">
                                            <NotificationComponent :notification="notification"/>
                                        </template>
                                    </ul>
                                </div>

                                <div v-else>
                                    <div class="block px-4 py-2 text-xs text-gray-500 text-center">
                                        You don't have any new notifications.
                                    </div>
                                </div>

                                <div class="block px-4 py-2 text-xs text-sky-500 text-center">
                                    <Link :href="route('notification.index')"
                                          class="text-sky-500 hover:text-sky-700">View all
                                    </Link>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                    <button
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                        @click="showingNavigationDropdown = ! showingNavigationDropdown">
                        <Bars3Icon class="h-6 w-6"/>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
             class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route('home')"
                                   :active="route().current('home')">
                    Home
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('invitation.index')"
                                   :active="route().current('invitation.index')">
                    Invitations
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover"
                             :src="'/' + $page.props.user.avatar" :alt="$page.props.user.name">
                    </div>

                    <div>
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.user.username }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {{ $page.props.user.email }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.show')"
                                       :active="route().current('profile.show')">
                        Profile
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('identity.verification.create')"
                                       :active="route().current('identity.verification.create')">
                        Identity Verification
                    </ResponsiveNavLink>

                    <div class="border-t border-gray-100"/>

                    <form method="POST" @submit.prevent="logout">
                        <ResponsiveNavLink as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</template>
