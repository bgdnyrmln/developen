<template>
    <headerline/>
    <div class = "container" style="padding: 20vh 5vh;">
        <div class="exercise">
            <h1>{{ exercise.name }}</h1>
            <h2 class="description">{{ exercise.description }}</h2>

            <form @submit.prevent="checkAnswer($event)" class="register-form">
                <input class = "register-input" type="text" name="answer" placeholder="Your answer"/>
                <button class = "register-button" type="submit">Check answer</button>
            </form>
        </div>
        <div id="confetti-container" v-if="iscorrert">
            <div class="confetti-card">
                <p>Congratulations, you are right!</p>
            </div>
        </div>

        <div class = "navigation">
            <NuxtLink v-if = "beforeExercise.id != null" style="width: 100%;" class="navigation-button" :to="{ name: 'exercises-id', params: { id: beforeExercise.id } }">
                <p class = "navigation-button-text" style="font-size: 20px;">{{ beforeExercise.name  }}</p>
                <p class = "navigation-button-symbol" style="font-size: 200px;"><</p>
            </NuxtLink>
            <NuxtLink to="/exercises/all" class="navigation-button" style="width: 100%;">
                <p class = "navigation-button-text" style="font-size: 20px;">Back to exercises </p>
                <p class = "navigation-button-symbol" style="font-size: 200px;">⌂</p>
            </NuxtLink>
            <NuxtLink id="next-button" v-if = "nextExercise.id != null && iscorrert===true" class="navigation-button" :to="{ name: 'exercises-id', params: { id: nextExercise.id }}">
                <p id="next-button-text" class = "navigation-button-text">{{ nextExercise.name  }}</p>
                <p id="next-button-symbol" class = "navigation-button-symbol">></p>
            </NuxtLink>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
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
const iscorrert = ref(false);

onMounted(async () => {
  try {
    await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
      withCredentials: true,
    });
    exercise.value = await $fetch(`http://localhost:9000/api/exercises/${id}`);
  } catch (error) {
    console.error('Error fetching exercises:', error);
  }

  try {
    beforeExercise.value = await $fetch(`http://localhost:9000/api/exercises/${id - 1}`);
  } catch (error) {
    console.error('Error fetching previous exercise:', error);
  }

  try {
    nextExercise.value = await $fetch(`http://localhost:9000/api/exercises/${id + 1}`);
  } catch (error) {
    console.error('Error fetching next exercise:', error);
  }
});

const showConfetti = () => {
  const confettiContainer = document.querySelector('#confetti-container');
  const confettiCardText = document.querySelector('.confetti-card p');
  const nextButton = document.querySelector('#next-button');
  const nextButtonText = document.querySelector('#next-button-text');
  const nextButtonSymbol = document.querySelector('#next-button-symbol');

  confettiContainer.style.height = '5vh';
  confettiCardText.style.fontSize = '2rem';
  nextButton.style.width = '100%';
  nextButtonText.style.fontSize = '20px';
  nextButtonSymbol.style.fontSize = '200px';

  if (!confettiContainer) return;

  const confetti = document.createElement('div');
  confetti.textContent = '🎉';
  confetti.classList.add('confetti');
  confetti.style.left = Math.random() * window.innerWidth + 'px';

  confettiContainer.appendChild(confetti);

  setTimeout(() => {
    confetti.remove();
  }, 5000);
};

let confettiInterval = null;

watch(iscorrert, (newVal) => {
  if (newVal === true) {
    confettiInterval = setInterval(showConfetti, 400);
    // Optionally clear it after a while to stop the rain
    setTimeout(() => {
      clearInterval(confettiInterval);
    }, 5000); // stop after 5 seconds
  }
});

const checkAnswer = async (e) => {
  try {
    const form = e.target;
    const formData = new FormData(form);
    const userAnswer = formData.get("answer").trim().toLowerCase();
    const correctAnswer = exercise.value.answer.trim().toLowerCase();

    if (userAnswer === correctAnswer) {
      iscorrert.value = true;
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
        margin-top: 0vh;
    }

    .navigation-button{
        height: 20vh;
        display: flex;
        position: relative;
        align-items: center;
        width: 0%;
        margin-bottom: 7vh;
        font-weight: 700;
        font-size: 14px;
        border-radius: 15px;
        background-color: #222222;
        border: none;
        color: white;
        padding: 16px 32px;
        text-decoration: none;
        margin: 0vh 2px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
   
    .navigation-button:hover{
        background-color: #444444;
    }

    .navigation-button-text{
        font-size: 0px;
        z-index: 2;
        transition: all 0.2s ease;
    }


    .navigation-button-symbol{
        font-size: 0px;
        position: absolute;
        right: 50px;
        color: #333333;
        transition: all 0.2s ease;
    }

    .description {
        white-space: pre-wrap;  /* Ensures newlines and wrapping are respected */
        word-wrap: break-word;  /* Allows long words to break properly */
    }

    @media (max-width: 700px) {
        .navigation {
            flex-direction: column;
        }}



    #confetti-container {
        margin: 1vh 0;
        height: 0vh;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }


    .confetti-card {
        background-color: #76c883;
        width: 100%;
        height: 100%;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .confetti-card p {
        font-size: 0rem;
        color: white;
        font-weight: bold;
        text-align: center;
        transition: all 0.2s ease;
    }


    .confetti {
        position: absolute;
        top: 0;
        font-size: 1.6rem;
        animation: confetti-fall linear 5s infinite;
    }

    @keyframes confetti-fall {
        0% {
            transform: translateY(-100%) rotate(0);
        }
        100% {
            transform: translateY(100vh) rotate(180deg);
        }
    }

</style>