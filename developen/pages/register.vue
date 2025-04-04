<template>
    <div class="register">
      <div class="container">
        <div class="register-title">
          <h1>Let's get started!</h1>
        </div>
        <div class="register-text">
          <p>Fill in the form below to create an account.</p>
        </div>
        <div class="register-form">
          <form @submit.prevent="submitForm"> 
            <div class="form-group">
              <label class="register-text" for="first_name">Name:</label>
              <input class="register-input" type="text" id="first_name" v-model="form.first_name" placeholder="Enter your name" required />
  
              <label class="register-text" for="last_name">Surname:</label>
              <input class="register-input" type="text" id="last_name" v-model="form.last_name" placeholder="Enter your surname" required />
  
              <label class="register-text" for="email">Email:</label>
              <input class="register-input" type="text" id="email" v-model="form.email" placeholder="Enter your email" required />
  
              <label class="register-text" for="password">Password:</label>
              <input class="register-input" type="password" id="password" v-model="form.password" placeholder="Enter your password" required />
  
              <button class="register-button" type="submit">Enter</button>
            </div>
          </form>
          <a class="register-button" href="/login">Already have an account?</a>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue'
  import axios from 'axios';
  useSeoMeta({
    title: "Register",
  });

  definePageMeta({
    middleware: ["$guest"],
  });

  await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true
    });


  const { refreshUser } = useSanctum();

  const form = useSanctumForm("post", "/register", {
    first_name: "",
    last_name: "",
    email: "",
    password: "",
  });

  async function submitForm() {
    if (form.processing) return;
    try {
      await form.submit();
      await refreshUser();
      return navigateTo("/main");
    } catch (err) {
      console.log(err);
    }
  }



  </script>
  
  <style>
  .register {
    height: 125vh;
    background-image: url(assets/background3.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  </style>
  