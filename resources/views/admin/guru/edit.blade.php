@extends('layouts.app')
@section('title','Edit Guru')
@section('content')
<h4 class="page-title mb-4">Edit Guru</h4>
<div class="card" style="max-width:640px"><div class="card-body">
<form method="POST" action="{{ route('admin.guru.update',$guru) }}">@csrf @method('PUT')
@include('admin.guru._form',['guru'=>$guru])
<button class="btn btn-primary mt-3">Update</button>
<a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary mt-3">Batal</a>
</form></div></div>
@endsection
