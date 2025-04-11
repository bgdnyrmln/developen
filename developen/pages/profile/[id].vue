<template>  

</template>

<script setup>

import axios from 'axios';

definePageMeta({
    middleware: ["$auth", "profile"],    
});
</script>