'use client';
import Link from 'next/link';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { api } from '@/lib/api';

export default function LoginPage() {
  const router = useRouter();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function onSubmit(e: React.FormEvent) {
    e.preventDefault();
    setLoading(true);
    setError('');
    try {
      const { data } = await api.post('/login', { email, password });
      localStorage.setItem('token', data.token);
      localStorage.setItem('user', JSON.stringify(data.user));
      if (data.user?.role === 'siswa') router.push('/biodata');
      else router.push('/dashboard');
    } catch (err: any) {
      setError(err?.response?.data?.message || 'Login gagal.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="flex min-h-screen">
      <div className="relative hidden flex-1 bg-gradient-to-br from-[#0b1220] via-[#1e1b4b] to-[#312e81] p-12 text-white lg:flex lg:items-center">
        <div className="max-w-md">
          <h1 className="text-4xl font-extrabold tracking-tight">Belajar lebih terorganisir.</h1>
          <p className="mt-3 text-white/65">Absensi WiFi · Jadwal · Nilai · SekolahBot AI</p>
        </div>
      </div>
      <div className="flex w-full max-w-lg flex-col justify-center px-8 py-12 lg:w-[480px]">
        <h2 className="text-2xl font-extrabold tracking-tight">Selamat datang</h2>
        <p className="mt-1 text-sm text-muted">Masuk ke akun portal Anda</p>
        {error && <div className="mt-4 rounded-xl bg-red-50 px-3 py-2 text-sm text-red-600">{error}</div>}
        <form onSubmit={onSubmit} className="mt-6 space-y-4">
          <div>
            <label className="mb-1 block text-xs font-semibold">Email</label>
            <input className="input" type="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
          </div>
          <div>
            <label className="mb-1 block text-xs font-semibold">Password</label>
            <input className="input" type="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
          </div>
          <button type="submit" disabled={loading} className="btn-primary w-full">{loading ? '...' : 'Masuk'}</button>
        </form>
        <p className="mt-6 text-center text-sm text-muted">
          Belum punya akun? <Link href="/register" className="font-semibold text-primary">Daftar</Link>
        </p>
      </div>
    </div>
  );
}
