<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Type-Rooms') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Type-Rooms</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <h3 class="text-xl font-semibold mb-3">List Type-Rooms</h3>

            <ul class="list-disc pl-6 mb-4">
                @foreach ($typerooms as $typeroom)
                    <li class="flex justify-between items-center border-b py-2">
                        <strong>{{ $typeroom->name }}</strong> - {{ $typeroom->facilitie }}
                        <form action="{{ route('type-room.destroy', $typeroom->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </li> 
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>