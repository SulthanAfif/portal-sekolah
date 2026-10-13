@extends('layouts.app')
@section('title','Tambah Mapel')
@section('content')
<h4 class="page-title mb-4">Tambah Mapel</h4>
<div class="card" style="max-width:480px"><div class="card-body">
<form method="POST" action="{{ route('admin.mapel.store') }}">@csrf
@include('admin.mapel._form')
<button class="btn btn-primary mt-3">Simpan</button>
</form></div></div>
@endsection
