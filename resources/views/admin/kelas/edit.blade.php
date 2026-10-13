@extends('layouts.app')
@section('title','Edit Kelas')
@section('content')
<h4 class="page-title mb-4">Edit Kelas</h4>
<div class="card" style="max-width:520px"><div class="card-body">
<form method="POST" action="{{ route('admin.kelas.update',$kelas) }}">@csrf @method('PUT')
@include('admin.kelas._form')
<button class="btn btn-primary mt-3">Update</button>
</form></div></div>
@endsection
