<h1>Cars</h1>

@if(empty($cars))
    <p>No cars available.</p>
@else
    <ul>
        @foreach($cars as $car)
            <li><a href="cars/{{strtolower($car['id'])}}"><strong>
                 {{ $car['name'] }}</strong></a> {{ $car['model'] }}</li>
        @endforeach
    </ul>
@endif
