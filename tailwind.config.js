import defaultTheme from 'tailwindcss/defaultTheme';

// eslint-disable-next-line no-undef
const plugin = require('tailwindcss/plugin')

/** @type {import('tailwindcss').Config} */
export default {
    prefix: '',
    darkMode: 'class',
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './resources/js/components/**/*.vue', 
    ],
    theme: {
        extend: {
            // colors: {
            //     'primary': {
            //         800: '#e1e5eb',
            //         900: '#f4f1f0',
            //         950: '#FCF9F8',
            //     },
            //     'primary-dark': {
            //         800: '#1D2128',//#1D2128 //#13171d //#121216
            //         900: '#211E1D',
            //         950: '#121216',//original: #121216 rtc: #161312 figma: 
            //     }

            // },
            colors: { // Default
                'primary': {
                    800: '#f4f4f5',
                    900: '#fafafa',
                    950: '#FCF9F8',
                },
                'primary-dark': {
                    800: '#27272a', // Card
                    900: '#18181b', // Panel
                    950: '#101016', // bg
                },
                'secondary': {},
                'accent': {
                    500: '#f59e0b',
                    600: '#ea580c'
                },
                'text': {},
                'input': {
                    100: '#F9F9F9', // Light bg
                    200: '#D8D8D8', // Light outline
                    800: '#212529', // Datatables bg dark
                    900: '#505056', // Dark bg
                    950: '#2D2D2d', // Darl outline
                },
                'button': {
                    100: '#E3E2E5', // Light primary
                    200: '#D2D2D2', // Light secondary
                    900: '#2F2F33', // Dark primary
                    950: '#2F2F33', // Dark secondary
                }
            },
            aspectRatio: {
                'video': '16 / 9',
                'square': '1 / 1',
                'portrait': '9 / 16'
            },
        },
    },
    variants: {
        extend: {
            visibility: ["group-hover"],
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        plugin(function({ addVariant }) {
            addVariant('hocus', ['&:hover', '&:focus'])
        }),
        // eslint-disable-next-line no-undef
        require('@tailwindcss/forms'),
        // eslint-disable-next-line no-undef
        require('@tailwindcss/aspect-ratio'),
    ]
}

