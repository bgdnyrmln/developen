<template>
  <!-- Header component -->
  <headerline />

  <div class="exercises">
    <h1>Exercises for you!</h1>

    <!-- Sorting and filtering UI -->
    <div class="filter-container">
      <div style="display:flex; gap: 5px">
        <!-- Toggle sorting order -->
        <button @click="toggleSortDirection" class="sort-button">
          Sort: {{ sortDirection === 'asc' ? 'Ascending' : 'Descending' }}
        </button>
        <!-- Reset search and category filter -->
        <button @click="clearFilters" class="sort-button" style="background-color: #555555;">
          Clear filters
        </button>
      </div>

      <!-- Search form -->
      <form class="search-exercise" @submit="handleSearch">
        <input
          class="search-exercise-input"
          type="text"
          placeholder="Search exercise"
          v-model="query"
        />
        <button class="search-exercise-button" type="submit">Search</button>
      </form>
    </div>

    <!-- List of exercises (filtered, sorted, paginated) -->
    <NuxtLink
      v-for="exercise in displayedExercises"
      :key="exercise.id"
      class="containerforexercise"
      :to="{ name: 'exercises-id', params: { id: exercise.id } }"
    >
      <h1 class="exercise-id">{{ exercise.id }}</h1>

      <div class="exercise-content">
        <h2 class="exercise-name">{{ exercise.name }}</h2>

        <!-- Category buttons (filterable) -->
        <div class="exercise-categories">
          <button
            v-for="category in exercise.categories"
            :key="category.id"
            class="exercise-category"
            :style="{
              backgroundColor: category.color,
              color: '#fff',
              border: `1px solid ${category.color}`,
              borderRadius: '50px',
              padding: '5px 10px',
              cursor: 'pointer'
            }"
            @click.stop.prevent="selectedCategory = selectedCategory === category.id ? null : category.id"
          >
            {{ category.name }}
          </button>
        </div>
      </div>
    </NuxtLink>

    <!-- Pagination (only shown if more than 5 items) -->
    <div v-if="filteredExercises.filter(ex => ex.id <= exercises_count).length > 5" class="pagination">
      <vue-awesome-paginate
        :total-items="filteredExercises.filter(ex => ex.id <= exercises_count).length"
        :items-per-page="5"
        :max-pages-shown="3"
        v-model="currentPage"
        @click="onClickHandler"
      />
    </div>
  </div>

  <!-- Footer component -->
  <footerline />
</template>

<script setup lang="ts">
import { NuxtLink } from '#components';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

// Data types
interface Category {
  id: number;
  name: string;
  color: string;
}

interface Exercise {
  id: number;
  name: string;
  categories: Category[];
}

// Reactive state
const exercises = ref<Exercise[]>([]);
const filteredExercises = ref<Exercise[]>([]);
const exercises_count = ref(1);
const sortDirection = ref<'asc' | 'desc'>('asc');
const currentPage = ref(1);

const query = ref('');
const loading = ref(false);
const error = ref<string | null>(null);
const selectedCategory = ref<number | null>(null);

// Middleware protection (authenticated users only)
definePageMeta({
  middleware: ["$auth"],
});

// Load user data and exercise list
onMounted(async () => {
  try {
    const userData = await useSanctumFetch('/api/user');
    exercises_count.value = userData.exercises_count;

    const data = await $fetch<Exercise[]>('/api/exercises');
    exercises.value = data;
    filteredExercises.value = data;
  } catch (err) {
    console.error('Error fetching data:', err);
  }
});

// Pagination handler
const onClickHandler = (page: number) => {
  currentPage.value = page;
};

// Toggle sorting direction
const toggleSortDirection = () => {
  sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
};

// Search exercises by name
const fetchData = async () => {
  if (!query.value.trim()) {
    filteredExercises.value = exercises.value;
    return;
  }

  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get<Exercise[]>('/api/exercises', {
      params: { name: query.value }
    });
    filteredExercises.value = response.data;
    currentPage.value = 1;
  } catch (err) {
    error.value = 'Error fetching data';
    filteredExercises.value = [];
  } finally {
    loading.value = false;
  }
};

// Reset all filters and search
const clearFilters = () => {
  selectedCategory.value = null;
  query.value = '';
  filteredExercises.value = exercises.value;
  currentPage.value = 1;
};

// Handle search form submit
const handleSearch = (e: Event) => {
  e.preventDefault();
  fetchData();
};

// Displayed list (filtered, sorted, paginated)
const displayedExercises = computed(() => {
  let filtered = filteredExercises.value.filter(ex => ex.id <= exercises_count.value);

  if (selectedCategory.value !== null) {
    filtered = filtered.filter(ex =>
      ex.categories.some(cat => cat.id === selectedCategory.value)
    );
  }

  const sorted = filtered.sort((a, b) =>
    sortDirection.value === 'asc' ? a.id - b.id : b.id - a.id
  );

  const start = (currentPage.value - 1) * 5;
  const end = start + 5;
  return sorted.slice(start, end);
});
</script>

<style>
/* Layout and spacing */
.exercises {
  padding-top: 20vh;
  padding-left: 10vh;
  padding-right: 10vh;
  min-height: 50vh;
  padding-bottom: 10vh;
}

/* Exercise card styling */
.containerforexercise {
  color: white;
  width: 96%;
  min-height: 10vh;
  background-color: #222222;
  margin: auto;
  border-radius: 10px;
  display: flex;
  position: relative;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
  padding: 2% 2%;
  transition: all 0.3s ease;
  text-decoration: none;
}

.containerforexercise:hover {
  background-color: #444444;
  cursor: pointer;
}

.exercise-id {
  position: absolute;
  left: 20px;
  font-weight: bold;
  font-size: 6vh;
  color: #333333;
}

.exercise-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
}

.exercise-name {
  font-size: 2rem;
  margin-bottom: 10px;
  text-align: center;
}

.exercise-categories {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-end;
  width: 100%;
  gap: 8px;
  transition: all 0.2s ease;
}

.exercise-category:hover {
  filter: brightness(1.3);
  transform: scale(1.05);
}
</style>
