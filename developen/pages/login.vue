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
          <form @submit.prevent="login"> 
            <div class="form-group">
              <label class="register-text" for="username">Username:</label>
              <input class="register-input" type="text" id="username" v-model="username" placeholder="Enter your username" required />
  
              <label class="register-text" for="password">Password:</label>
              <input class="register-input" type="password" id="password" v-model="password" placeholder="Enter your password" required />
  
              <button class="register-button" type="submit">Enter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
<script setup>
import { ref } from 'vue'

const username = ref('')
const password = ref('')

const login = async () => {
  if (!username.value || !password.value) {
    alert('Please enter your username and password!')
    return
  }

  try {
    const response = await fetch('/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        username: username.value,
        password: password.value
      })
    })

    const result = await response.json()

    if (result.success) {
      alert('Login successful!')
      // Redirect user or store session token if needed
    } else {
      alert(`Error: ${result.error}`)
    }
  } catch (error) {
    console.error('Error:', error)
    alert('Something went wrong, please try again.')
  }
}
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
  