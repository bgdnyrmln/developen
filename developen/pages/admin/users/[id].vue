<template>
    <div class="container" style="padding-left: 34vh;">
        <h1>User Current Details</h1>
        <p>User ID: {{ user.id }}</p>
        <p>User First Name: {{ user.first_name }}</p>
        <p>User Last Name: {{ user.last_name }}</p>
        <p>User Email: {{ user.email }}</p>
        <p>User Role: {{ user.role }}</p>
        <p>User Created At: {{ user.created_at }}</p>
    
        <form @submit.prevent="edituser(user.id)">
            <input type="text" name="first_name" placeholder="First Name" v-model="user.first_name">
            <input type="text" name="last_name" placeholder="Last Name" v-model="user.last_name">
            <input type="text" name="email" placeholder="Email" v-model="user.email">
            <input type="text" name="role" placeholder="Role" v-model="user.role">
            <button type="submit">Submit</button>
        </form>
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

    


    const edituser = async (id) => {
        if (confirm("Are you sure you want to edit this user?")) {
            try {
            // Get CSRF token from cookie
            const token = decodeURIComponent(
                document.cookie
                .split("; ")
                .find((row) => row.startsWith("XSRF-TOKEN="))
                ?.split("=")[1] ?? ""
            );

            // Make the PUT request with data and headers
            await axios.put(
                `http://localhost:9000/api/users/${id}`,
                {
                first_name: user.value.first_name,
                last_name: user.value.last_name,
                email: user.value.email,
                role: user.value.role,
                },
                {
                withCredentials: true,
                headers: {
                    "X-XSRF-TOKEN": token,
                },
                }
            );

            alert("User updated successfully!");
            } catch (error) {
            console.error("Error editing user:", error);
            }
        }
        };


</script>