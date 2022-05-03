<script>
	import { onDestroy, onMount } from 'svelte';

	function handleEchapKey(event) {
		if (!'Escape' === event.key) {
			return;
		}
		isEditMode = false;
	}

	function swupUnmount() {
		document.removeEventListener('keydown', handleEchapKey);
	}

	onMount(() => {
		document.addEventListener('keydown', handleEchapKey);
		document.addEventListener('swup:willReplaceContent', swupUnmount);
	});

	onDestroy(() => {
		document.removeEventListener('keydown', handleEchapKey);
		document.removeEventListener('swup:willReplaceContent', swupUnmount);
	});
</script>

<div class="absolute inset-0 bg-white h-full">
	<div class="container mx-auto border-2 h-full flex items-center justify-center" style="width: 28rem;">
		<slot />
	</div>
</div>
