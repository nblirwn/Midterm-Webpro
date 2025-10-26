<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','NoteHub') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dompurify@3/dist/purify.min.js"></script>
  
  <style>
    body {
      background-color: #121212 !important;
      color: #e0e0e0;
    }

    .form-label {
      color: #e0e0e0; 
    }

    .card-text {
      color: #e0e0e0; 
    }

    .text-muted {
      color: #999 !important; 
    }
    
    .alert-info {
      background-color: #112a40; 
      color: #9cdbff;
      border-color: #173b5a;
    }

    .markdown{
      border:1px solid #444; 
      padding:10px;
      border-radius:8px;
      background:#1e1e1e; 
    }
    .tag{
      font-size:.85rem;
      margin-right:.25rem
    }

    .form-control {
      background-color: #2c2c2c;
      color: #ffffff;
      border: 1px solid #444;
    }
    .form-control:focus {
      background-color: #333;
      color: #ffffff;
      border-color: #0d6efd; 
      box-shadow: none; 
    }
    .form-control::placeholder { color: #777; }
    .form-label { color: #a0a0a0; }
    .form-check-input {
      background-color: #2c2c2c;
      border-color: #444;
    }
    .form-check-input:checked {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }
    .form-check-label { color: #a0a0a0; }

    .form-select {
      background-color: #2c2c2c;
      color: #ffffff;
      border: 1px solid #444;
    }
    .form-select:focus {
      background-color: #333;
      color: #ffffff;
      border-color: #0d6efd;
      box-shadow: none;
    }
    
    .card {
      background-color: #1e1e1e;
      border: 1px solid #333;
    }

    .list-group-item {
      background-color: #1e1e1e; 
      color: #e0e0e0;         
      border-color: #444;     
    }

    p, h1, h2, h3, h4, h5, h6, .form-label, strong {
      color: #ffffff !important;
    }
    
    .navbar-text {
      color: rgba(255, 255, 255, 0.8) !important; 
    }
    
  </style>
  @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('notes.index') }}">NoteHub</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('notes.index') }}">Notes</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
        @endauth
      </ul>
      <div class="d-flex align-items-center justify-content-between">
        @auth
          <span class="navbar-text me-2">Hi, {{ auth()->user()->name }}</span>
          <form method="post" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
          </form>
        @else
          <a class="btn {{ Request::routeIs('login') ? 'btn-outline-primary' : 'btn-primary' }} btn-sm me-2" href="{{ route('login') }}">Login</a>
          <a class="btn {{ Request::routeIs('register') ? 'btn-outline-primary' : 'btn-primary' }} btn-sm" href="{{ route('register') }}">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
<main class="container py-4">
  @if (session('status')) <div class="alert alert-info">{{ session('status') }}</div> @endif
  @yield('content')
</main>
</body>
</html>