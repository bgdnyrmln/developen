<template>
<div class = "container" style="margin-left: 34vh;">
  
  <div class = "usercard" v-for="exercise in exercises" :key="exercise.id">
    <div>
        Name: {{ exercise.name }} <br>
        Description: {{ exercise.description }} <br>
    </div>
    <div style="display: flex; gap: 10px;">
        <NuxtLink :to="`/admin/exercises/${exercise.id}`" class="userbutton">Details</NuxtLink>
        <button @click = "deleteUser(exercise.id)" class="userbutton" style="background-color: red;">Delete</button>
    </div>
  </div>

</div>
<admin-panel/>
</template>

<script setup>
  definePageMeta({
      middleware: ["$auth", "admin"],    
  });

const exercises = ref([]);

onMounted(async () => {
  try {
    exercises.value = await $fetch('http://localhost:9000/api/exercises');
  } catch (error) {
    console.error('Error fetching users:', error);
  }
});

</script>