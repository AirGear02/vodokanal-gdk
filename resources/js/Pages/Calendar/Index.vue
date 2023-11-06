<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref, watch, onUpdated, onMounted, resolveDirective} from 'vue';
import debounce from 'lodash.debounce'
import {TailwindPagination} from 'laravel-vue-pagination';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from "@/Components/Select.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {initFlowbite} from "flowbite";
import {Calendar, DatePicker} from 'v-calendar';
import 'v-calendar/style.css';
import {format} from 'date-fns';
import uaLocale from 'date-fns/locale/uk';

const form = useForm({
    body: ''
});

const notes = ref([]);

const date = ref([
    {
        key: 'selected_date',
        highlight: true,
        dates: new Date(),
    },
]);


const submit = async () => {
    try {
        const response = await axios.post(route('calendar.store-note'), {
            ...form.data(),
            date: format(date.value[0].dates, 'yyyy-MM-dd')
        });
        form.reset()
        notes.value = [response.data.note, ...notes.value];
        date.value[1].dates.push(date.value[0].dates)
    } catch (ex) {
        console.log(ex);
    }
};

const fetchNotes = async (selected_date) => {
    const response = await fetch(route('calendar.get-notes', {date: selected_date}))
    const jsonResponse = await response.json();
    notes.value = jsonResponse.notes
    date.value = [
        date.value[0],
        {
            dot: true,
            dates: jsonResponse.note_dates.map(date => Date.parse(date))
        }]
}

fetchNotes(format(date.value[0].dates, 'yyyy-MM-dd'))

const onDateClick = (data) => {
    date.value[0].dates = data.date;
    fetchNotes(format(data.date, 'yyyy-MM-dd'))
};


</script>

<template>
    <app-layout title="Календар">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Календар
            </h2>
        </template>
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
            <div class="w-96 m-auto">
                <Calendar v-model="date" :attributes="date" expanded v-on:dayclick="onDateClick"/>
            </div>
            <div>
                <form @submit.prevent="submit" class="w-96 m-auto flex mt-5 justify-center align-middle">
                    <textarea
                        class="w-80 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        style="resize: both" v-model="form.body"></textarea>
                    <input type="submit" value="Зберегти"
                           class="m-auto ml-2 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none h-10"/>
                </form>
            </div>
            <div class="w-fit mt-10 m-auto">
                <div v-for="note in notes" class="mb-4 p-2 bg-white shadow-md sm:rounded-lg">
                    <textarea
                        class="w-96 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        disabled :value="note.body"
                        style="resize: both"
                    />
                    <div class="flex justify-between pl-2 pr-2">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ note.user.name }}</span>
                        </div>

                        <span>{{ format(Date.parse(note.created_at), 'd MMMM yyyy, HH:mm', {locale: uaLocale}) }}</span>
                    </div>
                </div>
            </div>
        </section>

    </app-layout>
</template>
