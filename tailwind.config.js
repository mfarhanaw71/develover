/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                battlesbridge: ['Battlesbridge', 'sans-serif'],
            },
            colors: {
                primary: '#068CE6',
                'primary-hover': '#27B1FE',
                'primary-dark': '#0573b8',
                'primary-light': '#4daef7',
                accent: '#008CA9',
                'accent-light': '#64D5E5',
                'accent-dark': '#006f86',
                'bg-light': '#f0faff',
            },
            // 🔵 TAMBAHKAN INI:
            boxShadow: {
                'card': '0 4px 20px rgba(6, 140, 230, 0.10)',
                'card-hover': '0 8px 30px rgba(6, 140, 230, 0.18)',
            },
        },
    },
    plugins: [],
};