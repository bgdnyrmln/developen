<template>
    <div class = "container" style="padding-left: 34vh">
        <h1>Name: {{ exercise.name }}</h1>
        <p>Description: {{ exercise.description }}</p>
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

    const exercise = ref([]);
    exercise.value = await $fetch(`http://localhost:9000/api/exercises/${id}`)
</script>