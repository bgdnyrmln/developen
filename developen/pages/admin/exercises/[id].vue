<template>
  <!-- Main container for the exercise details and editing form -->
  <div class="container" style="padding-left: 30vw; width: 60vw; padding-bottom: 10vh; padding-top: 10vh;">
    <!-- Heading for current exercise details -->
    <h1>Exercise Current Details</h1>
    <p>Exercise ID: {{ exercise.id }}</p>
    <p>Exercise Name: {{ exercise.name }}</p>
    <p>Exercise Description: {{ exercise.description }}</p>
    <p>Exercise Answer: {{ exercise.answer }}</p>

    <!-- Section for editing the exercise -->
    <div>
      <h1>Edit Exercise</h1>
      <form @submit.prevent="editexercise($event, exercise.id)" class="register-form">
        <!-- Form inputs for the exercise details, pre-filled with current values -->
        <input class="register-input" type="text" name="id" placeholder="id" :value="exercise.id" />
        <input class="register-input" type="text" name="name" placeholder="name" :value="exercise.name" />
        <textarea class="description-input" name="description" placeholder="Description">{{ exercise.description }}</textarea>
        <input class="register-input" type="text" name="answer" placeholder="answer" :value="exercise.answer" />

        <!-- Section for selecting categories -->
        <div class="category-selection">
          <div style="display: flex; align-items: center; width: 60vw; margin-bottom: 1vh; justify-content: space-between;">
            <h3>Select Categories</h3>
            <!-- Search input for filtering categories -->
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search categories..."
              class="search-exercise-input"
            />
          </div>
        </div>

        <!-- Category selection UI, with dynamic styling and selected state -->
        <div class="exercise-categories" style="margin-bottom: 2vh;">
          <label
            v-for="category in filteredCategories"
            :key="category.id"
            class="exercise-category"
            :style="{
              backgroundColor: selectedCategories.includes(category.id) ? category.color : '#f1f1f1',
              color: selectedCategories.includes(category.id) ? '#fff' : '#333',
              border: `none`,
              borderRadius: '50px',
              padding: '5px 10px',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
            }"
          >
            <!-- Hidden checkbox for category selection -->
            <input
              type="checkbox"
              :value="category.id"
              v-model="selectedCategories"
              style="display: none;"
            />
            {{ category.name }}
          </label>
        </div>

        <!-- Submit button to update the exercise -->
        <button class="register-button" type="submit">Submit</button>
      </form>
    </div>
  </div>

  <!-- Admin panel component -->
  <admin-panel />
</template>

<script setup>
  import axios from 'axios';
  import { useRoute, useRouter } from 'vue-router';
  import { computed, onMounted, ref } from 'vue';

  // Define page meta to ensure authentication and admin access
  definePageMeta({
    middleware: ["$auth", "admin"],
  });

  // Setup route and router for handling the exercise ID
  const route = useRoute();
  const router = useRouter();
  const id = route.params.id;

  // Refs to hold exercise details, categories, selected categories, and search query
  const exercise = ref({});
  const categories = ref([]);
  const selectedCategories = ref([]);
  const searchQuery = ref("");

  // Fetch exercise and category data when the component is mounted
  onMounted(async () => {
    try {
      await axios.get("/sanctum/csrf-cookie", { withCredentials: true });

      // Fetch exercise details from API
      const exerciseRes = await axios.get(`/api/exercises/${id}`);
      exercise.value = exerciseRes.data;

      // Set selected categories based on the current exercise's categories
      selectedCategories.value = exerciseRes.data.categories?.map(c => c.id) || [];

      // Fetch all categories from the API
      const categoriesRes = await axios.get("/api/categories");
      categories.value = categoriesRes.data;

    } catch (error) {
      console.error('Error fetching exercise or categories:', error);
    }
  });

  // Function to edit the exercise
  const editexercise = async (e, id) => {
    if (confirm("Are you sure you want to edit this exercise?")) {
      try {
        const form = e.target;
        const formData = new FormData(form);

        // Prepare the payload with the form data and selected categories
        const payload = {
          id: formData.get("id"),
          name: formData.get("name"),
          description: formData.get("description"),
          answer: formData.get("answer"),
          categories: selectedCategories.value,
        };

        // Retrieve CSRF token from cookies
        const token = decodeURIComponent(
          document.cookie
            .split("; ")
            .find((row) => row.startsWith("XSRF-TOKEN="))
            ?.split("=")[1] ?? ""
        );

        // Send a PUT request to update the exercise
        await axios.put(`/api/exercises/${id}`, payload, {
          withCredentials: true,
          headers: {
            "X-XSRF-TOKEN": token,
          },
        });

        // Show success message and navigate to the updated exercise details page
        alert("Exercise updated successfully!");
        router.push(`/admin/exercises/${payload.id}`);
      } catch (error) {
        console.error("Error editing exercise:", error);
      }
    }
  };

  // Filter categories based on search query and prioritize selected ones
  const filteredCategories = computed(() => {
    return categories.value
      .sort((a, b) => {
        const aSelected = selectedCategories.value.includes(a.id);
        const bSelected = selectedCategories.value.includes(b.id);

        // Ensure selected categories appear first
        if (aSelected === bSelected) return 0;
        return aSelected ? -1 : 1;
      })
      .filter(category =>
        category.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      );
  });
</script>

<style>
  /* Style for category selection area */
  .exercise-categories {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    width: 100%;
    gap: 8px;
    transition: all 0.2s ease;
  }

  /* Hover effect for category labels */
  .exercise-category:hover {
    filter: brightness(1.3);
    transform: scale(1.05);
  }
</style>
