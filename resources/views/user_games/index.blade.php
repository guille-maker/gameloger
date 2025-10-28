<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">🎮 Mis juegos añadidos</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 space-y-4">
        @foreach ($userGames as $userGame)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">{{ $userGame->game->title }} <span class="text-sm text-gray-500">({{ $userGame->game->platform }})</span></h3>
                <p class="text-sm text-gray-700">Progreso: {{ $userGame->progress }}%</p>
                @if ($userGame->screenshot_url)
                    <p class="text-sm text-blue-600">
                        <a href="{{ $userGame->screenshot_url }}" target="_blank">📸 Ver captura</a>
                    </p>
                @endif
                @if ($userGame->comment)
                    <p class="text-sm text-gray-600 italic">“{{ $userGame->comment }}”</p>
                @endif

                <div class="mt-2 flex gap-4">
                    <a href="#" onclick="event.preventDefault(); openEditModal(@json($userGame))" class="text-blue-600 hover:underline">
    ✏️ Editar
</a>

                    <form method="POST" action="{{ route('user-games.destroy', $userGame->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">🗑️ Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal de edición -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow max-w-md w-full">
            <h2 class="text-xl font-bold mb-4">Editar progreso</h2>
            <form method="POST" action="" id="editForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="game_id" id="edit_game_id">

                <div class="mb-4">
                    <label for="edit_progress" class="block text-sm font-medium text-gray-700">Progreso (%)</label>
                    <input type="number" name="progress" id="edit_progress" min="0" max="100" class="w-full px-3 py-2 border rounded">
                </div>

                <div class="mb-4">
                    <label for="edit_screenshot_url" class="block text-sm font-medium text-gray-700">URL de captura</label>
                    <input type="url" name="screenshot_url" id="edit_screenshot_url" class="w-full px-3 py-2 border rounded">
                </div>

                <div class="mb-4">
                    <label for="edit_comment" class="block text-sm font-medium text-gray-700">Comentario</label>
                    <textarea name="comment" id="edit_comment" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para controlar el modal -->
<script>
    function openEditModal(userGame) {
        document.getElementById('edit_game_id').value = userGame.game_id;
        document.getElementById('edit_progress').value = userGame.progress;
        document.getElementById('edit_screenshot_url').value = userGame.screenshot_url || '';
        document.getElementById('edit_comment').value = userGame.comment || '';
        document.getElementById('editForm').action = `/user-games/${userGame.id}`;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

</x-app-layout>
