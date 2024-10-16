export function useResizeFont() {
	function resizeFont(inner, container) {
		if (!inner || !container) return
		let fontSize = window.getComputedStyle(inner).fontSize
		if (inner.clientWidth >= container.clientWidth) {
			inner.style.fontSize = parseFloat(fontSize) - 1 + 'px'
			resizeFont(inner, container)
		}
	}
	return { resizeFont }
}
