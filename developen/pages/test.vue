<script setup>
import { ref } from 'vue'
import axios from 'axios'  // Assuming you have axios installed

// State to hold the input value and the search results
const query = ref('')
const results = ref([])  // To store API results
const loading = ref(false)  // To show loading state
const error = ref(null)  // To handle any errors

// Fetch data from API based on the query
const fetchData = async () => {
  if (!query.value.trim()) {
    results.value = []  // Clear results if query is empty
    return
  }

  loading.value = true
  error.value = null

  try {
    const response = await axios.get('http://localhost:9000/api/exercises', {
      params: { name: query.value }  // Assuming you're passing query as a parameter to your API
    })
    results.value = response.data  // Update the results with API data
  } catch (err) {
    error.value = 'Error fetching data'
  } finally {
    loading.value = false
  }
}

// Handle form submission and fetch data
const handleSearch = (e) => {
  e.preventDefault()
  fetchData()
}
</script>

<template>
  <form @submit="handleSearch">
    <input type="text" v-model="query" placeholder="Search by name..." />
    <button type="submit">Search</button>
  </form>

  <div v-if="loading" style="color: red;">Loading...</div>
  <div v-if="error"  style="color: red;">{{ error }}</div>

  
  <ul v-if="results.length > 0"  style="color: red;">
    <li v-for="result in results" :key="result.id" style="color: red;">
      {{ result.name }}
    </li>
  </ul>
  <div v-else-if="!loading" style="color: rebeccapurple">No results found</div>
</template>

<style scoped>
form {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
input {
  width: 300px;
  height: 50px;
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 10px;
}
button {
  margin-left: 10px;
  padding: 10px 20px;
  border-radius: 5px;
  border: none;
  background-color: #007bff;
  color: white;
  cursor: pointer;
}
</style>
