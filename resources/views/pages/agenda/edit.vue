<script setup lang="ts">
import { useForm, Link } from '@inertiajs/inertia-vue3';
import Input from '@/views/components/input.vue';
import Label from '@/views/components/label.vue';
import Textarea from '@/views/components/textarea.vue';
import axios from 'axios';
import Swal from 'sweetalert2'
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    auth: Object,
    action: String,
    agendaItem: Object,
    users: Object,
    parliamentMembers: Object,
});

const form = useForm({
    title: props?.agendaItem?.title ?? "",
    description: props?.agendaItem?.description ?? "",
    from_date: props?.agendaItem?.from_date ?? new Date().toISOString().substring(0, 10),
    from_time: props?.agendaItem?.from_time ?? new Date().toTimeString().substring(0, 5),
    to_date: props?.agendaItem?.to_date ?? new Date().toISOString().substring(0, 10),
    to_time: props?.agendaItem?.to_time ?? new Date().toTimeString().substring(0, 5),
    type: props?.agendaItem?.type ?? "",
    commission: props?.agendaItem?.commission ?? "",
    parliamentMembers: props?.agendaItem?.parliamentMembers ?? [],
    users: props?.agendaItem?.users ?? [],
});

const submit = () => {
    if (props.action === 'create') {
        axios.post('/agendaitem/store', {
            title: form.title,
            description: form.description,
            from_date: form.from_date,
            from_time: form.from_time,
            to_date: form.to_date,
            to_time: form.to_time,
            type: form.type,
            commission: form.commission,
            parliamentMembers: form.parliamentMembers,
            users: form.users,
        }).then(response => {
            if (response.status) {
                Swal.fire({
                    toast: true,
                    timer: 2000,
                    timerProgressBar: true,
                    title: 'Agenda item aangemaakt!',
                    icon: 'success',
                });
                Inertia.visit('/agenda');
            }
        });
    } else {
        axios.put('/agendaitem/update/' + props?.agendaItem?.id, {
        title: form.title,
            description: form.description,
            from_date: form.from_date,
            from_time: form.from_time,
            to_date: form.to_date,
            to_time: form.to_time,
            type: form.type,
            commission: form.commission,
            parliamentMembers: form.parliamentMembers,
            users: form.users,
        }).then(response => {
            if (response.status) {
                Swal.fire({
                    toast: true,
                    timer: 2000,
                    timerProgressBar: true,
                    title: 'Agenda item bewerkt!',
                    icon: 'success',
                });
                Inertia.visit('/agenda');
            }
        });
    }
}

</script>

<template layout>

<div class="container mx-auto">

    <h1 class="text-2xl font-bold my-5">{{ action == 'create' ? "Nieuw agenda item aanmaken" : "Agenda item aanpassen" }}</h1>

    <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">

        <!-- TITLE -->
        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="title" value="Titel" class="block uppercase tracking-wide font-bold mb-2" />
                <Input
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="p-1 pl-2 mt-1 block w-full border-gray-300 border-2"
                    required
                    autofocus
                    placeholder="Titel van het agenda item"
                />
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-full px-3">
                <Label for="description" value="Beschrijving" class="block uppercase tracking-wide font-bold mb-2" />
                <Textarea
                    id="description"
                    v-model="form.description"
                    rows="5"
                    class="p-1 pl-2 mt-1 block w-full border-gray-300 border-2"
                    placeholder="Beschrijving van het agenda item"
                />
            </div>
        </div>

        <!-- FROM DATE AND TO DATE -->
        <div class="-mx-3 md:flex mb-6">
            <!-- FROM DATE -->
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="from" value="Van" class="block uppercase tracking-wide font-bold mb-2" />
                <div id="from">
                    <Input
                        id="from_date"
                        v-model="form.from_date"
                        type="date"
                        class="p-1 pl-2 mt-1 border-gray-300 border-2"
                        required
                    />
                    <Input
                        id="from_time"
                        v-model="form.from_time"
                        type="time"
                        class="p-1 pl-2 mt-1 border-gray-300 border-2"
                        required
                    />
                </div>
            </div>
            <!-- TO DATE -->
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="to" value="Tot" class="block uppercase tracking-wide font-bold mb-2" />
                <div id="to">
                    <Input
                        id="to_date"
                        v-model="form.to_date"
                        type="date"
                        class="p-1 pl-2 mt-1 border-gray-300 border-2"
                        required
                    />
                    <Input
                        id="to_time"
                        v-model="form.to_time"
                        type="time"
                        class="p-1 pl-2 mt-1 border-gray-300 border-2"
                        required
                    />
                </div>
            </div>
        </div>

        <!-- TYPE AND COMMISSION -->
        <div class="-mx-3 md:flex mb-6">
            <!-- TYPE -->
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="type" value="Type" class="block uppercase tracking-wide font-bold mb-2" />
                <select name="type" id="type" v-model="form.type" class="
                        p-1 pl-1 mt-1
                        border-2
                        bg-white
                        border-gray-300 
                        focus:border-indigo-300 
                        focus:ring 
                        focus:ring-indigo-200 
                        focus:ring-opacity-50 
                        rounded-md shadow-sm
                        w-full h-9">
                    <option selected value="">- kies een type -</option>
                    <option value="Plenair debat">Plenair debat</option>
                    <option value="Commissiedebat">Commissiedebat</option>
                    <option value="Technische briefing">Technische briefing</option>
                    <option value="Procedurevergadering">Procedurevergadering</option>
                    <option value="Bijzondere procedure">Bijzondere procedure</option>
                    <option value="Rondetafelgesprek">Rondetafelgesprek</option>
                    <option value="Wetgevingsoverleg">Wetgevingsoverleg</option>
                    <option value="Notaoverleg">Notaoverleg</option>
                    <option value="Gesprek">Gesprek</option>
                </select>
                
            </div>
            <!-- COMMISSION -->
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="commission" value="Commissie" class="block uppercase tracking-wide font-bold mb-2" />
                <Input
                    id="commission"
                    v-model="form.commission"
                    type="text"
                    class="p-1 pl-1 mt-1 border-gray-300 border-2 w-full"
                    placeholder="Commissie voor Democratie"
                />
            </div>
        </div>

        <!-- Parliament members and Users -->
        <div class="-mx-3 md:flex mb-6">
            <!-- PARLIAMENT MEMBERS -->
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="parliamentMembers" value="Kamerleden" class="block uppercase tracking-wide font-bold mb-2" />
                <select multiple name="parliamentMembers" id="parliamentMembers" v-model="form.parliamentMembers" class="
                        bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>Kies kamerleden</option>
                        <option v-for="user in parliamentMembers" :value="user.id">{{ user.first_name + " " + user.last_name }}</option>
                </select>
                
            </div>
            <!-- USERS -->
            <div class="md:w-1/2 px-3 md:mb-0">
                <Label for="users" value="Gebruikers" class="block uppercase tracking-wide font-bold mb-2" />
                <select multiple name="users" id="users" v-model="form.users" class="
                        bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>Kies gebruikers</option>
                        <option v-for="user in users" :value="user.id">{{ user.name }}</option>
                </select>
            </div>
        </div>
        
        <div class="">
            <Link href="/agenda" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                Annuleren
            </Link>
            <button type="submit" class="text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-green-300 font-medium focus:ring-4 rounded-lg text-sm px-5 py-2.5 mr-2 text-center">
                {{ action == 'create' ? 'Aanmaken' : 'Opslaan' }}
            </button>
        </div>

    </form>
</div>

</template>