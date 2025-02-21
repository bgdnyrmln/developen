<template>
    <div class="register">
        <div class="container">
            <div class="register-title">
                <h1>Lets get started!</h1>
            </div>
            <div class="register-text">
                <p>Fill in the form below to create an account.</p>
            </div>
            <div class="register-form">
                <form action="">
                    <div class="form-group">
                        <label class="register-text" for="name">Name:</label>
                        <input class="register-input" type="text" id="name" name="name" placeholder="Enter your name">
                    
                        <label class="register-text" for="Surname">Surname:</label>
                        <input class="register-input" type="text" id="surname" name="surname" placeholder="Enter your surname">
                    
                        <label class="register-text" for="Username">Username:</label>
                        <input class="register-input" type="text" id="username" name="username" placeholder="Enter your username">
                    
                        <label class="register-text" for="Password">Password:</label>
                        <input class="register-input" type="password" id="password" name="password" placeholder="Enter your password">
                    
                        <button class="register-button" type="submit">Enter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<style>
.register{
    height: 100vh;
    background-image: url(assets/background3.png);
    background-size: cover;
    background-position: center center; /* Keeps the image centered */
    background-repeat: no-repeat; /* Prevents the image from repeating */
}
</style>