@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    <h3>New Category</h3>
    <form method="post" action="{{ route('categories.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" required>
      </div>
      <button class="btn btn-primary">Save</button>
      <a class="btn btn-secondary" href="{{ route('categories.index') }}">Cancel</a>
    </form>
  </div>
</div>
@endsection