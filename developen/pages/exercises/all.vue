<template>
  <headerline/>
  <div class="exercises">
    <h1>Exercises for you!</h1>

    <!-- Button to toggle sort direction -->
     <div class = "filter-container">
      <button @click="toggleSortDirection" class="sort-button">
        Sort: {{ sortDirection === 'asc' ? 'Ascending' : 'Descending' }}
      </button>
      <form class="search-exercise" @submit="handleSearch">
        <input
          class="search-exercise-input"
          type="text"
          placeholder="Search exercise"
          v-model="query"
        >
        <button class="search-exercise-button" type="submit">
          Search
        </button>
      </form>

    </div>

    <NuxtLink v-for="exercise in displayedExercises" 
      :key="exercise.id" 
      class="containerforexercise" 
      :to="{ name: 'exercises-id', params: { id: exercise.id } }">
      <h1 class="exercise-id">{{ exercise.id }}</h1>
      <h2>{{ exercise.name }}</h2>
    </NuxtLink>

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
  <footerline/>
</template>

<script setup lang="ts">
import { NuxtLink } from '#components';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

interface Exercise {
  id: number;
  name: string;
}

const exercises = ref<Exercise[]>([]);
const filteredExercises = ref<Exercise[]>([]);
const exercises_count = ref(1);
const sortDirection = ref<'asc' | 'desc'>('asc');
const currentPage = ref(1);

// Search-related states
const query = ref('');
const loading = ref(false);
const error = ref<string | null>(null);

definePageMeta({
  middleware: ["$auth"],
});

onMounted(async () => {
  try {
    const userData = await useSanctumFetch('http://localhost:9000/api/user');
    exercises_count.value = userData.exercises_count;
    const data = await $fetch<Exercise[]>('http://localhost:9000/api/exercises');
    exercises.value = data;
    filteredExercises.value = data;
  } catch (err) {
    console.error('Error fetching data:', err);
  }
});

const onClickHandler = (page: number) => {
  console.log(page);
};

const toggleSortDirection = () => {
  sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
};

// Fetch data from API based on search query
const fetchData = async () => {
  if (!query.value.trim()) {
    // Reset to full list if search is cleared
    filteredExercises.value = exercises.value;
    return;
  }

  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get('http://localhost:9000/api/exercises', {
      params: { name: query.value }
    });
    filteredExercises.value = response.data;
    currentPage.value = 1; // Reset pagination
  } catch (err) {
    error.value = 'Error fetching data';
    filteredExercises.value = [];
  } finally {
    loading.value = false;
  }
};

const handleSearch = (e: Event) => {
  e.preventDefault();
  fetchData();
};

// Computed property for sorting + paginating
const displayedExercises = computed(() => {
  const filtered = filteredExercises.value.filter(ex => ex.id <= exercises_count.value);
  const sorted = filtered.sort((a, b) => {
    return sortDirection.value === 'asc' ? a.id - b.id : b.id - a.id;
  });
  const start = (currentPage.value - 1) * 5;
  const end = start + 5;
  return sorted.slice(start, end);
});
</script>


<style>
.exercises{
  padding-top: 20vh;
  padding-left: 10vh; 
  padding-right: 10vh;
  min-height: 50vh;
}

.containerforexercise {
  color: white;
  height: 10vh;
  width: 100%;
  background-color: #222222;
  margin: auto;
  border-radius: 10px;
  display: flex;
  position: relative;
  align-items: center;
  justify-content: center;
  margin-bottom: 5px;
  transition: all 0.3s ease;
  text-decoration: none;
}

.containerforexercise:hover{
  background-color: #444444;
  cursor: pointer;
}

.exercise-id {
  position: absolute;
  left: 20px;
  font-weight: bold;
  font-size: 10vh;
  color: #333333;
}
</style>
