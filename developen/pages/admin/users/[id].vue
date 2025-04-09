<template>
    <div class="container" style="padding-left: 34vh;">
        <h1>User Current Details</h1>
        <p>User ID: {{ user.id }}</p>
        <p>User First Name: {{ user.first_name }}</p>
        <p>User Last Name: {{ user.last_name }}</p>
        <p>User Email: {{ user.email }}</p>
        <p>User Role: {{ user.role }}</p>
        <p>User Created At: {{ user.created_at }}</p>
        <div>
            <h1>Edit User</h1>
            <form @submit.prevent="edituser($event, user.id)" class="register-form">
                <input class="register-input" type="text" name="first_name" placeholder="First Name" :value="user.first_name" />
                <input class="register-input" type="text" name="last_name" placeholder="Last Name" :value="user.last_name" />
                <input class="register-input" type="text" name="email" placeholder="Email" :value="user.email" />
                <input class="register-input" type="text" name="role" placeholder="Role" :value="user.role" />
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
            await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
                withCredentials: true
            });
            user.value = await $fetch(`http://localhost:9000/api/users/${id}`)
        } catch (error) {
            console.error('Error fetching users:', error);
        }
    });
    

    const route = useRoute();
    const id = route.params.id;

    


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
                };

                // Get CSRF token from cookie
                const token = decodeURIComponent(
                    document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("XSRF-TOKEN="))
                    ?.split("=")[1] ?? ""
                );

                await axios.put(`http://localhost:9000/api/users/${id}`, payload, {
                    withCredentials: true,
                    headers: {
                    "X-XSRF-TOKEN": token,
                    },
                });
                
                alert("User updated successfully!");
            } catch (error) {
                console.error("Error editing user:", error);
            }
        }
    };


</script>