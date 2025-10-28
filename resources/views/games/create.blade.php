<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">➕ Añadir nuevo juego</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow text-black">
        <form method="POST" action="{{ route('games.store') }}">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="title" id="title" required class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="platform" class="block text-sm font-medium text-gray-700">Plataforma</label>
                <input type="text" name="platform" id="platform" required class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="genre" class="block text-sm font-medium text-gray-700">Género</label>
                <input type="text" name="genre" id="genre" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="cover_url" class="block text-sm font-medium text-gray-700">URL de portada</label>
                <input type="url" name="cover_url" id="cover_url" class="w-full px-3 py-2 border rounded">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar juego
            </button>
        </form>
    </div>
</x-app-layout>
