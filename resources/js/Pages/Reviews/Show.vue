<script setup>
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
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
const labels = props.ratingCategories.map(r => r.name)
const showMsg = ref(false)
const rateColor = ['#D1C37A', '#D1C37A', '#D1C37A']

const rating = ref(props.review.player.rating)
const ratingCategory = props.ratingCategories.map(cat => {
    return { id: cat.id, value: 0 }
})
const ratingForm = useForm(
    {
        ratingCategory,
        attended: true
    }
)

const graphData = computed(() => {

    // return ratingForm.ratingCategory.map(cat,i=>(cat.value+props.playerRating.find(r=> r.name=== cat.name ).value)/2)
    return ratingForm.ratingCategory.map(cat => cat.value)
})

function submitRatingForm() {
    showMsg.value=true
    ratingForm.post(route('player.review.store', props.review.id), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: () => {
            console.log('success')
        }
    })
}

function setRates() {

}

</script>

<template>
    <Head title="Home" />

    <AppLayout :title="$t('rate')">
        <template #header>
            {{ $t('rate') }}
        </template>
        <div class="bg-white h-full p-6 rounded-xl w-full md:w-1/2 md:mx-auto">
            <div class="text-black flex flex-col  gap-2 sm:items-center justify-between mb-4">
                <div class="flex flex-col gap-3">
                    <div class="min-w-max relative mx-auto">
                        <Avatar :id="review.player.id" :username="review.player.name" :image-url="review.player.avatar_url"
                            :size="'lg'" :border="true" border-color="primary" />
                        <Link :href="route('player.profile', review.player.id)" class="absolute inset-0 ">
                        </Link>
                    </div>
                    <div class="flex-col flex gap-0 text-center">
                        <Link :href="route('player.profile', review.player.id)">
                        <h3 class="capitalize font-bold text-lg text-primary">{{ review.player.name }}</h3>
                        </Link>
                        <Link :href="route('player.profile', review.player.id)">@{{ review.player.username }}</Link>
                        <div class="text-stone-400 text-xs flex gap-2 flex-wrap">
                            <span>{{ $t('age') }}: {{ review.player.age }}</span>
                            <span>{{ $t('played') }}: {{ review.player.played }}</span>
                            <span>{{ $t('missed') }}: {{ review.player.missed }}</span>
                            <span>{{ $t('Position') }}: {{ review.player.position.name }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex item-center gap-4 ">
                    <ElRate v-model="rating" disabled size="small" :colors="rateColor" void-color="#D1C37A"
                        disabled-void-color="#D1C37A" void-icon="star" />
                    <p class="flex items-center font-bold text-sm text-primary">
                        {{ rating }}
                    </p>
                    <span class="text-stone-400 text-xs flex items-center">{{ $t('based on :count players rating', {
                        count:
                            review.player.played
                    }) }}</span>
                </div>
            </div>

            <div class="flex flex-col gap-4">

                <div class="md:justify-self-end h-full flex flex-col justify-between ">
                    <div class=" p-2 ">
                        <RatingChart :data="graphData" :labels="labels" theme="rgb(0,100,0)" overlay='rgba(0,100,0,0.2)' />
                    </div>
                </div>
                <form @submit.prevent="submitRatingForm" class="flex flex-col gap-4 px-5">
                    <!-- <div class="flex items-center gap-x-2">
                                <input type="checkbox" id="male" value="male" v-model="ratingForm.attended" class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
                                <label for="male" class="text-sm font-medium text-black">{{ $t('attended') }}</label>
                            </div> -->
                    <template v-if="ratingForm.attended">
                        <template v-for="item in  ratingCategories" :key="item.id">
                            <div class="flex flex-col gap-2 ">
                                <div class="flex justify-between">
                                    <InputLabel color="black">{{ item.name }}</InputLabel>
                                    <span class="text-sm text-primary font-bold">{{ ratingForm.ratingCategory.filter(c =>
                                        c.id === item.id)[0].value }}</span>
                                </div>
                                <div class="px-6 py-1 mx-4 bg-stone-300 border border-white rounded-full">
                                    <el-slider v-model="ratingForm.ratingCategory.filter(c => c.id === item.id)[0].value"
                                        @change="setRates" :step="0.5" :min="0" :max="5" input-size="small" height="1" />
                                </div>
                            </div>
                        </template>
                    </template>

                </form>
                <button @click="submitRatingForm" class="bg-black p-3 px-6 mt-4  w-full text-white rounded-full">
                    {{ $t('rate') }}
                </button>
            </div>
        </div>

        <Modal :show="showMsg" max-width="md" @close="showMsg = false">
            <div class="bg-white rounded-xl p-6 md:min-h-[300px]">
                <div class="flex flex-col justify-between items-center h-56 md:min-h-[300px]">
                    <div class="flex justify-center">
                        <h2 class="text-xl text-primary font-bold uppercase">{{ $t('rate') }}</h2>
                    </div>
                    <p class="">{{ $t('thank you for sharing your experience with us') }}.</p>
                    <p class="">{{ $t('we appreciate you taking the time to share your rating') }}.</p>

                    <Link :href="route('home')" class="flex min-w-full w-full">
                    <PrimaryButton class="w-full" @click="showSuccessModal = false" >{{ $t('Ok') }}</PrimaryButton>
                    </Link>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
<style>
.el-slider__bar {
    height: 1px;
    background-color: gray;
}

.el-slider__runway {
    height: 1px !important;
    background-color: gray;
}
</style>

<style></style>
