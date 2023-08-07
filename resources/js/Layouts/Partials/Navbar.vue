<script setup>
import { computed, onBeforeMount, onMounted, onUpdated, ref, watch } from 'vue';
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
import axios from 'axios';
import SlideInTransition from '@/Components/SlideInTransition.vue';

const locale = usePage().props.value.locale
const currentUser = usePage().props.value.auth.user
const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
const links = [
    { id: 1, label: 'home', routeName: 'home', current: 'home', icon: HomeIcon },
    { id: 2, label: 'chat', routeName: 'chats.index', current: 'chat.*', icon: ChatIcon },
    { id: 3, label: 'favorites', routeName: 'favorites.index', current: 'favorites.*', icon: HeartIcon },
    { id: 4, label: 'invitations', routeName: 'invitation.index', current: 'invitation.*', icon: FootBallIcon },
    { id: 5, label: 'more', routeName: 'more', current: 'more', icon: EllipsisHorizontalCircleIcon },
]
let state = usePage().props.value.user.state_name
let notificationsLength = ref(usePage().props.value.notifications.length)
let notifications = ref(usePage().props.value.notifications)
const showNotificationIndicator = ref(false)

watch(() => notificationsLength.value, (newValue) => {
    console.log(newValue);
    newValue > 0 ? showNotificationIndicator.value = true : showNotificationIndicator.value = false;

})
onMounted(() => {
    notificationsLength.value > 0 ? showNotificationIndicator.value = true : showNotificationIndicator.value = false
})
onUpdated(() => {
    notificationsLength.value > 0 ? showNotificationIndicator.value = true : showNotificationIndicator.value = false
})


function markAllNotificationsAsRead() {
    if (!showNotificationIndicator.value) return

    notifications.value.forEach((n, i) => {
        axios.post(route('api.notifications.mark-as-read', n.id)).then(res => {
            if (i === notificationsLength.value - 1) {
                showNotificationIndicator.value = false
            }
        }).catch(err => console.error(err)).finally(() => {
            showNotificationIndicator.value = false
        })

    })
}
</script>

<template>
    <nav class="bg-transparent">
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center h-16 gap-1 md:justify-between">
                <div class="hidden md:flex">
                    <!-- Navigation Links -->
                    <div class="items-center hidden gap-2 lg:gap-8 sm:-my-px md:flex">
                        <template v-for="link in links">
                            <NavLink :href="route(link.routeName)" :active="route().current(link.current)" class="">
                                <component :is="link.icon" class="w-4 h-4 text-primary" />
                                <span class="">
                                    {{ $t(link.label) }}
                                </span>
                            </NavLink>
                        </template>
                    </div>
                </div>
                <div class="flex items-center md:gap-x-3 max-md:justify-between max-md:w-full ">
                    <button
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md md:hidden hover:text-gray-500 hover:bg-gray-100 focus:outline-none hover:bg-transparent focus:text-gray-500"
                        @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <Bars3Icon class="w-6 h-6" />
                    </button>
                    <div class="flex items-center justify-between gap-2">
                        <!-- upgrade button  -->
                        <button class="rounded-full   bg-[#CFC27A] font-medium px-2 py-1 flex items-center gap-1 justify-evenly">
                            <span class="bg-black rounded-full">
                                <StarIcon class="w-4 h-4 fill-[#CFC27A]" />
                            </span>
                            <Link class="uppercase max-xs:text-xs" :href="route('upgrade')">{{ $t('subscribe') }}</Link>
                        </button>
                        <!-- user city  -->
                        <div class="flex items-center gap-1 rtl:flex-row-reverse ">
                            <MapPinIcon class="w-4 h-4 text-primary" />
                            <span class="text-white max-lg:w-min max-xs:text-xs">{{ currentUser.current_city }}</span>
                        </div>
                        <!-- Settings Dropdown -->
                        <div class="relative ">
                            <Link :href="route('profile.show')"
                                class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                            <Avatar :id="$page.props.auth.user.id" :image-url="$page.props.auth.user.avatar_url" :username="$page.props.auth.user.name"
                                :border="true" border-color="primary" size="sm" :enable-light-box="false" />
                            </Link>
                        </div>

                        <!-- Notifications Dropdown -->
                        <div class="relative">
                            <Dropdown :align="locale == 'en' ? 'right' : 'left'" width="96">
                                <template #trigger>
                                    <button class="text-white " @click="markAllNotificationsAsRead">
                                        <div class="relative">
                                            <BellIcon class="w-6 h-6 text-white"></BellIcon>
                                            <div v-show="showNotificationIndicator"
                                                class="absolute top-0 grid w-2 h-2 p-1 text-xs rounded-full bg-primary -right-0 place-items-center">
                                                <!-- <span class="text-xs origin-center ">{{ $page.props.notifications.length }}</span> -->
                                            </div>
                                        </div>
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Notifications -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ $t('notifications') }}
                                    </div>

                                    <div v-if="$page.props.notifications.length">
                                        <ul role="list" class="divide-y divide-gray-200 max-h-[calc(100dvh-200px)] overflow-y-auto">
                                            <template v-for="notification in $page.props.notifications">
                                                <NotificationComponent :notification="notification" />
                                            </template>
                                        </ul>
                                    </div>

                                    <div v-else>
                                        <div class="block px-4 py-2 text-xs text-center text-gray-500">
                                            {{ $t("you do not have any new notifications") }}
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
                </div>

            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <!-- Responsive Navigation Menu -->
        <div class="fixed top-0 bottom-0 left-0 right-0 z-40 bg-black bg-opacity-50 md:hidden"
            :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }" @click="showingNavigationDropdown = false"></div>
        <SlideInTransition>
            <div class="pt-2 pb-3 space-y-1 fixed top-0  bg-black h-full w-[max(20em,50%)] z-50" v-if="showingNavigationDropdown">
                <div class="flex">
                    <XMarkIcon class="w-5 m-3 text-white mis-auto" @click="showingNavigationDropdown = false" />
                </div>

                <!-- Responsive Settings Options -->
                <template v-for="link in links">
                    <ResponsiveNavLink :href="route(link.routeName)" :active="route().current(link.current)">
                        <component :is="link.icon" class="w-4 h-4 text-primary" />
                        <span>{{ $t(link.label) }}</span>
                    </ResponsiveNavLink>
                </template>
            </div>
        </SlideInTransition>
    </nav>
</template>
