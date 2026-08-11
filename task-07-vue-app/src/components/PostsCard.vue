<script setup>
import { RouterLink } from 'vue-router'
defineProps({
  id: Number,
  title: String,
  body: String,
})
</script>

<template>
  <article class="post-card">
    <h3>{{ title }}</h3>
    <p>{{ body }}</p>
    <RouterLink :to="`/posts/${id}`"> View Details </RouterLink>
  </article>
</template>
<style scoped>
/* =========================
   Post Card
========================= */

.post-card {
  display: flex;
  flex-direction: column;

  min-height: 230px;

  padding: 25px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);

  transition: var(--transition);
}

.post-card:hover {
  transform: translateY(-5px);

  border-color: var(--primary-color);

  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.post-card h3 {
  margin-bottom: 15px;

  color: var(--secondary-color);

  font-size: 1.15rem;
  line-height: 1.4;

  text-transform: capitalize;
}

.post-card p {
  color: #666;

  font-size: 0.95rem;
  line-height: 1.7;
}

.post-card a {
  display: inline-block;
  align-self: flex-start;

  margin-top: auto;
  padding: 10px 18px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.post-card a:hover {
  background-color: var(--secondary-color);
  transform: translateY(-2px);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  .post-card {
    min-height: 210px;
    padding: 22px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .post-card {
    min-height: auto;

    padding: 20px;
  }

  .post-card h3 {
    font-size: 1.05rem;
  }

  .post-card p {
    font-size: 0.9rem;
  }
}
</style>
