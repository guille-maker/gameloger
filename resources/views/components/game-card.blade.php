@props(['userGame'])

<div class="-midnight p-4 rounded-xl border-2 border-phantom shadow-md hover:shadow-[0_0_10px_#E60012] transition">
    <h3 class="text-xl font-bold text-spirit uppercase tracking-wide">
        {{ $userGame->game->title }}
        <span class="text-sm text-shadow">({{ $userGame->game->platform }})</span>
    </h3>

    <p class="text-sm text-spirit mt-1">Estado: <span class="text-phantom font-semibold">{{ $userGame->estado ?? 'Sin estado' }}</span></p>

    @if ($userGame->screenshot_url)
        <p class="text-sm mt-1">
            <a href="{{ $userGame->screenshot_url }}" target="_blank" class="text-phantom hover:underline">📸 Ver captura</a>
        </p>
    @endif

    @if ($userGame->comment)
        <p class="text-sm text-shadow italic mt-1">“{{ $userGame->comment }}”</p>
    @endif

    <div class="mt-3 flex gap-4">
        <a href="#" onclick="event.preventDefault(); openEditModal(@json($userGame))"
           class="text-spirit hover:text-phantom hover:underline hover:shadow-[0_0_5px_#E60012] transition">✏️ Editar</a>

        <form method="POST" action="{{ route('user-games.destroy', $userGame->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-shadow hover:text-phantom hover:underline hover:shadow-[0_0_5px_#E60012] transition">🗑️ Eliminar</button>
        </form>
    </div>
</div>
