<template>
  <headerline/>
    <div class="exercises">
      <h1>Exercises for you!</h1>

        <NuxtLink v-for="exercise in exercises" :key="exercise.id" class="containerforexercise" :to="{ name: 'exercises-id', params: { id: exercise.id } }">
                
          <h1 class="exercise-id">{{ exercise.id }}</h1>
          <p class="exercise-name">{{ exercise.name }}</p>
        </NuxtLink>
              
    </div>
    <footerline/>
  </template>
  


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
  font-size: 100px;
  color: #333333;
}

.exercise-name {
}
</style>
