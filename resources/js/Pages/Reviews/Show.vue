<script setup>
import { Head, useForm, Link, usePage } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '../../Components/Modal.vue';
import { ElRate, ElSlider } from 'element-plus';
import InputLabel from '@/Components/InputLabel.vue';
import { computed, ref } from 'vue';
import RatingChart from '../../Components/RatingChart.vue';
import Avatar from '../../Components/Avatar.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { StarIcon as StarIconFilled } from '@heroicons/vue/20/solid'
import { StarIcon as StarIconOutline } from '@heroicons/vue/24/outline';
const props = defineProps({
    review: null,
    ratingCategories: Array,
    playerRating: Array
});


// const data = props.playerRating.map(r => r.value)

const labels = props.ratingCategories.map(r => r.name)
const showMsg = ref(false)
const state = props.review.player.state_name
const rateColor = state === 'Free' ? ['#006400', '#006400', '#006400'] : ['#99A9BF', '#F7BA2A', '#FF9900']
const rating = ref(props.review.player.rating)
const ratingCategory = props.ratingCategories.map(cat => {
    return { id: cat.id, value: 0 }
})

const locale = usePage().props.value.locale;
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
    showMsg.value = true
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

    <AppLayout :title="$t('rate')" :showBall="false">
        <template #header>
            {{ $t('rate') }}
        </template>
        <div class="w-full h-full py-6 bg-white sm:p-6 rounded-xl md:w-1/2 md:mx-auto">
            <div class="flex flex-col items-center justify-between gap-2 mb-4 text-black">
                <div class="flex flex-col gap-3">
                    <div class="relative mx-auto min-w-max">
                        <Avatar :id="review.player.id" :username="review.player.name" :image-url="review.player.avatar_url" :size="'xlg'" :border="true" border-color="primary" />
                        <Link :href="route('player.profile', review.player.id)" class="absolute inset-0 ">
                        </Link>
                    </div>
                    <div class="flex flex-col gap-0 text-center">
                        <Link :href="route('player.profile', review.player.id)">
                        <h3 class="text-lg font-bold capitalize text-primary">{{ review.player.name }}</h3>
                        </Link>
                        <Link :href="route('player.profile', review.player.id)">@{{ review.player.username }}</Link>
                        <div class="flex flex-wrap gap-2 text-xs text-stone-400">
                            <span>{{ $t('age') }}: {{ review.player.age }}</span>
                            <span>{{ $t('played') }}: {{ review.player.played }}</span>
                            <span>{{ $t('missed') }}: {{ review.player.missed }}</span>
                            <span>{{ $t('Position') }}: {{ review.player.position.name[locale] }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center gap-4 item-center ">
                    <span class="flex items-center scale-90 ltr:origin-right rtl:origin-left gap-x-1 text-gold">
                        <span class="flex items-center gap-1">
                            <template v-for="i in 5">
                                <StarIconFilled class="w-5 h-5 " v-if="review.player.rating >= i" />
                                <StarIconOutline class="w-5 h-5 " v-else />
                            </template>
                        </span>

                        <span class="ml-2 font-bold text-md ">{{ review.player.rating }}</span>
                    </span>
                    <span class="flex items-center text-xs text-stone-400">{{ $t('based on :count players', {
                        count:
                            review.player.played
                    }) }}
                    </span>
                </div>
            </div>

            <div class="flex flex-col mt-6 overflow-hidden gap-y-8">
                <div class="flex flex-col justify-between h-full max-sm:mb-10 md:justify-self-end">
                        <RatingChart :data="graphData" :labels="labels" theme="rgb(0,100,0)" overlay='rgba(0,100,0,0.2)' />
                </div>
                <form class="flex flex-col gap-4 px-5">
                    <div class="flex items-center gap-x-2">
                        <input type="checkbox" id="male" value="male" v-model="ratingForm.attended" class="accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4" />
                        <label for="male" class="text-sm font-medium text-black">{{ $t('attended') }}</label>
                    </div>
                    <template v-if="ratingForm.attended">
                        <template v-for="item in  ratingCategories" :key="item.id">
                            <div class="flex flex-col gap-2 ">
                                <div class="flex justify-between">
                                    <InputLabel color="black">{{ item.name }}</InputLabel>
                                    <span class="text-sm font-bold text-primary">{{ ratingForm.ratingCategory.filter(c =>
                                        c.id === item.id)[0].value }}</span>
                                </div>
                                <div class="px-6 py-1 mx-4 border border-white rounded-full bg-stone-300">
                                    <el-slider v-model="ratingForm.ratingCategory.filter(c => c.id === item.id)[0].value" @change="setRates" :step="0.1" :min="0" :max="5" input-size="small" height="1" />
                                </div>
                            </div>
                        </template>
                    </template>

                </form>
                <button @click="submitRatingForm" class="p-3 px-6 m-4 mt-4 text-white bg-black rounded-full">
                    {{ $t('rate') }}
                </button>
            </div>
        </div>

        <Modal :show="showMsg" :closeable="false" max-width="md" :showCloseIcon="false">
            <XMarkIcon class="w-4 m-1 mis-auto" @click="showMsg = false" />
            <div class="bg-white rounded-xl p-6 md:min-h-[300px]">
                <div class="flex flex-col justify-between items-center h-56 md:min-h-[200px]">
                    <div class="flex justify-center">
                        <h2 class="text-xl font-bold uppercase text-primary">{{ $t('rate') }}</h2>
                    </div>
                    <div class="text-center">
                        <p class="">{{ $t('thank you for sharing your experience with us') }}.</p>
                        <p class="">{{ $t('we appreciate you taking the time to share your rating') }}.</p>
                    </div>

                    <Link :href="route('home')" class="flex w-full min-w-full">
                    <PrimaryButton class="w-full" @click="showSuccessModal = false">{{ $t('Ok') }}</PrimaryButton>
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
