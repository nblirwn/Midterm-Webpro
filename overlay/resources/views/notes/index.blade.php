@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>{{ $archived ? 'Archived Notes' : 'My Notes' }}</h3>
  <div>
    <a class="btn btn-success" href="{{ route('notes.create') }}">New Note</a>
    <a class="btn btn-secondary" href="{{ $archived ? route('notes.index') : route('notes.index',['archived'=>1]) }}">{{ $archived ? 'Back to Active' : 'View Archived' }}</a>
  </div>
</div>

<form class="row g-3 mb-4" method="get" action="{{ route('notes.index') }}">
  <input type="hidden" name="archived" value="{{ $archived?1:0 }}">
  <div class="col-md-4"><input class="form-control" name="q" value="{{ $q }}" placeholder="Search title/content..."></div>
  <div class="col-md-3">
    <select name="cat" class="form-select">
      <option value="">All Categories</option>
      @foreach ($categories as $c)
        <option value="{{ $c->id }}" @selected($cat==$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3"><input class="form-control" name="tag" value="{{ $tag }}" placeholder="Tag filter"></div>
  <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
</form>

@if ($notes->isEmpty())
  <div class="alert alert-info">No notes.</div>
@endif

<div class="row">
@foreach ($notes as $n)
  <div class="col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h5 class="card-title mb-0">{{ $n->title ?: '(untitled)' }}</h5>
          @if ($n->is_pinned) <span class="badge bg-warning text-dark">Pinned</span> @endif
        </div>
        <div class="text-muted mb-2">{{ $n->category->name ?? 'No category' }}</div>
        <p class="card-text small">{{ \Illuminate\Support\Str::limit(strip_tags($n->content), 160) }}</p>
        <div class="d-flex gap-2">
          <a class="btn btn-sm btn-outline-primary" href="{{ route('notes.show',$n) }}">Open</a>
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('notes.edit',$n) }}">Edit</a>
          <form method="post" action="{{ route('notes.pin',$n) }}" class="d-inline">@csrf <button class="btn btn-sm btn-outline-warning">{{ $n->is_pinned ? 'Unpin' : 'Pin' }}</button></form>
          @if (!$archived)
            <form method="post" action="{{ route('notes.archive',$n) }}" class="d-inline">@csrf <button class="btn btn-sm btn-outline-light">Archive</button></form>
          @else
            <form method="post" action="{{ route('notes.restore',$n) }}" class="d-inline">@csrf <button class="btn btn-sm btn-outline-success">Restore</button></form>
          @endif
        </div>
      </div>
    </div>
  </div>
@endforeach
</div>
@endsection