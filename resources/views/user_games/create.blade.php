<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">🎮 Añadir juego a mi perfil</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow text-black">
        <form method="POST" action="{{ route('user-games.store') }}">
            @csrf

            <div class="mb-4">
                <label for="game_id" class="block text-sm font-medium text-gray-700">Selecciona un juego</label>
                <select name="game_id" id="game_id" required class="w-full px-3 py-2 border rounded"></select>
            </div>

            <div class="mb-4">
                <label for="progress" class="block text-sm font-medium text-gray-700">Progreso (%)</label>
                <input type="number" name="progress" id="progress" min="0" max="100" value="0" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comentario</label>
                <textarea name="comment" id="comment" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar en mi perfil
            </button>
        </form>
    </div>

    <!-- TomSelect scripts -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new TomSelect('#game_id', {
                valueField: 'value',
                labelField: 'text',
                searchField: 'text',
                placeholder: 'Busca un juego...',
                maxOptions: 20,
                loadThrottle: 300,
                loadingClass: 'loading',
                preload: false,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    fetch(`/api/games/search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(callback)
                        .catch(() => callback());
                }
            });
        });
    </script>
</x-app-layout>
