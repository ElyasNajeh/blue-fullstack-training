<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <footer>
    <h3>Blue Information Technology</h3>

    <p>Delivering innovative software solutions for businesses worldwide.</p>

    <RouterLink to="/">Home</RouterLink>
    <RouterLink to="/services">Services</RouterLink>
    <RouterLink to="/posts">Posts</RouterLink>
    <RouterLink to="/contact">Contact Us</RouterLink>

    <p>&copy; 2026 Blue Information Technology. All Rights Reserved.</p>
  </footer>
</template>
<style scoped>
footer {
  width: 100%;

  padding: 45px 20px 30px;

  background-color: var(--secondary-color);
  color: var(--white-color);

  text-align: center;

  border-top: 3px solid var(--primary-color);
}

/* =========================
   Company Name
========================= */

footer h3 {
  margin-bottom: 12px;

  color: var(--white-color);

  font-size: 1.4rem;
  font-weight: 700;
}

/* =========================
   Paragraphs
========================= */

footer p {
  max-width: 650px;

  margin: 0 auto 18px;

  color: #d1d5db;

  font-size: 0.95rem;
  line-height: 1.7;
}

/* =========================
   Navigation Links
========================= */

footer a {
  display: inline-block;

  margin: 0 8px;
  padding: 4px 2px;

  color: var(--white-color);

  font-size: 0.95rem;
  font-weight: 600;

  text-decoration: none;

  transition: var(--transition);
}

footer a:hover {
  color: var(--primary-color);
}

/* Last paragraph - Copyright */

footer p:last-child {
  margin-top: 20px;
  margin-bottom: 0;

  padding-top: 20px;

  border-top: 1px solid rgba(255, 255, 255, 0.15);

  color: #9ca3af;

  font-size: 0.85rem;
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  footer {
    padding: 40px 20px 25px;
  }

  footer h3 {
    font-size: 1.3rem;
  }

  footer p {
    font-size: 0.9rem;
  }

  footer a {
    margin: 0 6px;

    font-size: 0.9rem;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  footer {
    padding: 35px 15px 25px;
  }

  footer h3 {
    font-size: 1.2rem;
  }

  footer p {
    font-size: 0.85rem;
  }

  footer a {
    margin: 4px 5px;

    font-size: 0.85rem;
  }

  footer p:last-child {
    margin-top: 15px;
    padding-top: 15px;

    font-size: 0.8rem;
  }
}
</style>
