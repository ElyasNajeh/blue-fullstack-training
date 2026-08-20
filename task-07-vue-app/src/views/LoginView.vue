<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

async function handleLogin() {
  loading.value = true
  error.value = ''

  const success = await authStore.login(email.value, password.value)

  if (success) {
    router.push('/posts')
  } else {
    error.value = 'Invalid email or password'
  }

  loading.value = false
}
</script>

<template>
  <main>
    <h1>Login</h1>

    <form @submit.prevent="handleLogin">
      <div>
        <label for="email">Email</label>
        <input id="email" v-model="email" type="email" required />
      </div>

      <div>
        <label for="password">Password</label>
        <input id="password" v-model="password" type="password" required />
      </div>

      <p v-if="error">{{ error }}</p>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>
    </form>
  </main>
</template>
<style scoped>
main {
  min-height: 520px;

  display: flex;
  flex-direction: column;
  align-items: center;

  padding: 70px 20px;

  background-color: var(--background-color);
}

h1 {
  margin-bottom: 30px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;
}

form {
  width: 100%;
  max-width: 450px;

  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

form div {
  margin-bottom: 22px;
}

label {
  display: block;

  margin-bottom: 8px;

  color: var(--secondary-color);

  font-size: 0.95rem;
  font-weight: 600;
}

input {
  width: 100%;

  padding: 12px 14px;

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  background-color: var(--white-color);
  color: var(--text-color);

  font-size: 1rem;

  outline: none;

  transition: var(--transition);
}

input:focus {
  border-color: var(--primary-color);

  box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.12);
}

form p {
  margin-bottom: 18px;

  color: #dc3545;

  font-size: 0.9rem;
  font-weight: 500;
}

button {
  width: 100%;

  padding: 12px 20px;

  border: none;
  border-radius: var(--border-radius);

  background-color: var(--primary-color);
  color: var(--white-color);

  font-size: 1rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

button:hover:not(:disabled) {
  opacity: 0.85;
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* =========================
   Mobile
========================= */

@media (max-width: 768px) {
  main {
    min-height: 450px;

    padding: 45px 20px;
  }

  h1 {
    margin-bottom: 25px;

    font-size: 1.9rem;
  }

  form {
    max-width: 400px;

    padding: 28px 24px;
  }
}

/* =========================
   Small Mobile
========================= */

@media (max-width: 480px) {
  main {
    padding: 35px 15px;
  }

  h1 {
    font-size: 1.7rem;
  }

  form {
    padding: 24px 18px;
  }

  input,
  button {
    font-size: 0.95rem;
  }
}
</style>
