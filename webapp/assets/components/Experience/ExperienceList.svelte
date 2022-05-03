<script>
	import { onDestroy, onMount } from 'svelte';
	import Modal from '../Modal/Modal.svelte';
	import ExperienceItem from './ExperienceItem.svelte';

	let experiences = [
		{
			id: 1,
			name: 'Developpeur web',
			company: 'BNP Paribas',
			startedAt: '2020-01-01',
			endedAt: '2020-12-31',
			localization: 'Fort de France',
			description: 'lorremp',
		},
		{
			id: 2,
			name: 'Developpeur web',
			company: 'BNP Paribas',
			startedAt: '2020-01-01',
			endedAt: '2020-12-31',
			localization: 'Fort de France',
			description: 'lorremp',
		},
	];

	let isEditMode = false;

	function handleEdit() {
		isEditMode = !isEditMode;
	}

	// function handleEchapKey(event) {
	// 	if (!event.key === 'Escape') {
	// 		return;
	// 	}
	// 	isEditMode = false;
	// }

	// onMount(() => {
	// 	document.addEventListener('keydown', handleEchapKey);
	// });

	// onDestroy(() => {
	// 	document.removeEventListener('keydown', handleEchapKey);
	// });
</script>

<div class="flex flex-col gap-4">
	{#each experiences as experience (experience.id)}
		<ExperienceItem {...experience} on:edit="{handleEdit}" />
	{/each}
</div>

{#if isEditMode}
	<Modal>
		<h1>test</h1>
	</Modal>
{/if}
