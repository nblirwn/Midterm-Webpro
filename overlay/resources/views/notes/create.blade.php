@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">

    <h3 class="text-white">New Note</h3>
    <form method="post" action="{{ route('notes.store') }}">
      @csrf
      <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title"></div>
      <div class="mb-3"><label class="form-label">Category</label>
        <select name="category_id" class="form-select">
          <option value="">-- none --</option>
          @foreach ($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3"><label class="form-label">Tags (comma separated)</label><input class="form-control" name="tags"></div>
      <div class="mb-3"><label class="form-label">Content (Markdown supported)</label>
        <textarea class="form-control" name="content" rows="8" oninput="preview(this.value)"></textarea>
      </div>
      <div class="mb-3"><label class="form-label">Preview:</label>
        <div id="md-preview" class="markdown"></div>
      </div>
      <button class="btn btn-primary">Save</button>
      <a class="btn btn-secondary" href="{{ route('notes.index') }}">Cancel</a>
    </form>
    <script>function preview(text){ document.getElementById('md-preview').innerHTML = DOMPurify.sanitize(marked.parse(text||'')); }</script>
    
  </div>
</div>
@endsection