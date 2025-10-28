<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">🎮 Biblioteca de Juegos</h2>
    </x-slot>
<form method="GET" action="{{ route('games.index') }}" class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
    <!-- Filtro por género -->
    <div>
        <label for="genre" class="block text-sm font-medium text-white mb-1">Filtrar por género:</label>
        <select name="genre" id="genre" onchange="this.form.submit()" class="text-black w-full px-3 py-2 border rounded shadow-sm">
            <option value="">Todos los géneros</option>
            @foreach ($availableGenres as $genre)
                <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>
                    {{ $genre }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Filtro por plataforma -->
    <div>
        <label for="platform" class="block text-sm font-medium text-white mb-1">Filtrar por plataforma:</label>
        <select name="platform" id="platform" onchange="this.form.submit()" class="text-black w-full px-3 py-2 border rounded shadow-sm">
            <option value="">Todas las plataformas</option>
            @foreach ($availablePlatforms as $platform)
                <option value="{{ $platform }}" {{ request('platform') === $platform ? 'selected' : '' }}>
                    {{ $platform }}
                </option>
            @endforeach
        </select>
    </div>
</form>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white">🎮 Biblioteca de Juegos</h2>
        <a href="{{ route('games.create') }}"
           class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">
            ➕ Añadir juego
        </a>
    </div>
</x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 p-4">
        @forelse ($games as $game)
            <div class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden">
                <img src="{{ $game->cover_url }}" alt="{{ $game->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $game->title }}</h3>
                    <p class="text-sm text-gray-600 truncate">🎮 {{ $game->platform }}</p>
                    <p class="text-sm text-gray-600 truncate">🧬 {{ $game->genre }}</p>
                    <div class="mt-2 text-xs text-gray-500">Progreso: {{ $game->progress }}%</div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center">No hay juegos disponibles.</p>
        @endforelse
    </div>
</x-app-layout>
