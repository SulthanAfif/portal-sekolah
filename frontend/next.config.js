/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  async rewrites() {
    return [
      {
        source: '/api/laravel/:path*',
        destination: process.env.LARAVEL_URL
          ? `${process.env.LARAVEL_URL}/api/:path*`
          : 'http://127.0.0.1:8000/api/:path*',
      },
    ];
  },
};
module.exports = nextConfig;
