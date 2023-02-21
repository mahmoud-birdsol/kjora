<script setup>
import { ref } from 'vue';
import { Inertia, usePage } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NotificationComponent from '@/Components/NotificationComponent.vue';
import ChatIcon from '@/Components/ChatIcon.vue';
import {
    BellIcon,
    Bars3Icon,
    MapPinIcon, HomeIcon,
    HeartIcon,
    Cog6ToothIcon,
    EllipsisHorizontalCircleIcon,
    StarIcon
} from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <nav class="bg-transparent">
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-4  items-center sm:space-x-8 sm:-my-px md:flex">
                        <NavLink :href="route('home')" :active="route().current('home')" class="">
                            <HomeIcon class="w-4 h-4 text-primary" />
                            <span class="">
                                Home
                            </span>
                        </NavLink>
                        <NavLink :href="route('chats.index')" :active="route().current('chats.index')" class="">
                            <ChatIcon class="w-4 h-4 text-primary" />
                            <span>
                                Chat
                            </span>
                        </NavLink>
                        <NavLink :href="route('favourite')" :active="route().current('favourite')">
                            <HeartIcon class="w-4 h-4 text-primary" />
                            <span>
                                Favourite
                            </span>
                        </NavLink>
                        <NavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                            <Cog6ToothIcon class="w-4 h-4 text-primary" />
                            <span>
                                Invitation
                            </span>
                        </NavLink>
                        <NavLink :href="route('more')" :active="route().current('more')">
                            <EllipsisHorizontalCircleIcon class="w-4 h-4 text-primary" />
                            <span>
                                More
                            </span>
                        </NavLink>
                    </div>
                </div>

                <div class="hidden md:flex md:gap-x-3 sm:items-center sm:ml-6">
                    <!-- upgrade button  -->
                    <button class="rounded-full bg-[#CFC27A] font-medium px-4 py-1 flex items-center gap-1 mie-5">
                        <div class="rounded-full bg-black">
                            <StarIcon class="w-4 h-4 fill-[#CFC27A]" />
                        </div>
                        <span>Upgrade</span>
                    </button>
                    <!-- user city  -->
                    <div class="flex items-center gap-1 ">
                        <MapPinIcon class="w-4 h-4 text-primary" />
                        <span class="text-white w-max">{{ 'Egypt' }}</span>
                    </div> <!-- Settings Dropdown -->
                    <div class="relative ">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-10 h-10 rounded-full"
                                        :src="$page.props.user.avatar ? $page.props.user.avatar_url : `https://ui-avatars.com/api/?name=${$page.props.user.first_name}${$page.props.user.last_name}'&color=094609FF&background=E2E2E2`"
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

                                <div class="border-t border-gray-100" />

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
                    <div class="relative ">
                        <Dropdown width="96">
                            <template #trigger>
                                <button>
                                    <BellIcon class="w-6 h-6 text-white"></BellIcon>
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
                                            <NotificationComponent :notification="notification" />
                                        </template>
                                    </ul>
                                </div>

                                <div v-else>
                                    <div class="block px-4 py-2 text-xs text-center text-gray-500">
                                        You don't have any new notifications.
                                    </div>
                                </div>

                                <div class="block px-4 py-2 text-xs text-center text-sky-500">
                                    <Link :href="route('notification.index')" class="text-sky-500 hover:text-sky-700">
                                    View all
                                    </Link>
                                </div>
                            </template>
                        </Dropdown>
                    </div>

                </div>

                <!-- Hamburger -->
                <div class="flex items-center -mr-2 space-x-2 md:hidden">
                    <div class="relative ml-3">
                        <Dropdown width="96">
                            <template #trigger>
                                <button>
                                    <BellIcon class="w-6 h-6 text-white"></BellIcon>
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
                                            <NotificationComponent :notification="notification" />
                                        </template>
                                    </ul>
                                </div>

                                <div v-else>
                                    <div class="block px-4 py-2 text-xs text-center text-gray-500">
                                        You don't have any new notifications.
                                    </div>
                                </div>

                                <div class="block px-4 py-2 text-xs text-center text-sky-500">
                                    <Link :href="route('notification.index')" class="text-sky-500 hover:text-sky-700">
                                    View all
                                    </Link>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                    <button
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500"
                        @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <Bars3Icon class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            class="md:hidden transition">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                    Home
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                    Chat
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                    Invitations
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                    Favorite
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                    More
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="mr-3 shrink-0">
                        <img class="object-cover w-10 h-10 rounded-full"
                            :src="$page.props.user.avatar ? $page.props.user.avatar_url : `https://ui-avatars.com/api/?name=${$page.props.user.first_name}${$page.props.user.last_name}'&color=094609FF&background=E2E2E2`"
                            :alt="$page.props.user.name">
                    </div>
                    <div>
                        <div class="text-base font-medium text-gray-800">
                            {{ $page.props.user.username }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            {{ $page.props.user.email }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                        Profile
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('identity.verification.create')"
                        :active="route().current('identity.verification.create')">
                        Identity Verification
                    </ResponsiveNavLink>

                    <div class="border-t border-gray-100" />

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
