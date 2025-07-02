<!-- components/HeaderSection.vue -->
<template>
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <!-- Left Heading -->
    <h2 class="text-2xl font-semibold text-gray-800">{{ heading }}</h2>

    <!-- Right Actions -->
    <div v-if="hasActions" class="mt-2 sm:mt-0 flex gap-2">
      <template v-for="(action, index) in actions" :key="index">
        <RouterLink
          v-if="action.to"
          :to="action.to"
          class="inline-flex items-center px-3 py-1.5 rounded bg-blue-600 text-white hover:bg-blue-500 text-sm"
        >
          {{ action.label }}
        </RouterLink>

        <button
          v-else-if="action.onClick"
          @click="action.onClick"
          class="inline-flex items-center px-3 py-1.5 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 text-sm"
        >
          {{ action.label }}
        </button>
      </template>

      <slot name="actions" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  heading: { type: String, required: true },
  actions: { type: Array, default: () => [] }
});

const hasActions = computed(() => props.actions.length > 0);
</script>
