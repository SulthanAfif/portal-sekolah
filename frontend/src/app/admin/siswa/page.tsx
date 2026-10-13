'use client';
import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import { AppShell } from '@/components/AppShell';
import { api } from '@/lib/api';

export default function AdminSiswaPage() {
  const router = useRouter();
  const [user, setUser] = useState<any>(null);
  const [rows, setRows] = useState<any[]>([]);
  useEffect(() => {
    const raw = localStorage.getItem('user');
    if (!raw) return router.replace('/login');
    const u = JSON.parse(raw);
    if (!['admin','tu'].includes(u.role)) return router.replace('/dashboard');
    setUser(u);
    api.get('/admin/siswa').then((r) => setRows(r.data.data || r.data || [])).catch(() => {});
  }, [router]);
  if (!user) return null;
  return (
    <AppShell user={user}>
      <h1 className="text-2xl font-extrabold mb-4">Data Siswa</h1>
      <div className="card overflow-hidden">
        <table className="w-full text-sm">
          <thead className="bg-slate-50 text-left text-xs text-muted"><tr><th className="p-3">Nama</th><th>NIS</th><th>Email</th></tr></thead>
          <tbody>
            {rows.length === 0 ? <tr><td colSpan={3} className="p-6 text-center text-muted">Hubungkan API Laravel untuk data</td></tr> :
              rows.map((s) => <tr key={s.id} className="border-t"><td className="p-3 font-semibold">{s.name}</td><td>{s.nis_nip}</td><td>{s.email}</td></tr>)}
          </tbody>
        </table>
      </div>
    </AppShell>
  );
}
