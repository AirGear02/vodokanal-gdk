<script setup>
import { Select, initTE } from "tw-elements";
import {onMounted, onUpdated} from "vue";

defineProps({
    modelValue: String,
    id: Number,
    name: String,
    data: Array
});


onMounted(() => {
  initTE({Select})
});
defineEmits(['update:modelValue']);

</script>


<template>
    <select
        :name="name"
        @change="$emit('update:modelValue', $event.target.value)"
        class="w-full rounded border-slate-300"
    >
        <option :key="item.id" :value="item.id" v-for="item in data">{{ item.name }}</option>
    </select>
</template>
