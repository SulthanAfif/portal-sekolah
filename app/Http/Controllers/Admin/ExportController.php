<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Nilai;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function siswa(): StreamedResponse
    {
        return $this->csv('siswa.csv', ['NIS', 'Nama', 'Email', 'Kelas', 'No HP', 'Status'], function ($out) {
            User::where('role', 'siswa')->with('kelas')->orderBy('name')->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $u) {
                    fputcsv($out, [
                        $u->nis_nip, $u->name, $u->email,
                        $u->kelas?->nama, $u->no_hp,
                        $u->is_active ? 'Aktif' : 'Nonaktif',
                    ]);
                }
            });
        });
    }

    public function guru(): StreamedResponse
    {
        return $this->csv('guru.csv', ['NIP', 'Nama', 'Email', 'No HP', 'Status'], function ($out) {
            User::where('role', 'guru')->orderBy('name')->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $u) {
                    fputcsv($out, [
                        $u->nis_nip, $u->name, $u->email, $u->no_hp,
                        $u->is_active ? 'Aktif' : 'Nonaktif',
                    ]);
                }
            });
        });
    }

    public function nilai(Request $request): StreamedResponse
    {
        return $this->csv('nilai.csv', ['Siswa', 'NIS', 'Mapel', 'Jenis', 'Nilai', 'Semester', 'Tahun', 'Status', 'Guru'], function ($out) {
            $q = Nilai::with(['siswa', 'mapel', 'guru'])->latest();
            if ($request->status) {
                $q->where('status', $request->status);
            }
            $q->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $n) {
                    fputcsv($out, [
                        $n->siswa?->name, $n->siswa?->nis_nip,
                        $n->mapel?->nama, $n->jenis, $n->nilai,
                        $n->semester, $n->tahun_ajaran, $n->status ?? 'submitted',
                        $n->guru?->name,
                    ]);
                }
            });
        });
    }

    public function absensi(Request $request): StreamedResponse
    {
        return $this->csv('absensi.csv', ['Tanggal', 'Siswa', 'NIS', 'Status', 'Metode', 'IP'], function ($out) {
            Absensi::with('siswa')->latest('tanggal')->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $a) {
                    fputcsv($out, [
                        $a->tanggal, $a->siswa?->name, $a->siswa?->nis_nip,
                        $a->status, $a->metode ?? '', $a->ip_address ?? '',
                    ]);
                }
            });
        });
    }

    private function csv(string $filename, array $header, callable $writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($header, $writer) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM Excel
            fputcsv($out, $header);
            $writer($out);
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
