<template>
    <div class="container" style="padding-left: 34vh;">
      <!-- Page Title -->
      <h1>User Current Details</h1>
      
      <!-- Display User Information -->
      <p>User ID: {{ user.id }}</p>
      <p>User First Name: {{ user.first_name }}</p>
      <p>User Last Name: {{ user.last_name }}</p>
      <p>User Email: {{ user.email }}</p>
      <p>User Role: {{ user.role }}</p>
      <p>User Created At: {{ user.created_at }}</p>
      <p>Exercises done: {{ user.exercises_count }}</p>
      
      <!-- Edit User Section -->
      <div>
        <h1>Edit User</h1>
        
        <!-- Form to Edit User Details -->
        <form @submit.prevent="edituser($event, user.id)" class="register-form">
          
          <!-- First Name Input -->
          <input 
            class="register-input" 
            type="text" 
            name="first_name" 
            placeholder="First Name" 
            :value="user.first_name" 
          />
          <!-- Display Error for First Name -->
          <p v-if="error.first_name" style="color: red;">{{ error.first_name[0] }}</p>
  
          <!-- Last Name Input -->
          <input 
            class="register-input" 
            type="text" 
            name="last_name" 
            placeholder="Last Name" 
            :value="user.last_name" 
          />
          <!-- Display Error for Last Name -->
          <p v-if="error.last_name" style="color: red;">{{ error.last_name[0] }}</p>
  
          <!-- Email Input -->
          <input 
            class="register-input" 
            type="text" 
            name="email" 
            placeholder="Email" 
            :value="user.email" 
          />
          <!-- Display Error for Email -->
          <p v-if="error.email" style="color: red;">{{ error.email[0] }}</p>
  
          <!-- Role Input -->
          <input 
            class="register-input" 
            type="text" 
            name="role" 
            placeholder="Role" 
            :value="user.role" 
          />
          <!-- Display Error for Role -->
          <p v-if="error.role" style="color: red;">{{ error.role[0] }}</p>
  
          <!-- Exercises Count Input -->
          <input 
            class="register-input" 
            type="text" 
            name="exercises_count" 
            placeholder="Exercises Count" 
            :value="user.exercises_count" 
          />
          <!-- Display Error for Exercises Count -->
          <p v-if="error.role" style="color: red;">{{ error.role[0] }}</p>
  
          <!-- Display General Error Message -->
          <p v-if="error.general" style="color: red; font-weight: bold;">{{ error.general }}</p>
  
          <!-- Submit Button -->
          <button class="register-button" type="submit">Submit</button>
        </form>
      </div>
    </div>
    
    <!-- Admin Panel Component -->
    <admin-panel/>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  
  // Middleware to ensure only authenticated admins can access the page
  definePageMeta({
    middleware: ["$auth", "admin"],
  });
  
  const user = ref([]); // Store the user data
  const error = ref({}); // Store validation errors
  
  // Fetch the user data on page mount
  onMounted(async () => {
    try {
      // First, get CSRF cookie for secure requests
      await axios.get("/sanctum/csrf-cookie", {
        withCredentials: true
      });
      
      // Fetch user details from the API using the user ID
      user.value = await $fetch(`/api/users/${id}`)
    } catch (error) {
      console.error('Error fetching users:', error);
    }
  });
  
  // Get the user ID from the route parameters
  const route = useRoute();
  const id = route.params.id;
  
  // Edit user function
  const edituser = async (e, id) => {
    // Confirm before editing the user details
    if (confirm("Are you sure you want to edit this user?")) {
      try {
        // Grab form data manually
        const form = e.target;
        const formData = new FormData(form);
  
        // Prepare payload with the form data
        const payload = {
          first_name: formData.get("first_name"),
          last_name: formData.get("last_name"),
          email: formData.get("email"),
          role: formData.get("role"),
          exercises_count: formData.get("exercises_count"),
        };
  
        // Get CSRF token from cookies
        const token = decodeURIComponent(
          document.cookie
            .split("; ")
            .find((row) => row.startsWith("XSRF-TOKEN="))
            ?.split("=")[1] ?? ""
        );
  
        // Make the PUT request to update user data
        await axios.put(`/api/users/${id}`, payload, {
          withCredentials: true,
          headers: {
            "X-XSRF-TOKEN": token,
          },
        });
  
        // Success message
        alert("User updated successfully!");
      } catch (err) {
        console.error("Error editing user:", err);
  
        // Handle validation errors and display them
        if (err.response?.data?.errors) {
          // Assign field-specific errors
          error.value = err.response.data.errors;
        } else if (err.response?.data?.message) {
          // Generic error message
          error.value = { general: err.response.data.message };
        } else {
          // Fallback if no specific error is provided
          error.value = { general: "An unexpected error occurred." };
        }
      }
    }
  };
  </script>
  