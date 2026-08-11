<script setup></script>
<template>
  <section id="hero">
    <h1>Blue Information Technology</h1>
    <p>Building modern web solutions for businesses.</p>
    <a href="#contactus">Get Started</a>
  </section>
</template>
<style scoped>
#hero {
  min-height: 420px;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

  text-align: center;

  padding: 80px 20px;

  background: linear-gradient(135deg, var(--white-color) 0%, var(--background-color) 100%);

  border-bottom: 1px solid var(--border-color);
}

/* =========================
   Title
========================= */

#hero h1 {
  margin-bottom: 18px;

  color: var(--secondary-color);

  font-size: 3rem;
  font-weight: 700;
  line-height: 1.2;
}

/* =========================
   Description
========================= */

#hero p {
  max-width: 650px;

  margin-bottom: 30px;

  color: #666;

  font-size: 1.15rem;
  line-height: 1.7;
}

/* =========================
   Get Started Button
========================= */

#hero a {
  display: inline-block;

  padding: 12px 28px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: 2px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-size: 1rem;
  font-weight: 600;

  text-decoration: none;

  transition: var(--transition);
}

#hero a:hover {
  background-color: #0096d6;
  border-color: #0096d6;

  transform: translateY(-3px);

  box-shadow: 0 8px 18px rgba(0, 174, 239, 0.25);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  #hero {
    min-height: 360px;

    padding: 60px 20px;
  }

  #hero h1 {
    font-size: 2.3rem;
  }

  #hero p {
    max-width: 550px;

    font-size: 1rem;

    margin-bottom: 25px;
  }

  #hero a {
    padding: 11px 24px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  #hero {
    min-height: 320px;

    padding: 45px 15px;
  }

  #hero h1 {
    font-size: 1.8rem;

    margin-bottom: 15px;
  }

  #hero p {
    font-size: 0.95rem;
    line-height: 1.6;

    margin-bottom: 22px;
  }

  #hero a {
    padding: 10px 20px;

    font-size: 0.95rem;
  }
}
</style>
