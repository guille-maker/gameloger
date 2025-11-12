<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">🎮 Añadir juego a mi perfil</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow text-black">
        <form method="POST" action="{{ route('user-games.store') }}">
            @csrf

            <!-- Juego -->
            <div class="mb-4">
                <label for="game_id" class="block text-sm font-medium text-gray-700">Selecciona un juego</label>
                <select name="game_id" id="game_id" required class="w-full px-3 py-2 border rounded"></select>
            </div>

            <!-- Horas jugadas -->
            <div class="mb-4">
                <label for="hours_played" class="block text-sm font-medium text-gray-700">Horas jugadas</label>
                <input type="number" name="hours_played" id="hours_played" min="0"
                       class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Dificultad -->
            <div class="mb-4">
                <label for="difficulty" class="block text-sm font-medium text-gray-700">Dificultad</label>
                <select name="difficulty" id="difficulty" class="w-full px-3 py-2 border rounded"
                        onchange="toggleCustomDifficulty(this.value)">
                    <option value="facil">Fácil</option>
                    <option value="normal">Normal</option>
                    <option value="dificil">Difícil</option>
                    <option value="custom">Insertar dificultad personalizada</option>
                </select>
                <input type="text" name="custom_difficulty" id="custom_difficulty"
                       class="w-full px-3 py-2 border rounded mt-2 hidden"
                       placeholder="Escribe tu dificultad personalizada">
            </div>

            <!-- Estado del juego -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Estado del juego</label>
                <select name="status" id="status" class="w-full px-3 py-2 border rounded">
                    <option value="jugando">Jugando</option>
                    <option value="pausa">En pausa</option>
                    <option value="terminado">Terminado</option>
                    <option value="rejugando">Rejugando</option>
                </select>
            </div>

            <!-- Progreso con slider -->
            <div class="mb-4">
                <label for="progress" class="block text-sm font-medium text-gray-700">Progreso (%)</label>
                <input type="range" name="progress" id="progress" min="0" max="100" value="0"
                       class="w-full accent-blue-600">
                <span id="progress_value" class="text-sm text-gray-600">0%</span>
            </div>

            <!-- Fecha de finalización (opcional) -->
            <div class="mb-4">
                <label for="finished_at" class="block text-sm font-medium text-gray-700">Fecha de finalización</label>
                <input type="date" name="finished_at" id="finished_at"
                       class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Comentario -->
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comentario</label>
                <textarea name="comment" id="comment" rows="4"
                          class="w-full px-3 py-2 border rounded"></textarea>
            </div>

            <!-- Botón -->
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Guardar en mi perfil
            </button>
        </form>
    </div>

    <!-- TomSelect scripts -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // TomSelect para buscar juegos
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

            // Slider de progreso
            const slider = document.getElementById('progress');
            const output = document.getElementById('progress_value');
            slider.addEventListener('input', () => {
                output.textContent = slider.value + '%';
            });
        });

        // Mostrar input personalizado si se selecciona "custom"
        function toggleCustomDifficulty(value) {
            const customInput = document.getElementById('custom_difficulty');
            if (value === 'custom') {
                customInput.classList.remove('hidden');
            } else {
                customInput.classList.add('hidden');
                customInput.value = '';
            }
        }
    </script>
</x-app-layout>
