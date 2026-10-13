# Portal Sekolah — Frontend (Next.js)

UI modern berbasis **Next.js 14 + React + Tailwind**.

## Setup

```bash
cd frontend
npm install
cp .env.example .env.local
npm run dev
```

Buka http://localhost:3000

## Environment

```
NEXT_PUBLIC_API_URL=http://127.0.0.1:8000/api
NEXT_PUBLIC_SCHOOL_EMAIL_DOMAINS=sekolah.sch.id,siswa.sch.id
LARAVEL_URL=http://127.0.0.1:8000
```

## Catatan

- Laravel tetap menangani data & auth API (Sanctum).
- Blade UI Laravel masih tersedia di port 8000 sebagai fallback.
- Admin/TU mengelola master data lewat menu Administrasi.
