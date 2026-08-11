<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <section class="not-found">
    <div class="not-found-content">
      <h1>404</h1>
      <h2>Page Not Found</h2>

      <p>The page you're looking for doesn't exist or may have been moved.</p>

      <RouterLink to="/">Back to Home</RouterLink>
    </div>
  </section>
</template>

<style scoped>
.not-found {
  min-height: 500px;

  display: flex;
  justify-content: center;
  align-items: center;

  padding: 60px 20px;

  background-color: var(--background-color);
}

.not-found-content {
  width: 100%;
  max-width: 600px;

  padding: 40px 30px;

  text-align: center;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.not-found-content h1 {
  margin-bottom: 5px;

  color: var(--primary-color);

  font-size: 5rem;
  line-height: 1;
}

.not-found-content h2 {
  margin-bottom: 15px;

  color: var(--secondary-color);

  font-size: 1.8rem;
}

.not-found-content p {
  margin-bottom: 25px;

  color: #666;

  line-height: 1.7;
}

.not-found-content a {
  display: inline-block;

  padding: 11px 22px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border-radius: var(--border-radius);

  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.not-found-content a:hover {
  transform: translateY(-2px);
}

/* Mobile */

@media (max-width: 480px) {
  .not-found {
    min-height: 400px;
    padding: 40px 15px;
  }

  .not-found-content {
    padding: 30px 20px;
  }

  .not-found-content h1 {
    font-size: 4rem;
  }

  .not-found-content h2 {
    font-size: 1.5rem;
  }
}
</style>
