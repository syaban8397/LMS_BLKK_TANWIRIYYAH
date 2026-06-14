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
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
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
                '3d-sm': '0 2px 0 0 rgba(15, 23, 42, 0.06), 0 4px 8px -2px rgba(15, 23, 42, 0.12), inset 0 1px 0 0 rgba(255, 255, 255, 0.6)',
                '3d-md': '0 4px 0 0 rgba(15, 23, 42, 0.08), 0 8px 20px -4px rgba(15, 23, 42, 0.18), inset 0 1px 0 0 rgba(255, 255, 255, 0.65)',
                '3d-lg': '0 6px 0 0 rgba(15, 23, 42, 0.1), 0 16px 32px -8px rgba(15, 23, 42, 0.22), inset 0 1px 0 0 rgba(255, 255, 255, 0.7)',
                '3d-xl': '0 8px 0 0 rgba(15, 23, 42, 0.12), 0 24px 48px -12px rgba(15, 23, 42, 0.28), inset 0 1px 0 0 rgba(255, 255, 255, 0.75)',
                'glow-brand': '0 0 24px -4px rgba(37, 99, 235, 0.45)',
                'dark-3d-sm': '0 2px 0 0 rgba(0, 0, 0, 0.35), 0 4px 12px -2px rgba(0, 0, 0, 0.5), inset 0 1px 0 0 rgba(255, 255, 255, 0.06)',
                'dark-3d-md': '0 4px 0 0 rgba(0, 0, 0, 0.4), 0 10px 24px -4px rgba(0, 0, 0, 0.55), inset 0 1px 0 0 rgba(255, 255, 255, 0.08)',
                'dark-3d-lg': '0 6px 0 0 rgba(0, 0, 0, 0.45), 0 16px 36px -8px rgba(0, 0, 0, 0.6), inset 0 1px 0 0 rgba(255, 255, 255, 0.1)',
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
