<template>
    <div class="register">
      <div class="container">
        <div class="register-title">
          <h1>Welcome back!</h1>
        </div>
        <div class="register-text">
          <p>Log into your account.</p>
        </div>
        <div class="register-form">
          <form @submit.prevent="submitForm"> 
            <div class="form-group">
              <label class="register-text" for="username">Username:</label>
              <input class="register-input" type="email" id="email" v-model="form.email" placeholder="Enter your email" />
  
              <label class="register-text" for="password">Password:</label>
              <input class="register-input" type="password" id="password" v-model="form.password" placeholder="Enter your password" />
  
              <button class="register-button" type="submit">Enter</button>
              
            </div>
          </form>
          <a class="register-button" href="/register">Don't have an account?</a>
        </div>
      </div>
    </div>
  </template>
  
<script setup>
import { ref } from 'vue'

const form = ref({
  email: '',
  password: ''
});

const { login } = useSanctum();
 
const submitForm = () => {
  login(form.value);
};


</script>



  <style>
  .register {
    height: 100vh;
    background-image: url(assets/background3.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  </style>
  