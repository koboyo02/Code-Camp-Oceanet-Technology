<script>
	import { onDestroy, onMount } from 'svelte';
	import ExperienceList from './components/Experience/ExperienceList.svelte';

	function swupUnmount() {
		document.removeEventListener('keydown', handleEchapKey);
	}

	onMount(() => {
		// document.addEventListener('keydown', handleEchapKey);
		document.addEventListener('swup:willReplaceContent', () => {
			console.log('swup:willReplaceContent');
		});

		return () => {
			document.removeEventListener('keydown', handleEchapKey);
			document.removeEventListener('swup:willReplaceContent', swupUnmount);
		};
		console.log('test');
	});
</script>

<div class="container mx-auto _border-2 _bg-gray-100" style="max-width: 48rem;">
	<a href="/resume">resume</a>

	<ExperienceList />
</div>
