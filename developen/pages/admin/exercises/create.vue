<template>
  <!-- Main container for creating a new exercise -->
  <div class="container" style="padding-left: 34vh;">
    <!-- Title of the page -->
    <h1>Create New Exercise</h1>

    <!-- Form for creating a new exercise -->
    <form @submit.prevent="createExercise" class="register-form">
      <!-- Input field for the exercise name -->
      <input class="register-input" type="text" name="name" placeholder="Exercise Name" />
      
      <!-- Textarea for the exercise description -->
      <textarea class="description-input" name="description" placeholder="Description"></textarea>
      
      <!-- Input field for the exercise answer -->
      <input class="register-input" type="text" name="answer" placeholder="Answer" />
      
      <!-- Submit button for creating the exercise -->
      <button class="register-button" type="submit">Create</button>
    </form>
  </div>

  <!-- Admin panel component for consistent layout -->
  <admin-panel />
</template>

<script setup>
import axios from 'axios';

// Define page meta to enforce authentication and admin access
definePageMeta({
  middleware: ["$auth", "admin"],
});

// Function to handle exercise creation
const createExercise = async (e) => {
  try {
    // Get the form data
    const form = e.target;

    const payload = {
      name: form.name.value, // Get the exercise name from the form
      description: form.description.value, // Get the description
      answer: form.answer.value, // Get the answer
    };

    // CSRF setup: ensure CSRF token is sent with the request
    await axios.get("/sanctum/csrf-cookie", {
      withCredentials: true, // Ensure the request is sent with credentials (cookies)
    });

    // Extract the CSRF token from the cookies
    const token = decodeURIComponent(
      document.cookie
        .split("; ")
        .find((row) => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1] ?? ""
    );

    // Post the exercise data to the server
    await axios.post("/api/exercises", payload, {
      withCredentials: true, // Send the request with credentials
      headers: {
        "X-XSRF-TOKEN": token, // Include the CSRF token in the request headers
        "Content-Type": "application/json", // Specify content type
      },
    });

    // Show a success message
    alert("Exercise created successfully!");

    // Optional: Reset the form or navigate away after creation
    form.reset();
  } catch (error) {
    // Log and display any errors that occur during the creation process
    console.error("Error creating exercise:", error.response?.data || error);
  }
};
</script>
