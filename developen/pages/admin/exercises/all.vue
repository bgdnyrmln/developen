<template>
  <!-- Main container for displaying exercises -->
  <div class="container" style="margin-left: 34vh; padding-top: 10vh;">
    <!-- Title of the exercises page -->
    <h1 style="justify-self: center;">Exercises</h1>

    <!-- Filter and sort container -->
    <div class="filter-container" style="width: 80%; margin: auto; margin-bottom: 2vh;">
      <div>
        <!-- Button to toggle sort direction (ascending/descending) -->
        <button @click="toggleSortDirection" class="sort-button" style="margin-right: 10px;">
          Sort: {{ sortDirection === 'asc' ? 'Ascending' : 'Descending' }}
        </button>
        <!-- Button to toggle sorting by ID or name -->
        <button @click="toggleSortSubject" class="sort-button" style="margin-right: 10px;">
          Sort by: {{ sortSubjectDisplay }}
        </button>
        <!-- Button to reset the sort order to default -->
        <button @click="resetSort" class="sort-button" style="background-color: gray;">
          Reset Sort
        </button>
      </div>
      <!-- Search form to filter exercises by name -->
      <form class="search-exercise" @submit="handleSearch">
        <input
          class="search-exercise-input"
          type="text"
          placeholder="Search exercise"
          v-model="query"
        />
      </form>
    </div>

    <!-- Link to create a new exercise -->
    <a class="usercard" href="/admin/exercises/create">Create new exercise</a>

    <!-- Loop through exercises and display each one -->
    <div class="usercard" v-for="exercise in paginatedExercises" :key="exercise.id">
      <div>
        ID: {{ exercise.id }} <br />
        Name: {{ exercise.name }} <br />
      </div>
      <div style="display: flex; gap: 10px;">
        <!-- Link to the details page for each exercise -->
        <NuxtLink :to="`/admin/exercises/${exercise.id}`" class="userbutton">Details</NuxtLink>
        <!-- Button to delete an exercise -->
        <button
          @click="deleteExercise(exercise.id)"
          class="userbutton"
          style="background-color: red;"
        >
          Delete
        </button>
      </div>
    </div>

    <!-- Pagination controls -->
    <div v-if="filteredExercises.length > itemsPerPage" class="pagination">
      <vue-awesome-paginate
        :total-items="filteredExercises.length"
        :items-per-page="itemsPerPage"
        :max-pages-shown="3"
        v-model="currentPage"
        @click="onClickHandler"
      />
    </div>

    <!-- Admin panel component -->
    <admin-panel />
  </div>
</template>

<script setup>
  import { ref, onMounted, computed } from 'vue';
  import axios from 'axios';

  // Define page meta to ensure authentication and admin access
  definePageMeta({
    middleware: ["$auth", "admin"],
  });

  // Refs to hold the state of exercises, search query, sort direction, and pagination
  const exercises = ref([]);
  const query = ref('');
  const sortDirection = ref('asc'); // Default sorting direction (ascending)
  const sortSubject = ref('id'); // Default sorting by ID
  const currentPage = ref(1); // Current page for pagination
  const itemsPerPage = 5; // Items per page for pagination

  // Fetch exercises from the API on component mount
  onMounted(async () => {
    try {
      await axios.get("/sanctum/csrf-cookie", {
        withCredentials: true,
      });
      exercises.value = await $fetch("/api/exercises");
    } catch (error) {
      console.error("Error fetching exercises:", error);
    }
  });

  // Function to delete an exercise by its ID
  const deleteExercise = async (id) => {
    if (confirm("Are you sure you want to delete this exercise?")) {
      try {
        // Retrieve CSRF token from cookies
        const token = decodeURIComponent(
          document.cookie
            .split("; ")
            .find((row) => row.startsWith("XSRF-TOKEN="))
            ?.split("=")[1] ?? ""
        );

        // Make a DELETE request to remove the exercise
        await axios.delete(`/api/exercises/${id}`, {
          withCredentials: true,
          headers: {
            "X-XSRF-TOKEN": token,
          },
        });

        // Update the exercises list by removing the deleted exercise
        exercises.value = exercises.value.filter((exercise) => exercise.id !== id);
      } catch (error) {
        console.error("Error deleting exercise:", error);
      }
    }
  };

  // Toggle sorting direction between ascending and descending
  const toggleSortDirection = () => {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  };

  // Toggle sorting criteria between 'id' and 'name'
  const toggleSortSubject = () => {
    const order = ['id', 'name']; // Define the possible sorting criteria
    const currentIndex = order.indexOf(sortSubject.value);
    sortSubject.value = order[(currentIndex + 1) % order.length];
  };

  // Reset the sorting to default (ID ascending)
  const resetSort = () => {
    sortDirection.value = 'asc';
    sortSubject.value = 'id';
  };

  // Display the label for the current sorting subject
  const sortSubjectDisplay = computed(() => {
    switch (sortSubject.value) {
      case 'id': return 'ID';
      case 'name': return 'Name';
      default: return 'ID';
    }
  });

  // Handle search form submission and reset pagination to the first page
  const handleSearch = (e) => {
    e.preventDefault();
    currentPage.value = 1;
  };

  // Filter and sort exercises based on the search query and sorting preferences
  const filteredExercises = computed(() => {
    let filtered = exercises.value.filter((exercise) =>
      exercise.name.toLowerCase().includes(query.value.toLowerCase())
    );

    // Sort the filtered exercises based on the selected criteria and direction
    return filtered.sort((a, b) => {
      const valueA = a[sortSubject.value];
      const valueB = b[sortSubject.value];

      if (sortSubject.value === 'id') {
        return sortDirection.value === 'asc' ? valueA - valueB : valueB - valueA;
      } else {
        return sortDirection.value === 'asc'
          ? String(valueA).toLowerCase().localeCompare(String(valueB).toLowerCase())
          : String(valueB).toLowerCase().localeCompare(String(valueA).toLowerCase());
      }
    });
  });

  // Return paginated exercises based on the current page and items per page
  const paginatedExercises = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredExercises.value.slice(start, end);
  });

  // Handle pagination click event to update the current page
  const onClickHandler = (page) => {
    currentPage.value = page;
  };
</script>
