<template>
    <div class="container" style="padding-left: 34vh;">
        <h1>User Current Details</h1>
        <p>User ID: {{ user.id }}</p>
        <p>User First Name: {{ user.first_name }}</p>
        <p>User Last Name: {{ user.last_name }}</p>
        <p>User Email: {{ user.email }}</p>
        <p>User Role: {{ user.role }}</p>
        <p>User Created At: {{ user.created_at }}</p>
        <p>Exercises done: {{ user.exercises_count }}</p>
        <div>
            <h1>Edit User</h1>
            <form @submit.prevent="edituser($event, user.id)" class="register-form">
                <input class="register-input" type="text" name="first_name" placeholder="First Name" :value="user.first_name" />
                <p v-if="error.first_name" style="color: red;">{{ error.first_name[0] }}</p>

                <input class="register-input" type="text" name="last_name" placeholder="Last Name" :value="user.last_name" />
                <p v-if="error.last_name" style="color: red;">{{ error.last_name[0] }}</p>

                <input class="register-input" type="text" name="email" placeholder="Email" :value="user.email" />
                <p v-if="error.email" style="color: red;">{{ error.email[0] }}</p>

                <input class="register-input" type="text" name="role" placeholder="Role" :value="user.role" />
                <p v-if="error.role" style="color: red;">{{ error.role[0] }}</p>

                <input class="register-input" type="text" name="exercises_count" placeholder="Exercises Count" :value="user.exercises_count" />
                <p v-if="error.role" style="color: red;">{{ error.role[0] }}</p>

                <p v-if="error.general" style="color: red; font-weight: bold;">{{ error.general }}</p>

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

    const user = ref([]);

    onMounted(async () => {     
        try {
            // First, get CSRF cookie
            await axios.get("/sanctum/csrf-cookie", {
                withCredentials: true
            });
            user.value = await $fetch(`/api/users/${id}`)
        } catch (error) {
            console.error('Error fetching users:', error);
        }
    });
    

    const route = useRoute();
    const id = route.params.id;
    const error = ref({});

    


    const edituser = async (e, id) => {
        if (confirm("Are you sure you want to edit this user?")) {
            try {
                // Grab form data manually
                const form = e.target;
                const formData = new FormData(form);

                const payload = {
                    first_name: formData.get("first_name"),
                    last_name: formData.get("last_name"),
                    email: formData.get("email"),
                    role: formData.get("role"),
                    exercises_count: formData.get("exercises_count"),
                };

                // Get CSRF token from cookie
                const token = decodeURIComponent(
                    document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("XSRF-TOKEN="))
                    ?.split("=")[1] ?? ""
                );

                await axios.put(`/api/users/${id}`, payload, {
                    withCredentials: true,
                    headers: {
                    "X-XSRF-TOKEN": token,
                    },
                });
                
                alert("User updated successfully!");
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
    };


</script>