<template>
  <div class="container" style="padding-left: 34vh; padding-top: 10vh;">
    <!-- Page title -->
    <h1 style="justify-self: center;">Users</h1>

    <!-- Filter section (Sorting and Search) -->
    <div class="filter-container" style="width: 80%; margin: auto; margin-bottom: 2vh;">
      <div>
        <!-- Toggle Sort Direction Button -->
        <button @click="toggleSortDirection" class="sort-button" style="margin-right: 10px;">
          Sort: {{ sortDirection === 'asc' ? 'Ascending' : 'Descending' }}
        </button>
        <!-- Toggle Sort Subject Button (e.g., First Name, Last Name, etc.) -->
        <button @click="toggleSortSubject" class="sort-button" style="margin-right: 10px;">
          Sort by: {{ sortSubjectDisplay }}
        </button>
        <!-- Reset Sort Button -->
        <button @click="resetSort" class="sort-button" style="background-color: gray;">
          Reset Sort
        </button>
      </div>
      <!-- Search Form -->
      <form class="search-exercise" @submit="handleSearch">
        <input
          class="search-exercise-input"
          type="text"
          placeholder="Search user"
          v-model="query"
        />
      </form>
    </div>

    <!-- Users List -->
    <div class="users">
      <div v-for="user in paginatedUsers" :key="user.id" class="usercard">
        <!-- Display user details -->
        <div>
          First Name: {{ user.first_name }} <br />
          Last Name: {{ user.last_name }} <br />
          Email Address: {{ user.email }} <br />
          Role: {{ user.role }}
        </div>
        <div style="display: flex; gap: 10px;">
          <!-- User Details Link -->
          <NuxtLink :to="`/admin/users/${user.id}`" class="userbutton">Details</NuxtLink>
          <!-- Delete User Button -->
          <button
            @click="deleteUser(user.id)"
            class="userbutton"
            style="background-color: red;"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Pagination (Only visible if more than 1 page of results) -->
    <div v-if="filteredUsers.length > itemsPerPage" class="pagination">
      <vue-awesome-paginate
        :total-items="filteredUsers.length"
        :items-per-page="itemsPerPage"
        :max-pages-shown="3"
        v-model="currentPage"
        @click="onClickHandler"
      />
    </div>
  </div>

  <!-- Admin Panel Component -->
  <admin-panel />
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// Middleware to ensure only authenticated admins can access the page
definePageMeta({
  middleware: ["$auth", "admin"],
});

const users = ref([]); // List of all users
const query = ref(''); // Search query input
const sortDirection = ref('asc'); // Current sort direction (ascending or descending)
const sortSubject = ref('first_name'); // Current sort subject (e.g., first_name, last_name)
const currentPage = ref(1); // Current page in pagination
const itemsPerPage = 5; // Number of items to display per page

// Fetch users when the component is mounted
onMounted(async () => {
  try {
    // Get CSRF token for authenticated requests
    await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
    
    // Fetch users from the API
    users.value = await $fetch("/api/users");
  } catch (error) {
    console.error("Error fetching users:", error);
  }
});

// Function to delete a user
const deleteUser = async (id) => {
  if (confirm("Are you sure you want to delete this user?")) {
    try {
      const token = decodeURIComponent(
        document.cookie
          .split("; ")
          .find((row) => row.startsWith("XSRF-TOKEN="))
          ?.split("=")[1] ?? ""
      );

      // Send delete request to API
      await axios.delete(`/api/users/${id}`, {
        withCredentials: true,
        headers: {
          "X-XSRF-TOKEN": token,
        },
      });

      // Remove the user from the list after deletion
      users.value = users.value.filter((user) => user.id !== id);
    } catch (error) {
      console.error("Error deleting user:", error);
    }
  }
};

// Toggle sort direction between ascending and descending
const toggleSortDirection = () => {
  sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
};

// Cycle through different sorting subjects (first_name, last_name, email, role)
const toggleSortSubject = () => {
  const order = ['first_name', 'last_name', 'email', 'role'];
  const currentIndex = order.indexOf(sortSubject.value);
  sortSubject.value = order[(currentIndex + 1) % order.length];
};

// Reset sorting to default (ascending by first name)
const resetSort = () => {
  sortDirection.value = 'asc';
  sortSubject.value = 'first_name';
};

// Display label for the current sort subject (e.g., "First Name", "Last Name")
const sortSubjectDisplay = computed(() => {
  switch (sortSubject.value) {
    case 'first_name':
      return 'First Name';
    case 'last_name':
      return 'Last Name';
    case 'email':
      return 'Email';
    case 'role':
      return 'Role';
    default:
      return 'First Name';
  }
});

// Handle search submit and reset pagination to page 1
const handleSearch = (e) => {
  e.preventDefault();
  currentPage.value = 1;
};

// Filter and sort users based on query and selected sort options
const filteredUsers = computed(() => {
  let filtered = users.value.filter((user) => {
    const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
    return (
      fullName.includes(query.value.toLowerCase()) ||
      user.email.toLowerCase().includes(query.value.toLowerCase())
    );
  });

  // Sort filtered users based on selected criteria
  return filtered.sort((a, b) => {
    const valueA = String(a[sortSubject.value]).toLowerCase();
    const valueB = String(b[sortSubject.value]).toLowerCase();
    return sortDirection.value === 'asc'
      ? valueA.localeCompare(valueB)
      : valueB.localeCompare(valueA);
  });
});

// Paginate users based on current page
const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredUsers.value.slice(start, end);
});

// Handle page click for pagination
const onClickHandler = (page) => {
  currentPage.value = page;
};
</script>
