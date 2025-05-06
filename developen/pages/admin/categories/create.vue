<template>
  <div class="container" style="padding-left: 34vh;">
    <h1>Create New Category</h1>

    <!-- Form to create a new category -->
    <form @submit.prevent="createCategory" class="register-form">
      <!-- Input field for category name -->
      <input class="register-input" type="text" name="name" placeholder="Category Name" />
      <!-- Color picker for category color -->
      <input class="register-input-color"
      style="
          border: 5px solid grey;
          border-radius: 15px;" type="color" name="color" placeholder="Category Color" />
      <!-- Submit button to create the category -->
      <button class="register-button" type="submit">Create</button>
    </form>
  </div>
  <!-- Admin panel component -->
  <admin-panel />
</template>

<script setup>
import axios from 'axios';

// Function to handle the category creation
const createCategory = async (e) => {
try {
  // Access the form element
  const form = e.target;

  // Prepare the payload with name and color values from the form
  const payload = {
    name: form.name.value,
    color: form.color.value, // Color value from the color input
  };

  // Ensure CSRF token is set before sending the request
  await axios.get("/sanctum/csrf-cookie", { withCredentials: true });

  // Extract the CSRF token from cookies for secure submission
  const token = decodeURIComponent(
    document.cookie
      .split("; ")
      .find((row) => row.startsWith("XSRF-TOKEN="))
      ?.split("=")[1] ?? ""
  );

  // Send the POST request to create the new category
  await axios.post("/api/categories", payload, {
    withCredentials: true,
    headers: {
      "X-XSRF-TOKEN": token, // CSRF token in the header for security
      "Content-Type": "application/json", // Indicate that we are sending JSON
    },
  });

  // Success message and reset the form
  alert("Category created successfully!");
  form.reset();
} catch (error) {
  // Handle any errors during the category creation process
  console.error("Error creating category:", error.response?.data || error);
}
};
</script>
