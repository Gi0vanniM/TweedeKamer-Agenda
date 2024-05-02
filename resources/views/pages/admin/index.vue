<script setup lang="ts">
import { useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { reactive } from 'vue';


const props = defineProps({
    users: Object,
    parliamentMembers: Object,
});

const data = reactive({
    showAddParliamentMember: false,
});

const formAddPB = useForm({
    first_name: "",
    last_name: "",
    party: "",
});

const submitPB = () => {
    axios.post('/admin/parliamentmember/store', {
        first_name: formAddPB.first_name,
        last_name: formAddPB.last_name,
        party: formAddPB.party,
    });
}

</script>

<template layout>

<div class="container mx-auto">

    <!-- USERS -->
    <div class="my-5">
        <div class="flex justify-center">
            <h1 class="">USERS</h1>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Naam
                        </th>
                        <th scope="col" class="px-6 py-3">
                            E-mail
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100 odd:bg-white even:bg-gray-50 border-b" v-for="user in users">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ user.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ user.name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.email }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Parliament members -->
    <div class="my-5">
        <div class="flex justify-center">
            <h1 class="">KAMERLEDEN</h1>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-4">
                <button 
                    type="button" 
                    class="text-white bg-green-500 focus:ring-4 focus:bg-green-600 focus:ring-green-300 rounded-lg px-2 py-1"
                    @click="data.showAddParliamentMember = true"
                >
                    <b>+</b> Toevoegen
                </button>
            </div>
            <div v-if="data.showAddParliamentMember == true" id="add-user-modal" class="overflow-y-auto overflow-x-hidden fixed z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <div class="relative bg-white rounded-lg shadow">
                        <button @click="data.showAddParliamentMember = false" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="authentication-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900">Kamerlid toevoegen</h3>
                            <form class="space-y-6" @submit.prevent="submitPB">
                                <div class="grid-cols-2 grid gap-1">
                                    <div>
                                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">
                                            Voor naam
                                        </label>
                                        <input v-model="formAddPB.first_name" type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="John" required>
                                    </div>
                                    <div>
                                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">
                                            Achter naam
                                        </label>
                                        <input v-model="formAddPB.last_name" type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Smith" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="party" class="block mb-2 text-sm font-medium text-gray-900">
                                        Partij
                                    </label>
                                    <input v-model="formAddPB.party" type="text" name="party" id="party" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Partij voor Partijen" required>
                                </div>
                                <button type="submit" class="w-full text-white bg-green-500 focus:ring-4 focus:bg-green-600 focus:ring-green-300 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Aanmaken</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Naam
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Partij
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100 odd:bg-white even:bg-gray-50 border-b" v-for="user in parliamentMembers">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ user.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ user.first_name + ' ' + user.last_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.party }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</template>