<template>
    <div class="container" style="margin-left: 34vh; padding-top: 10vh;">
        <h1 style="justify-self: center;">Categories</h1>
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
            placeholder="Search category"
            v-model="query"
          />
        </form>
      </div>
  
      <a class="usercard" href="/admin/categories/create">Create new category</a>
  
      <div class="usercard" v-for="category in paginatedCategories" :key="category.id">
        <div>
          ID: {{ category.id }} <br />
          Name: {{ category.name }} <br />
          Color: <span :style="{ color: category.color }">{{ category.color }}</span> <br />
        </div>
        <div style="display: flex; gap: 10px;">
          <NuxtLink :to="`/admin/categories/${category.id}`" class="userbutton">Details</NuxtLink>
          <button
            @click="deleteCategory(category.id)"
            class="userbutton"
            style="background-color: red;"
          >
            Delete
          </button>
        </div>
      </div>
  
      <div v-if="filteredCategories.length > itemsPerPage" class="pagination">
        <vue-awesome-paginate
          :total-items="filteredCategories.length"
          :items-per-page="itemsPerPage"
          :max-pages-shown="3"
          v-model="currentPage"
          @click="onClickHandler"
        />
      </div>
  
      <admin-panel />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue';
  import axios from 'axios';
  
  const categories = ref([]);
  const query = ref('');
  const sortDirection = ref('asc');
  const sortSubject = ref('id'); // Default to sorting by ID
  const currentPage = ref(1);
  const itemsPerPage = 5;
  
  // Fetch categories
  onMounted(async () => {
    try {
      await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
      categories.value = await $fetch("http://localhost:9000/api/categories");
    } catch (error) {
      console.error("Error fetching categories:", error);
    }
  });
  
  // Delete category
  const deleteCategory = async (id) => {
    if (confirm("Are you sure you want to delete this category?")) {
      try {
        const token = decodeURIComponent(
          document.cookie
            .split("; ")
            .find((row) => row.startsWith("XSRF-TOKEN="))
            ?.split("=")[1] ?? ""
        );
  
        await axios.delete(`http://localhost:9000/api/categories/${id}`, {
          withCredentials: true,
          headers: {
            "X-XSRF-TOKEN": token,
          },
        });
  
        categories.value = categories.value.filter((category) => category.id !== id);
      } catch (error) {
        console.error("Error deleting category:", error);
      }
    }
  };
  
  // Toggle sort direction
  const toggleSortDirection = () => {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  };
  
  // Cycle through sort subjects
  const toggleSortSubject = () => {
    const order = ['id', 'name'];
    const currentIndex = order.indexOf(sortSubject.value);
    sortSubject.value = order[(currentIndex + 1) % order.length];
  };
  
  // Reset sort
  const resetSort = () => {
    sortDirection.value = 'asc';
    sortSubject.value = 'id';
  };
  
  // Display current sort label
  const sortSubjectDisplay = computed(() => {
    switch (sortSubject.value) {
      case 'id': return 'ID';
      case 'name': return 'Name';
      default: return 'ID';
    }
  });
  
  // Handle search
  const handleSearch = (e) => {
    e.preventDefault();
    currentPage.value = 1;
  };
  
  // Filter + Sort
  const filteredCategories = computed(() => {
    let filtered = categories.value.filter((category) =>
      category.name.toLowerCase().includes(query.value.toLowerCase())
    );
  
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
  
  // Paginated result
  const paginatedCategories = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredCategories.value.slice(start, end);
  });
  
  // Pagination click
  const onClickHandler = (page) => {
    currentPage.value = page;
  };
  </script>
  