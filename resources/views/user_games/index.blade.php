<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">👤 Mi lista de juegos</h2>
    </x-slot>

    <div x-data="{ tab: 'juegos', editId: null }" class="p-6">
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

<div x-data="{ tab: 'juegos', editId: null }" class="p-6">
    <!-- pestañas ... -->

    <div x-show="tab === 'juegos'" x-cloak>
        <a href="{{ route('user-games.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition mb-4 inline-block">
            ➕ Añadir juego a mi perfil
        </a>

        @foreach ($userGames as $userGame)
            <div class="bg-white p-4 rounded shadow mb-4 text-black flex justify-between items-start">
                <div class="flex-1 pr-4">
                    <h3 class="text-lg font-bold">{{ $userGame->game->title }}</h3>
                    <p>🎮 Plataforma: {{ $userGame->game->platform }}</p>
                    <p>📝 Comentario: {{ $userGame->comment }}</p>
                    <p>⏱️ Horas jugadas: {{ $userGame->hours_played ?? 0 }}h</p>
                    <p>⚔️ Dificultad: {{ $userGame->difficulty ?? 'No especificada' }}</p>
                    <p>📊 Estado: {{ ucfirst($userGame->status ?? 'jugando') }}</p>

                    <div class="w-full bg-gray-200 rounded h-3 mt-2">
                        <div class="bg-blue-600 h-3 rounded" style="width: {{ $userGame->progress }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Progreso: {{ $userGame->progress }}%</p>

                    <p>📅 Inicio: {{ $userGame->started_at ? \Carbon\Carbon::parse($userGame->started_at)->format('d/m/Y') : 'No especificada' }}</p>
                    <p>🏁 Finalización: {{ $userGame->finished_at ? \Carbon\Carbon::parse($userGame->finished_at)->format('d/m/Y') : 'No especificada' }}</p>

                    @if($userGame->status === 'terminado' || $userGame->status === 'rejugando')
                        <p>✅ Completado al 100%: {{ $userGame->completed ? 'Sí' : 'No' }}</p>
                    @endif

                    <div class="flex justify-start space-x-4 mt-4">
                        <button type="button" @click="editId = {{ $userGame->id }}" class="text-blue-600 hover:underline">
                            ✏️ Editar
                        </button>
                        <form action="{{ route('user-games.destroy', $userGame->id) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este juego de tu perfil?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">🗑️ Eliminar</button>
                        </form>
                    </div>

                    {{-- Formulario inline --}}
                    {{-- Formulario inline --}}
<div x-show="editId === {{ $userGame->id }}" x-cloak class="mt-4">
    <form method="POST" action="{{ route('user-games.update', $userGame->id) }}">
        @csrf
        @method('PUT')

        <!-- Comentario -->
        <textarea name="comment" class="w-full border rounded p-2">{{ $userGame->comment }}</textarea>

        <!-- Horas jugadas -->
        <input type="number" name="hours_played" value="{{ $userGame->hours_played }}"
               class="w-full border rounded p-2 mt-2" placeholder="Horas jugadas">

        <!-- Dificultad -->
        <select name="difficulty" class="w-full border rounded p-2 mt-2"
                onchange="toggleCustomDifficultyEdit(this.value, {{ $userGame->id }})">
            <option value="facil" @selected($userGame->difficulty === 'facil')>Fácil</option>
            <option value="normal" @selected($userGame->difficulty === 'normal')>Normal</option>
            <option value="dificil" @selected($userGame->difficulty === 'dificil')>Difícil</option>
            <option value="custom" @selected(!in_array($userGame->difficulty, ['facil','normal','dificil']))>
                Insertar dificultad personalizada
            </option>
        </select>
        <input type="text" name="custom_difficulty" id="custom_difficulty_{{ $userGame->id }}"
               class="w-full border rounded p-2 mt-2 {{ in_array($userGame->difficulty, ['facil','normal','dificil']) ? 'hidden' : '' }}"
               value="{{ !in_array($userGame->difficulty, ['facil','normal','dificil']) ? $userGame->difficulty : '' }}"
               placeholder="Escribe tu dificultad personalizada">

        <!-- Estado -->
        <select name="status" class="w-full border rounded p-2 mt-2">
            <option value="jugando" @selected($userGame->status === 'jugando')>Jugando</option>
            <option value="pausa" @selected($userGame->status === 'pausa')>En pausa</option>
            <option value="terminado" @selected($userGame->status === 'terminado')>Terminado</option>
            <option value="rejugando" @selected($userGame->status === 'rejugando')>Rejugando</option>
             <option value="abandonado" @selected($userGame->status === 'abandonado')>Abandonado</option>

        </select>

        <!-- Completado (condicional) -->
        <div id="completed_wrapper_{{ $userGame->id }}"
             class="{{ in_array($userGame->status, ['terminado','rejugando']) ? '' : 'hidden' }} mt-2">
            <label for="completed">¿Completado al 100%?</label>
            <select name="completed" class="w-full border rounded p-2">
                <option value="0" @selected(!$userGame->completed)>No</option>
                <option value="1" @selected($userGame->completed)>Sí</option>
            </select>
        </div>

        <!-- Progreso -->
        <label class="block mt-2">Progreso (%)</label>
        <input type="range" name="progress" min="0" max="100" value="{{ $userGame->progress }}"
               class="w-full accent-blue-600"
               oninput="document.getElementById('progress_value_{{ $userGame->id }}').textContent = this.value + '%'">
        <span id="progress_value_{{ $userGame->id }}" class="text-sm text-gray-600">{{ $userGame->progress }}%</span>

        <!-- Fechas -->
        <input type="date" name="started_at" value="{{ $userGame->started_at }}"
               class="w-full border rounded p-2 mt-2">
        <input type="date" name="finished_at" value="{{ $userGame->finished_at }}"
               class="w-full border rounded p-2 mt-2">

        <!-- Botones -->
        <div class="flex justify-end space-x-2 mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar
            </button>
            <button type="button" @click="editId = null" class="text-gray-600 hover:underline">
                Cancelar
            </button>
        </div>
    </form>
</div>

                </div>

                @if ($userGame->screenshot_url)
                    <div class="flex-shrink-0">
                        <img src="{{ $userGame->screenshot_url }}" class="w-40 h-40 object-cover rounded shadow">
                    </div>
                @endif
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
