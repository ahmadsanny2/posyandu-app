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
                sans: ['Inter', 'Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#2563EB', // blue-600
                'app-bg': '#F8FAFC', // slate-50
                'app-text': '#1E293B', // slate-800
                'app-text-muted': '#64748B', // slate-500
            },
        },
    },

    plugins: [forms],
};
