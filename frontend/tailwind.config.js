/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        primary: { DEFAULT: '#4f46e5', hover: '#4338ca', soft: '#eef2ff' },
        ink: '#0f172a',
        muted: '#64748b',
        surface: '#ffffff',
        canvas: '#f4f6fb',
        line: '#e8ecf4',
        sidebar: '#0b1220',
      },
      fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
      boxShadow: {
        soft: '0 4px 24px rgba(15,23,42,0.06)',
        glow: '0 8px 24px rgba(79,70,229,0.35)',
      },
      borderRadius: { xl2: '16px' },
    },
  },
  plugins: [],
};
