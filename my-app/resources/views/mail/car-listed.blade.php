<x-mail::message>

# Hello!

Thanks for listing your car on our platform.
<a href="{{ url('/cars/' . $car->id) }}">Check your listing</a>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
