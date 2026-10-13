@extends('layouts.app')
@section('title','Nilai Saya')
@section('content')
<h4 class="page-title mb-1">Nilai Saya</h4>
<p class="text-muted mb-4">Rekap nilai yang sudah diinput guru</p>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Mapel</th><th>Jenis</th><th>Nilai</th><th>Semester</th><th>Guru</th></tr></thead>
<tbody>
@forelse($nilais as $n)
<tr>
<td class="ps-3 fw-semibold">{{ $n->mapel->nama }}</td>
<td>{{ $n->jenis }}</td>
<td><span class="fw-bold {{ $n->nilai>=75?'text-success':'text-danger' }}">{{ $n->nilai }}</span></td>
<td class="small">{{ $n->semester }} {{ $n->tahun_ajaran }}</td>
<td class="small">{{ $n->guru?->name }}</td>
</tr>
@empty<tr><td colspan="5" class="text-center text-muted py-4">Belum ada nilai</td></tr>@endforelse
</tbody></table></div>{{ $nilais->links() }}</div>
@endsection
