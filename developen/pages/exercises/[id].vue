<template>
    <div class="container" style="padding-left: 34vh;">
        <h1>exercise Current Details</h1>
        <p>exercise ID: {{ exercise.id }}</p>
        <p>exercise First Name: {{ exercise.first_name }}</p>
        <p>exercise Last Name: {{ exercise.last_name }}</p>
        <p>exercise Email: {{ exercise.email }}</p>
        <p>exercise Role: {{ exercise.role }}</p>
        <p>exercise Created At: {{ exercise.created_at }}</p>
        <div>
            <h1>Edit exercise</h1>
            <form @submit.prevent="editexercise($event, exercise.id)" class="register-form">
                <input class="register-input" type="text" name="first_name" placeholder="First Name" :value="exercise.first_name" />
                <input class="register-input" type="text" name="last_name" placeholder="Last Name" :value="exercise.last_name" />
                <input class="register-input" type="text" name="email" placeholder="Email" :value="exercise.email" />
                <input class="register-input" type="text" name="role" placeholder="Role" :value="exercise.role" />
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
            user.value = await $fetch(`http://localhost:9000/api/exercises/${id}`)
        } catch (error) {
            console.error('Error fetching exercises:', error);
        }
    });
    

    const route = useRoute();
    const id = route.params.id;

    


    const editexercise = async (e, id) => {
        if (confirm("Are you sure you want to edit this exercise?")) {
            try {
                // Grab form data manually
                const form = e.target;
                const formData = new FormData(form);

                const payload = {
                    first_name: formData.get("first_name"),
                    last_name: formData.get("last_name"),
                    email: formData.get("email"),
                    role: formData.get("role"),
                };

                // Get CSRF token from cookie
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
                
                alert("exercise updated successfully!");
            } catch (error) {
                console.error("Error editing exercise:", error);
            }
        }
    };


</script>