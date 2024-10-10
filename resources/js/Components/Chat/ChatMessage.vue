<script setup>
import { computed, ref } from "@vue/reactivity";
import ReplyIcon from "../Icons/ReplyIcon.vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/20/solid";
import { TrashIcon, ArrowDownCircleIcon } from "@heroicons/vue/24/outline";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import dayjs from "dayjs";
import MediaPreview from "@/Components/MediaPreview.vue";
import { useChat } from "../../stores/chat";
import ChatGallery from "./MediaGallery.vue";
import SingleMediaPreview from "./SingleMediaPreview.vue";
import MediaThumbnails from "./MediaThumbnails.vue";
import Avatar from "@/Components/Avatar.vue";
import DateTranslation from "@/Components/DateTranslation.vue";

import axios from "axios";
import ConfirmationModal from "../ConfirmationModal.vue";
import FadeInTransition from "../FadeInTransition.vue";
const chat = useChat();
const props = defineProps({
    message: Object,
    player: null,
});
const emits = defineEmits(["reply"]);
onMounted(() => {
    setTimeout(() => {
        props.message.new = false;
    }, 10000);

    // props.message.media.media !== [] && console.log(props.message.media)
});
const currentUser = usePage().props.auth.user;
const showOptions = ref(false);
const showMediaGallery = ref(false);
const showSingleMediaGallery = ref(false);
const showDeleteMessage = ref(false);
const imagesVideosOnly = props.message.attachments.filter(
    (a) => a.mime_type.startsWith("image") || a.mime_type.startsWith("video")
);
const otherMedia = props.message.attachments.filter(
    (a) => !a.mime_type.startsWith("image") && !a.mime_type.startsWith("video")
);

const isCurrentUser = computed(() => {
    return props.message.sender_id === currentUser.id;
});
const alignmentClass = computed(() => {
    return isCurrentUser.value ? "self-end  " : "self-start   ";
});
const parentClasses = computed(() => {
    return isCurrentUser.value
        ? "relative flex justify-end   pie-8 "
        : "flex gap-2 items-center  ";
});
const bodyClass = computed(() => {
    return isCurrentUser.value
        ? " bg-primary text-white rounded-br-none"
        : " bg-stone-200 text-black rounded-bl-none";
});
const repliedClasses = computed(() => {
    return isCurrentUser.value
        ? "bg-white text-black  "
        : "bg-primary text-white  ";
});
const newMessageClasses = computed(() => {
    return props.message?.new
        ? 'border-t-2    border-green-400 relative before:content-["New"] before:absolute before:-top-3 before:bg-white before:right-3 before:text-sm before:text-green-700 before:px-1 '
        : "";
});
function handleReply(e) {
    // emits('reply', props.message)
    chat.setMessageToReplyTo(props.message);
    showOptions.value ? (showOptions.value = false) : null;
}

