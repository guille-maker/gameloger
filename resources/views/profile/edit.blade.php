<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">👤 Mi perfil</h2>
    </x-slot>

    <div x-data="{ tab: 'juegos' }" class="p-6">
        <!-- Pestañas -->
        <div class="flex space-x-4 border-b mb-6">
            <button @click="tab = 'juegos'"
                    :class="tab === 'juegos' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'"
                    class="pb-2 font-semibold">
                🎮 Mis Juegos
            </button>
            <button @click="tab = 'config'"
                    :class="tab === 'config' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'"
                    class="pb-2 font-semibold">
                ⚙️ Configuración
            </button>
        </div>

        <!-- Contenido de pestañas -->
        <div x-show="tab === 'juegos'" x-cloak>
            <a href="{{ route('user-games.create') }}"
   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition mb-4 inline-block">
   ➕ Añadir juego a mi perfil
</a>
            @foreach (auth()->user()->userGames as $userGame)
                <div class="bg-white p-4 rounded shadow mb-4 text-black">
                    <h3 class="text-lg font-bold">{{ $userGame->game->title }}</h3>
                    <p>Plataforma: {{ $userGame->game->platform }}</p>
                    <p>Progreso: {{ $userGame->progress }}%</p>
                    <p>Comentario: {{ $userGame->comment }}</p>
                    @if ($userGame->screenshot_url)
                        <img src="{{ $userGame->screenshot_url }}" class="w-full h-48 object-cover mt-2">

                    @endif
                    <div class="flex justify-end space-x-4 mt-4">
        <a href="{{ route('user-games.edit', $userGame->id) }}"
           class="text-blue-600 hover:underline">✏️ Editar</a>

        <form action="{{ route('user-games.destroy', $userGame->id) }}" method="POST"
              onsubmit="return confirm('¿Eliminar este juego de tu perfil?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">🗑️ Eliminar</button>
        </form>
    </div>
                </div>
                

            @endforeach
        </div>

        <div x-show="tab === 'config'" x-cloak>
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
