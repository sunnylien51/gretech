/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './source/**/*.blade.php',
        './source/**/*.js',
        './source/**/*.php',
        './source/**/*.html',
        './source/**/*.md',
        './config.php',
    ],
    safelist: [
        'bg-gradient',
        {
            pattern: /text-(cb[23]|ch[23]|eb[23]|eh[1-3])/,
            variants: ['md', 'lg'],
        },
        {
            pattern: /^(bg|text|border|outline|ring|fill|stroke)-(main[1-3]|gray[1-5]|bg|white)(\/\d+)?$/,
            variants: ['hover', 'focus', 'active', 'md', 'lg'],
        },
        {
            pattern: /^opacity-(0|5|10|20|25|30|40|50|60|70|75|80|90|95|100)$/,
            variants: ['hover', 'md', 'lg'],
        },
        {
            pattern: /^(bg|text|border)-(black|white)\/(5|10|20|25|30|40|50|60|70|75|80|90|95)$/,
            variants: ['hover', 'md', 'lg'],
        },
    ],
    theme: {
        screens: {
            'md': '800px',
            'lg': '1200px',
        },
        extend: {
            colors: {
                main1: '#592678',
                main2: '#9969B7',
                main3: '#DAD2EB',
                gray5: '#0C0B12',
                gray4: '#57575B',
                gray3: '#7B7C86',
                gray2: '#C0BFC7',
                gray1: '#E5E6E9',
                bg: '#F5F4F6',
                white: '#FFFFFF',
            },
            backgroundImage: {
                gradient: 'radial-gradient(at 0% 0%, #E2DDF5CC 0%, #F6F7FA99 60%, #F5F4F6 100%)',
            },
            fontFamily: {
                sans: ['Noto Sans TC', 'sans-serif'],
                outfit: ['Outfit', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
