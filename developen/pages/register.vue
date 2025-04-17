<template style="background-color: black;">
  <headerline/>

  <div class="register" style="height: 125vh;">
    <div class="container">
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
            <input
              class="register-input"
              type="text"
              id="first_name"
              v-model="form.first_name"
              placeholder="Enter your name"
              required
            />
            <p v-if="error.first_name" style="color: red;">{{ error.first_name[0] }}</p>

            <label class="register-text" for="last_name">Surname:</label>
            <input
              class="register-input"
              type="text"
              id="last_name"
              v-model="form.last_name"
              placeholder="Enter your surname"
              required
            />
            <p v-if="error.last_name" style="color: red;">{{ error.last_name[0] }}</p>

            <label class="register-text" for="email">Email:</label>
            <input
              class="register-input"
              type="text"
              id="email"
              v-model="form.email"
              placeholder="Enter your email"
              required
            />
            <p v-if="error.email" style="color: red;">{{ error.email[0] }}</p>

            <label class="register-text" for="password">Password:</label>
            <input
              class="register-input"
              type="password"
              id="password"
              v-model="form.password"
              placeholder="Enter your password"
              required
            />
            <p v-if="error.password" style="color: red;">{{ error.password[0] }}</p>

            <p v-if="error.general" style="color: red;">{{ error.general }}</p>

            <button class="register-button" type="submit">Enter</button>
          </form>

          <button class="register-button" @click="navigateTo('/login')">Already have an account?</button>
        </div>
      </div>
    </div>
  </div>

  <footerline/>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

definePageMeta({
  middleware: ["$guest"],
});


await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
  withCredentials: true,
});


const router = useRouter();

const form = ref({
  first_name: "",
  last_name: "",
  email: "",
  password: "",
});

const error = ref({});

const submitForm = async () => {
  try {
    const token = decodeURIComponent(
      document.cookie
        .split("; ")
        .find((row) => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1] ?? ""
    );

  await axios.post("http://localhost:9000/register", form.value, {
    withCredentials: true,
    headers: {
      "X-XSRF-TOKEN": token,
    },
  });

  router.push('/login');
  } catch (err) {
    console.error("Registration error:", err);
    if (err.response?.data?.errors) {
      error.value = err.response.data.errors;
    } else if (err.response?.data?.message) {
      error.value = { general: err.response.data.message };
    } else {
      error.value = { general: "An unexpected error occurred." };
    }
  }
};

</script>
