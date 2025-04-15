<template>
    <headerline/>
    <div class="container" style="padding: 20vh 5vh;">
        <div class="exercise">
            <h1>{{ exercise.name }}</h1>
            <h2 class="description">{{ exercise.description }}</h2>

            <form @submit.prevent="checkAnswer($event)" class="register-form">
                <input class="register-input" type="text" name="answer" placeholder="Your answer"/>
                <button class="register-button" type="submit" ref="submitButton">Check answer</button>
            </form>
        </div>

        <div id="confetti-container" v-if="iscorrert !== null">
            <div class="confetti-card">
                <p>{{ result }}</p>
            </div>
        </div>

        <div class="navigation">
            <a v-if="beforeExercise.id != null" style="width: 100%;" class="navigation-button" :href="`${beforeExercise.id}`">
                <p class="navigation-button-text" style="font-size: 4vh;">{{ beforeExercise.name }}</p>
                <p class="navigation-button-symbol" style="font-size: 25vh;"><</p>
            </a>
            <NuxtLink to="/exercises/all" class="navigation-button" style="width: 100%;">
                <p class="navigation-button-text" style="font-size: 4vh;">Back to exercises </p>
                <p class="navigation-button-symbol" style="font-size: 25vh;">⌂</p>
            </NuxtLink>
            <a id="next-button" v-if="nextExercise.id != null && iscorrert === true" class="navigation-button" :href="`${nextExercise.id}`">
                <p id="next-button-text" class="navigation-button-text">{{ nextExercise.name }}</p>
                <p id="next-button-symbol" class="navigation-button-symbol">></p>
            </a>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

definePageMeta({
    middleware: ["$auth", "exerciseaccess"],
});

const route = useRoute();
const id = Number(route.params.id);

const exercise = ref([]);
const nextExercise = ref([]);
const beforeExercise = ref([]);
const iscorrert = ref(null);
const result = ref("");

// Add a ref for the submit button
const submitButton = ref(null);

const user = ref([]);

onMounted(async () => {
    try {

        await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
            withCredentials: true,
        });
        exercise.value = await $fetch(`http://localhost:9000/api/exercises/${id}`);
        user.value = await useSanctumFetch(`http://localhost:9000/api/user`);

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

onBeforeUnmount(() => {
    // Reset the state when leaving the page and remove event listener
    iscorrert.value = null;
    result.value = "";

    if (submitButton.value) {
        submitButton.value.removeEventListener('click', handleSubmit);
    }
});

const showConfetti = () => {
    const confettiContainer = document.querySelector('#confetti-container');
    const confettiCard = document.querySelector('.confetti-card');
    const confettiCardText = document.querySelector('.confetti-card p');
    const nextButton = document.querySelector('#next-button');
    const nextButtonText = document.querySelector('#next-button-text');
    const nextButtonSymbol = document.querySelector('#next-button-symbol');

    if (iscorrert.value === true) {
        confettiContainer.style.height = '5vh';
        confettiCardText.style.fontSize = '3vh';
        confettiCard.style.backgroundColor = '#76c883';
        if(nextExercise.value.id != null) {
            nextButton.style.width = '100%';
            nextButtonText.style.fontSize = '20px';
            nextButtonSymbol.style.fontSize = '200px';
        }
    } else if (iscorrert.value === false) {
        confettiContainer.style.height = '5vh';
        confettiCardText.style.fontSize = '3vh';
        confettiCard.style.backgroundColor = '#b54040';
        return;
    }

    if (!confettiContainer) return;

    const confetti = document.createElement('div');
    confetti.classList.add('confetti');
    confetti.style.left = Math.random() * window.innerWidth + 'px';
    confetti.textContent = '🎉';
    confettiContainer.appendChild(confetti);

    setTimeout(() => {
        confetti.remove();
    }, 5000);
};

let confettiInterval = null;

watch(iscorrert, (newVal) => {
    if (newVal === null) {
        // Stop the confetti if it's reset to null
        clearInterval(confettiInterval);
        return;
    }

    confettiInterval = setInterval(showConfetti, 400);

    setTimeout(() => {
        clearInterval(confettiInterval);
    }, 5000); // stop after 5 seconds
});


// Your existing checkAnswer function
const checkAnswer = async (e) => {

    const form = e.target;
    const formData = new FormData(form);
    const userAnswer = formData.get("answer").trim().toLowerCase();
    const correctAnswer = exercise.value.answer.trim().toLowerCase();

    


    if (userAnswer === correctAnswer) {
        result.value = "Correct answer! 🎉";
        iscorrert.value = true;

        if (user.value.exercises_count < id+1) {
            try {
                // Grab form data manually
                const form = e.target;
                const formData = new FormData(form);

                const payload = {
                    first_name: user.value.first_name,
                    last_name: user.value.last_name,
                    email: user.value.email,
                    role: user.value.role,
                    exercises_count: id+1,
                };

                // Get CSRF token from cookie
                const token = decodeURIComponent(
                    document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("XSRF-TOKEN="))
                    ?.split("=")[1] ?? ""
                );

                await axios.put(`http://localhost:9000/api/users/${user.value.id}`, payload, {
                    withCredentials: true,
                    headers: {
                    "X-XSRF-TOKEN": token,
                    },
                });
                
            } catch (err) {
                console.error("Error editing user:", err);
                
                if (err.response?.data?.errors) {
                    // Assign each field error
                    error.value = err.response.data.errors;
                } else if (err.response?.data?.message) {
                    // Generic fallback message
                    error.value = { general: err.response.data.message };
                } else {
                    error.value = { general: "An unexpected error occurred." };
                }
            }

        }
    } else {
        result.value = "Incorrect answer. Try again. 😢";
        iscorrert.value = false;
    }

};
</script>

<style>
    .navigation {
        display: flex; 
        justify-content: space-around; 
    }

    .navigation-button {
        height: 20vh;
        display: flex;
        position: relative;
        align-items: center;
        width: 0px;
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

    .navigation-button:hover {
        background-color: #444444;
    }

    .navigation-button-text {
        font-size: 0px;
        z-index: 2;
        transition: all 0.2s ease;
    }

    .navigation-button-symbol {
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
            gap: 3px;
            padding-right: 5vh;
        }

    }

    #confetti-container {
        margin: 1vh 0;
        height: 0vh;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .confetti-card {
        background-color: whitesmoke;
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
        font-size: 3vh;
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
