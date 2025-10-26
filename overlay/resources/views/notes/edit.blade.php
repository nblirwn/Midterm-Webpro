@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">

    <h3>Edit Note</h3>
    <form method="post" action="{{ route('notes.update',$note) }}">
      @csrf @method('PUT')
      <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" value="{{ $note->title }}"></div>
      <div class="mb-3"><label class="form-label">Category</label>
        <select name="category_id" class="form-select">
          <option value="">-- none --</option>
          @foreach ($categories as $c)
            <option value="{{ $c->id }}" @selected($note->category_id==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3"><label class="form-label">Tags (comma separated)</label><input class="form-control" name="tags" value="{{ $tags }}"></div>
      <div class="mb-3"><label class="form-label">Content (Markdown supported)</label>
        <textarea class="form-control" name="content" rows="8" oninput="preview(this.value)">{{ $note->content }}</textarea>
      </div>
      <div class="mb-3"><strong>Preview:</strong><div id="md-preview" class.markdown"></div></div>
      <button class="btn btn-primary">Update</button>
      <a class="btn btn-secondary" href="{{ route('notes.index') }}">Back</a>
    </form>
    <script>
    function preview(text){ document.getElementById('md-preview').innerHTML = DOMPurify.sanitize(marked.parse(text||'')); }
    preview(@json($note->content));
    </script>

    <hr style="border-top: 1px solid #444;" class="my-4">

    <form method="post" action="{{ route('notes.destroy',$note) }}" onsubmit="return confirm('Delete this note?')" class="mt-3 d-inline">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger">Delete</button>
    </form>
    
    <form class="mt-3 d-inline" method="post" action="{{ route('notes.share',$note) }}">
      @csrf
      <button class="btn btn-outline-success">Create Share Link</button>
    </form>
    <form class="mt-3 d-inline" method="post" action="{{ route('notes.unshare',$note) }}">
      @csrf
      <button class="btn btn-outline-secondary">Disable Share</button>
    </form>

  </div>
</div>
@endsection