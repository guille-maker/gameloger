<nav x-data="{ open: false }">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('img/logo2.png') }}" alt="Logo"
                         :class="theme === 'night' ? 'h-12 drop-shadow-[0_0_5px_#E60012]' : 'h-12 drop-shadow-[0_0_5px_#3F5AA6]'">
                </a>

                <!-- Enlaces -->
                <div class="hidden sm:flex gap-6 text-lg font-semibold">
                    <a href="{{ route('home') }}"
                       :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'"
                       class="transition">Inicio</a>
                    <a href="{{ route('profile.edit') }}"
                       :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'"
                       class="transition">Perfil</a>
                    <a href="{{ route('games.index') }}"
                       :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'"
                       class="transition">Juegos</a>
                    <a href="{{ route('posts.index') }}"
                       :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'"
                       class="transition">Posts</a>
                </div>
            </div>

            <!-- Botón de tema -->
            <button @click="theme = theme === 'night' ? 'day' : 'night'"
                    :class="theme === 'night' ? 'bg-phantom' : 'bg-velvet'"
                    class="px-3 py-2 text-white rounded hover:shadow transition uppercase tracking-wide">
                Cambiar tema
            </button>
        </div>
    </div>

    <!-- Menú responsive -->
    <div class="sm:hidden px-4 pt-2 pb-4" x-show="open" x-transition>
        <a href="{{ route('home') }}"
           :class="theme === 'night' ? 'text-spirit hover:text-phantom' : 'text-bluehour hover:text-velvet'"
           class="block py-2 font-semibold transition">Inicio</a>
        <a href="{{ route('profile.edit') }}"
           :class="theme === 'night' ? 'text-spirit hover:text-phantom' : 'text-bluehour hover:text-velvet'"
           class="block py-2 font-semibold transition">Perfil</a>
        <a href="{{ route('games.index') }}"
           :class="theme === 'night' ? 'text-spirit hover:text-phantom' : 'text-bluehour hover:text-velvet'"
           class="block py-2 font-semibold transition">Juegos</a>
        <a href="{{ route('posts.index') }}"
           :class="theme === 'night' ? 'text-spirit hover:text-phantom' : 'text-bluehour hover:text-velvet'"
           class="block py-2 font-semibold transition">Posts</a>
    </div>
</nav>
