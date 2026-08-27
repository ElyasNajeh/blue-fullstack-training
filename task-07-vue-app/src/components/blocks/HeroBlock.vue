<script setup>
defineProps({
  data: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <section class="hero-block">
    <h1>{{ data.title }}</h1>
    <p v-if="data.subtitle">{{ data.subtitle }}</p>
  </section>
</template>
