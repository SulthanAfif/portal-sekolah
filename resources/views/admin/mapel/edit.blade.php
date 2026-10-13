@extends('layouts.app')
@section('title','Edit Mapel')
@section('content')
<h4 class="page-title mb-4">Edit Mapel</h4>
<div class="card" style="max-width:480px"><div class="card-body">
<form method="POST" action="{{ route('admin.mapel.update',$mapel) }}">@csrf @method('PUT')
@include('admin.mapel._form')
<button class="btn btn-primary mt-3">Update</button>
</form></div></div>
@endsection
