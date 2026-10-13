'use client';
import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { AppShell } from '@/components/AppShell';

export default function DashboardPage() {
  const router = useRouter();
  const [user, setUser] = useState<any>(null);
  useEffect(() => {
    const raw = localStorage.getItem('user');
    if (!raw) router.replace('/login');
    else setUser(JSON.parse(raw));
  }, [router]);
  if (!user) return null;
  const isAdmin = ['admin', 'tu'].includes(user.role);
  return (
    <AppShell user={user}>
      <h1 className="text-2xl font-extrabold">Halo, {user.name}</h1>
      <p className="text-sm text-muted capitalize mb-6">Dashboard {user.role}</p>
      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {[['Jadwal','/jadwal'],['Absensi','/absensi'],['Pengumuman','/pengumuman'],['SekolahBot','/chatbot']].map(([l,h]) => (
          <Link key={h} href={h} className="card p-5 font-semibold hover:-translate-y-1 transition">{l}</Link>
        ))}
      </div>
      {isAdmin && (
        <div className="mt-8">
          <h2 className="mb-3 text-sm font-bold text-muted">ADMINISTRASI</h2>
          <div className="grid gap-2 sm:grid-cols-3">
            {['siswa','guru','kelas','mapel','jadwal','nilai','pengumuman'].map((x) => (
              <Link key={x} href={`/admin/${x}`} className="card px-4 py-3 text-sm font-semibold capitalize">{x}</Link>
            ))}
          </div>
        </div>
      )}
    </AppShell>
  );
}
