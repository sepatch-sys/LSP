<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Typeroom') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Create type-room</h2>
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <form action="{{ route('type-room.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Type</label>
                    <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Facilitie</label>
                    <input type="text" name="facilitie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>

                <button type="submit" class="create-button">Create</button>
                <a href="{{ route('type-room.index') }}" class="return-button">Returns</a>
            </form>
        </div>
    </div>

    <style>
        .create-button {
            background-color: #3498DB;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .create-button:hover {
            background-color: #2980B9;
            color: aliceblue;
        }

        .return-button {
            background-color: #F44336;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .return-button:hover {
            background-color: #DA190B;
            color: aliceblue;
        }
    </style>
</x-app-layout>