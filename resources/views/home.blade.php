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
            <h3 :class="theme === 'night' ? 'text-spirit border-shadow' : 'text-black border-bluehour'"
                class="border-b pb-2 flex items-center gap-2 uppercase tracking-wide">
                <span>🔥</span> Juegos en progreso
            </h3>

            <div class="space-y-5">
                <!-- Juego 1 -->
                <div class="flex items-center gap-4 group">
                    <img src="https://upload.wikimedia.org/wikipedia/en/3/32/Hollow_Knight_cover.jpg"
                         alt="Hollow Knight"
                         class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-[0_0_10px_#E60012] transition">
                    <div>
                        <p :class="theme === 'night' ? 'text-spirit' : 'text-black'"
                           class="font-semibold group-hover:text-phantom transition">Hollow Knight</p>
                        <div :class="theme === 'night' ? '-urban' : 'bg-bluehour'" class="w-32 rounded-full h-2 mt-1">
                            <div :class="theme === 'night' ? '-phantom' : 'bg-velvet'" class="h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        <p class="text-sm mt-1">
                            Estado: <span :class="theme === 'night' ? 'text-spirit' : 'text-black'">En progreso</span>
                        </p>
                    </div>
                </div>

                <!-- Juego 2 -->
                <div class="flex items-center gap-4 group">
                    <img src="https://upload.wikimedia.org/wikipedia/en/3/3d/Persona_5_cover_art.jpg"
                         alt="Persona 5 Royal"
                         class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-[0_0_10px_#E60012] transition">
                    <div>
                        <p :class="theme === 'night' ? 'text-spirit' : 'text-black'"
                           class="font-semibold group-hover:text-phantom transition">Persona 5 Royal</p>
                        <div :class="theme === 'night' ? '-urban' : 'bg-bluehour'" class="w-32 rounded-full h-2 mt-1">
                            <div :class="theme === 'night' ? '-shadow' : 'bg-velvet'" class="h-2 rounded-full" style="width: 40%"></div>
                        </div>
                        <p class="text-sm mt-1">
                            Estado: <span :class="theme === 'night' ? 'text-spirit' : 'text-black'">Rejugando</span>
                        </p>
                    </div>
                </div>

                <!-- Juego 3 -->
                <div class="flex items-center gap-4 group">
                    <img src="https://upload.wikimedia.org/wikipedia/en/9/9c/Metroid_Dread_cover_art.jpg"
                         alt="Metroid Dread"
                         class="w-14 h-14 rounded-lg shadow-sm group-hover:shadow-[0_0_10px_#E60012] transition">
                    <div>
                        <p :class="theme === 'night' ? 'text-spirit' : 'text-black'"
                           class="font-semibold group-hover:text-phantom transition">Metroid Dread</p>
                        <div :class="theme === 'night' ? '-urban' : 'bg-bluehour'" class="w-32 rounded-full h-2 mt-1">
                            <div :class="theme === 'night' ? '-phantom' : 'bg-velvet'" class="h-2 rounded-full" style="width: 80%"></div>
                        </div>
                        <p class="text-sm mt-1">
                            Estado: <span :class="theme === 'night' ? 'text-spirit' : 'text-black'">Completado</span>
                        </p>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</x-app-layout>
