<template>
  <div class="container" style="padding-left: 30vw; width: 60vw; padding-bottom: 10vh; padding-top: 10vh;">
    <!-- Title for the page -->
    <h1>Edit Category</h1>
    <!-- Display category ID and Name -->
    <p>Category ID: {{ category.id }}</p>
    <p>Category Name: {{ category.name }}</p>
    <!-- Display category color with inline style to match the color -->
    <p>Category Color: <span :style="{ color: category.color }">{{ category.color }}</span></p>

    <!-- Form to edit the category details, prevents default form submission -->
    <form @submit.prevent="editCategory($event, category.id)" class="register-form">
      <!-- ID field, disabled from editing, showing the current category ID -->
      <input class="register-input" type="text" name="id" placeholder="id" :value="category.id" readonly />
      <!-- Name field, editable by the user to change the category name -->
      <input class="register-input" type="text" name="name" placeholder="Name" :value="category.name" />
      <!-- Color picker to change the category's color -->
      <input class="register-input-color" type="color" name="color" placeholder="Color" :value="category.color" />
      <!-- Submit button to save the changes -->
      <button class="register-button" type="submit">Submit</button>
    </form>
  </div>
  <!-- Admin panel component -->
  <admin-panel />
</template>

<script setup>
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';

// Get route and router instances for navigation and fetching parameters
const route = useRoute();
const router = useRouter();

// Extract the category ID from the URL parameters
const id = route.params.id;
// Create a reactive reference to store category data
const category = ref({});

// Fetch the category details when the component is mounted
onMounted(async () => {
  try {
    // Ensure CSRF token is set before making requests
    await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
    // Fetch the category details from the API
    const categoryRes = await axios.get(`/api/categories/${id}`);
    // Store the fetched category data in the reactive reference
    category.value = categoryRes.data;
  } catch (error) {
    console.error("Error fetching category:", error);
  }
});

// Method to handle category update when form is submitted
const editCategory = async (e, id) => {
  try {
    // Access form data when the form is submitted
    const form = e.target;
    const formData = new FormData(form);

    // Prepare the payload to update the category with the form data
    const payload = {
      id: formData.get("id"),
      name: formData.get("name"),
      color: formData.get("color"),
    };

    // Extract the CSRF token from the cookies for secure submission
    const token = decodeURIComponent(
      document.cookie
        .split("; ")
        .find((row) => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1] ?? ""
    );

    // Send the updated category data to the server using a PUT request
    await axios.put(`/api/categories/${id}`, payload, {
      withCredentials: true,
      headers: {
        "X-XSRF-TOKEN": token,
      },
    });

    // Alert the user that the update was successful and navigate to the category page
    alert("Category updated successfully!");
    router.push(`/admin/categories/${id}`);
  } catch (error) {
    // Handle any errors that occur during the category update
    console.error("Error editing category:", error);
  }
};
</script>
