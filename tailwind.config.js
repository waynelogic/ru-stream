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
        },
        container: {
            center: true,
        },
    },

    plugins: [forms, typography],
};
