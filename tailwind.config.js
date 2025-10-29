import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

  theme: {
    extend: {
      colors: {
       phantom: '#E60012',
        midnight: '#0A0A0A',
        spirit: '#F4F4F4',
        urban: '#2C2C2C',
        shadow: '#B00010',
        
        // Modo día (Persona 3)
      aegis: '#DDE6F0',       // Fondo claro
      bluehour: '#1B3B6F',    // Azul profundo
      velvet: '#3F5AA6',      // Azul vibrante
      silver: '#F8F9FA',      // Blanco puro
      },
    },
  },
safelist: [
    'bg-phantom', 'bg-midnight', 'bg-spirit', 'bg-shadow', 'bg-urban',
    'text-phantom', 'text-midnight', 'text-spirit', 'text-shadow', 'text-urban',
    'border-phantom', 'border-shadow', 'hover:text-phantom', 'hover:shadow-[0_0_10px_#E60012]'
  ],
    plugins: [forms],
};