function deleteMessage() {
    axios.delete(route("api.messages.delete", props.message.id));
    showOptions.value = false;
    chat.deleteMessage(props.message.id);
}
</script>
<template>
    <FadeInTransition appear>
        <div
            :class="[alignmentClass, parentClasses, newMessageClasses]"
            class="w-full pt-2 transition-all duration-150"
        >
            <!-- avatar for non current user message -->
            <template v-if="!isCurrentUser">
                <div class="self-start">
                    <Avatar
                        :id="player.id"
                        :image-url="player.avatar_url"
                        :size="'md'"
                        :username="player.name"
                        :border="true"
                    />
                </div>
            </template>
            <!-- message body -->
            <div class="max-w-[60%]">
                <div :class="[bodyClass]" class="max-w-full p-4 rounded-2xl">
                    <!-- replied message -->
                    <div
                        v-if="message.parent_id"
                        :class="repliedClasses"
                        class="p-3 mb-2 text-xs rounded-lg"
                    >
                        <!-- name -->
                        <div
                            class="mb-2 font-semibold capitalize"
                            :class="
                                isCurrentUser ? 'text-primary' : 'text-white'
                            "
                        >
                            <h4 v-if="message.parent?.sender_id === player.id">
                                {{ player.name }}
                            </h4>
                            <h4 v-else>{{ currentUser.name }}</h4>
                        </div>
                        <span class="">{{ message.parent?.body }}</span>
                        <MediaPreview
                            v-if="message.parent.attachments[0]"
                            :fileType="message.parent.attachments[0].mime_type"
                            :filePreview="
                                message.parent.attachments[0].original_url
                            "
                            :fileName="message.parent.attachments[0].name"
                        />
                    </div>
                    <!-- media message -->
                    <template
                        v-if="
                            message.attachments &&
                            message.attachments.length === 1
                        "
                    >
                        <SingleMediaPreview
                            @showGallery="showSingleMediaGallery = true"
                            :media="message.attachments[0]"
                            :is-current-user="isCurrentUser"
                            class="cursor-pointer"
                        />
                        <ChatGallery
                            :show="showSingleMediaGallery"
                            @close="showSingleMediaGallery = false"
                            :media="message.attachments"
                            :user="message.message_sender"
                        />
                    </template>
                    <!-- message.attachments && message.attachments.length > 1 -->
                    <template v-if="message.attachments.length > 1">
                        <!-- images and videos -->
                        <div
                            v-if="imagesVideosOnly.length"
                            class="grid max-w-[200px] grid-cols-2 gap-2 place-items-center"
                            :class="
                                imagesVideosOnly.length > 2 ? 'grid-rows-2' : ''
                            "
                        >
                            <MediaThumbnails :media="imagesVideosOnly[0]" />
                            <MediaThumbnails
                                v-if="imagesVideosOnly.length > 2"
                                :media="imagesVideosOnly[1]"
                            />
                            <div
                                v-if="imagesVideosOnly.length == 2"
                                class="relative w-full aspect-square"
                                @click="showMediaGallery = true"
                            >
                                <MediaThumbnails :media="imagesVideosOnly[1]" />
                                <div
                                    class="absolute inset-0 grid font-bold text-white rounded-md cursor-pointer max-sm:text-xs bg-stone-700/70 place-items-center"
                                >
                                    {{
                                        `${
                                            $page.props.locale == "en"
                                                ? "show all"
                                                : "عرض الجميع"
                                        }`
                                    }}
                                </div>
                            </div>
                            <MediaThumbnails
                                v-if="imagesVideosOnly[2]"
                                :media="imagesVideosOnly[2]"
                            />
                            <div
                                v-if="imagesVideosOnly.length >= 3"
                                class="relative w-full aspect-square"
                                @click="showMediaGallery = true"
                            >
                                <MediaThumbnails :media="imagesVideosOnly[4]" />
                                <div
                                    class="absolute inset-0 grid font-bold text-white rounded-md cursor-pointer bg-stone-700/70 place-items-center max-sm:text-xs"
                                >
                                    {{
                                        imagesVideosOnly.length > 3
                                            ? `+ ${
                                                  imagesVideosOnly.length - 3
                                              } ${
                                                  $page.props.locale == "en"
                                                      ? "more..."
                                                      : "المزيد ..."
                                              }`
                                            : `${
                                                  $page.props.locale == "en"
                                                      ? "show all"
                                                      : "عرض الجميع"
                                              }`
                                    }}
                                </div>
                            </div>
                        </div>
                        <!-- docs and PDFs   -->
                        <div
                            v-if="otherMedia.length"
                            class="flex flex-col gap-1 mt-2"
                        >
                            <template
                                v-for="(item, index) in otherMedia"
                                :key="item.id"
                            >
                                <SingleMediaPreview
                                    :media="item"
                                    :is-current-user="isCurrentUser"
                                />
                            </template>
                        </div>
                        <ChatGallery
                            :show="showMediaGallery"
                            @close="showMediaGallery = false"
                            :media="imagesVideosOnly"
                            :user="message.message_sender"
                        />
                    </template>
                    <!-- text message -->

                    <div class="break-all whitespace-pre-wrap">
                        {{ message.body }}
                    </div>
                </div>
                <!-- date -->
                <div
                    class="mt-2 text-xs"
                    :class="isCurrentUser ? 'text-end' : null"
                >
                    <!-- date -->
                    <span v-if="isCurrentUser">
                        <template v-if="message.read_at">
                            <DateTranslation
                                :start="message.read_at"
                                format="hh:mm A"
                            />
                        </template>
                        <template v-else>
                            <DateTranslation
                                :start="message.created_at"
                                format="hh:mm A"
                            />
                        </template>
                    </span>
                    <span v-if="!isCurrentUser">
                        <DateTranslation
                            :start="message.created_at"
                            format="hh:mm A"
                        />
                    </span>
                    <!-- read status -->
                    <template v-if="isCurrentUser">
                        <span> | </span>
                        <span class="capitalize text-primary">{{
                            message.read_at ? "r" : "s"
                        }}</span>
                    </template>
                </div>
            </div>
            <!-- options menu if message of the current user -->
            <div
                v-if="isCurrentUser"
                class="absolute top-0 ltr:right-0 rtl:left-0"
            >
                <button @click="showOptions = !showOptions">
                    <EllipsisVerticalIcon class="w-6 text-neutral-500" />
                </button>
                <OnClickOutside @trigger="showOptions = false">
                    <Transition
                        enterFromClass="opacity-0"
                        enterToClass="opacity-100"
                        leaveFromClass="opacity-100"
                        leaveToClass="opacity-0"
                        leave-active-class="transition-all duration-150 ease-in"
                        enterActiveClass="transition-all duration-150 ease-out"
                    >
                        <div
                            v-show="showOptions"
                            class="absolute z-20 px-6 py-2 text-xs text-white bg-black border -top-1 rounded-xl border-neutral-500 pie-10 z-2 rtl:left-7 ltr:right-7"
                        >
                            <ul class="flex flex-col justify-center gap-y-2">
                                <button
                                    class="hover:text-gray-400"
                                    @click="showDeleteMessage = true"
                                >
                                    <li
                                        class="flex items-center justify-center gap-x-2 rtl:flex-row-reverse"
                                    >
                                        <TrashIcon class="w-4" />
                                        <span> {{ $t("delete") }}</span>
                                    </li>
                                    <ConfirmationModal
                                        :show="showDeleteMessage"
                                        @close="showDeleteMessage = false"
                                        @delete="deleteMessage"
                                    >
                                        <template #body>
                                            <span>{{
                                                $t(
                                                    "Are you sure you want delete this message ? "
                                                )
                                            }}</span>
                                        </template>
                                    </ConfirmationModal>
                                </button>
                                <button
                                    class="hover:text-gray-400 group"
                                    @click="handleReply"
                                >
                                    <li
                                        class="flex items-center justify-center gap-x-2 rtl:flex-row-reverse"
                                    >
                                        <ReplyIcon
                                            class="cursor-pointer fill-transparent group-hover:stroke-gray-400 stroke-white rtl:mis-2"
                                        >
                                        </ReplyIcon>
                                        <span>{{ $t("Quote") }}</span>
                                    </li>
                                </button>
                            </ul>
                        </div>
                    </Transition>
                </OnClickOutside>
            </div>
            <!-- reply icon for non current user message -->
            <button
                v-if="!isCurrentUser"
                @click="chat.setMessageToReplyTo(message)"
            >
                <ReplyIcon
                    class="fill-transparent hover:fill-black stroke-black"
                ></ReplyIcon>
            </button>
        </div>
    </FadeInTransition>
</template>
<style scoped></style>
