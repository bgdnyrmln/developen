<template>
    <div class="container" style="padding-left: 34vh;">
        <h1>exercise Current Details</h1>
        <p>exercise ID: {{ exercise.id }}</p>
        <p>exercise name: {{ exercise.name }}</p>
        <p>exercise description: {{ exercise.description }}</p>
        <p>exercise answer: {{ exercise.answer }}</p>

        <div>
            <h1>Edit exercise</h1>
            <form @submit.prevent="editexercise($event, exercise.id)" class="register-form">
                <input class="register-input" type="text" name="id" placeholder="id" :value="exercise.id" />
                <input class="register-input" type="text" name="name" placeholder="name" :value="exercise.name" />
                <input class="register-input" type="text" name="description" placeholder="description" :value="exercise.description" />
                <input class="register-input" type="text" name="answer" placeholder="answer" :value="exercise.answer" />
                <button class="register-button" type="submit">Submit</button>
            </form>
        </div>
    </div>
    <admin-panel/>
</template>

<script setup>
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';

definePageMeta({
    middleware: ["$auth", "admin"],    
});

const route = useRoute();
const router = useRouter();
const id = route.params.id;
const exercise = ref([]);

onMounted(async () => {
    try {
        await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
            withCredentials: true
        });
        exercise.value = await $fetch(`http://localhost:9000/api/exercises/${id}`);
    } catch (error) {
        console.error('Error fetching exercise:', error);
    }
});

const editexercise = async (e, id) => {
    if (confirm("Are you sure you want to edit this exercise?")) {
        try {
            const form = e.target;
            const formData = new FormData(form);

            const payload = {
                id: formData.get("id"),
                name: formData.get("name"),
                description: formData.get("description"),
                answer: formData.get("answer"),
            };

            const token = decodeURIComponent(
                document.cookie
                .split("; ")
                .find((row) => row.startsWith("XSRF-TOKEN="))
                ?.split("=")[1] ?? ""
            );

            await axios.put(`http://localhost:9000/api/exercises/${id}`, payload, {
                withCredentials: true,
                headers: {
                    "X-XSRF-TOKEN": token,
                },
            });

            alert("Exercise updated successfully!");

            const newId = formData.get("id");
            router.push(`/admin/exercises/${newId}`);
        } catch (error) {
            console.error("Error editing exercise:", error);
        }
    }
};
</script>
