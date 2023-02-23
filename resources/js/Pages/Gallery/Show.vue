<template>
    <AppLayout>
        <template #header>
            <p>Photos</p>
        </template>
        <div class="bg-white rounded-3xl px-4 py-6">
            <div class="w-full grid lg:grid-cols-2 gap-3 px-3 py-4 border rounded-2xl border-stone-400   max-w-5xl mx-auto">


                <div class="grid  gap-4 ">
                    <!-- image -->
                    <div class="rounded-3xl w-full aspect-video overflow-hidden"> <img :src="media.original_url" alt=""
                            class="object-cover w-full h-full ">
                    </div>
                    <!-- information -->
                    <div class="grid grid-cols-[min-content_1fr] gap-4">
                        <!-- col 1 -->
                        <div class="min-w-max ">
                            <Avatar username="peter emad" :size="'md'" :border="true" border-color="primary" />
                        </div>
                        <!-- col 2 -->
                        <div class="flex flex-col gap-3">
                            <!-- user information row 1-->
                            <div class="flex w-full justify-between">
                                <div class="flex flex-col gap-1 ">
                                    <div class="flex flex-row gap-2">
                                        <h3 class="font-bold m-0 text-lg leading-none  capitalize ">{{ 'peter emad' }} </h3>
                                        <span v-if="false">star icon</span>
                                    </div>
                                    <span class="text-xs text-stone-400 ">@{{ 'username' }} </span>
                                </div>
                                <div>...</div>
                            </div>
                            <!-- date and time and likes row 2-->
                            <div class="flex w-full text-sm justify-between text-stone-700">
                                <div class="flex flex-row gap-2">
                                    <span>2 days </span>
                                    <span>|</span>
                                    <span>12:08 PM</span>

                                </div>
                                <div>10 likes</div>
                            </div>
                            <!-- caption row 3 -->
                            <div>
                                <p class="text-sm text-stone-500">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio officiis et nisi hic eos
                                    recusandae quasi assumenda cupiditate blanditiis, iure autem praesentium perferendis
                                    velit
                                    molestias error nemo iste temporibus at!
                                </p>
                            </div>

                        </div>
                    </div>



                </div>
                <div>
                    <div>comment 5 </div>
                    <div>comments</div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Avatar from '../../Components/Avatar.vue';
const props = defineProps({
    media: null,
    user: null,
})

</script>

<style lang="scss" scoped></style>
