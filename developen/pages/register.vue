<template>
    <headerline/>

    <div class="register">
      
        <div class="register-title">
          <h1>Let's get started!</h1>
        </div>
        <div class="register-text">
          <p>Fill in the form below to create an account.</p>
        </div>
        <div class="register-form">
          <div class="form-group">
          <form @submit.prevent="submitForm"> 
              <label class="register-text" for="first_name">Name:</label>
              <input class="register-input" type="text" id="first_name" v-model="form.first_name" placeholder="Enter your name" required />
  
              <label class="register-text" for="last_name">Surname:</label>
              <input class="register-input" type="text" id="last_name" v-model="form.last_name" placeholder="Enter your surname" required />
  
              <label class="register-text" for="email">Email:</label>
              <input class="register-input" type="text" id="email" v-model="form.email" placeholder="Enter your email" required />
  
              <label class="register-text" for="password">Password:</label>
              <input class="register-input" type="password" id="password" v-model="form.password" placeholder="Enter your password" required />
  
              <button class="register-button" type="submit">Enter</button>
            
          </form>          
          <button class="register-button" @click="navigateTo('/login')">Already have an account?</button>
        </div>
      </div>
    
    </div>
<footerline/>

  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import axios from 'axios';
  useSeoMeta({
    title: "Register",
  });

  await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true
    });


  interface User {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
  }
  const { refreshUser } = useSanctum<User>();

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
      return navigateTo("/login");
    } catch (err) {
      console.log(err);
    }
  }



  </script>
  
  <style>
  </style>
  