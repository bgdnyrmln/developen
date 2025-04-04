<template>
    <div class="exercises">
        <div class="exercise-title">
            <h3>Exercise</h3>
        </div>
        <div class="exercise-text">
            <h1>{{ exercises.name }}</h1>
            <p style="font-size: 25px;">{{ exercises.description }}</p>
        </div>
    </div>

    
</template>


<script setup>

definePageMeta({
    middleware: ["$auth"],
});

const route = useRoute();
const exercises = ref([]);

try {
    exercises.value = await $fetch(`http://localhost:9000/api/exercises/${route.params.id}`);
  } catch (error) {
    console.error('Error fetching exercises:', error);
  }


</script>


