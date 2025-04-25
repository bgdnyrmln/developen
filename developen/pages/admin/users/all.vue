<template>
    <div class="container" style="padding-left: 34vh; padding-top: 10vh;">
      <h1 style="justify-self: center;">Users</h1>

      <div class="filter-container" style="width: 80%; margin: auto; margin-bottom: 2vh;">
        <div>
          <button @click="toggleSortDirection" class="sort-button" style="margin-right: 10px;">
            Sort: {{ sortDirection === 'asc' ? 'Ascending' : 'Descending' }}
          </button>
          <button @click="toggleSortSubject" class="sort-button" style="margin-right: 10px;">
            Sort by: {{ sortSubjectDisplay }}
          </button>
          <button @click="resetSort" class="sort-button" style="background-color: gray;">
            Reset Sort
          </button>
        </div>
        <form class="search-exercise" @submit="handleSearch">
          <input
            class="search-exercise-input"
            type="text"
            placeholder="Search user"
            v-model="query"
          />
        </form>
      </div>
  
      <div class="users">
        <div v-for="user in paginatedUsers" :key="user.id" class="usercard">
          <div>
            First Name: {{ user.first_name }} <br />
            Last Name: {{ user.last_name }} <br />
            Email Address: {{ user.email }} <br />
            Role: {{ user.role }}
          </div>
          <div style="display: flex; gap: 10px;">
            <NuxtLink :to="`/admin/users/${user.id}`" class="userbutton">Details</NuxtLink>
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
  
    <admin-panel />
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue';
  import axios from 'axios';
  
  definePageMeta({
    middleware: ["$auth", "admin"],
  });
  
  const users = ref([]);
  const query = ref('');
  const sortDirection = ref('asc');
  const sortSubject = ref('first_name');
  const currentPage = ref(1);
  const itemsPerPage = 5;
  
  // Fetch users
  onMounted(async () => {
    try {
      await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
  
      users.value = await $fetch("http://localhost:9000/api/users");
    } catch (error) {
      console.error("Error fetching users:", error);
    }
  });
  
  // Delete user
  const deleteUser = async (id) => {
    if (confirm("Are you sure you want to delete this user?")) {
      try {
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
  
  // Toggle sort direction
  const toggleSortDirection = () => {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  };
  
  // Cycle through sort subjects
  const toggleSortSubject = () => {
    const order = ['first_name', 'last_name', 'email', 'role'];
    const currentIndex = order.indexOf(sortSubject.value);
    sortSubject.value = order[(currentIndex + 1) % order.length];
  };
  
  // Reset sort to default
  const resetSort = () => {
    sortDirection.value = 'asc';
    sortSubject.value = 'first_name';
  };
  
  // Display label for current sort subject
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
  
  // Handle search submit
  const handleSearch = (e) => {
    e.preventDefault();
    currentPage.value = 1;
  };
  
  // Filter + Sort users
  const filteredUsers = computed(() => {
    let filtered = users.value.filter((user) => {
      const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
      return (
        fullName.includes(query.value.toLowerCase()) ||
        user.email.toLowerCase().includes(query.value.toLowerCase())
      );
    });
  
    return filtered.sort((a, b) => {
      const valueA = String(a[sortSubject.value]).toLowerCase();
      const valueB = String(b[sortSubject.value]).toLowerCase();
      return sortDirection.value === 'asc'
        ? valueA.localeCompare(valueB)
        : valueB.localeCompare(valueA);
    });
  });
  
  // Paginate users
  const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredUsers.value.slice(start, end);
  });
  
  // Handle pagination
  const onClickHandler = (page) => {
    currentPage.value = page;
  };
  </script>
  