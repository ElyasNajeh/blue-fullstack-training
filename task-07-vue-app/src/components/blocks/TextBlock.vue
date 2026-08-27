<script setup>
defineProps({
  data: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <section class="text-block">
    <h2 v-if="data.title">{{ data.title }}</h2>
    <p>{{ data.text }}</p>
  </section>
</template>
