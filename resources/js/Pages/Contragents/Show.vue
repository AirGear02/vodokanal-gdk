<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import Select from "@/Components/Select.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from 'vue';

const props = defineProps({
    contragent: Object,
    contragent_info: Array,
});

const form = useForm({
    avg_water_usage: null,
    date: null,
    comment_1: null,
    coefficient: null,
    gdk_exceeding_letter_date: null,
    invoice_issuance_date: null,
    invoice_due_date: null,
    penalty_amount: null,
    penalty_comment: null,
    application_increasing_coef_date: null,
    applied_coefficient: null,
    disconnection_notification_date: null,
    disconnection_date: null,
    is_disconnected: null,
    comment_2: null
});

const contragent_info = ref(props.contragent_info);

const saveInfo = async () => {
    try {
        const response = await axios.post(route('contragents.info.store', props.contragent.id), form);
        form.reset()
        contragent_info.value = [response.data.info, ...contragent_info.value];
    } catch (ex) {

    }
}

const updateInfo = async (id) => {
    try {
        const response = await axios.put(route('contragents.info.update', [props.contragent.id, id]), contragent_info.value.find(item => item.id === id));
        console.log(response);
    } catch (ex) {
        console.log(ex);
    }
}


</script>

<template>
    <app-layout title="Контрагенти" fit-width="true">
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
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased w-fit m-auto">

            <div class="shadow-md sm:rounded-lg w-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-16">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="text-center">
                            Середньо<br>місячне <br> споживання води
                        </th>
                        <th scope="col" class="text-center">
                            Дата взяття <br> аналізу/відвідин
                        </th>
                        <th scope="col" class="text-center">
                            Коментар
                        </th>
                        <th scope="col" class="text-center">
                            Результат <br> аналізу <br> (коефіцієнт)
                        </th>

                        <th scope="col" class="text-center">
                            Дата листа про <br> перевищення <br> ГДК (5 днів)
                        </th>
                        <th scope="col" class="text-center">
                            Дата видачі <br> рахунку <br> (до 60 днів від п.2)
                        </th>

                        <th scope="col" class="text-center">
                            Дата <br> закінчення <br> терміну дії <br> рахунку <br> (місяць від п.5)
                        </th>

                        <th scope="col" class="text-center">
                            Сума штрафу, <br> грн
                        </th>
                        <th scope="col" class="text-center">
                            Коментар <br> стосовно <br> штрафу
                        </th>

                        <th scope="col" class="text-center">
                            Дата заяви про <br> підвищуючий <br> коефіцієнт
                        </th>
                        <th scope="col" class="text-center">
                            Встановлений <br> коефіцієнт
                        </th>
                        <th scope="col" class="text-center">
                            Повідомлення <br> про <br> відключення <br> від ВП (через 10 <br> днів після п.6)
                        </th>

                        <th scope="col" class="text-center">
                            Дата передачі в <br> роботу для <br> відключення
                        </th>
                        <th scope="col" class="text-center">
                            Виконано/ <br> Невиконано <br> відключення
                        </th>
                        <th scope="col" class="text-center">
                            Коментар
                        </th>
                        <th scope="col" class="text-center">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="text-center">
                            <input type="number" v-model="form.avg_water_usage" step="0.01"
                                   class="w-20 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="form.date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <textarea v-model="form.comment_1"
                                      class="mt-1 w-24 h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      style="resize: both; overflow: hidden" rows="1"> </textarea>
                        </td>
                        <td class="text-center">
                            <input v-model="form.coefficient" type="number" step="0.01"
                                   class="w-20 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input v-model="form.gdk_exceeding_letter_date" type="date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="form.invoice_issuance_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="form.invoice_due_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="number" step="0.01" v-model="form.penalty_amount"
                                   class="w-24 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>

                        <td class="text-center">
                            <textarea v-model="form.penalty_comment"
                                      class="mt-1 w-24 h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      style="resize: both; overflow: hidden" rows="1"> </textarea>
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="form.application_increasing_coef_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="number" v-model="form.applied_coefficient" step="0.01"
                                   class="w-24 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="form.disconnection_notification_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="form.disconnection_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <Select v-model="form.is_disconnected"
                                    :data="[{id:null, name: ''}, {id: true, name: 'Так'}, {id: false, name: 'Ні'}]"></Select>
                        </td>
                        <td class="text-center">
                            <textarea v-model="form.comment_2"
                                      class="mt-1 w-24 h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      style="resize: both; overflow: hidden" rows="1"> </textarea>
                        </td>
                        <td>
                            <button v-on:click="saveInfo"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Додати
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                    <tr v-for="info in contragent_info" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="text-center">
                            <input type="number" v-model="info.avg_water_usage" step="0.01"
                                   class="w-20 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="info.date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <textarea v-model="info.comment_1"
                                      class="mt-1 w-24 h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      style="resize: both; overflow: hidden" rows="1"> </textarea>
                        </td>
                        <td class="text-center">
                            <input v-model="info.coefficient" type="number" step="0.01"
                                   class="w-20 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input v-model="info.gdk_exceeding_letter_date" type="date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="info.invoice_issuance_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="info.invoice_due_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="number" step="0.01" v-model="info.penalty_amount"
                                   class="w-24 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>

                        <td class="text-center">
                            <textarea v-model="info.penalty_comment"
                                      class="mt-1 w-24 h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      style="resize: both; overflow: hidden" rows="1"> </textarea>
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="info.application_increasing_coef_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="number" v-model="info.applied_coefficient" step="0.01"
                                   class="w-24 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="info.disconnection_notification_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <input type="date" v-model="info.disconnection_date"
                                   class="w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </td>
                        <td class="text-center">
                            <Select v-model="info.is_disconnected"
                                    :data="[{id:null, name: ''}, {id: true, name: 'Так'}, {id: false, name: 'Ні'}]"></Select>
                        </td>
                        <td class="text-center">
                            <textarea v-model="info.comment_2"
                                      class="mt-1 w-24 h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      style="resize: both; overflow: hidden" rows="1"> </textarea>
                        </td>
                        <td>
                            <button v-on:click="updateInfo(info.id)"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded h-10">
                                Зберегти
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </app-layout>
</template>
