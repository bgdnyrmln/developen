<script setup>
import { NuxtLink } from '#components';
import { ref, onMounted } from 'vue';

const exercises = ref([]);

onMounted(async () => {
  try {
    exercises.value = await $fetch('http://localhost:9000/api/exercises');
  } catch (error) {
    console.error('Error fetching users:', error);
  }


});
</script>

<template>
    <div class="exercises">
      <h1>Exercises for you!</h1>
  
      <div v-for="exercise in exercises" :key="exercise.id" class="containerforexercise">
        <span>{{ exercise.name }}</span>
        <!-- <NuxtLink :to="{ name: 'exercises-id', params: { id: exercise.id } }">
          Create Exercise
        </NuxtLink> -->
      </div>
    </div>
  </template>
  


<style>
.exercises{
    padding-top: 20vh;
    padding-left: 10vh; 
    padding-right: 10vh;
}

.containerforexercise{
    color: white;
    height: 10vh;
    width: 100%;
    background-color: #222222;
    margin: auto;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.containerforexercise:hover{
    background-color: #444444;
    cursor: pointer;
}

</style>
