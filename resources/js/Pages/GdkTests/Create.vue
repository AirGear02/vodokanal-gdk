<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ModelSelect} from 'vue-search-select'
import {usePage} from '@inertiajs/vue3'
import {ref} from 'vue'

defineProps({
    contragents: Array,
    default_act_no: Number,
    measurements: Array,
});

const page = usePage()

const form = useForm({
    contragent_id: '',
    act_no: page.props.default_act_no,
    date: new Date().toISOString().slice(0,10),
    measurements: page.props.measurements.map(measurement => ({id: measurement.id, standard: measurement.standard, value:"", proposed_coefficient: "", real_coefficient: ""}))
});


const submit = () => {
    form.post(route('contragents.store'));
};

const sum_proposed_coefficient = ref(0.000)
const sum_real_coefficient = ref(0.000)


const changeMeasurementValue = (event, index) => {
    const measurement = form.measurements[index]
    if (event.target.value.length === 0) {
        form.measurements[index].proposed_coefficient = ""
        form.measurements[index].real_coefficient = ""
    } else {
        const newValue = Number.parseFloat(event.target.value)
        form.measurements[index].proposed_coefficient =  newValue <= measurement.standard ? 0 : (newValue/measurement.standard - 1).toFixed(3)
        form.measurements[index].real_coefficient = form.measurements[index].proposed_coefficient
    }
    const filled_measurements = form.measurements.filter(measurement => measurement.value !== '')
    sum_real_coefficient.value = filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.real_coefficient), 0)
    sum_proposed_coefficient.value = filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.proposed_coefficient), 0)
}

const updateRealCoefficient = () => {
    const filled_measurements = form.measurements.filter(measurement => measurement.value !== '')
    sum_real_coefficient.value = filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.real_coefficient), 0)
}

</script>

<style>
@import "vue-search-select/dist/VueSearchSelect.css";
</style>

<template>
    <app-layout title="Додати ГДК тест">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Додати результати ГДК тесту
            </h2>
        </template>
        <form @submit.prevent="submit">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
                <div class="flex px-6 mt-10 py-4 bg-white shadow-md  sm:rounded-lg">
                    <div class="w-64 mr-10">
                        <InputLabel value="Контрагент"/>
                        <ModelSelect
                            :options="contragents.map(contragent => ({value: contragent.id, text: contragent.name}))"
                            name="contragent_id"
                            required
                            autofocus
                            v-model="form.contragent_id"
                            class="mt-1 h-10"
                            style="font-size: 20px"
                        />
                    </div>

                    <div class="w-24 mr-10">
                        <InputLabel for="act_no" value="Акт №"/>
                        <TextInput
                            v-model="form.act_no"
                            class="mt-1 block w-full"
                            name="act_no"
                            type="number"
                            min="1"
                            required
                        />
                    </div>
                    <div>
                        <InputLabel for="date" value="Дата:"/>
                        <TextInput
                            v-model="form.date"
                            class="mt-1 block w-full"
                            name="date"
                            type="date"
                            required
                        />
                    </div>
                </div>
                <div class="w-auto px-6 mt-10 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <table>
                        <thead>
                        <tr>
                            <th colspan="2" class="w-80">
                                Назва показника вимірювань
                            </th>
                            <th align="left" class="w-28">
                                ДК
                            </th>
                            <th>
                                Результат
                            </th>
                            <th>
                                KK
                            </th>
                            <th>
                                КК
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(measurement, index) of measurements" class="">
                            <td>{{measurement.order_index}}.</td>
                            <td>{{measurement.name}}</td>
                            <td>{{measurement.standard}}</td>
                            <td>
                                <TextInput
                                    class="block w-32"
                                    name="act_no"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    v-model="form.measurements[index].value"
                                    required
                                    v-on:change="changeMeasurementValue($event, index)"
                                />
                            </td>
                            <td>
                                <TextInput
                                    name="act_no"
                                    step="0.01"
                                    min="0"
                                    v-model="form.measurements[index].proposed_coefficient"
                                    required
                                    disabled
                                    class="block w-24 bg-gray-50"                              />
                            </td>
                            <td>
                                <TextInput
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    v-model="form.measurements[index].real_coefficient"
                                    required
                                    class="w-24 font-bold border-3"
                                    v-on:change="updateRealCoefficient"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="pl-2 pt-3"><b>Разом</b></td>
                            <td class="pl-2 pt-3"><b>{{sum_proposed_coefficient.toFixed(3)}}</b></td>
                            <td class="pl-2 pt-3"><b>{{sum_real_coefficient.toFixed(3)}}</b></td>
                        </tr>
                        </tbody>
                    </table>
                    <span></span>
                </div>

            </div>
        </form>

    </app-layout>
</template>
