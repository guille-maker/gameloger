<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-dark flex items-center gap-2 border-b-4 border-primary pb-2">
            <span>🎮</span> Panel de Actividad
        </h2>
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- 📰 Panel de actividad principal -->
        <div class="flex-1 space-y-8">

            <!-- Actividad reciente -->
            <div class="bg-light p-6 rounded-2xl shadow-md border-l-4 border-primary hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-accent mb-4 flex items-center gap-2">
                    <span>🕹️</span> Tu actividad reciente
                </h3>
                <ul class="space-y-3 text-dark">
                    <li class="flex items-center gap-2">
                        <span class="text-primary">🎮</span> Jugaste <strong>Zelda: Tears of the Kingdom</strong> durante 2h
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-secondary">📝</span> Publicaste un post sobre <strong>Hollow Knight</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-accent">👥</span> Tu amiga <strong>Laura que vive a 2km de ti</strong> completó <strong>Celeste</strong>
                    </li>
                </ul>
            </div>

            <!-- Actividad de amigos -->
            <div class="bg-light p-6 rounded-2xl shadow-md border-l-4 border-secondary hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-accent mb-4 flex items-center gap-2">
                    <span>💬</span> Actividad de tus amigos
                </h3>
                <ul class="space-y-3 text-dark">
                    <li class="flex items-center gap-2">
                        <span class="text-primary">🎮</span> <strong>David</strong> empezó <strong>Final Fantasy VII Remake</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-secondary">📝</span> <strong>Lucía</strong> publicó una reseña de <strong>Stardew Valley</strong>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 🎮 Panel lateral de juegos activos -->
        <aside class="w-full lg:w-1/4 bg-light p-6 rounded-2xl shadow-md border border-accent/20 space-y-6 hover:shadow-lg transition">
            <h3 class="text-xl font-semibold text-accent border-b border-accent/30 pb-2 flex items-center gap-2">
                <span>🔥</span> Juegos en progreso
            </h3>

            <div class="space-y-5">
                <!-- Juego -->
                <div class="flex items-center gap-4 group">
                    <img src="https://upload.wikimedia.org/wikipedia/en/3/32/Hollow_Knight_cover.jpg"
                         alt="Hollow Knight"
                         class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-md transition">
                    <div>
                        <p class="font-semibold text-dark group-hover:text-primary transition">Hollow Knight</p>
                        <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-primary h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Progreso: 65%</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 group">
                    <img src="https://upload.wikimedia.org/wikipedia/en/3/3d/Persona_5_cover_art.jpg"
                         alt="Persona 5 Royal"
                         class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-md transition">
                    <div>
                        <p class="font-semibold text-dark group-hover:text-primary transition">Persona 5 Royal</p>
                        <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-secondary h-2 rounded-full" style="width: 40%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Progreso: 40%</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 group">
                    <img src="https://upload.wikimedia.org/wikipedia/en/9/9c/Metroid_Dread_cover_art.jpg"
                         alt="Metroid Dread"
                         class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-md transition">
                    <div>
                        <p class="font-semibold text-dark group-hover:text-primary transition">Metroid Dread</p>
                        <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-accent h-2 rounded-full" style="width: 80%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Progreso: 80%</p>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</x-app-layout>
