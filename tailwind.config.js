import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                
            },
            colors: {
                'red-200': '#FFC6C6',
                'red-300': '#FF8484',
                'red-500': '#FA0000',
                'red-700': '#B30000',
              },
        },
    },
    plugins: [],
};
