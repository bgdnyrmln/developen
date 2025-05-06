<template>
  <!-- Main container for the admin panel screen -->
  <div class="admin-panel-screen">
    <div class="container" style="padding-left: 34vh">
      
      <!-- Welcome message for the admin with the user's first name -->
      <h1>Welcome back, dear {{ first_name }}!</h1>
      <h2>You can use the navigation bar to the left from this text.</h2>

    </div>
  </div>

  <!-- Admin panel component -->
  <admin-panel/>
</template>

<script setup lang="ts">
  // Fetch user data using the Sanctum fetch to get the logged-in user's first name
  const { first_name } = await useSanctumFetch('/api/user');

  // Define page meta to ensure the user is authenticated and has admin privileges
  definePageMeta({
    middleware: ["$auth", "admin"]
  });
</script>

<style>
  /* Styles for the admin panel screen */
  .admin-panel-screen {
    background-image: url('assets/background5.png'); /* Set background image */
    background-size: cover; /* Ensure the background covers the full viewport */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Prevent the background from repeating */
    height: 100vh; /* Set the height to cover the entire viewport height */
  }
</style>
