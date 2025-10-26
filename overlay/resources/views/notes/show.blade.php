@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    <h3>{{ $note->title ?: '(untitled)' }}</h3>
    <div class="text-muted mb-2">Category: {{ $note->category->name ?? 'No category' }}</div>
    <div class="mb-2">
      @foreach ($note->tags as $t)
        <span class="badge bg-secondary tag">{{ $t->name }}</span>
      @endforeach
    </div>
    <div class="markdown" id="content"></div>
    <script>document.getElementById('content').innerHTML = DOMPurify.sanitize(marked.parse(@json($note->content)));</script>
    <a class="btn btn-secondary mt-3" href="{{ route('notes.index') }}">Back</a>
  </div>
</div>
@endsection