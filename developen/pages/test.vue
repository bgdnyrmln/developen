<template>
    <div class="container">
        <div class="about-title">
            <h1>{{ role }}</h1>
        </div>
        <div class="about-text">
        </div></div>     
</template>


<script setup lang="ts">


const { role } = await useSanctumFetch('http://localhost:9000/api/user');


</script>