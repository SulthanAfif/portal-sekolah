'use client';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import { ReactNode, useState } from 'react';
import clsx from 'clsx';

export function AppShell({ user, children }: { user: any; children: ReactNode }) {
  const pathname = usePathname();
  const router = useRouter();
  const [open, setOpen] = useState(false);
  const isAdmin = user?.role === 'admin' || user?.role === 'tu';
  const nav = [
    { href: '/dashboard', label: 'Dashboard' },
    ...(user?.role === 'siswa' ? [{ href: '/biodata', label: 'Biodata' }] : []),
    { href: '/jadwal', label: 'Jadwal' },
    { href: '/absensi', label: 'Absensi' },
    { href: '/pengumuman', label: 'Pengumuman' },
    { href: '/chatbot', label: 'SekolahBot' },
  ];
  const adminNav = isAdmin
    ? ['siswa', 'guru', 'kelas', 'mapel', 'jadwal', 'nilai', 'pengumuman'].map((x) => ({
        href: `/admin/${x}`,
        label: x.charAt(0).toUpperCase() + x.slice(1),
      }))
    : [];

  return (
    <div className="min-h-screen">
      <aside className={clsx('fixed inset-y-0 left-0 z-50 w-64 bg-sidebar text-slate-400 transition-transform lg:translate-x-0', open ? 'translate-x-0' : '-translate-x-full')}>
        <div className="flex h-[68px] items-center gap-2 border-b border-white/5 px-4 font-bold text-white">Portal Sekolah</div>
        <nav className="space-y-1 p-3">
          {nav.map((n) => (
            <Link key={n.href} href={n.href} className={clsx('block rounded-xl px-3 py-2.5 text-sm font-medium', pathname === n.href ? 'bg-primary text-white' : 'hover:bg-white/5 hover:text-white')}>{n.label}</Link>
          ))}
          {adminNav.map((n) => (
            <Link key={n.href} href={n.href} className={clsx('block rounded-xl px-3 py-2 text-sm', pathname.startsWith(n.href) ? 'bg-primary text-white' : 'hover:bg-white/5')}>{n.label}</Link>
          ))}
          <button onClick={() => { localStorage.clear(); router.push('/login'); }} className="mt-4 w-full rounded-xl px-3 py-2 text-left text-sm text-red-400">Keluar</button>
        </nav>
      </aside>
      {open && <div className="fixed inset-0 z-40 bg-black/40 lg:hidden" onClick={() => setOpen(false)} />}
      <div className="lg:pl-64">
        <header className="sticky top-0 z-30 flex h-[68px] items-center border-b border-line bg-white/85 px-4 backdrop-blur">
          <button className="lg:hidden" onClick={() => setOpen(true)}>Menu</button>
          <span className="ml-auto text-sm font-medium">{user?.name}</span>
        </header>
        <main className="p-4 md:p-6">{children}</main>
      </div>
    </div>
  );
}
