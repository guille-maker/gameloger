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
        games {
          title
          status
          cover_url
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

        <!-- 📰 Panel de actividad principal -->
        <div class="flex-1 space-y-8">

            <!-- Actividad reciente -->
            <div :class="theme === 'night'
                ? '-midnight border-l-4 border-phantom shadow-md hover:shadow-[0_0_10px_#E60012]'
                : 'bg-aegis border-l-4 border-bluehour shadow-md hover:shadow-[0_0_10px_#3F5AA6]'"
                class="p-6 rounded-xl transition">
                <h3 :class="theme === 'night' ? 'text-spirit' : 'text-black'"
                    class="text-2xl font-bold mb-4 flex items-center gap-2 uppercase tracking-wide">
                    <span>🕹️</span> Tu actividad reciente
                </h3>
                <ul class="space-y-3" :class="theme === 'night' ? 'text-spirit' : 'text-black'">
                    <li class="flex items-center gap-2">
                        <span :class="theme === 'night' ? 'text-phantom' : 'text-velvet'">🎮</span>
                        Jugaste <strong :class="theme === 'night' ? 'text-shadow' : 'text-black'">Zelda: Tears of the Kingdom</strong>
                        durante <span :class="theme === 'night' ? 'text-phantom' : 'text-velvet'">2h</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span :class="theme === 'night' ? 'text-shadow' : 'text-black'">📝</span>
                        Publicaste un post sobre <strong :class="theme === 'night' ? 'text-spirit' : 'text-black'">Hollow Knight</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <span :class="theme === 'night' ? 'text-phantom' : 'text-velvet'">👥</span>
                        Tu amiga <strong :class="theme === 'night' ? 'text-spirit' : 'text-black'">Laura</strong> completó
                        <strong :class="theme === 'night' ? 'text-shadow' : 'text-black'">Celeste</strong>
                    </li>
                </ul>
            </div>

            <!-- Actividad de amigos -->
            <div :class="theme === 'night'
                ? '-urban border-l-4 border-shadow shadow-md hover:shadow-[0_0_10px_#B00010]'
                : 'bg-bluehour border-l-4 border-velvet shadow-md hover:shadow-[0_0_10px_#3F5AA6]'"
                class="p-6 rounded-xl transition">
                <h3 :class="theme === 'night' ? 'text-phantom' : 'text-white'"
                    class="text-2xl font-bold mb-4 flex items-center gap-2 uppercase tracking-wide">
                    <span>💬</span> Actividad de tus amigos
                </h3>
                <ul class="space-y-3" :class="theme === 'night' ? 'text-spirit' : 'text-white'">
                    <li class="flex items-center gap-2">
                        <span :class="theme === 'night' ? 'text-phantom' : 'text-velvet'">🎮</span>
                        <strong :class="theme === 'night' ? 'text-shadow' : 'text-white'">David</strong> empezó
                        <strong :class="theme === 'night' ? 'text-spirit' : 'text-white'">Final Fantasy VII Remake</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <span :class="theme === 'night' ? 'text-shadow' : 'text-white'">📝</span>
                        <strong :class="theme === 'night' ? 'text-spirit' : 'text-white'">Lucía</strong> publicó una reseña de
                        <strong :class="theme === 'night' ? 'text-shadow' : 'text-white'">Stardew Valley</strong>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 🎮 Panel lateral de juegos activos -->
<aside :class="theme === 'night'
    ? '-midnight border border-phantom shadow-md hover:shadow-[0_0_10px_#E60012]'
    : 'bg-aegis border border-bluehour shadow-md hover:shadow-[0_0_10px_#3F5AA6]'"
    class="w-full lg:w-1/4 p-6 rounded-xl space-y-6 transition">
    <h3 class="text-lg font-bold mb-2">🎮 Tus juegos</h3>

@if($games->isEmpty())
    <p class="text-gray-500">No tienes juegos guardados aún.</p>
@else
    <ul class="space-y-4">
        @foreach($games as $game)
            <li class="flex items-center gap-4">
                <img src="{{ $game->cover_url ?? '/img/default-cover.jpg' }}"
                     alt="{{ $game->title }}"
                     class="w-14 h-14 rounded shadow">
                <div>
                    <p class="font-semibold">{{ $game->title }}</p>
                    <p class="text-sm">Estado: {{ ucfirst($game->status) }}</p>
                    @if($game->pivot)
                        <p class="text-sm">Progreso: {{ $game->pivot->progress ?? 'N/A' }}</p>
                        <p class="text-sm">Comentario: {{ $game->pivot->comment ?? 'Sin comentario' }}</p>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
@endif

</aside>


    </div>
    <script>
document.addEventListener("DOMContentLoaded", () => {
  fetch("/graphql", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    credentials: "include",
    body: JSON.stringify({
      query: `query {
        me {
          games {
            id
            title
            status
            cover_url
          }
        }
      }`
    })
  })
  .then(res => res.json())
  .then(data => {
    const container = document.getElementById("juegos-activos");
    container.innerHTML = "";

    const juegos = data.data.me.games.filter(juego =>
      ["empezado", "en curso", "rejugando"].includes(juego.status)
    );

    if (juegos.length === 0) {
      container.innerHTML = "<p class='text-gray-500'>No estás jugando ningún juego actualmente.</p>";
      return;
    }

    juegos.forEach(juego => {
      const estado = juego.status.charAt(0).toUpperCase() + juego.status.slice(1);
      const progreso = {
        "empezado": "20%",
        "en curso": "50%",
        "rejugando": "40%",
        "completado": "100%"
      }[juego.status] || "30%";

      const html = `
        <div class="flex items-center gap-4 group">
          <img src="${juego.cover_url || '/img/default-cover.jpg'}"
               alt="${juego.title}"
               class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-[0_0_10px_#E60012] transition">
          <div>
            <p class="font-semibold group-hover:text-phantom transition">${juego.title}</p>
            <div class="w-32 rounded-full h-2 mt-1 bg-bluehour">
              <div class="h-2 rounded-full bg-velvet" style="width: ${progreso}"></div>
            </div>
            <p class="text-sm mt-1">Estado: <span>${estado}</span></p>
          </div>
        </div>
      `;
      container.innerHTML += html;
    });
  });
});
</script>

</x-app-layout>
