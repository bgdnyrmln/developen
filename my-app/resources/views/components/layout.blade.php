<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container mx-auto mt-10 mb-10">
    <nav class = "flex flex-1 justify-between items-center">
        <div>
            <a href="/cars" >
                <img src="https://picsum.photos/seed/{{ rand(0, 100000) }}/100/100" class="rounded-xl">
            </a>
        </div>

        <div class="flex gap-6">
            <a href="/cars/create">Create a listing </a>
        </div>
        @guest
            <div class="flex gap-6">
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            </div>
        @endguest
        @auth
        <div>
            <form method = "POST" action="/logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
        @endauth
    </nav>
</div>

{{ $slot }}

</body>
</html>

