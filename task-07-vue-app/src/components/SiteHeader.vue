<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'

import { usePostStore } from '@/stores/posts'
import { useAuthStore } from '@/stores/auth'
import blueLogo from '../assets/blue.png'

const isMenuOpen = ref(false)
const router = useRouter()

const postStore = usePostStore()
const { favoriteCnt } = storeToRefs(postStore)

const authStore = useAuthStore()
const { user, isAuthenticated } = storeToRefs(authStore)

async function handleLogout() {
  const success = await authStore.logout()

  if (success) {
    router.push('/login')
  }
}
</script>

<template>
  <header>
    <img :src="blueLogo" alt="Company Logo" />
    <button
      class="menu-toggle"
      @click="isMenuOpen = !isMenuOpen"
      aria-label="Open menu"
      aria-controls="menu"
      :aria-expanded="isMenuOpen"
    >
      ☰
    </button>
  </header>
  <nav id="menu" :class="{ active: isMenuOpen }">
    <RouterLink to="/">Home</RouterLink>
    <RouterLink to="/services">Services</RouterLink>
    <RouterLink to="/posts">Posts</RouterLink>
    <RouterLink to="/contact">Contact Us</RouterLink>
    <RouterLink to="/favorites">Favorites {{ favoriteCnt }}</RouterLink>
    <RouterLink v-if="!isAuthenticated" to="/login"> Login </RouterLink>

    <template v-else>
      <span class="auth-user">
        {{ user?.name }}
      </span>

      <button class="logout-button" @click="handleLogout">Logout</button>
    </template>
  </nav>
</template>
<style scoped>
/* =========================
   Header
========================= */

header {
  width: 100%;
  min-height: 90px;

  display: flex;
  align-items: center;
  justify-content: center;

  padding: 15px 6%;

  background-color: var(--white-color);
  border-bottom: 1px solid var(--border-color);
}

header img {
  display: block;
  width: 170px;
  height: auto;
}

/* =========================
   Navigation
========================= */

nav {
  width: 100%;

  display: flex;
  align-items: center;
  justify-content: center;
  gap: 35px;

  padding: 14px 20px;

  background-color: var(--secondary-color);

  position: sticky;
  top: 0;
  z-index: 999;

  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

nav a {
  position: relative;

  color: var(--white-color);
  font-size: 1rem;
  font-weight: 600;

  padding: 5px 0;

  text-decoration: none;

  transition: var(--transition);
}

nav a:hover {
  color: var(--primary-color);
}

/* Small line under link */

nav a::after {
  content: '';

  position: absolute;
  left: 0;
  bottom: 0;

  width: 0;
  height: 2px;

  background-color: var(--primary-color);

  transition: var(--transition);
}

nav a:hover::after {
  width: 100%;
}

/* =========================
   Menu Button
========================= */

.menu-toggle {
  display: none;

  background: none;
  border: none;

  color: var(--secondary-color);

  font-size: 2rem;
  line-height: 1;

  padding: 5px;

  cursor: pointer;

  transition: var(--transition);
}

.menu-toggle:hover {
  color: var(--primary-color);
}

nav a.router-link-active {
  color: var(--primary-color);
}

nav a.router-link-active::after {
  width: 100%;
}
.auth-user {
  color: var(--white-color);
  font-weight: 600;
}

.logout-button {
  padding: 7px 14px;

  border: 1px solid var(--primary-color);
  border-radius: var(--border-radius);

  background: transparent;
  color: var(--white-color);

  font-size: 0.95rem;
  font-weight: 600;

  cursor: pointer;
  transition: var(--transition);
}

.logout-button:hover {
  background-color: var(--primary-color);
}

/* =========================
   Tablet
========================= */

@media (max-width: 1024px) {
  header {
    padding: 15px 5%;
  }

  header img {
    width: 160px;
  }

  nav {
    gap: 25px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 768px) {
  header {
    min-height: 75px;

    justify-content: space-between;

    padding: 12px 20px;

    position: relative;
    z-index: 1001;
  }

  header img {
    width: 145px;
  }

  .menu-toggle {
    display: block;
  }

  #menu {
    display: none;
    position: absolute;

    top: 103px;
    right: 20px;

    width: 70%;
    max-width: 280px;

    padding: 0;

    background-color: var(--white-color);
    border-radius: var(--border-radius);

    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);

    overflow: hidden;
    z-index: 1000;
  }
  #menu.active {
    display: block;
  }

  #menu a {
    display: block;

    width: 100%;

    padding: 15px 20px;

    color: var(--text-color);

    font-size: 0.95rem;
    font-weight: 600;

    text-align: left;

    border-bottom: 1px solid var(--border-color);
  }

  #menu a:last-child {
    border-bottom: none;
  }

  #menu a:hover {
    color: var(--primary-color);
    background-color: var(--background-color);
  }

  /* ما بدنا underline animation داخل mobile menu */
  #menu a::after {
    display: none;
  }
  #menu .auth-user {
    display: block;
    padding: 15px 20px;

    color: var(--text-color);
    font-weight: 600;

    border-bottom: 1px solid var(--border-color);
  }

  #menu .logout-button {
    display: block;

    width: 100%;
    padding: 15px 20px;

    border: none;
    border-radius: 0;

    color: var(--text-color);
    background: var(--white-color);

    text-align: left;
  }

  #menu .logout-button:hover {
    color: var(--primary-color);
    background-color: var(--background-color);
  }
}

/* =========================
   Small Mobile
========================= */

@media (max-width: 480px) {
  header {
    min-height: 70px;
    padding: 10px 15px;
  }

  header img {
    width: 125px;
  }

  .menu-toggle {
    font-size: 1.8rem;
  }

  #menu {
    top: 85px;
    right: 15px;

    width: calc(100% - 30px);
  }

  #menu a {
    padding: 14px 18px;
  }
}
</style>
