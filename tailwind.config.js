import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.css',
    ],
    safelist: [
        'bg-green-600',
        'bg-gray-300',
        'text-green-600',
        'text-gray-500',
        'text-gray-800',
        'text-gray-700',
        'text-orange-500',
        'grid-cols-[auto_min-content_auto]',
        'h-[1px]',
        'absolute',
        'left-0',
        'top-0',
        'w-1',
        'h-10',
        'my-2',
        'mx-4',
        'relative',
        'cursor-not-allowed',
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
                'hero-image': "linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), url('/images/hero-bg.png')",
                'footer-image': "linear-gradient(rgba(50, 50, 50, 0.8), rgba(50, 50, 50, 0.8)), url('/images/footer-bg.png')",
                'chat-admin': "url('/images/bg-chat-admin.png')",
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
