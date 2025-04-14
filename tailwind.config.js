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
                sans: ['Poppins', 'sans-serif'],
            },
            colors: {
                'red-200': '#FFC6C6',
                'red-300': '#FF8484',
                'red-500': '#FA0000',
                'red-700': '#B30000',
            },
            backgroundImage: {
                'hero-image': "linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), url('/public/images/hero-bg.png')",
                'footer-image': "linear-gradient(rgba(50, 50, 50, 0.8), rgba(50, 50, 50, 0.8)), url('/public/images/hero-bg.png')",
                'chat-admin': "url('/public/images/bg-chat-admin.png')",
            },
            keyframes: {
                typing: {
                    'from': { width: '0' },
                    'to': { width: '100%' },
                },
            },
            animation: {
                typing: 'typing 1s steps(30, end) forwards',
            },
        },
    },
    plugins: [],
};
