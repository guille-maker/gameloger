<script>
const token = "2|gay8NAUehqRbcfI7taDKZzGEPWhGQIDO0QB0URDta2681bd7";

fetch("/graphql", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer " + token
  },
  body: JSON.stringify({
    query: `query {
       me {
         id
         name
         activities {
           description
           created_at
           game {
             title
             cover_url
           }
         }
         friends {
           id
           name
           activities {
             description
             created_at
             game {
               title
               cover_url
             }
           }
         }
       }
    }`
  })
})
.then(res => res.json())
.then(data => console.log(data));
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 :class="theme === 'night' ? 'text-spirit border-shadow' : 'text-black border-bluehour'"
            class="border-b-4 pb-2 flex items-center gap-2 uppercase tracking-widest transition-all duration-300">
            <span></span> Panel de Actividad
        </h2>
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- 📰 Panel principal -->
        <div class="flex-1 space-y-8">

            <!-- Actividad reciente (propia + amigos) -->
          <div :class="theme === 'night'
    ? '-midnight border-l-4 border-phantom shadow-md hover:shadow-[0_0_10px_#E60012]'
    : 'bg-aegis border-l-4 border-bluehour shadow-md hover:shadow-[0_0_10px_#3F5AA6]'"
    class="p-6 rounded-xl transition">
    <h3 :class="theme === 'night' ? 'text-spirit' : 'text-black'"
        class="text-2xl font-bold mb-4 flex items-center gap-2 uppercase tracking-wide">
        <span>🕹️</span> Actividad reciente
    </h3>

    <ul class="space-y-3" :class="theme === 'night' ? 'text-spirit' : 'text-black'">
        @foreach($activities as $activity)
            <li class="flex items-center gap-4">
                {{-- Imagen cuadrada del juego --}}
                @if($activity->game && $activity->game->cover_url)
            <img src="{{ $activity->game->cover_url }}"
                 alt="{{ $activity->game->title }}"
                 class="w-12 h-12 object-cover rounded shadow">
        @endif

                {{-- Texto de la actividad --}}
                <div class="flex-1">
                    <p>
                        🎮 <strong>{{ $activity->user->name }}</strong> {{ $activity->description }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $activity->created_at->diffForHumans() }}
                    </p>
                </div>

                {{-- Botón eliminar solo si es tuya --}}
                @if($activity->user_id === auth()->id())
                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar esta actividad?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">🗑️</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</div>


            <!-- Juegos populares -->
            <div :class="theme === 'night'
                ? '-urban border-l-4 border-shadow shadow-md hover:shadow-[0_0_10px_#B00010]'
                : 'bg-bluehour border-l-4 border-velvet shadow-md hover:shadow-[0_0_10px_#3F5AA6]'"
                class="p-6 rounded-xl transition">
                <h3 :class="theme === 'night' ? 'text-phantom' : 'text-white'"
                    class="text-2xl font-bold mb-4 flex items-center gap-2 uppercase tracking-wide">
                    <span>🔥</span> Juegos populares
                </h3>
                <ul class="space-y-3" :class="theme === 'night' ? 'text-spirit' : 'text-white'">
                    @foreach($popularGames as $game)
                        <li class="flex items-center gap-4">
                            <img src="{{ $game->cover_url ?? '/img/default-cover.jpg' }}"
                                 alt="{{ $game->title }}"
                                 class="w-12 h-12 rounded shadow">
                            <div>
                                <p class="font-semibold">{{ $game->title }}</p>
                                <p class="text-sm">Plataforma: {{ $game->platform }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div> <!-- cierre del panel principal -->
<!-- 🎮 Panel lateral de juegos activos -->
<aside :class="theme === 'night'
    ? '-midnight border border-phantom shadow-md hover:shadow-[0_0_10px_#E60012]'
    : 'bg-aegis border border-bluehour shadow-md hover:shadow-[0_0_10px_#3F5AA6]'"
    class="w-full lg:w-1/4 p-6 rounded-xl space-y-6 transition">

    <h3 class="text-lg font-bold mb-2">🎮 Tus juegos en progreso</h3>

    {{-- Juegos empezados --}}
    <div>
        <h4 class="font-semibold mb-2">▶️ Empezados</h4>
        @if($gamesStarted->isEmpty())
            <p class="text-gray-500">No tienes juegos empezados.</p>
        @else
            <ul class="space-y-4">
                @foreach($gamesStarted as $userGame)
                    <li class="flex items-center gap-4">
                        <img src="{{ $userGame->game->cover_url ?? '/img/default-cover.jpg' }}"
                             alt="{{ $userGame->game->title }}"
                             class="w-14 h-14 rounded shadow object-cover">
                        <div>
                            <p class="font-semibold">{{ $userGame->game->title }}</p>
                            <p class="text-sm">Estado: {{ ucfirst($userGame->status) }}</p>
                            <p class="text-sm">Progreso: {{ $userGame->progress ?? 0 }}%</p>
                            <p class="text-sm">Horas jugadas: {{ $userGame->hours_played ?? 0 }}h</p>
                            <p class="text-sm">Dificultad: {{ $userGame->difficulty ?? 'N/A' }}</p>
                            </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Juegos en pausa --}}
    <div>
        <h4 class="font-semibold mb-2">⏸️ En pausa</h4>
        @if($gamesPaused->isEmpty())
            <p class="text-gray-500">No tienes juegos en pausa.</p>
        @else
            <ul class="space-y-4">
                @foreach($gamesPaused as $userGame)
                    <li class="flex items-center gap-4">
                        <img src="{{ $userGame->game->cover_url ?? '/img/default-cover.jpg' }}"
                             alt="{{ $userGame->game->title }}"
                             class="w-14 h-14 rounded shadow object-cover">
                        <div>
                            <p class="font-semibold">{{ $userGame->game->title }}</p>
                            <p class="text-sm">Estado: {{ ucfirst($userGame->status) }}</p>
                            <p class="text-sm">Progreso: {{ $userGame->progress ?? 0 }}%</p>
                            <p class="text-sm">Horas jugadas: {{ $userGame->hours_played ?? 0 }}h</p>
                            <p class="text-sm">Dificultad: {{ $userGame->difficulty ?? 'N/A' }}</p>
                            
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</aside>

    </div> <!-- cierre del flex principal -->
</x-app-layout>
