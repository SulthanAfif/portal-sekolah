@extends('layouts.app')
@section('title','Edit Pengumuman')
@section('content')
<h4 class="page-title mb-4">Edit Pengumuman</h4>
<div class="card" style="max-width:720px"><div class="card-body">
<form method="POST" action="{{ route('admin.pengumuman.update',$pengumuman) }}">@csrf @method('PUT')
@include('admin.pengumuman._form')
<button class="btn btn-primary mt-3">Update</button>
</form></div></div>
@endsection
