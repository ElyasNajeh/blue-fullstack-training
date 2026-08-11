<script setup>
import { ref, computed } from 'vue'
import ServiceCard from '../components/ServiceCard.vue'
const services = ref([
  {
    id: 1,
    title: 'Web Development',
    description: 'Building responsive and modern websites for businesses.',
    category: 'Web',
  },
  {
    id: 2,
    title: 'Mobile Applications',
    description: 'Developing Android and iOS applications with modern technologies.',
    category: 'Mobile',
  },
  {
    id: 3,
    title: 'UI/UX Design',
    description: 'Designing attractive and user-friendly interfaces.',
    category: 'UI/UX',
  },
  {
    id: 4,
    title: 'E-Commerce Development',
    description: 'Building modern and scalable online stores for businesses.',
    category: 'Web',
  },
  {
    id: 5,
    title: 'Android Development',
    description: 'Developing reliable and user-friendly Android applications.',
    category: 'Mobile',
  },
  {
    id: 6,
    title: 'Interface Prototyping',
    description: 'Creating interactive prototypes for modern digital products.',
    category: 'UI/UX',
  },
  {
    id: 7,
    title: 'Frontend Development',
    description: 'Creating responsive and interactive user interfaces for the web.',
    category: 'Web',
  },
  {
    id: 8,
    title: 'iOS Development',
    description: 'Building modern applications for Apple mobile devices.',
    category: 'Mobile',
  },
])
const selectedCategory = ref('All')
const selectedService = ref('')
const filteredServices = computed(() => {
  if (selectedCategory.value === 'All') {
    return services.value
  }
  return services.value.filter((service) => {
    return service.category === selectedCategory.value
  })
})

function showDetails(service) {
  selectedService.value = service
}
</script>

<template>
  <section id="services">
    <h2>Services</h2>
    <div class="service-filters">
      <button :class="{ active: selectedCategory === 'All' }" @click="selectedCategory = 'All'">
        All
      </button>
      <button :class="{ active: selectedCategory === 'Web' }" @click="selectedCategory = 'Web'">
        Web
      </button>
      <button
        :class="{ active: selectedCategory === 'Mobile' }"
        @click="selectedCategory = 'Mobile'"
      >
        Mobile
      </button>
      <button :class="{ active: selectedCategory === 'UI/UX' }" @click="selectedCategory = 'UI/UX'">
        UI/UX
      </button>
    </div>
    <div v-if="selectedService" class="service-details">
      <h3>{{ selectedService.title }}</h3>
      <p>{{ selectedService.description }}</p>

      <button @click="selectedService = null">Close</button>
    </div>
    <ServiceCard
      v-for="service in filteredServices"
      :key="service.id"
      :title="service.title"
      :description="service.description"
      @view-details="showDetails"
    />
  </section>
</template>

<style scoped>
/* =========================
   Services Section
========================= */

#services {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;

  width: 100%;
  max-width: 1200px;

  margin: 0 auto;
  padding: 70px 30px;

  background-color: var(--white-color);
}

/* =========================
   Section Title
========================= */

#services h2 {
  grid-column: 1 / -1;

  margin-bottom: 10px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;

  text-align: center;
}

/* =========================
   Filter Buttons
========================= */

.service-filters {
  grid-column: 1 / -1;

  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;

  gap: 12px;

  margin-bottom: 25px;
}

.service-filters button {
  min-width: 90px;

  padding: 10px 20px;

  background-color: var(--white-color);
  color: var(--text-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  font-size: 0.95rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.service-filters button:hover {
  color: var(--primary-color);

  border-color: var(--primary-color);

  transform: translateY(-2px);
}

.service-filters button.active {
  background-color: var(--primary-color);
  color: var(--white-color);

  border-color: var(--primary-color);

  box-shadow: 0 4px 12px rgba(0, 174, 239, 0.2);
}

/* =========================
   Selected Service Details
========================= */

.service-details {
  grid-column: 1 / -1;

  width: 100%;
  max-width: 650px;

  margin: 0 auto 20px;
  padding: 25px 30px;

  text-align: center;

  background-color: var(--background-color);

  border: 1px solid var(--border-color);
  border-left: 4px solid var(--primary-color);
  border-radius: var(--border-radius);

  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
}

.service-details h3 {
  margin-bottom: 10px;

  color: var(--secondary-color);

  font-size: 1.3rem;
}

.service-details p {
  margin-bottom: 18px;

  color: #666;

  font-size: 0.95rem;
  line-height: 1.7;
}

.service-details button {
  padding: 8px 20px;

  background-color: var(--secondary-color);
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.service-details button:hover {
  background-color: var(--primary-color);

  transform: translateY(-2px);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  #services {
    grid-template-columns: repeat(2, 1fr);

    gap: 20px;

    padding: 55px 20px;
  }

  #services h2 {
    font-size: 1.9rem;
  }

  .service-filters {
    margin-bottom: 20px;
  }

  .service-details {
    padding: 22px 20px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  #services {
    grid-template-columns: 1fr;

    gap: 18px;

    padding: 45px 15px;
  }

  #services h2 {
    font-size: 1.7rem;
  }

  .service-filters {
    gap: 8px;

    margin-bottom: 15px;
  }

  .service-filters button {
    min-width: auto;

    padding: 8px 14px;

    font-size: 0.85rem;
  }

  .service-details {
    margin-bottom: 10px;

    padding: 20px 15px;
  }
}
</style>
