<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<style>
@import url('assets/style.css');
</style>

<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()

// Redirect from '/' to '/main' on client side
if (process.client && router.currentRoute.value.path === '/') {
  router.replace('/main')
}
</script>
