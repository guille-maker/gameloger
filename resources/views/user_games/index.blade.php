<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-phantom uppercase tracking-widest">🎮 Mis juegos añadidos</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 space-y-4">
       @foreach ($userGames as $userGame)
    <x-game-card :userGame="$userGame" />
@endforeach

    </div>

    <!-- Modal de edición -->
    <div id="editModal" class="fixed inset-0 -black -opacity-80 flex items-center justify-center hidden z-50">
        <div class="-midnight p-6 rounded-xl border-2 border-phantom shadow-lg max-w-md w-full text-spirit">
            <h2 class="text-xl font-bold mb-4 text-phantom uppercase tracking-wide">Editar juego</h2>
            <form method="POST" action="" id="editForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="game_id" id="edit_game_id">

                <div class="mb-4">
                    <label for="edit_progress" class="block text-sm font-medium text-spirit">Progreso (%)</label>
                    <input type="number" name="progress" id="edit_progress" min="0" max="100"
                           class="w-full px-3 py-2 border border-phantom rounded -urban text-spirit">
                </div>

                <div class="mb-4">
                    <label for="edit_screenshot_url" class="block text-sm font-medium text-spirit">URL de captura</label>
                    <input type="url" name="screenshot_url" id="edit_screenshot_url"
                           class="w-full px-3 py-2 border border-phantom rounded -urban text-spirit">
                </div>

                <div class="mb-4">
                    <label for="edit_comment" class="block text-sm font-medium text-spirit">Comentario</label>
                    <textarea name="comment" id="edit_comment" rows="4"
                              class="w-full px-3 py-2 border border-phantom rounded -urban text-spirit"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 -shadow text-white rounded hover:shadow-[0_0_5px_#B00010] transition">Cancelar</button>
                    <button type="submit" class="px-4 py-2 -phantom text-white rounded hover:shadow-[0_0_5px_#E60012] transition">Guardar</button>
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
