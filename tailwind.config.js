import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                primary: {
                    50:  '#f0f4ff',
                    100: '#e0e9ff',
                    200: '#c0d4ff',
                    300: '#91b4ff',
                    400: '#6090ff',
                    500: '#3b6bff',
                    600: '#2952f5',
                    700: '#1e3ce0',
                    800: '#1830b5',
                    900: '#172b8f',
                },
                accent: {
                    400: '#f472b6',
                    500: '#ec4899',
                    600: '#db2777',
                },
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
        },
    },

    plugins: [forms],
};
