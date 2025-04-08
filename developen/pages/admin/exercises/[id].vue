<template>

<admin-panel/>
</template>

<script setup>
    definePageMeta({
        middleware: ["$auth", "admin"],    
    });
</script>