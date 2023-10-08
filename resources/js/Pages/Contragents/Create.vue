<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from "@/Components/Select.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
  contragent_types: Array,
  type_id: Number
});

const form = useForm({
  name: '',
  type_id: '1',
  edrpou: ''
});

const submit = () => {
  form.post(route('contragents.store'));
};
</script>

<template>
  <app-layout title="Контрагенти">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Створення контрагенту
      </h2>
    </template>

    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
      <div class="w-full sm:max-w-md px-6 mt-10 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form @submit.prevent="submit">
          <div>
            <InputLabel for="name" value="Назва"/>
            <TextInput
                id="name"
                v-model="form.name"
                class="mt-1 block w-full"
                required
                autofocus
            />
            <InputError class="mt-2" :message="form.errors.name"/>
          </div>
          <div class="mt-4">
            <InputLabel for="type_id" value="ЄДРПОУ"/>
            <TextInput
                id="name"
                v-model="form.edrpou"
                type="number"
                class="mt-1 block w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
            />
              <InputError class="mt-2" :message="form.errors.edrpou"/>
          </div>
          <div class="mt-4">
            <InputLabel for="type_id" value="Вид діяльності"/>
            <Select :data="contragent_types" name="type_id" v-model="form.type_id" style="color: black !important;"></Select>
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Створити
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>
