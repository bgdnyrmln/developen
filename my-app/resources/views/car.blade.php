<x-layout>

<p>Name: {{ $car->name }}</p>
<p>Model: {{ $car->model }}</p>

<!-- Access and display tags for this car -->
<p>Tags:
    @foreach($car->tags as $tag)
        {{ $tag->name }} <!-- Assuming the Tag model has a 'name' attribute -->
        @if(!$loop->last), @endif <!-- Add a comma between tags, except for the last one -->
    @endforeach
</p>

<!-- Access and display the driver for this car -->
<p>Driver: {{ $car->driver->name }}</p>

@can('edit-car', $car)
    <a href="/cars/{{ $car->id }}/edit">Edit</a>
@endcan
</x-layout>
