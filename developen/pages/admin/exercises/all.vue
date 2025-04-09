<template>
<div class = "container" style="margin-left: 34vh;">
  <a class = "usercard"  href="/admin/exercises/create">Create new exercise</a>
  
  <div class = "usercard" v-for="exercise in exercises" :key="exercise.id">
    <div>
        Name: {{ exercise.name }} <br>
        Description: {{ exercise.description }} <br>
    </div>
    <div style="display: flex; gap: 10px;">
        <NuxtLink :to="`/admin/exercises/${exercise.id}`" class="userbutton">Details</NuxtLink>
        <button @click = "deleteExercise(exercise.id)" class="userbutton" style="background-color: red;">Delete</button>
    </div>
  </div>

</div>
<admin-panel/>
</template>

<script setup>
import axios from 'axios';

definePageMeta({
    middleware: ["$auth", "admin"],    
});

const exercises = ref([]);

onMounted(async () => {
  try {

    // First, get CSRF cookie
    await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true
    });
    exercises.value = await $fetch('http://localhost:9000/api/exercises');
  } catch (error) {
    console.error('Error fetching exercises:', error);
  }
});



const deleteExercise = async (id) => {
    if (confirm("Are you sure you want to delete this exercise?")) {
        try {
        // Get CSRF token from cookie
            const token = decodeURIComponent(
                document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("XSRF-TOKEN="))
                    ?.split("=")[1] ?? ""
            );

            await axios.delete(`http://localhost:9000/api/exercises/${id}`, {
                withCredentials: true,
                headers: {
                    "X-XSRF-TOKEN": token,
                },
            });

            exercises.value = exercises.value.filter((exercise) => exercise.id !== id);
        } catch (error) {
            console.error("Error deleting exercise:", error);
        }
    }
};


</script>