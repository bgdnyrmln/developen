<template>
    <!-- Header component -->
    <headerline/>
  
    <!-- Profile section -->
    <div class="profile">
      <div class="container" style="display: flex; position: relative; justify-content: space-around; color: white;">
  
        <!-- Left: Display user info -->
        <div class="left">
          <h1>Current Profile</h1>
          <h2>Name: <span>{{ user.first_name }} {{ user.last_name }}</span></h2>
          <h2>Email: <span>{{ user.email }}</span></h2>
        </div>
  
        <!-- Right: Edit form -->
        <div class="right">
          <h1>Edit Your Profile</h1>
          <form @submit.prevent="edituser($event, user.id)" class="register-form" style="width: 40vw;">
  
            <label class="register-text" for="first_name">First Name:</label>
            <input class="register-input" type="text" :value="user.first_name" name="first_name" placeholder="First Name" />
  
            <label class="register-text" for="last_name">Last Name:</label>
            <input class="register-input" type="text" :value="user.last_name" name="last_name" placeholder="Last Name" />
  
            <label class="register-text" for="email">Email:</label>
            <input class="register-input" type="email" :value="user.email" name="email" placeholder="Email" />
  
            <button class="register-button" type="submit">Edit</button>
          </form>
        </div>
      </div>
  
      <!-- Footer component -->
      <footerline/>
    </div>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  
  // Page restricted to authenticated users
  definePageMeta({
    middleware: ["$auth"],
  });
  
  const id = ref(null);
  const role = ref(null);
  const user = ref([]);
  
  // Fetch logged-in user's ID and role from Sanctum
  const { id: fetchedId, role: fetchedRole } = await useSanctumFetch('/api/user')
  id.value = fetchedId;
  role.value = fetchedRole;
  
  // Fetch user profile data on mount
  onMounted(async () => {
    try {
      await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
      user.value = await $fetch(`/api/users/${id.value}`);
    } catch (error) {
      console.error('Error fetching users:', error);
    }
  });
  
  // Handles profile update form submission
  const edituser = async (e, id) => {
    if (confirm("Are you sure you want to edit your profile?")) {
      try {
        // Extract data from form inputs
        const form = e.target;
        const formData = new FormData(form);
  
        const payload = {
          first_name: formData.get("first_name"),
          last_name: formData.get("last_name"),
          email: formData.get("email"),
          role: role.value,
        };
  
        // Get CSRF token from cookies
        const token = decodeURIComponent(
          document.cookie
            .split("; ")
            .find((row) => row.startsWith("XSRF-TOKEN="))
            ?.split("=")[1] ?? ""
        );
  
        // Send PUT request to update user
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
          error.value = err.response.data.errors;
        } else if (err.response?.data?.message) {
          error.value = { general: err.response.data.message };
        } else {
          error.value = { general: "An unexpected error occurred." };
        }
      }
    }
  };
  </script>
  
  <style>
  /* Profile background styling */
  .profile {
    background-image: url('assets/background4.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
  }
  </style>
  