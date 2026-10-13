@extends('layouts.app')
@section('title','Tambah Jadwal')
@section('content')
<h4 class="page-title mb-4">Tambah Jadwal</h4>
<div class="card" style="max-width:560px"><div class="card-body">
<form method="POST" action="{{ route('admin.jadwal.store') }}">@csrf
@include('admin.jadwal._form')
<button class="btn btn-primary mt-3">Simpan</button>
</form></div></div>
@endsection
