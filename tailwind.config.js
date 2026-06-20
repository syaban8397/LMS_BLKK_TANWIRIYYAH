import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', 'Inter', 'system-ui', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#f0f6fb',
                    100: '#dceaf5',
                    200: '#b8d4ea',
                    300: '#7fb0d9',
                    400: '#4589c1',
                    500: '#004071',
                    600: '#003560',
                    700: '#0c2340',
                    800: '#061525',
                    900: '#030b14',
                },
                brand: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                accent: {
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                },
                surface: {
                    light: '#f8fafc',
                    card: '#ffffff',
                    dark: '#0f172a',
                    'card-dark': '#1e293b',
                },
            },
            borderRadius: {
                xl: '1rem',
                '2xl': '1.25rem',
                '3xl': '1.5rem',
            },
            boxShadow: {
                '3d-sm': '0 1px 2px 0 rgba(15, 23, 42, 0.08), inset 0 1px 0 0 rgba(255, 255, 255, 0.1)',
                '3d-md': '0 2px 4px -1px rgba(15, 23, 42, 0.1), 0 1px 2px -1px rgba(15, 23, 42, 0.06), inset 0 1px 0 0 rgba(255, 255, 255, 0.12)',
                '3d-lg': '0 4px 8px -2px rgba(15, 23, 42, 0.12), 0 2px 4px -2px rgba(15, 23, 42, 0.08), inset 0 1px 0 0 rgba(255, 255, 255, 0.14)',
                '3d-xl': '0 8px 16px -4px rgba(15, 23, 42, 0.14), 0 4px 8px -4px rgba(15, 23, 42, 0.1), inset 0 1px 0 0 rgba(255, 255, 255, 0.16)',
                'glow-brand': '0 0 0 3px rgba(37, 99, 235, 0.15)',
                'dark-3d-sm': '0 1px 2px 0 rgba(0, 0, 0, 0.35), inset 0 1px 0 0 rgba(255, 255, 255, 0.05)',
                'dark-3d-md': '0 2px 4px -1px rgba(0, 0, 0, 0.4), inset 0 1px 0 0 rgba(255, 255, 255, 0.06)',
                'dark-3d-lg': '0 4px 8px -2px rgba(0, 0, 0, 0.45), inset 0 1px 0 0 rgba(255, 255, 255, 0.08)',
            },
            animation: {
                'float-slow': 'floatSlow 6s ease-in-out infinite',
                'fade-up': 'fadeUp 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards',
                'card-pop': 'cardPop 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards',
            },
            keyframes: {
                floatSlow: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-8px)' },
                },
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                cardPop: {
                    '0%': { opacity: '0', transform: 'scale(0.96) translateY(16px)' },
                    '100%': { opacity: '1', transform: 'scale(1) translateY(0)' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },

    plugins: [forms],
};
