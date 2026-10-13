'use client';
import Link from 'next/link';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { api } from '@/lib/api';

const DOMAINS = (process.env.NEXT_PUBLIC_SCHOOL_EMAIL_DOMAINS || 'sekolah.sch.id,siswa.sch.id').split(',');

export default function RegisterPage() {
  const router = useRouter();
  const [form, setForm] = useState({ name: '', email: '', password: '', password_confirmation: '', role: 'siswa', nis_nip: '' });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const set = (k: string, v: string) => setForm((f) => ({ ...f, [k]: v }));

  async function onSubmit(e: React.FormEvent) {
    e.preventDefault();
    setLoading(true);
    setError('');
    try {
      const { data } = await api.post('/register', form);
      localStorage.setItem('token', data.token);
      localStorage.setItem('user', JSON.stringify(data.user));
      router.push(data.user?.role === 'siswa' ? '/biodata' : '/dashboard');
    } catch (err: any) {
      setError(err?.response?.data?.message || 'Registrasi gagal. Gunakan email domain sekolah.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="flex min-h-screen items-center justify-center bg-canvas p-4">
      <div className="card w-full max-w-md p-8">
        <h1 className="text-center text-xl font-extrabold">Buat Akun</h1>
        <p className="mt-1 text-center text-sm text-muted">Domain: @{DOMAINS.join(', @')}</p>
        {error && <div className="mt-3 rounded-xl bg-red-50 px-3 py-2 text-sm text-red-600">{error}</div>}
        <form onSubmit={onSubmit} className="mt-4 space-y-3">
          <input className="input" placeholder="Nama" value={form.name} onChange={(e) => set('name', e.target.value)} required />
          <input className="input" type="email" placeholder="email@sekolah.sch.id" value={form.email} onChange={(e) => set('email', e.target.value)} required />
          <select className="input" value={form.role} onChange={(e) => set('role', e.target.value)}>
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
          </select>
          <input className="input" type="password" placeholder="Password" value={form.password} onChange={(e) => set('password', e.target.value)} required />
          <input className="input" type="password" placeholder="Konfirmasi" value={form.password_confirmation} onChange={(e) => set('password_confirmation', e.target.value)} required />
          <button type="submit" disabled={loading} className="btn-primary w-full">{loading ? '...' : 'Daftar'}</button>
        </form>
        <p className="mt-4 text-center text-sm"><Link href="/login" className="text-primary font-semibold">Masuk</Link></p>
      </div>
    </div>
  );
}
