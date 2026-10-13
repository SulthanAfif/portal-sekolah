@extends('layouts.app')
@section('title','Tambah Kelas')
@section('content')
<h4 class="page-title mb-4">Tambah Kelas</h4>
<div class="card" style="max-width:520px"><div class="card-body">
<form method="POST" action="{{ route('admin.kelas.store') }}">@csrf
@include('admin.kelas._form')
<button class="btn btn-primary mt-3">Simpan</button>
</form></div></div>
@endsection
