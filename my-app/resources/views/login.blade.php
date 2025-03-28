<div class="register">
      <div class="container">
        <div class="register-title">
          <h1>Let's get started!</h1>
        </div>
        <div class="register-text">
          <p>Fill in the form below to create an account.</p>
        </div>
        <div class="register-form">
        <form method="POST" action="/login">
            @csrf

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Enter</button>
        </form>


        </div>
      </div>
    </div>
