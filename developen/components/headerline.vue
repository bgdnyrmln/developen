
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
            freak my eyes pls
        </div>

        <div v-if="role === 'admin'">
            <a class = "button" href="/admin/panel">Admin panel</a>
        </div>
                
                <!-- profile button dropdown (need to add the functionality)-->
        <div class="dropdown" >
            <div class="btn">
                <a class = "button">Profile &#x2935;</a>
            </div>

            <div class="dropdown-content">
              <template v-if="!isLoggedIn">
                <a v-bind:href="register">Register</a>
                <a v-bind:href="login">Login</a>
              </template>
              <template v-else>
                <a href="#">Profile</a>
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
import { useRouter } from 'vue-router'
const { logout } = useSanctum()

const router = useRouter()

if (process.client) {
if (router.currentRoute.value.path === '/') {
router.replace('/main')
}
}

import { ref, onMounted, onUnmounted } from 'vue'

const { isLoggedIn } = useSanctum()
const { role } = await useSanctumFetch('http://localhost:9000/api/user');

// Reactive variables
const name = ref("Bogdan")
const surname = ref("Yarmolinsqy")
const number = ref("+37122073901")
const aboutpage = ref("/about")
const contactpage = ref("/contacts")
const home = ref("/main")
const register = ref("/register")
const login = ref("/login")


// Header Scroll Behavior
const headerline = ref(null)

onMounted(() => {
headerline.value = document.getElementById("headerline")

window.addEventListener("scroll", () => {
if (window.scrollY > 0) {
  headerline.value.style.backgroundColor = "black"
} else {
  headerline.value.style.backgroundColor = "transparent"
}

if (window.scrollY > window.innerHeight * 0.99) {
  headerline.value.style.opacity = "0"
  headerline.value.style.pointerEvents = "none"
} else {
  headerline.value.style.opacity = "1"
  headerline.value.style.pointerEvents = "auto"
}
})
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
onMounted(() => {
const themeToggleButton = document.getElementById("theme-toggle")
const bodyElement = document.body

themeToggleButton.addEventListener("click", () => {
bodyElement.classList.toggle("light-theme")

themeToggleButton.textContent = bodyElement.classList.contains("light-theme")
  ? "Back to Dark Mode"
  : "freak my eyes pls"
})
})
</script>

