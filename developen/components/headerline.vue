
<template> 
    <div class = "header-line" id = "headerline">
        <div class = "header-logo">
            <img class = "logo-img" src="assets/logo.png" id="logo" alt="">
        </div>
        <div class = "nav">
            <a class="nav-item" v-bind:href="home">Home</a>
            <a class="nav-item" v-bind:href="aboutpage">About us</a>
            <a class="nav-item" v-bind:href="contactpage">Contacts</a>
        </div>
        <div>
            <div class="number">
                <a class = "num" href="#">{{number}}</a>
             </div>
            <div class="phone-text">
                Bro just call us if u want.
            </div>
        </div>
        <div class="changetheme" id='theme-toggle'>
            Ligt Mode
        </div>

        <div v-if="role === 2">
            <a class = "button" href="/admin/panel">Admin panel</a>
        </div>
        <div class="dropdown" >
            <div class="btn">
                <a class = "button" style="color: white;">Profile &#x2935;</a>
            </div>
            <div class="dropdown-content">
              <template v-if="!isLoggedIn">
                <a v-bind:href="register">Register</a>
                <a v-bind:href="login">Login</a>
              </template>
              <template v-else>
                <a href="/profile">Profile</a>
                <a href="#" id="logout" @click.prevent="logout()">Logout</a>
              </template>

            </div>
        </div>
        <div id="side-menu" class="side-menu">
            <a v-bind:href="home">Home</a>
            <a v-bind:href="aboutpage">About us</a>
            <a v-bind:href="contactpage">Contacts</a>
            <a href="#" id="close-btn">Close</a>
        </div>
    </div>
    


</template>



<script setup>

import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'



const { logout } = useSanctum()
const { isLoggedIn } = useSanctum()
const role = ref(null)
const id = ref(null)
// Reactive variables
const name = ref("Bogdan")
const surname = ref("Yarmolinsqy")
const number = ref("+37122073901")
const aboutpage = ref("/about")
const contactpage = ref("/contacts")
const home = ref("/main")
const register = ref("/register")
const login = ref("/login")



onMounted(async () => {
  try {
    const { id: fetchedId, role: fetchedRole } = await useSanctumFetch('/api/user')
    id.value = fetchedId
    role.value = fetchedRole
  } catch (e) {
    console.error('Error fetching role:', e)
  }
})

// Header Scroll Behavior
const headerline = ref(null)


onMounted(() => {
  const route = useRoute()
  headerline.value = document.getElementById("headerline")

  const handleScroll = () => {
    const scrolled = window.scrollY > 0

    // If we're on /main, use transparent at the top, otherwise always black
    if (route.path === '/main') {
      headerline.value.style.backgroundColor = scrolled ? "black" : "transparent"
    } else {
      headerline.value.style.backgroundColor = "black"
    }

    // Hide the header if user scrolls too far
    if (window.scrollY > window.innerHeight * 0.99) {
      headerline.value.style.opacity = "0"
      headerline.value.style.pointerEvents = "none"
    } else {
      headerline.value.style.opacity = "1"
      headerline.value.style.pointerEvents = "auto"
    }
  }

  // Set initial style
  handleScroll()

  window.addEventListener("scroll", handleScroll)
})



// Mobile Menu
onMounted(() => {
document.getElementById("logo").addEventListener("click", () => {
if (window.innerWidth <= 815) {
  document.getElementById("side-menu").style.width = "250px"
} else {
  window.location.href = "/main"
}
})

document.getElementById("close-btn").addEventListener("click", () => {
document.getElementById("side-menu").style.width = "0"
})
})

// Theme Toggle
// Theme Toggle
onMounted(() => {
  const themeToggleButton = document.getElementById("theme-toggle")
  const bodyElement = document.body

  // Check localStorage on load
  const savedTheme = localStorage.getItem("theme")
  if (savedTheme === "light") {
    bodyElement.classList.add("light-theme")
    themeToggleButton.textContent = "Back to Dark Mode"
  } else {
    themeToggleButton.textContent = "Ligt Mode"
  }

  // Toggle and save to localStorage
  themeToggleButton.addEventListener("click", () => {
    const isLight = bodyElement.classList.toggle("light-theme")

    localStorage.setItem("theme", isLight ? "light" : "dark")
    themeToggleButton.textContent = isLight
      ? "Back to Dark Mode"
      : "Ligt Mode"
  })
})





</script>

