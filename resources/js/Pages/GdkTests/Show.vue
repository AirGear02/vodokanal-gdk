<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ModelSelect} from 'vue-search-select'
import {ref} from 'vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    contragent: Object,
    gdk_test: Object,
});


const form = useForm({
    act_no: props.gdk_test.act_no,
    date: props.gdk_test.date,
    applied_coefficient: props.gdk_test.applied_coefficient,
    water_usage: props.gdk_test.water_usage,
    tariff: props.gdk_test.tariff,
    penalty_amount: props.gdk_test.penalty_amount,
    measurements: props.gdk_test.measurements.map(measurement => ({
        id: measurement.id,
        standard: measurement.standard,
        value: measurement.pivot.value,
        proposed_coefficient: measurement.pivot.proposed_coefficient,
        real_coefficient: measurement.pivot.real_coefficient
    }))
});


const submit = () => {
    form.post(route('contragents.gdk-tests.store', props.contragent.id));
};

const filled_measurements = form.measurements.filter(measurement => measurement.value !== null)

const sum_proposed_coefficient = ref(filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.proposed_coefficient || 0), 0))
const sum_real_coefficient = ref(filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.real_coefficient || 0), 0))


const changeMeasurementValue = (event, index) => {
    const measurement = form.measurements[index]
    if (event.target.value.length === 0) {
        form.measurements[index].proposed_coefficient = null
        form.measurements[index].real_coefficient = null
    } else {
        const newValue = Number.parseFloat(event.target.value)
        form.measurements[index].proposed_coefficient = newValue <= measurement.standard ? 0 : (newValue / measurement.standard - 1).toFixed(3)
        form.measurements[index].real_coefficient = form.measurements[index].proposed_coefficient
    }
    const filled_measurements = form.measurements.filter(measurement => measurement.value !== null)
    sum_real_coefficient.value = filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.real_coefficient || 0), 0)
    sum_proposed_coefficient.value = filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.proposed_coefficient || 0), 0)
    form.applied_coefficient = sum_real_coefficient.value;
}


const updateRealCoefficient = () => {
    const filled_measurements = form.measurements.filter(measurement => measurement.value !== null)
    sum_real_coefficient.value = filled_measurements.reduce((sum, current) => sum + Number.parseFloat(current.real_coefficient), 0)
    form.applied_coefficient = sum_real_coefficient.value;
}

const updatePenaltyAmount = () => {
    if (form.water_usage === null || form.applied_coefficient === null || form.tariff === null) {
        return
    }
    form.penalty_amount = Number.parseFloat(form.water_usage || 0) * Number.parseFloat(form.applied_coefficient || 0) * Number.parseFloat(form.tariff || 0)
}

</script>

<style>
@import "vue-search-select/dist/VueSearchSelect.css";
</style>

<template>
    <app-layout title="Перегляд ГДК аналізу">
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
        <form @submit.prevent="submit">
            <div class="flex flex-col items-center sm:pt-0 bg-gray-100">
                <div class="flex px-6 mt-5 py-4 bg-white shadow-md  sm:rounded-lg">
                    <div class="w-64 mr-10 flex items-center justify-center">
                        <h1 class="text-black font-bold text-xl">{{ contragent.name }}</h1>
                    </div>

                    <div class="w-24 mr-10">
                        <InputLabel for="act_no" value="Акт №"/>
                        <TextInput
                            v-model="form.act_no"
                            class="mt-1 block w-full"
                            name="act_no"
                            type="number"
                            min="1"
                            disabled
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
                <div class="w-auto px-6 mt-5 mb-5 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
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
                        <tr v-for="(measurement, index) of gdk_test.measurements" class="">
                            <td>{{ measurement.order_index }}.</td>
                            <td>{{ measurement.name }}</td>
                            <td>{{ measurement.standard }}</td>
                            <td>
                                <TextInput
                                    class="block w-32"
                                    name="act_no"
                                    type="number"
                                    step="0.001"
                                    min="0"
                                    v-model="form.measurements[index].value"
                                    v-on:change="changeMeasurementValue($event, index)"
                                />
                            </td>
                            <td>
                                <TextInput
                                    name="act_no"
                                    step="0.001"
                                    min="0"
                                    v-model="form.measurements[index].proposed_coefficient"
                                    disabled
                                    class="block w-24 bg-gray-50"/>
                            </td>
                            <td>
                                <TextInput
                                    type="number"
                                    step="0.001"
                                    min="0"
                                    v-model="form.measurements[index].real_coefficient"
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
                            <td class="pl-2 pt-3"><b>{{ sum_proposed_coefficient.toFixed(3) }}</b></td>
                            <td class="pl-2 pt-3"><b>{{ sum_real_coefficient.toFixed(3) }}</b></td>
                        </tr>
                        </tbody>
                    </table>
                    <span></span>
                </div>

            </div>
            <div class="flex flex-col items-center bg-gray-100">
                <div class="flex px-6 mt-5 py-4 bg-white shadow-md  sm:rounded-lg">
                    <div class="w-24 mr-10">
                        <InputLabel for="act_no" value="Об'єм"/>
                        <TextInput
                            v-model="form.water_usage"
                            class="mt-1 block w-full"
                            name="act_no"
                            type="number"
                            min="0"
                            v-on:change="updatePenaltyAmount"
                            required
                        />
                    </div>
                    <div class="w-24 mr-10">
                        <InputLabel for="act_no" value="Тариф"/>
                        <TextInput
                            v-model="form.tariff"
                            class="mt-1 block w-full"
                            name="act_no"
                            type="number"
                            min="0"
                            step="0.001"
                            v-on:change="updatePenaltyAmount"
                            required
                        />
                    </div>
                    <div class="w-44 mr-10">
                        <InputLabel value="Встановлений коефіцієнт"/>
                        <TextInput
                            v-model="form.applied_coefficient"
                            class="mt-1 w-44"
                            type="number"
                            step="0.001"
                            min="0"
                            v-on:change="updatePenaltyAmount"
                            required
                        />
                    </div>
                    <div class="w-24 mr-10">
                        <InputLabel for="act_no" value="Сума штрафу"/>
                        <div class="flex h-12 align-middle text-xl">
                                <span class="font-bold block m-auto">{{Number.parseFloat(form.penalty_amount).toLocaleString('uk-UA', {
                                    style: 'currency',
                                    currency: 'UAH',
                                })}}</span>
                        </div>

                    </div>
                </div>
<!--                <PrimaryButton class="mt-5 mb-5" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                    Оновити-->
<!--                </PrimaryButton>-->
            </div>
        </form>
    </app-layout>
</template>
