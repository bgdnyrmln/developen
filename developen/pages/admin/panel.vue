<template>

    
    <div class = "container" style="padding-left: 34vh">
        <h1>Welcome back, dear {{ first_name }}!</h1>
        <h2>You can use the navigation bar to the left from this text.</h2>
        <img src='https://picsum.photos/seed/{{ rand(0, 100000) }}/1550/400' alt="">
    </div>

    <div class="sidenav">
        <a href="/admin/users/all">Users</a>
        <a href="/admin/exercises/all">Exercises</a>
    </div>   

</template>

<script setup lang="ts">

const { first_name } = await useSanctumFetch('http://localhost:9000/api/user');

definePageMeta({
  middleware: ["$auth", "admin"]
});

</script>

<style>

.sidenav {
      height: 100%;
      width: 32vh;
      position: fixed;
      left: 0;
      top: 0;
      background-color: #111;
      padding-top: 0;
      transition: 0.3s;
    }

    .sidenav a {
      padding: 12px 20px;
      text-decoration: none;
      font-size: 18px;
      color: #fff;
      display: block;
      transition: 0.2s;
    }

    .sidenav a:first-child {
      margin-top: 22vh;
    }

    .sidenav a:hover {
      background-color: #575757;
    }
</style>