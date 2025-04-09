<template>

    <div class = "container" style="padding-left: 34vh;">
        <div v-for="user in users" class = "usercard">
            <div>
                First Name: {{ user.first_name }} <br>
                Last Name: {{ user.last_name }} <br>
                Email Adress: {{ user.email }}  <br>
                Role: {{ user.role }} 
            </div>
            <div style="display: flex; gap: 10px;">
                <NuxtLink :to="`/admin/users/${user.id}`" class="userbutton">Details</NuxtLink>
                <button @click = "deleteUser(user.id)" class="userbutton" style="background-color: red;">Delete</button>
            </div>
        </div>
    </div>
    <admin-panel/>
</template>

<script setup>
import axios from 'axios';
const users = ref([]);

definePageMeta({
    middleware: ["$auth", "admin"],    
});

onMounted(async () => {

    
  try {
    // First, get CSRF cookie
    await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true
    });

    // Then fetch users
    users.value = await $fetch('http://localhost:9000/api/users', {
    });
  } catch (error) {
    console.error('Error fetching users:', error);
  }
});


const deleteUser = async (id) => {
    if (confirm("Are you sure you want to delete this user?")) {
        try {
        // Get CSRF token from cookie
            const token = decodeURIComponent(
                document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("XSRF-TOKEN="))
                    ?.split("=")[1] ?? ""
            );

            await axios.delete(`http://localhost:9000/api/users/${id}`, {
                withCredentials: true,
                headers: {
                    "X-XSRF-TOKEN": token,
                },
            });

            users.value = users.value.filter((user) => user.id !== id);
        } catch (error) {
            console.error("Error deleting user:", error);
        }
}
};




</script>

<style>

.usercard{
    height: 10vh;
    width: 80%;
    background-color: #222222;
    margin: auto;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    padding-inline: 3vh;
    align-items: center;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.usercard:hover{
    background-color: #444444;
}

.userbutton{
    background-color: #0f0f0f;
    color: white;
    border-radius: 5px;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}


</style>