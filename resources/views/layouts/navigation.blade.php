<nav x-data="{ open: false }" class="relative">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
         <!-- Logo a la izquierda -->
         <div class="flex-shrink-0">
            <a href="{{ route('dashboard') }}">
               <img src="{{ asset('img/logo2.png') }}" alt="Logo"
                  :class="theme === 'night' ? 'h-12 drop-shadow-[0_0_5px_#E60012]' : 'h-12 drop-shadow-[0_0_5px_#3F5AA6]'">
            </a>
         </div>

         <!-- Enlaces centrados -->
         <div class="flex-1 flex justify-center">
            <div class="hidden sm:flex gap-8 text-lg font-semibold">
               <a href="{{ route('home') }}" :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'"
                  class="transition">Inicio</a>
               <a href="{{ route('profile.edit') }}"
                  :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'" class="transition">Perfil</a>
               <a href="{{ route('profile.edit') }}"
                  :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'" class="transition">Mis juegos</a>
               <a href="{{ route('games.index') }}"
                  :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'" class="transition">Listado juegos</a>
               <a href="{{ route('posts.index') }}"
                  :class="theme === 'night' ? 'hover:text-phantom' : 'hover:text-velvet'" class="transition">Posts</a>
                  
            </div>
         </div>

         <!-- Icono de usuario a la derecha -->
         @auth
         <div class="flex-shrink-0 relative" x-data="{ openProfileMenu: false }">
            <button @click="openProfileMenu = !openProfileMenu" class="flex items-center focus:outline-none">
               <img src="{{ Auth::user()->profile_photo_url ?? asset('img/icono.webp') }}" alt="Avatar"
                  class="w-8 h-8 rounded-full border border-gray-300">
            </button>

            <div x-show="openProfileMenu" @click.away="openProfileMenu = false" x-transition
               class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 text-sm text-gray-700">
               <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">👤 Mi perfil</a>
               <a href="{{ route('profile.edit') }}#config" class="block px-4 py-2 hover:bg-gray-100">⚙️ Configuración</a>
               <a href="#" @click="theme = theme === 'night' ? 'day' : 'night'"
                  class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
                  🌗 <span>Cambiar tema</span>
               </a>
               <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">🚪 Cerrar sesión</button>
               </form>
            </div>
         </div>
         @endauth
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
