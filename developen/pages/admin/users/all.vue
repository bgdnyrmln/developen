<template>

    <div class = "container">
        <div v-for="user in users" class = "usercard">
            First Name: {{ user.first_name }} 
            Last Name: {{ user.last_name }}
            Email Adress: {{ user.email }}
            Role: {{ user.role }}
            <a href="">Edit</a>
            <button @click = "deleteUser(user.id)">Delete</button>

        </div>
    </div>

</template>

<script setup>
import axios from 'axios';
const users = ref([]);

definePageMeta({
    middleware: ["$auth"],    
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
    try {
        await $fetch(`http://localhost:9000/api/users/${id}`, {
            method: 'DELETE',
        });
        users.value = users.value.filter(user => user.id !== id);
    } catch (error) {
        console.error('Error deleting user:', error);
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
    justify-content: center;
    align-items: center;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}


</style>