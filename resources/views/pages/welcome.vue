<script setup lang="ts">
import LaravelLogo from '@/views/components/laravel-logo.vue'
import InertiaLogo from '@/views/components/inertia-logo.vue'
import ResourceBlock from '@/views/components/resource-block.vue'
import buttonVue from '../components/button.vue';
import { Link } from '@inertiajs/inertia-vue3';

defineProps<{
	versions: {
		php: string
		laravel: string
	},
	auth: Object,
}>()
</script>

<template>

	<div class="relative flex items-top justify-center min-h-screen bg-zinc-100 sm:items-center py-4 sm:pt-0">
		<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

			<div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow sm:rounded-lg">
				<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
					<div class="mt-8 mb-8 text-2xl">
						<h1>Welkom</h1>
					</div>
					<div class="grid grid-cols-2 gap-4">
						<Link href="login" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
							Login
						</Link>
						<Link href="register" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
							Register
						</Link>
					</div>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2">
					<ResourceBlock
						name="Tweede Kamer Agenda"
						description="Welkom op mijn sollicitatieopdracht applicatie" 
						href="https://www.tweedekamer.nl/debat_en_vergadering"
					/>
				</div>
			</div>

			<div class="flex justify-center mt-4 sm:items-center sm:justify-between">
				<div class="text-center text-sm text-zinc-500 sm:text-left space-x-2">
					<span>Laravel v{{ versions.laravel }}</span>
					<span>(PHP {{ versions.php }})</span>
				</div>
			</div>
		</div>
	</div>
</template>
