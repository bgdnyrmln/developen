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

              <label class="register-text" for="email">Email:</label>
              <input
                class="register-input"
                type="email"
                id="email"
                v-model="form.email"
                placeholder="Enter your email"
              />
  
              <label class="register-text" for="password">Password:</label>
              <input
                class="register-input"
                type="password"
                id="password"
                v-model="form.password"
                placeholder="Enter your password"
              />
              <p v-if="error" style="color: red;">{{ error }}</p>
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
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';
const router = useRouter();



definePageMeta({
  middleware: ["$guest"],
});

onMounted( async () => {
  await axios.get("/sanctum/csrf-cookie", {
    withCredentials: true
  });
});



const form = ref({
  email: '',
  password: ''
});


const error = ref(null);

const { refreshUser } = useSanctum();

const submitForm = async () => {
  try {
    const token = decodeURIComponent(
      document.cookie
        .split("; ")
        .find((row) => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1] ?? ""
    );

    await axios.post("/login", form.value, {
      withCredentials: true,
      headers: {
        "X-XSRF-TOKEN": token,
      },
    });

    await refreshUser();

    router.push("/exercises");
  } catch (err) {
    error.value = "Invalid username or password";
    console.error("Login error:", err);
  }
};
</script>
  