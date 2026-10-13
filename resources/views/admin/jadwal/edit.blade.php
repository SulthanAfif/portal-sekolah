@extends('layouts.app')
@section('title','Edit Jadwal')
@section('content')
<h4 class="page-title mb-4">Edit Jadwal</h4>
<div class="card" style="max-width:560px"><div class="card-body">
<form method="POST" action="{{ route('admin.jadwal.update',$jadwal) }}">@csrf @method('PUT')
@include('admin.jadwal._form')
<button class="btn btn-primary mt-3">Update</button>
</form></div></div>
@endsection
