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
    import { useRoute } from 'vue-router';

    definePageMeta({
        middleware: ["$auth", "admin"],    
    });

    const exercise = ref([]);

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
    });
    

    const route = useRoute();
    const id = route.params.id;

    


    const editexercise = async (e, id) => {
  if (confirm("Are you sure you want to edit this exercise?")) {
    try {
      const form = e.target;

      // Get values directly from the form
      const payload = {
        name: form.name.value,
        description: form.description.value,
        answer: form.answer.value,
      };

      // Get CSRF token from cookies
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
          "Content-Type": "application/json", // explicitly declare JSON
        },
      });

      alert("Exercise updated successfully!");
    } catch (error) {
      console.error("Error editing exercise:", error.response?.data || error);
    }
  }
};

</script>