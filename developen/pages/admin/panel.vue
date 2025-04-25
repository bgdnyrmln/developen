<template>
  <div class="admin-panel-screen">
    <div class = "container" style="padding-left: 34vh">
        <h1>Welcome back, dear {{ first_name }}!</h1>
        <h2>You can use the navigation bar to the left from this text.</h2>
    </div>
  </div>
    

    <admin-panel/>
</template>

<script setup lang="ts">

const { first_name } = await useSanctumFetch('/api/user');

definePageMeta({
  middleware: ["$auth", "admin"]
});

</script>

<style>

.admin-panel-screen{
  background-image: url('assets/background5.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: 100vh;
}

</style>