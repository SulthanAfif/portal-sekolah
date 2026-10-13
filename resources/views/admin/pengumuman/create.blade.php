@extends('layouts.app')
@section('title','Buat Pengumuman')
@section('content')
<h4 class="page-title mb-4">Buat Pengumuman</h4>
<div class="card" style="max-width:720px"><div class="card-body">
<form method="POST" action="{{ route('admin.pengumuman.store') }}">@csrf
@include('admin.pengumuman._form')
<button class="btn btn-primary mt-3">Publikasikan</button>
</form></div></div>
@endsection
