@extends('layouts.app')
@section('title','Edit Siswa')
@section('content')
<h4 class="page-title mb-4">Edit Siswa</h4>
<div class="card" style="max-width:640px"><div class="card-body">
<form method="POST" action="{{ route('admin.siswa.update',$siswa) }}">@csrf @method('PUT')
@include('admin.siswa._form',['siswa'=>$siswa])
<button class="btn btn-primary mt-3">Update</button>
<a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary mt-3">Batal</a>
</form></div></div>
@endsection
