<script setup>
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ModelSelect} from 'vue-search-select'
import {usePage} from '@inertiajs/vue3'
import {ref} from 'vue'
import Select from "@/Components/Select.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    contragent:Object,
    gdk_tests: Array
});

const openGdkTest = test_id => {
    router.visit(route('contragents.gdk-tests.show', [props.contragent.id, test_id]))
}
</script>

<style>
@import "vue-search-select/dist/VueSearchSelect.css";
</style>

<template>
    <app-layout title="Контрагенти">
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ contragent.name }}
                </h2>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <NavLink :href="route('contragents.show', contragent.id)"
                             :active="route().current('contragents.show', contragent.id)">
                        Переглянути
                    </NavLink>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <NavLink :href="route('contragents.gdk-tests.index', contragent.id)" :active="route().current('contragents.gdk-tests.*', [contragent.id])">
                        ГДК аналізи
                    </NavLink>
                </div>
            </div>
        </template>
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
            <div class="m-auto w-fit">
                <Link :href="route('contragents.gdk-tests.create', contragent.id)">
                    <button type="button" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                  d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                        </svg>
                        Додати результати ГДК аналізу
                    </button>
                </Link>
            </div>

            <div class="relative overflow-x-auto">
                <table class="w-1/2 mt-5 m-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Дата
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Акт№
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Розрахунковий Коефіцієнт
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Встановлений коефіцієнт
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Розмір штрафу
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="test in gdk_tests" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 hover:cursor-pointer"
                        v-on:click="openGdkTest(test.id)"
                    >
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{test.date}}
                        </th>
                        <td class="px-6 py-4">
                            {{test.act_no}}
                        </td>
                        <td class="px-6 py-4">
                            {{test.coefficient}}
                        </td>
                        <td class="px-6 py-4">
                            {{test.applied_coefficient}}
                        </td>
                        <td class="px-6 py-4">
                            {{Number.parseFloat(test.penalty_amount).toLocaleString('uk-UA', {
                            style: 'currency',
                            currency: 'UAH',
                            })}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </app-layout>
</template>
