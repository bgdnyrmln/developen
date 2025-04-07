<template>

    


    <div class="sidenav">
        <a href="/admin/users/all">Users</a>
        <a href="/admin/exercises/all">Exercises</a>
    </div>   
    

    <NuxtPage />
</template>

<script setup lang="ts">

const { role } = await useSanctumFetch('http://localhost:9000/api/user');

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