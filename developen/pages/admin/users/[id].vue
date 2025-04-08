<template>
    <div class="container" style="padding-left: 34vh;">
        <h1>User Current Details</h1>
        <p>User ID: {{ user.id }}</p>
        <p>User First Name: {{ user.first_name }}</p>
        <p>User Last Name: {{ user.last_name }}</p>
        <p>User Email: {{ user.email }}</p>
        <p>User Role: {{ user.role }}</p>
        <p>User Created At: {{ user.created_at }}</p>
    </div>
    <admin-panel/>
</template>

<script setup>

    definePageMeta({
        middleware: ["$auth", "admin"],    
    });

    
    import { useRoute } from 'vue-router';

    const route = useRoute();
    const id = route.params.id;

    const user = ref([]);
    user.value = await $fetch(`http://localhost:9000/api/users/${id}`)

</script>