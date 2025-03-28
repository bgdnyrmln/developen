<div class="register">
  <div class="container">
    <div class="register-title">
      <h1>Let's get started!</h1>
    </div>
    <div class="register-text">
      <p>Fill in the form below to create an account.</p>
    </div>
    <div class="register-form">
      <form method="POST" action="/register">
        @csrf

        <label class="register-text" for="first_name">First name:</label>
        <input class="register-input" type="text" id="first_name" name="first_name" placeholder="Enter your name" required />

        <label class="register-text" for="last_name">Last name:</label>
        <input class="register-input" type="text" id="last_name" name="last_name" placeholder="Enter your surname" required />

        <label class="register-text" for="email">Email:</label>
        <input class="register-input" type="email" id="email" name="email" placeholder="Enter your email" required />

        <label class="register-text" for="password">Password:</label>
        <input class="register-input" type="password" id="password" name="password" placeholder="Enter your password" required />

        <button class="register-button" type="submit">Enter</button>
      </form>
    </div>
  </div>
</div>
