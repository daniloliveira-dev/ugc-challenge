<template>
    <div class="mb-10">
        <div class="flex justify-between text-sm text-slate-600 mb-2">
            <span>Progresso</span>
            <span>{{ currentStep }} de {{ totalSteps }}</span>
        </div>

        <div class="w-full bg-slate-200 rounded-full h-3">
            <div class="bg-green-500 h-3 rounded-full transition-all" :style="{ width: percentage + '%' }" />
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    currentStep: Number,
    totalSteps: Number
});

const percentage = computed(() => {
    return (props.currentStep / props.totalSteps) * 100;
});
</script>