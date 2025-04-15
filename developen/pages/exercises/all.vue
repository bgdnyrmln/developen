<template>
<headerline/>
  <div class="exercises">
    <h1>Exercises for you!</h1>

      <NuxtLink v-for="exercise in displayedExercises" 
      :key="exercise.id" 
      class="containerforexercise" 
      :to="{ name: 'exercises-id', params: { id: exercise.id } }">
              
        <h1 class="exercise-id">{{ exercise.id }}</h1>
        <h2>{{ exercise.name }}</h2>
      </NuxtLink>
      <div class="pagination">
        <vue-awesome-paginate
          :total-items="exercises.filter(ex => ex.id <= exercises_count).length"
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
import { ref, onMounted } from 'vue';

const exercises = ref([]);
const exercises_count = ref(1);

definePageMeta({
  middleware: ["$auth"],
});

onMounted(async () => {

  try {
    const userData = await useSanctumFetch('http://localhost:9000/api/user');
    exercises_count.value = userData.exercises_count;

    exercises.value = await $fetch('http://localhost:9000/api/exercises');
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});

const onClickHandler = (page: number) => {
      console.log(page);
    };

const currentPage = ref(1);


const displayedExercises = computed(() => {
  const filtered = exercises.value.filter(ex => ex.id <= exercises_count.value);
  const start = (currentPage.value - 1) * 5;
  const end = start + 5;
  return filtered.slice(start, end);
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

.pagination{
  margin-top: 5vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.pagination-container {
  margin: auto;
  display: flex;
  justify-content: center;
  align-items: center;

}

.paginate-buttons {
  height: 5vh;
  width: 5vw;
  margin: 0px 2px;
  cursor: pointer;
  background-color: #222222;
  border: 1px solid #222222;
  color: white;
  transition: all 0.3s ease;
  border-radius: 5px;
}

.paginate-buttons:hover {
  background-color: #444444;
}

.active-page {
  background-color: #444444;
  border: 1px solid #444444;
  color: white;
}

.active-page:hover {
  background-color: #555555;
}
</style>
