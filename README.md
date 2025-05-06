# DevelOpen

**Author:** B. Jarmolinskis  
**Education Program:** Programming  
**Institution:** Rīgas Valsts Tehnikums   

---

# Overview

DevelOpen is an online platform designed to help beginners learn programming interactively. It provides a structured environment with various tasks and exercises that help users gradually build their programming skills. The platform features user authentication, task management, and personalized tracking of progress, aiming to offer a more efficient learning experience compared to unstructured resources.

The platform is developed using modern technologies such as Nuxt.js, Laravel, and MariaDB, ensuring high performance, maintainability, and ease of use.

### Key Features

- **User Authentication**: Secure login and registration system with role-based access (Administrator, Registered User, Guest).
- **Task Management**: Users can view, filter, and search for programming tasks; administrators can add, edit, and delete tasks.
- **Progress Tracking**: Automatically track task completion and user progress.
- **Personalized Experience**: Users can edit their profiles and manage their learning experience.
- **Task Categories**: Tasks are organized into categories to help users focus on specific topics.
  
### Technologies Used

- **Backend**: Laravel 12 (PHP framework)
- **Database**: MariaDB 10.6 (Almost the same as MySQL, you can use MySQL)
- **Containerization**: Docker
- **Frontend**: Nuxt.js 3 (JavaScript framework made by expending Vue.js)
- **Server**: Node.js (for rendering Nuxt.js pages)

### Till 27.05.25!!!

You can check out DevelOpen running on http://developen.space

But if you want to try to run it yourself on localhost then read bellow.

# Installation Guide

### System Requirements

- **PHP** >= 8.1
- **Composer**
- **Laravel** >= 12.0
- **MariaDB** >= 10.6
- **Node.js** and **npm**
- **Docker** (optional, for containerization)

1. **Clone the Repository**

    ```bash
    git clone https://github.com/bgdnyrmln/developen.git
    cd developen
    ```

2. **Install PHP Dependencies**

    ```bash
    .../developen> cd my-app
    .../developen/my-app> composer install
    ```

3. **Install JavaScript Dependencies**

    ```bash
    .../developen> cd developen
    .../developen/developen> npm install
    ```

4. **Configure Database**

    - Create a new MariaDB database for the application.
    - Update the `.env` file with your database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=developen
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Run Database Migrations**

    ```bash
    php artisan migrate
    ```

6. **Start the Backend Server**

    ```bash
    php artisan serve
    ```

    The application's backend will be available at `http://localhost:8000`.


7. **Start the Frontend Server**

    ```bash
    npm run dev
    ```

    The application's frontend will be available at `http://localhost:3000`.


8. **Visit DevelOpen 🚀**

    [DevelOpen](http://localhost:3000)

### User Roles and Permissions

- **admin**: Can manage users, tasks, and system settings.
- **user**: Can solve tasks, upload answers, and track progress.
- **guest**: Can register for an account.

---

