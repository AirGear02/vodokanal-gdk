<script setup>

defineProps({
    modelValue: String,
    id: Number,
    name: String,
    data: Array
});

defineEmits(['update:modelValue']);
</script>


<template>
    <select
        ref="input"
        :value="modelValue"
        :name="name"
        @change="$emit('update:modelValue', $event.target.value)"
        class="data-te-select-link"
    >
        <option :key="item[id]" :value="item[id]" v-for="item in data">{{ item[name] }}</option>
    </select>
</template>
