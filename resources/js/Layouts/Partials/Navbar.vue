<script setup>
import { onBeforeMount, ref } from 'vue';
import { Inertia, usePage } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NotificationComponent from '@/Components/NotificationComponent.vue';
import ChatIcon from '../../Components/Icons/ChatIcon.vue';
import FootBallIcon from '../../Components/Icons/FootBallIcon.vue';
import {
    BellIcon,
    Bars3Icon,
    MapPinIcon, HomeIcon,
    HeartIcon,
    Cog6ToothIcon,
    EllipsisHorizontalCircleIcon,
    StarIcon,
} from '@heroicons/vue/24/outline';
import Avatar from '../../Components/Avatar.vue';
import { XMarkIcon } from '@heroicons/vue/20/solid';



const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <nav class="bg-transparent">
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex">
                    <!-- Navigation Links -->
                    <div class="items-center hidden gap-2 lg:gap-8 sm:-my-px md:flex">
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
                        <NavLink :href="route('favorites.index')" :active="route().current('favorites.index')">
                            <HeartIcon class="w-4 h-4 text-primary" />
                            <span>
                                Favorites
                            </span>
                        </NavLink>
                        <NavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                            <FootBallIcon class="fill-primary" />

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

                <div class="hidden md:flex md:gap-x-3 sm:items-center lg:ml-6">
                    <!-- upgrade button  -->
                    <button class="rounded-full bg-[#CFC27A] font-medium px-4 py-1 flex items-center gap-1 mie-5">
                        <div class="bg-black rounded-full">
                            <StarIcon class="w-4 h-4 fill-[#CFC27A]" />
                        </div>
                        <Link :href="route('upgrade')">Upgrade</Link>
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
                                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="min-w-max">
                                        <Avatar :image-url="$page.props.auth.user.avatar_url" :size="'md'"
                                            :username="$page.props.auth.user.name" :border="true" />
                                    </div>
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
                    <button class="rounded-full bg-[#CFC27A] font-medium px-4 py-1 flex items-center gap-1 mie-5">
                        <div class="bg-black rounded-full">
                            <StarIcon class="w-4 h-4 fill-[#CFC27A]" />
                        </div>
                        <Link :href="route('upgrade')">Upgrade</Link>
                    </button>
                    <button
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none hover:bg-transparent focus:text-gray-500"
                        @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <Bars3Icon class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            class="transition md:hidden relative overflow-hidden z-50">
            <div class="fixed top-0 right-0 left-0 bottom-0 bg-black bg-opacity-50"
                @click="showingNavigationDropdown = false"></div>
            <div class="pt-2 pb-3 space-y-1 fixed top-0 transition-all duration-1000 bg-primaryDark h-full w-[max(20em,50%)]">
                <XMarkIcon class="w-5 absolute right-0 m-3 text-white"
                    @click="showingNavigationDropdown = false" />
                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center justify-center px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="mr-3 shrink-0 min-w-max">
                            <Avatar :image-url="$page.props.auth.user.avatar_url" :size="'lg'"
                                :username="$page.props.auth.user.name" :border="true" />
                        </div>
                        <div>
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.username }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
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
                <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                    <HomeIcon class="w-4 h-4 text-primary" />
                    <span>Home</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('chats.index')" :active="route().current('chats.index')">
                    <ChatIcon class="w-4 h-4 text-primary" />
                    <span>Chat</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invitation.index')" :active="route().current('invitation.index')">
                    <FootBallIcon class="fill-primary" />
                    <span>Invitations</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('favorites.index')" :active="route().current('favorites.index')">
                    <HeartIcon class="w-4 h-4 text-primary" />
                    <span>Favorite</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('more')" :active="route().current('more')">
                    <EllipsisHorizontalCircleIcon class="w-4 h-4 text-primary" />
                    <span>More</span>
                </ResponsiveNavLink>

            </div>

        </div>
    </nav>
</template>
