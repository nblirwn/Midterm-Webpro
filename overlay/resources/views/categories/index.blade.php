@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Categories</h3>
  <a class="btn btn-success" href="{{ route('categories.create') }}">New Category</a>
</div>

@if ($categories->isEmpty())
  <div class="alert alert-info">No categories.</div>
@endif
<ul class="list-group">
@foreach ($categories as $c)
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <span>{{ $c->name }}</span>
    <span>
      <a class="btn btn-sm btn-outline-secondary" href="{{ route('categories.edit',$c) }}">Edit</a>
      <form method="post" action="{{ route('categories.destroy',$c) }}" class="d-inline" onsubmit="return confirm('Delete?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-outline-danger">Delete</button>
      </form>
    </span>
  </li>
@endforeach
</ul>
@endsection