<template>
  <headerline/>

    <div class="register">
      <div class="container">
        <div class="register-title">
          <h1>Welcome back!</h1>
        </div>
        <div class="register-text">
          <p>Log into your account.</p>
        </div>
        <div class="register-form">
          <!-- Prevent default form submission and handle it with submitForm method -->
          <div class="form-group">
          <form @submit.prevent="submitForm">

              <label class="register-text" for="email">Username:</label>
              <input
                class="register-input"
                type="text"
                id="email"
                v-model="form.email"
                placeholder="Enter your username"
              />
  
              <label class="register-text" for="password">Password:</label>
              <input
                class="register-input"
                type="password"
                id="password"
                v-model="form.password"
                placeholder="Enter your password"
              />
  
              <button class="register-button" type="submit">Enter</button>
              

          </form>
          <button class="register-button" @click="navigateTo('/register')">Dont have an account</button>
        </div>

        </div>
      </div>
    </div>
<footerline/>

  </template>
  
  <script setup>
  import axios from 'axios';
  import { ref } from 'vue';
  
  // Call this before making login requests
    await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true
    });

  const form = ref({
    email: '',
    password: ''
  });

// Assuming useSanctum is a composable that provides authentication methods
const { login } = useSanctum();

const submitForm = async () => {
    await login(form.value);
};


const { isLoggedIn } = useSanctum();
</script>
  

<style>
.register {
    height: 80vh;
    background-image: url(assets/background3.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
</style>