<script setup>
import { onBeforeMount, ref } from 'vue';
import { Inertia, } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NotificationComponent from '@/Components/NotificationComponent.vue';
import ChatIcon from '@/Components/Icons/ChatIcon.vue';
import FootBallIcon from '@/Components/Icons/FootBallIcon.vue';
import {
    BellIcon,
    Bars3Icon,
    MapPinIcon, HomeIcon,
    HeartIcon,
    Cog6ToothIcon,
    EllipsisHorizontalCircleIcon,
    StarIcon,
} from '@heroicons/vue/24/outline';
import Avatar from "@/Components/Avatar.vue";
import { XMarkIcon } from '@heroicons/vue/20/solid';

const locale = usePage().props.value.locale
const currentUser = usePage().props.value.auth.user
const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
let state = usePage().props.value.user.state_name

</script>

<template>
    <nav class="bg-transparent">
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center h-16 md:justify-between">
                <div class="hidden md:flex">
                    <!-- Navigation Links -->
                    <div class="items-center hidden gap-2 lg:gap-8 sm:-my-px md:flex">
                        <NavLink :href="route('home')" :active="route().current('home')" class="">
                            <HomeIcon class="w-4 h-4 text-primary" />
                            <span class="">
                                {{ $t('home') }}
                            </span>
                        </NavLink>
                        <NavLink :href="route('chats.index')" :active="route().current('chats.index')" class="">
                            <ChatIcon class="w-4 h-4 text-primary" />
                            <span>
                                {{ $t('chat') }}
                            </span>
                        </NavLink>
                        <NavLink :href="route('favorites.index')" :active="route().current('favorites.index')">
                            <HeartIcon class="w-4 h-4 text-primary" />
                            <span>
                                {{ $t('favorites') }}
                            </span>
                        </NavLink>
                        <NavLink :href="route('invitation.index')" :active="route().current('invitation.index') || route().current('hire.index')">
                            <FootBallIcon class="fill-primary" />

                            <span>
                                {{ $t('invitations') }}
                            </span>
                        </NavLink>
                        <NavLink :href="route('more')" :active="route().current('more')">
                            <EllipsisHorizontalCircleIcon class="w-4 h-4 text-primary" />
                            <span>
                                {{ $t('more') }}
                            </span>
                        </NavLink>
                    </div>
                </div>
                <div class="hidden md:flex md:gap-x-3 sm:items-center lg:ml-6">
                    <!-- upgrade button  -->
                    <button class="rounded-full bg-[#CFC27A] font-medium px-4 py-1 flex items-center gap-1 mie-5"
                        v-if="state !== 'Premium'">
                        <span class="bg-black rounded-full">
                            <StarIcon class="w-4 h-4 fill-[#CFC27A]" />
                        </span>
                        <Link :href="route('upgrade')">{{ $t('upgrade') }}</Link>
                    </button>
                    <!-- user city  -->
                    <div class="flex items-center gap-1 ">
                        <MapPinIcon class="w-4 h-4 text-primary" />
                        <span class="text-white w-max">{{ currentUser.current_city }}</span>
                    </div> <!-- Settings Dropdown -->
                    <div class="relative ">
                        <Dropdown :align="locale == 'en' ? 'right' : 'left'" width="48">
                            <template #trigger>
                                <button
                                    class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <Avatar :id="$page.props.auth.user.id" :image-url="$page.props.auth.user.avatar_url"
                                        :username="$page.props.auth.user.name" :border="true" border-color="primary"
                                        size="sm" :enable-light-box="false" />
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.show')">
                                    {{ $t('profile') }}
                                </DropdownLink>

                                <DropdownLink :href="route('identity.verification.create')">
                                    {{ $t('identity-verification') }}
                                </DropdownLink>

                                <div class="border-t border-gray-100" />

                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        {{ $t('log-out') }}
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Notifications Dropdown -->
                    <div class="relative">
                        <Dropdown :align="locale == 'en' ? 'right' : 'left'" width="96">
                            <template #trigger>
                                <button>
                                    <BellIcon class="w-6 h-6 text-white"></BellIcon>
                                </button>
                            </template>

                            <template #content>
                                <!-- Notifications -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ $t('notifications') }}
                                </div>

                                <div v-if="$page.props.notifications.length">
                                    <ul role="list"
                                        class="divide-y divide-gray-200 max-h-[calc(100dvh-200px)] overflow-y-auto">
                                        <template v-for="notification in $page.props.notifications">
                                            <NotificationComponent :notification="notification" />
                                        </template>
                                    </ul>
                                </div>

                                <div v-else>
                                    <div class="block px-4 py-2 text-xs text-center text-gray-500">
                                        {{ $t("you-don't-have-any-new-notifications") }}.
                                    </div>
                                </div>

                                <div class="block px-4 py-2 text-xs text-center ">
                                    <Link :href="route('notification.index')" class="text-primary hover:text-primaryDark">
                                    {{ $t('view-all') }}
                                    </Link>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Mobile navigation menu. -->
                <div class="flex justify-between items-center -mr-2 space-x-2 rtl:flex-row-reverse md:hidden w-full">
                    <button
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none hover:bg-transparent focus:text-gray-500"
                        @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <Bars3Icon class="w-6 h-6" />
                    </button>
                    <button class="rounded-full bg-[#CFC27A] font-medium px-4 py-1 flex items-center gap-1 mie-5"
                        v-if="state !== 'Premium'">
                        <span class="bg-black rounded-full">
                            <StarIcon class="w-4 h-4 fill-[#CFC27A]" />
                        </span>
                        <Link :href="route('upgrade')">{{ $t('upgrade') }}</Link>
                    </button>
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
                                    {{ $t('notifications') }}
                                </div>

                                <div v-if="$page.props.notifications.length">
                                    <ul role="list"
                                        class="divide-y divide-gray-200 max-h-[calc(100dvh-200px)] overflow-y-auto">
                                        <template v-for="notification in $page.props.notifications">
                                            <NotificationComponent :notification="notification" />
                                        </template>
                                    </ul>
                                </div>

                                <div v-else>
                                    <div class="block px-4 py-2 text-xs text-center text-gray-500">
                                        {{ $t("you-don't-have-any-new-notifications") }}.
                                    </div>
                                </div>

                                <div class="block px-4 py-2 text-xs text-center">
                                    <Link :href="route('notification.index')" class="text-primary hover:text-primaryDark">
                                        {{ $t('view-all') }}
                                    </Link>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <!-- Responsive Navigation Menu -->
        <div class="fixed top-0 bottom-0 left-0 right-0 z-40 bg-black bg-opacity-50"
            :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            @click="showingNavigationDropdown = false"></div>
        <Transition enter-from-class="ltr:-left-full rtl:-right-full" enter-to-class="ltr:left-0 rtl:right-0"
            enter-active-class="transition-all duration-700" leave-to-class="ltr:-left-full rtl:-right-full"
            leave-from-class="ltr:left-0 rtl:right-0" leave-active-class="transition-all duration-700">
            <div class="pt-2 pb-3 space-y-1 fixed top-0  bg-black h-full w-[max(20em,50%)] z-50"
                v-if="showingNavigationDropdown">
                <XMarkIcon class="absolute w-5 m-3 text-white ltr:right-0 rtl:left-0"
                    @click="showingNavigationDropdown = false" />

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-gray-200">
                    <div class="flex px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="mx-3 shrink-0 min-w-max">
                            <Avatar :id="$page.props.auth.user.id" :image-url="$page.props.auth.user.avatar_url" :size="'lg'"
                                :username="$page.props.auth.user.name" :border="true" />
                        </div>
                        <div>
                            <div class="text-base font-medium text-white">
                                {{ $page.props.auth.user.username }}
                            </div>
                            <div class="text-sm font-medium text-stone-300">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                            {{ $t('profile') }}
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('identity.verification.create')"
                            :active="route().current('identity.verification.create')">
                            {{ $t('identity-verification') }}
                        </ResponsiveNavLink>


                        <form method="POST" @submit.prevent="logout">
                            <ResponsiveNavLink as="button">
                                {{ $t('log-out') }}
                            </ResponsiveNavLink>
                        </form>
                        <div class="border-t border-gray-100" />
                    </div>
                </div>
                <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                    <HomeIcon class="w-4 h-4 text-primary" />
                    <span>{{ $t('home') }}</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('chats.index')" :active="route().current('chats.index')">
                    <ChatIcon class="w-4 h-4 text-primary" />
                    <span>{{ $t('chat') }}</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invitation.index')" :active="route().current('invitation.index') || route().current('hire.index')">
                    <FootBallIcon class="fill-primary" />
                    <span>{{ $t('invitations') }}</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('favorites.index')" :active="route().current('favorites.index')">
                    <HeartIcon class="w-4 h-4 text-primary" />
                    <span>{{ $t('favorites') }}</span>
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('more')" :active="route().current('more')">
                    <EllipsisHorizontalCircleIcon class="w-4 h-4 text-primary" />
                    <span>{{ $t('more') }}</span>
                </ResponsiveNavLink>

            </div>
        </Transition>
    </nav>
</template>
