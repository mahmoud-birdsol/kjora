<template>
    <div class="px-4 py-4 bg-white sm:px-8 rounded-3xl">
        <div class="grid w-full h-full gap-3 border lg:grid-cols-2 rounded-2xl border-stone-400 ">
            <!-- image and caption left col -->
            <div class="flex flex-col max-w-full gap-6 p-3 ">
                <!-- media -->

                <slot name="media"/>

                <!-- post information -->
                <div class="grid xs:grid-cols-[min-content_1fr] gap-4">


                    <!-- col 1 user image-->
                    <div class="min-w-max ">
                        <slot name="userImage"></slot>
                    </div>
                    <!-- col 2 post information -->
                    <div class="flex flex-col gap-3">
                        <!-- user information row 1-->
                        <slot name="userInfo"></slot>
                        <!-- date and time and likes row 2-->
                        <slot name="postDate&Time"></slot>
                        <slot name="postCaption"></slot>
                        <!-- caption row 3 -->
                    </div>


                    <!-- col 1 user image -->
                </div>
            </div>
            <!-- comment and replies right col -->
            <div class="flex flex-col h-full gap-2 max-lg:border-t ltr:lg:border-l rtl:lg:border-r border-stone-300">
                <!-- header -->
                <slot name="commentsCount"></slot>
                <!-- comments -->
                <div class="self-stretch h-full p-3 px-6 ">
                    <slot name="postComments"></slot>
                </div>
                <!-- new comment form -->
                <div class="flex flex-row items-center self-end w-full p-3 border-t gap-x-3 border-stone-300">
                    <slot name="newCommentForm"></slot>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped></style>
