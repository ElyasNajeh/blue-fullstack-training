<script setup>
defineProps({
  data: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <section class="cta-block">
    <h2 v-if="data.title">{{ data.title }}</h2>

    <p v-if="data.text">{{ data.text }}</p>

    <RouterLink v-if="data.url" :to="data.url">
      {{ data.button_text || 'Learn More' }}
    </RouterLink>
  </section>
</template>
