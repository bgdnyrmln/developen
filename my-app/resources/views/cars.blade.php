
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>


<x-layout>
    @if(empty($cars))
        <p>No cars available.</p>
    @else
        <ul>
            @foreach($cars as $car)
                <li>
                    <h3>{{ $car->driver->name }}</h3>
                    <a href="cars/{{strtolower($car['id'])}}"><strong>
                    {{ $car['name'] }}</strong></a> {{ $car['model'] }}</li>
            @endforeach
        </ul>
    @endif

    {{ $cars->links() }}

    <a href="/cars/create">Create a new car</a>

</x-layout>


