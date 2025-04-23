<template>
    <div class="sidenav">
        <a href="/main">
            <img class = "logo-img" src="assets/logo.png" id="logo" alt="">
          
        </a>
        <a href="/admin/users/all">Users</a>
        <a href="/admin/exercises/all">Exercises</a>
        <a href="/admin/categories/all">Categories</a>
    </div> 
</template>

<style>

.sidenav {
      height: 100%;
      width: 32vh;
      position: fixed;
      left: 0;
      top: 0;
      background-color: #111;
      padding-top: 0;
      transition: 0.3s;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .sidenav a {
      width: 30vh;
      text-align: center;
      padding: 12px;
      text-decoration: none;
      font-size: 18px;
      color: #fff;
      transition: 0.2s;
    }

    .sidenav a:hover {
      background-color: #575757;
    }

    
</style>

