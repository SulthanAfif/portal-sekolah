@extends('layouts.app')
@section('title','Tambah Siswa')
@section('content')
<h4 class="page-title mb-4">Tambah Siswa</h4>
<div class="card" style="max-width:640px"><div class="card-body">
<form method="POST" action="{{ route('admin.siswa.store') }}">@csrf
@include('admin.siswa._form')
<button class="btn btn-primary mt-3">Simpan</button>
<a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary mt-3">Batal</a>
</form></div></div>
@endsection
