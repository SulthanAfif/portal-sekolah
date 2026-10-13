@extends('layouts.app')
@section('title','Persetujuan Cuti')
@section('content')
<h4 class="page-title mb-1">Persetujuan Cuti / Izin Guru</h4>
<p class="text-muted mb-4">Review pengajuan dari guru</p>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<form class="mb-3"><select name="status" class="form-select w-auto" onchange="this.form.submit()">
<option value="">Semua status</option>
<option value="pending" @selected(request('status')==='pending')>Menunggu</option>
<option value="approved" @selected(request('status')==='approved')>Disetujui</option>
<option value="rejected" @selected(request('status')==='rejected')>Ditolak</option>
</select></form>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Guru</th><th>Jenis</th><th>Tanggal</th><th>Alasan</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($items as $item)
<tr>
<td class="ps-3 fw-semibold">{{ $item->user->name }}</td>
<td class="text-capitalize">{{ $item->jenis }}</td>
<td class="small">{{ $item->tanggal_mulai->format('d/m/Y') }} – {{ $item->tanggal_selesai->format('d/m/Y') }}</td>
<td class="small">{{ Str::limit($item->alasan,50) }}</td>
<td>
@if($item->status==='approved')<span class="badge bg-success">Disetujui</span>
@elseif($item->status==='rejected')<span class="badge bg-danger">Ditolak</span>
@else<span class="badge bg-warning text-dark">Menunggu</span>@endif
</td>
<td class="text-end pe-3 text-nowrap">
@if($item->status==='pending')
<form action="{{ route('admin.cuti.update',$item) }}" method="POST" class="d-inline">@csrf @method('PATCH')
<input type="hidden" name="status" value="approved">
<button class="btn btn-sm btn-outline-success">Setujui</button></form>
<form action="{{ route('admin.cuti.update',$item) }}" method="POST" class="d-inline">@csrf @method('PATCH')
<input type="hidden" name="status" value="rejected">
<button class="btn btn-sm btn-outline-danger">Tolak</button></form>
@endif
</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data</td></tr>@endforelse
</tbody></table></div>{{ $items->links() }}</div>
@endsection
