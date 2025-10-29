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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                solDorado: '#FFC43D',
                nubeSuave: '#F8FFE5',
                verdeNeon: '#06D6A0',
                azulClaro: '#1B9AAA',
                rosaImpacto: '#EF476F',
            },
        },
    },

    plugins: [forms],
};
