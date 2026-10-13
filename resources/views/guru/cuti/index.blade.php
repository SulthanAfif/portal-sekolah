@extends('layouts.app')
@section('title','Pengajuan Cuti / Izin')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
<div><h4 class="page-title mb-1">Pengajuan Cuti & Izin</h4><p class="text-muted mb-0">Ajukan cuti, izin, sakit, atau dinas</p></div>
<a href="{{ route('guru.cuti.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Ajukan</a>
</div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Jenis</th><th>Tanggal</th><th>Alasan</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($items as $item)
<tr>
<td class="ps-3 text-capitalize fw-semibold">{{ $item->jenis }}</td>
<td class="small">{{ $item->tanggal_mulai->format('d M Y') }} – {{ $item->tanggal_selesai->format('d M Y') }}</td>
<td class="small">{{ Str::limit($item->alasan, 60) }}</td>
<td>
@if($item->status==='approved')<span class="badge bg-success">Disetujui</span>
@elseif($item->status==='rejected')<span class="badge bg-danger">Ditolak</span>
@else<span class="badge bg-warning text-dark">Menunggu</span>@endif
</td>
<td class="text-end pe-3">
@if($item->status==='pending')
<form action="{{ route('guru.cuti.destroy',$item) }}" method="POST" onsubmit="return confirm('Batalkan?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger">Batal</button></form>
@endif
</td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-4">Belum ada pengajuan</td></tr>@endforelse
</tbody></table></div>{{ $items->links() }}</div>
@endsection
