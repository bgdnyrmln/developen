<x-layout>
    <form method="POST" action="/cars">
        @csrf

    <div class="space-y-12">
        <div class="border-b border-white-900/10 pb-12">
        <h2 class="text-base/7 font-semibold text-white-900">Create</h2>
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <label for="username" class="block text-sm/6 font-medium text-white-900">Name</label>
                <div class="mt-2">
                    <div class="flex items-center rounded-md bg-gray-900 pl-3 outline-1 -outline-offset-1 outline-white-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                        <input type="text" name="name" id="username" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-white-900 placeholder:text-white-400 focus:outline-none sm:text-sm/6" placeholder="BMW">
                    </div>
                </div>


                    <label for="username" class="block text-sm/6 font-medium text-white-900">Model</label>
                        <div class="mt-2">
                            <div class="flex items-center rounded-md bg-gray-900 pl-3 outline-1 -outline-offset-1 outline-white-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <input type="text" name="model" id="username" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-white-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" placeholder="E90">
                            </div>
                        </div>
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>

                </div>
            </form>
</x-layout>
