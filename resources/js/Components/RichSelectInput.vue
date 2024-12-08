<script setup>
import { onMounted, onUpdated, ref } from 'vue'
import { CheckIcon, PlayIcon } from '@heroicons/vue/24/solid'
import { useFloating, size, flip, hide, autoUpdate } from '@floating-ui/vue'
// import { ElInfiniteScroll } from 'element-plus'

const props = defineProps({
	modelValue: [String, Number],
	valueName: String,
	textName: String,
	imageName: String,
	options: {
		required: false,
		type: Array,
		default: [],
	},
	source: {
		required: false,
		type: String,
		default: '',
	},
	append: {
		required: false,
		type: Object,
	},
	bgColor: {
		default: 'white',
	},
	txtColor: {
		default: 'black',
	},
})

const nextPageUrl = ref(null)

const filteredOptions = ref([])
onUpdated(() => {
	if (props.options.length) {
		filteredOptions.value = props.options

		if (props.modelValue) {
			selected.value = props.options.filter((option) => {
				return option[props.valueName] == props.modelValue
			})[0]
		} else {
			selected.value = ''
		}
	}
})
onMounted(() => {
	if (props.options.length) {
		filteredOptions.value = props.options

		if (props.modelValue) {
			selected.value = props.options.filter((option) => {
				return option[props.valueName] == props.modelValue
			})[0]
		} else {
			selected.value = ''
		}
	} else {
		axios
			.get(props.source)
			.then((response) => {
				filteredOptions.value = response.data.data
				nextPageUrl.value = response.data.links.next

				if (props.append) {
					let exists = false

					filteredOptions.value.forEach((item) => {
						if (item[props.valueName] == props.append[props.valueName]) {
							exists = true
						}
					})

					if (!exists) {
						filteredOptions.value.push(props.append)
					}
				}

				if (props.modelValue) {
					selected.value = filteredOptions.value.filter((option) => {
						return option[props.valueName] == props.modelValue
					})[0]
				} else {
					selected.value = response.data.data[0]
				}
			})
			.catch((error) => console.log(error))
	}
})

const showDropDown = ref(false)

const selected = ref(null)

const emit = defineEmits(['update:modelValue', 'selected'])

const select = (option) => {
	selected.value = option
	emit('update:modelValue', selected.value[props.valueName])
	emit('selected')
	if (props.options.length) {
		searchValue.value = ''
		filteredOptions.value = props.options
	}
	showDropDown.value = false
}

const searchValue = ref('')

const search = () => {
	if (props.options.length) {
		filteredOptions.value = props.options.filter((option) => {
			return option.name.toUpperCase().includes(searchValue.value.toUpperCase())
		})
	} else {
		axios
			.get(props.source, {
				params: {
					search: searchValue.value,
				},
			})
			.then((response) => {
				filteredOptions.value = response.data.data
				nextPageUrl.value = response.data.links.next
			})
			.catch((error) => console.log(error.response))
	}
}

const loading = ref(false)

const loadMore = () => {
	loading.value = true

	if (props.options.length) {
		loading.value = false
		return
	}

	if (nextPageUrl.value == null) {
		loading.value = false
		return
	}

	axios
		.get(nextPageUrl.value)
		.then((response) => {
			filteredOptions.value = filteredOptions.value.concat(response.data.data)
			loading.value = false
			nextPageUrl.value = response.data.links.next
		})
		.catch((error) => console.log(error.response))
}
const reference = ref(null)
const floating = ref(null)
const { floatingStyles, middlewareData } = useFloating(reference, floating, {
	whileElementsMounted: autoUpdate,
	middleware: [
		flip(),
		size({
			apply({ rects, elements }) {
				// Change styles, e.g.
				Object.assign(elements.floating.style, {
					minWidth: `${rects.reference.width}px`,
				})
			},
			padding: 5,
		}),
		hide(),
	],
})
</script>

<template>
	<div>
		<!--        <div class="fixed top-0 left-0 z-20 w-full h-full" @click="showDropDown = false" v-if="showDropDown"></div>-->
		<div class="mt-1">
			<button
				ref="reference"
				type="button"
				@click="showDropDown = !showDropDown"
				class="relative w-full pl-3 pr-10 text-left border border-gray-300 rounded-full shadow-sm cursor-pointer focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary sm:text-sm"
				:class="[
					`bg-${bgColor} text-${txtColor}`,
					selected != '' ? 'py-2' : 'py-5',
				]"
				aria-haspopup="listbox"
				aria-expanded="true"
				aria-labelledby="listbox-label">
				<span
					class="flex items-center"
					v-if="selected">
					<img
						v-if="imageName"
						:src="selected[imageName]"
						alt=""
						class="flex-shrink-0 w-6 h-6 rounded" />
					<span class="block truncate mis-3">{{ selected[textName] }}</span>
				</span>
				<span
					class="absolute inset-y-0 flex items-center pr-2 pointer-events-none mie-3 ltr:right-0 rtl:left-0">
					<PlayIcon class="w-3 text-gray-400 rotate-90" />
				</span>
			</button>
			<Teleport
				v-if="showDropDown"
				to="body">
				<div
					ref="floating"
					:style="{
						...floatingStyles,
						visibility: middlewareData.hide?.referenceHidden
							? 'hidden'
							: 'visible',
					}"
					class="z-50 py-1 mt-1 overflow-auto text-base rounded-lg shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
					:class="`bg-${bgColor}`">
					<transition
						enter-active-class="transition duration-100 ease-in"
						enter-from-class="opacity-0"
						enter-to-class="opacity-100"
						leave-active-class="transition duration-100 ease-in"
						leave-from-class="opacity-100"
						leave-to-class="opacity-0">
						<ul
							v-if="showDropDown"
							v-infinite-scroll="loadMore"
							infinite-scroll-distance="5"
							v-loading="loading"
							tabindex="-1"
							role="listbox"
							aria-labelledby="listbox-label"
							aria-activedescendant="listbox-option-3">
							<li>
								<div class="flex p-4">
									<input
										type="search"
										v-model="searchValue"
										class="block w-full px-4 border-gray-300 rounded shadow-sm focus:border-primary focus:ring-primary sm:text-sm disabled:bg-gray-100"
										@input="search"
										placeholder="Search" />
								</div>
							</li>
							<template v-if="filteredOptions.length">
								<li
									v-for="option in filteredOptions"
									@click="select(option)"
									class="relative py-2 pl-3 cursor-pointer select-none pr-9 hover:bg-primary hover:text-white"
									:class="`text-${txtColor}`"
									id="listbox-option-0"
									role="option">
									<div class="flex items-center">
										<img
											v-if="imageName"
											:src="option[imageName]"
											alt=""
											class="flex-shrink-0 w-6 h-6 rounded" />
										<span
											class="block font-normal truncate mis-3"
											:class="{
												'font-semibold':
													option[valueName] == selected[valueName],
												'font-normal': option[valueName] != selected[valueName],
											}"
											>{{ option[textName] }}</span
										>
									</div>

									<span
										class="absolute inset-y-0 flex items-center rtl:left-0 ltr:right-0 pie-4"
										:class="{
											'text-primary': option[valueName] == selected[valueName],
											[`text-${bgColor}`]:
												option[valueName] != selected[valueName],
										}">
										<CheckIcon class="w-5 h-5" />
									</span>
								</li>
							</template>
						</ul>
					</transition>
				</div>
			</Teleport>
		</div>
	</div>
</template>
