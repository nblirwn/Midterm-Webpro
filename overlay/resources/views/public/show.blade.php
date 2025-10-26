@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    <h3>{{ $note->title ?: '(untitled)' }}</h3>
    <div class="text-muted mb-2">Category: {{ $note->category->name ?? 'No category' }}</div>
    <div class="markdown" id="content"></div>
    <script>document.getElementById('content').innerHTML = DOMPurify.sanitize(marked.parse(@json($note->content)));</script>
    <div class="mt-3">
      <a class="btn btn-primary" href="{{ route('notes.edit',$note) }}">Edit</a>
      <a class="btn btn-secondary" href="{{ route('notes.index') }}">Back</a>
    </div>

  </div>
</div>
@endsection