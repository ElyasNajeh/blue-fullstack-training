<script setup></script>

<template>
  <section class="contact-page">
    <div class="contact-content">
      <h1>Contact Us</h1>

      <p>
        Have a project in mind? We'd love to hear from you. Get in touch with Blue Information
        Technology.
      </p>

      <div class="contact-info">
        <p><strong>Phone:</strong> 02-2929090</p>
        <p><strong>Email:</strong> info@blue.ps</p>
        <p><strong>Location:</strong> Nablus Street, Al-Bireh</p>
      </div>
    </div>
  </section>
</template>

<style scoped>
.contact-page {
  min-height: 500px;

  display: flex;
  justify-content: center;
  align-items: center;

  padding: 70px 20px;

  background-color: var(--background-color);
}

.contact-content {
  width: 100%;
  max-width: 700px;

  padding: 40px;

  text-align: center;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.contact-content h1 {
  margin-bottom: 15px;

  color: var(--secondary-color);
  font-size: 2rem;
}

.contact-content > p {
  max-width: 550px;

  margin: 0 auto 30px;

  color: #555;
  line-height: 1.7;
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: 15px;

  padding-top: 25px;

  border-top: 1px solid var(--border-color);
}

.contact-info p {
  margin: 0;

  color: var(--text-color);
}

.contact-info strong {
  color: var(--primary-color);
}

/* Tablet */

@media (max-width: 768px) {
  .contact-page {
    min-height: 450px;
    padding: 50px 20px;
  }

  .contact-content {
    padding: 30px;
  }

  .contact-content h1 {
    font-size: 1.8rem;
  }
}

/* Mobile */

@media (max-width: 480px) {
  .contact-page {
    min-height: 400px;
    padding: 35px 15px;
  }

  .contact-content {
    padding: 25px 18px;
  }

  .contact-content h1 {
    font-size: 1.6rem;
  }

  .contact-content > p {
    font-size: 0.95rem;
  }
}
</style>
