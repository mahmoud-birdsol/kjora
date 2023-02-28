<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '../../Components/Modal.vue';
import { ElRate, ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import { computed, ref } from 'vue';
import RatingChart from '../../Components/RatingChart.vue';
import Avatar from '../../Components/Avatar.vue';
const props = defineProps({
    review: null,
    ratingCategories: Array,
    playerRating: Array
});

const data = props.playerRating.map(r => r.value)
const labels = props.playerRating.map(r => r.ratingCategory)

const rating = ref(props.review.player.rating)
const ratingCategory = props.ratingCategories.map(cat => {
    return { id: cat.id, value: 0 }
})
const ratingForm = useForm(
    {
        ratingCategory
    }
)
function submitRatingForm() {

    ratingForm.post(route('player.review.store', props.review.id), {
        onSuccess: () => {
            console.log('success')
        }
    })
}



</script>

<template>
    <Head title="Home" />

    <AppLayout title="rate">
        <template #header>
            rate
        </template>



        <div class="bg-white h-full p-6 rounded-xl">
            <div class="text-black flex flex-col  sm:flex-row gap-2 sm:items-center justify-between mb-4">
                <div class="flex gap-3">
                    <div class="min-w-max ">
                        <Avatar :username="review.player.name" :image-url="review.player.avatar_url" :size="'lg'"
                            :border="true" border-color="primary" />
                    </div>
                    <div class="flex-col flex gap-0">
                        <h3 class="capitalize font-bold text-lg text-primary">{{ review.player.name }}</h3>
                        <span>@{{ review.player.username }} {{ 'cairo' }}</span>
                        <div class="text-stone-400 text-xs flex gap-2 flex-wrap">
                            <span>Age: {{ review.player.age }}</span>
                            <span>Played: {{ '24' }}</span>
                            <span>Missed: {{ '15' }}</span>
                            <span>Position: {{ review.player.position.name }}</span>
                        </div>
                    </div>
                </div>
                                    <div class="flex flex-col gap1 ">
                                        <ElRate v-model="rating" disabled size="large" />
                                        <p class="flex items-center font-bold text-sm text-primary">
                                            {{ rating }} out of 5
                                        </p>
                                        <span class="text-stone-400 text-xs">based on 245 players rating</span>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-[1fr_2fr] gap-4">
                                    <form @submit.prevent="submitRatingForm" class="flex flex-col gap-4">
                                        <template v-for="item in  ratingCategories" :key="item.id">
                                            <div class="flex flex-col gap-2 ">
                                                <InputLabel class="text-black">{{ item.name }}</InputLabel>
                                                <div class="px-6 py-1 mx-4 bg-black border border-white rounded-full">
                                                    <el-slider v-model="ratingForm.ratingCategory.filter(c => c.id === item.id)[0].value"
                                                        :step="0.5" :min="0" :max="5" />
                                                </div>
                                            </div>
                                        </template>

                                    </form>
                                    <div class="md:w-2/3 md:justify-self-end h-full flex flex-col justify-between ">
                                        <div class=" p-2 ">
                                            <RatingChart :data="data" :labels="labels" theme="rgb(0,100,0)" overlay='rgba(0,100,0,0.2)' />
                                        </div>
                                        <button @click="submitRatingForm" class="bg-black p-3 px-6 mt-4  w-full text-white rounded-full">
                                            Rate
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </AppLayout>
</template>

<style></style>
