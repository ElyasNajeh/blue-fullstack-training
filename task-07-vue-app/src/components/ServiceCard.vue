<script setup>
defineProps({
  title: String,
  description: String,
})

const emit = defineEmits(['view-details'])
</script>
<template>
  <article>
    <h3>{{ title }}</h3>
    <p>{{ description }}</p>

    <button @click="emit('view-details', { title, description })">View Details</button>
  </article>
</template>
<style scoped>
article {
  height: 100%;

  display: flex;
  flex-direction: column;
  align-items: center;

  padding: 28px 24px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: center;

  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);

  transition: var(--transition);
}

article:hover {
  transform: translateY(-6px);

  border-color: var(--primary-color);

  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* =========================
   Title
========================= */

article h3 {
  margin-bottom: 14px;

  color: var(--secondary-color);

  font-size: 1.25rem;
  font-weight: 700;
}

/* =========================
   Description
========================= */

article p {
  flex-grow: 1;

  margin-bottom: 22px;

  color: #666;

  font-size: 0.95rem;
  line-height: 1.7;
}

/* =========================
   View Details Button
========================= */

article button {
  padding: 10px 20px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: 2px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

article button:hover {
  background-color: #0096d6;
  border-color: #0096d6;

  transform: translateY(-2px);

  box-shadow: 0 5px 12px rgba(0, 174, 239, 0.2);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  article {
    padding: 24px 20px;
  }

  article h3 {
    font-size: 1.15rem;
  }

  article p {
    font-size: 0.9rem;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  article {
    padding: 22px 18px;
  }

  article h3 {
    font-size: 1.1rem;
  }

  article p {
    margin-bottom: 18px;
  }

  article button {
    width: 100%;
  }
}
</style>
