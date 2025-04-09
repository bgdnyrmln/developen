<template>
    <headerline/>
    <div class = "container" style="padding-left: 5vh;">
        <h1>{{ exercise.name }}</h1>
        <h2>{{ exercise.description }}</h2>
        
        <form @submit.prevent="checkAnswer($event)" class="register-form">
            <input class = "register-input" type="text" name="answer" placeholder="Your answer"/>
            <button class = "register-button" type="submit">Check answer</button>
        </form>

        <div style= "display:flex; justify-content: space-around; margin-top: 2vh;">
            <NuxtLink v-if = "beforeExercise.id != null" class="register-button" :to="{ name: 'exercises-id', params: { id: beforeExercise.id } }">
                {{ beforeExercise.name  }}
            </NuxtLink>
            <NuxtLink to="/exercises/all" class="register-button">
                Back to exercises
            </NuxtLink>
            <NuxtLink v-if = "nextExercise.id != null" class="register-button" :to="{ name: 'exercises-id', params: { id: nextExercise.id } }">
                {{ nextExercise.name  }}
            </NuxtLink>
        </div>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router';
import axios from 'axios';


definePageMeta({
    middleware: ["$auth"],
});

const route = useRoute();
const id = Number(route.params.id);
const exercise = ref([]);
const nextExercise = ref([]);
const beforeExercise = ref([]);

onMounted(async () => {     
    try {
        // First, get CSRF cookie
        await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
            withCredentials: true
        });
        exercise.value = await $fetch(`http://localhost:9000/api/exercises/${id}`)
    } catch (error) {
        console.error('Error fetching exercises:', error);
    }
    try{
        beforeExercise.value = await $fetch(`http://localhost:9000/api/exercises/${id-1}`)
    } catch (error) {
        console.error('Error fetching exercises:', error);
    }
    try{
        nextExercise.value = await $fetch(`http://localhost:9000/api/exercises/${id+1}`)
    } catch (error) {
        console.error('Error fetching exercises:', error);
    }
});

const checkAnswer = async (e) => {
  try {
    const form = e.target;
    const formData = new FormData(form);
    const userAnswer = formData.get("answer").trim().toLowerCase();
    const correctAnswer = exercise.value.answer.trim().toLowerCase();

    if (userAnswer === correctAnswer) {
      alert("Correct answer!");
    } else {
      alert("Incorrect answer. Try again.");
    }
  } catch (error) {
    console.error("Error checking answer:", error);
    alert("An error occurred while checking the answer.");
  }
};

</script>