<template>
    <Splide dir="ltr" class="" :options="options">
        <template v-for="media in postMedia" :key="media.id">
            <SplideSlide class="">
                <div class="flex justify-center overflow-hidden group rounded-3xl aspect-video ">
                    <img v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')"
                        :src="media.original_url" alt="" class="object-contain h-full ">
                    <video v-if="media.mime_type.startsWith('video')" controls :src="media.original_url" alt=""
                        class="object-contain h-full " />
                    <!-- delete single media -->
                    <!-- <button v-if="currentUser.id === user.id"
                                        @click.prevent.stop="showDeleteMediaModal = true"
                                        class="absolute top-0 right-0 hidden bg-white group-hover:block bg-opacity-90 rounded-bl-xl">
                                        <div class="flex flex-col items-start justify-center h-full p-1 opacity-100 ">
                                            <XMarkIcon class="w-5 h-5 text-stone-800" />
                                        </div>
                                        <Modal :show="showDeleteMediaModal" @close="showDeleteMediaModal = false"
                                            :closeable="true" :show-close-icon="false" :max-width="'sm'">
                                            <div class="flex flex-col justify-center p-6 text-stone-800 ">
                                                <p class="mb-3 text-lg">Are you sure you want delete this
                                                    post ?</p>
                                                <div class="flex justify-center w-full gap-4">
                                                    <button
                                                        class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                                                        @click="showDeleteMediaModal = false">Cancel</button>
                                                    <button
                                                        class="p-2 px-8 text-white bg-red-800 border-2 border-red-800 rounded-full hover:bg-transparent hover:text-red-800 active:scale-95 "
                                                        @click="removeSingleMedia(media.id)">Delete Media</button>

                                                </div>
                                            </div>
                                        </Modal>
                                    </button> -->
                </div>
            </SplideSlide>
        </template>
    </Splide>
</template>

<script setup>
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import { ref } from "vue";

const props = defineProps(['postMedia', 'user'])


const showDeleteMediaModal = ref(false);
// slider option
const options = {
    arrows: true,
    rewind: false,
    pagination: false,
    // drag: "free",
    type: 'slide',
    focus: "center",
    perPage: 1,
    perMove: 1,
    snap: true,
    autoplay: false,
};
// delete media
// function removeSingleMedia(id) {
//     axios.delete(route('api.gallery.destroy', id)).then((res) => console.log(res))

//     showDeleteMediaModal.value = false
//     Inertia.reload({
//         only: ['post'],
//     });
// }

</script>

<style  scoped></style>
