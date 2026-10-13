@extends('layouts.app')
@section('title','Tambah Guru')
@section('content')
<h4 class="page-title mb-4">Tambah Guru</h4>
<div class="card" style="max-width:640px"><div class="card-body">
<form method="POST" action="{{ route('admin.guru.store') }}">@csrf
@include('admin.guru._form')
<button class="btn btn-primary mt-3">Simpan</button>
<a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary mt-3">Batal</a>
</form></div></div>
@endsection
