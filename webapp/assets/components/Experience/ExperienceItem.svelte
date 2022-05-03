<script>
	import { createEventDispatcher } from 'svelte';
	export let id;
	export let name;
	export let company;
	export let startedAt;
	export let endedAt;
	export let localization;
	export let description;

	const dispatch = createEventDispatcher();

	function handleEditPencilClick() {
		dispatch('edit', { id });
	}
</script>

<div class="p-12 bg-white overflow-hidden rounded-md relative" data-id="{id}">
	<div
		class="absolute bottom-0 right-0 mr-4 mb-4 cursor-pointer hover:bg-gray-200 duration-200 transform p-2 rounded-md"
		on:click="{handleEditPencilClick}"
	>
		<svg
			class="w-5 h-5"
			fill="none"
			stroke="currentColor"
			viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg"
			><path
				stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				d="m15.232 5.232 3.536 3.536m-2.036-5.036a2.5 2.5 0 1 1 3.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
			></path></svg
		>
	</div>
	<span class="text-xs px-3 py-1 bg-gray-200 rounded-full">Expérience professionnelle - 4 mois</span>
	<div class="flex flex-col mt-4">
		<div class="text-xl font-semibold">{name}</div>
		<div class="mt-0.5">{company}</div>
		<div class="mt-0.5 text-sm text-gray-400">{startedAt} - {endedAt}</div>
		<div class="mt-0.5 text-sm text-gray-400">{localization}</div>
		<div class="mt-0.5 text-sm">{description}</div>
	</div>
</div>
