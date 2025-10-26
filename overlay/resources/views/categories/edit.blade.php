@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    <h3>Edit Category</h3>
    <form method="post" action="{{ route('categories.update',$cat) }}">
      @csrf @method('PUT')
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="{{ $cat->name }}" required>
      </div>
      <button class="btn btn-primary">Update</button>
      <a class="btn btn-secondary" href="{{ route('categories.index') }}">Back</a>
    </form>
  </div>
</div>
@endsection