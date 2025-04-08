<template>
    <div class = 'footer'>
        <div class = 'footer-line'>
            <nav class = "nav">
                <a class="nav-item" href="https://www.instagram.com/bgdnyrmln/"> {{name}} {{surname}}</a>
                <a class="nav-item" href="https://en.wikipedia.org/wiki/2025">2025</a>
                <a class="nav-item" v-bind:href="home">Home</a>
                <a class="nav-item" v-bind:href="aboutpage">About us</a>
                <a class="nav-item" v-bind:href="contactpage">Contacts</a>
            </nav>
        </div>
    </div>
</template>    

<script setup>
import { ref } from 'vue'


const name = ref("Bogdan")
const surname = ref("Yarmolinsqy")
const number = ref("+37122073901")
const aboutpage = ref("/about")
const contactpage = ref("/contacts")
const home = ref("/main")
const register = ref("/register")
const login = ref("/login")


</script>