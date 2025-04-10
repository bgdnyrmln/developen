<template>
    <headerline/>
    <div class = "container" style="padding: 20vh 5vh;">
        <h1>{{ exercise.name }}</h1>
        <h2 class="description">{{ exercise.description }}</h2>


        <form @submit.prevent="checkAnswer($event)" class="register-form">
            <input class = "register-input" type="text" name="answer" placeholder="Your answer"/>
            <button class = "register-button" type="submit">Check answer</button>
        </form>

        <div class = "navigation">
            <NuxtLink v-if = "beforeExercise.id != null" class="navigation-button" :to="{ name: 'exercises-id', params: { id: beforeExercise.id } }">
                <p class = "navigation-button-text">{{ beforeExercise.name  }}</p>
                <p class = "navigation-button-symbol"><</p>
            </NuxtLink>
            <NuxtLink to="/exercises/all" class="navigation-button">
                <p class = "navigation-button-text">Back to exercises </p>
                <p class = "navigation-button-symbol">⌂</p>
            </NuxtLink>
            <NuxtLink v-if = "nextExercise.id != null" class="navigation-button" :to="{ name: 'exercises-id', params: { id: nextExercise.id } }">
                <p class = "navigation-button-text">{{ nextExercise.name  }}</p>
                <p class = "navigation-button-symbol">></p>
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


<style>

    .navigation{
        display:flex; 
        justify-content:space-around; 
        margin-top: 2vh;
    }

    .navigation-button{
        height: 20vh;
        display: flex;
        position: relative;
        align-items: center;
        width: 100%;
        margin-bottom: 7vh;
        font-weight: 700;
        font-size: 14px;
        border-radius: 15px;
        background-color: #222222;
        border: none;
        color: white;
        padding: 16px 32px;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
   
    .navigation-button:hover{
        background-color: #444444;
    }

    .navigation-button-text{
        font-size: 20px;
        z-index: 2;
    }


    .navigation-button-symbol{
        font-size: 200px;
        position: absolute;
        right: 50px;
        color: #333333;
    }

    .description {
        white-space: pre-wrap;  /* Ensures newlines and wrapping are respected */
        word-wrap: break-word;  /* Allows long words to break properly */
    }

    @media (max-width: 700px) {
        .navigation {
            flex-direction: column;
        }}

</style>