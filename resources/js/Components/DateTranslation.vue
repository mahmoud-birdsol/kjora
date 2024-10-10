<script setup>
import { usePage } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import updateLocale from 'dayjs/plugin/updateLocale'
import relativeTime from 'dayjs/plugin/relativeTime.js'
import { onBeforeMount, onMounted } from 'vue'

defineProps({
	format: {
		default: 'dddd, DD MMMM YYYY',
	},
	type: {
		default: 'normal', //normal is 22 sunday 2023 , range is 30 day ago
	},
	start: String,
	end: String,
})
onBeforeMount(() => {
	dayjs.extend(updateLocale)
	dayjs.extend(relativeTime)
})

const currentLocale = usePage().props.locale
const months =
	'يناير_فبراير_مارس_أبريل_مايو_يونيو_يوليو_أغسطس_سبتمبر_أكتوبر_نوفمبر_ديسمبر'.split(
		'_'
	)
const symbolMap = {
	1: '١',
	2: '٢',
	3: '٣',
	4: '٤',
	5: '٥',
	6: '٦',
	7: '٧',
	8: '٨',
	9: '٩',
	0: '٠',
}
const numberMap = {
	'١': '1',
	'٢': '2',
	'٣': '3',
	'٤': '4',
	'٥': '5',
	'٦': '6',
	'٧': '7',
	'٨': '8',
	'٩': '9',
	'٠': '0',
}

const arLocaleConfig = {
	name: 'ar',
	weekdays: 'الأحد_الإثنين_الثلاثاء_الأربعاء_الخميس_الجمعة_السبت'.split('_'),
	weekdaysShort: 'أحد_إثنين_ثلاثاء_أربعاء_خميس_جمعة_سبت'.split('_'),
	weekdaysMin: 'ح_ن_ث_ر_خ_ج_س'.split('_'),
	months,
	monthsShort: months,
	weekStart: 6,
	relativeTime: {
		future: 'بعد %s',
		past: '%s',
		s: '١ ث',
		m: '١ ق',
		mm: '%d ق',
		h: '١ س',
		hh: '%d س',
		d: '١ يوم',
		dd: '%d أيام',
		M: '١ شهر',
		MM: '%d أشهر',
		y: '١ عام',
		yy: '%d أعوام',
	},
	meridiem: (hour, minute, isLowercase) => {
		// OPTIONAL, AM/PM
		if (currentLocale == 'en') return hour > 12 ? 'PM' : 'AM'
		else return hour > 12 ? 'م' : 'ص'
	},
	preparse(string) {
		return string
			.replace(/[١٢٣٤٥٦٧٨٩٠]/g, (match) => numberMap[match])
			.replace(/،/g, ',')
	},
	postformat(string) {
		return string.replace(/\d/g, (match) => symbolMap[match]).replace(/,/g, '،')
	},
	ordinal: (n) => n,
	formats: {
		LT: 'HH:mm',
		LTS: 'HH:mm:ss',
		L: 'D/‏M/‏YYYY',
		LL: 'D MMMM YYYY',
		LLL: 'D MMMM YYYY HH:mm',
		LLLL: 'dddd D MMMM YYYY HH:mm',
	},
}

const enLocaleConfig = {
	relativeTime: {
		future: 'in %s',
		past: '%s',
		s: 'a few sec',
		m: '1 min',
		mm: '%d mins',
		h: '1 hr',
		hh: '%d hrs',
		d: '1 d',
		dd: '%d d',
		M: '1m',
		MM: '%d m',
		y: '1 y',
		yy: '%d yrs',
	},
}

onBeforeMount(() => {
	dayjs.locale(arLocaleConfig, null, true)
	dayjs.updateLocale('en', enLocaleConfig)
})
</script>
<template>
	<span v-if="type === 'normal'">{{
		dayjs(start).locale(currentLocale).format(format)
	}}</span>
	<span v-else-if="type === 'range'">{{
		dayjs(start).locale(currentLocale).fromNow()
	}}</span>
	<span v-else-if="type === 'period'">{{
		dayjs().locale(currentLocale).to(dayjs(end, true))
	}}</span>
</template>
