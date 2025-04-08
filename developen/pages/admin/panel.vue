<template>

    
    <div class = "container" style="padding-left: 34vh">
        <h1>Welcome back, dear {{ first_name }}!</h1>
        <h2>You can use the navigation bar to the left from this text.</h2>
        <img src='https://picsum.photos/seed/{{ rand(0, 100000) }}/1550/400' alt="">
    </div>

    <admin-panel/>
</template>

<script setup lang="ts">

const { first_name } = await useSanctumFetch('http://localhost:9000/api/user');

definePageMeta({
  middleware: ["$auth", "admin"]
});

</script>
