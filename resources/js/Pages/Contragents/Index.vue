<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import {TailwindPagination} from 'laravel-vue-pagination';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from "@/Components/Select.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    contragents: Array,
    page: Number
});

const form = useForm({
    name: '',
    type_id: '1',
    edrpou: ''
});

const contragents = ref({});

const getResults = async (page = 1) => {
    const response = await fetch(route('api.contragents.get-all', {page: page}));
    contragents.value = await response.json();
}

getResults();

const submit = () => {
    form.post(route('contragents.store'));
};
</script>

<template>
    <app-layout title="Контрагенти">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Контрагенти
            </h2>
        </template>
        <div class="w-fit m-auto mt-10">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Назва
                                <a href="#"><svg class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg></a>
                            </div>

                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                ЄДРПОУ
                                <a href="#"><svg class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg></a>
                            </div>

                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Вид діяльності
                                <a href="#"><svg class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg></a>
                            </div>

                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="contragent in contragents.data" :key="contragents.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ contragent.name }}</th>
                        <td class="px-6 py-4">{{ contragent.edrpou }}</td>
                        <td class="px-6 py-4">{{ contragent.type.name }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Переглянути</a>
                        </td>
                    </tr>
                    </tbody>

                </table>
                <div class="m-auto w-fit mt-2 mb-2">
                    <TailwindPagination
                        :data="contragents"
                        @pagination-change-page="getResults"
                    />
                </div>

            </div>
        </div>
    </app-layout>
</template>
