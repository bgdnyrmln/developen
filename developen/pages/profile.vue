<template>

<headerline/>
<div class="profile">
    <div class="container" style="
    display: flex;
    position: relative;
    justify-content: space-around;">
        <div class = "left">
            <h1>Current Profile</h1>
            <h2>Name: <span>{{ user.first_name }} {{ user.last_name }}</span></h2>
            <h2>Email: <span>{{ user.email }}</span></h2>
        </div>
        <div class="right">
            <h1>Edit Your Profile</h1>
            <form @submit.prevent="edituser($event, user.id)" class="register-form" style="width: 40vw;">
                <input class = "register-input" type="text" :value="user.first_name" name="first_name" placeholder="First Name" />
                <input class = "register-input" type="text" :value="user.last_name" name="last_name" placeholder="Last Name" />
                <input class = "register-input" type="email" :value="user.email" name="email" placeholder="Email" />
                <button class = "register-button" type="submit"> Edit</button>
            </form>
        </div>
    </div>

<footerline/>
</div>

</template>

<script setup>

import axios from 'axios';
import { useRoute } from 'vue-router';

definePageMeta({
    middleware: ["$auth"],    
});

const id = ref(null);
const role = ref(null);
const user = ref([]);

const { id: fetchedId, role: fetchedRole } = await useSanctumFetch('http://localhost:9000/api/user')
id.value = fetchedId
role.value = fetchedRole

onMounted(async () => {     
        try {
            // First, get CSRF cookie
            await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
                withCredentials: true
            });
            user.value = await $fetch(`http://localhost:9000/api/users/${id.value}`)
        } catch (error) {
            console.error('Error fetching users:', error);
        }
    });

    const edituser = async (e, id) => {
        if (confirm("Are you sure you want to edit your profile?")) {
            try {
                // Grab form data manually
                const form = e.target;
                const formData = new FormData(form);

                const payload = {
                    first_name: formData.get("first_name"),
                    last_name: formData.get("last_name"),
                    email: formData.get("email"),
                    role: role.value,
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

<style>
.profile {
    background-image: url('assets/background4.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
}
</style>