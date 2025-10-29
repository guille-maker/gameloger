<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{
    theme: localStorage.getItem('theme') || 'night',
    themeClasses: {
        bg: '',
        text: '',
        border: '',
        accent: '',
        hoverShadow: ''
    }
}"
x-init="
    themeClasses = theme === 'night'
        ? {
            bg: 'bg-midnight',
            text: 'text-spirit',
            border: 'border-phantom',
            accent: 'text-phantom',
            hoverShadow: 'hover:shadow-[0_0_10px_#E60012]'
        }
        : {
            bg: 'bg-aegis',
            text: 'text-shadow',
            border: 'border-bluehour',
            accent: 'text-bluehour',
            hoverShadow: 'hover:shadow-[0_0_10px_#3F5AA6]'
        };

    $watch('theme', val => {
        localStorage.setItem('theme', val);
        themeClasses = val === 'night'
            ? {
                bg: 'bg-midnight',
                text: 'text-spirit',
                border: 'border-phantom',
                accent: 'text-phantom',
                hoverShadow: 'hover:shadow-[0_0_10px_#E60012]'
            }
            : {
                bg: 'bg-aegis',
                text: 'text-shadow',
                border: 'border-bluehour',
                accent: 'text-bluehour',
                hoverShadow: 'hover:shadow-[0_0_10px_#3F5AA6]'
            };
});
"
:class="themeClasses.bg + ' ' + themeClasses.text"
class="font-sans antialiased transition-colors duration-300">




    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header :class="theme === 'night' ? 'bg-phantom text-white border-b-4 border-shadow shadow-[0_0_10px_#E60012]' : 'bg-velvet text-white border-b-4 border-bluehour shadow-[0_0_10px_#3F5AA6]'">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 uppercase tracking-widest">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
