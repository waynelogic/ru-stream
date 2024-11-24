import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Gilroy', ...defaultTheme.fontFamily.sans],
                serif: ['Unbounded', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': {
                    50: '#ece9fe',
                    100: '#dcd7fd',
                    200: '#c1b7fb',
                    300: '#a28df8',
                    400: '#845ff3',
                    500: '#743ee9',
                    600: '#652cd5',
                    700: '#5524b3',
                    800: '#261059',
                    900: '#0b072f',
                    '950': '#00031c',
                },
            },
            animation: {
                bulb: 'bulb 2s ease-in-out infinite',
                wiggle: 'wiggle 1s ease-in-out infinite',
                'gradient-glow': 'gradient-glow 2s linear infinite',
            },
            keyframes: {
                'gradient-glow': {
                    '0%, 100%': {
                        'background-position': '0% 50%',
                        'background-size': '100% 100%'
                    },
                    '50%': {
                        'background-position': '100% 50%;',
                        'background-size': '300% 300%'
                    },
                },
                bulb: {
                    '0%, 100%': { filter: 'drop-shadow(-0.5px -3px 6px #ffe082);' },
                    '50%': { filter: 'drop-shadow(0.5px -4px 4px #ffcd82)' },
                },
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-3deg)' },
                    '50%': { transform: 'rotate(3deg)' },
                }
            }
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
            },
        },
    },

    plugins: [forms, typography],
};
