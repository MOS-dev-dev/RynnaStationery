const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
                beige: {
                    50: '#fdfcfb',
                    100: '#f9f6f2',
                    200: '#f0eade',
                    300: '#e8decb',
                    400: '#d9c9ae',
                    500: '#cbb692',
                },
                earth: {
                    50: '#f5f2f0',
                    100: '#ece5e1',
                    200: '#d0c2ba',
                    300: '#b49f93',
                    400: '#987c6c',
                    500: '#7c5945',
                },
                sepia: {
                    500: '#704214',
                    600: '#5a3510',
                    700: '#46290c',
                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
