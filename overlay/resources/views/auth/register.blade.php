@extends('layouts.app')

@push('styles')
<style>
  .login-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
    padding-top: 2rem; 
    padding-bottom: 2rem;
  }

  .login-card {
    background-color: #1e1e1e;
    border-radius: 8px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    border: 1px solid #333;
    width: 100%;
  }

  .login-card h3 {
    color: #ffffff;
    text-align: center;
    font-weight: 600;
    margin-bottom: 2rem;
  }
</style>
@endpush

@section('content')
<div class="login-container">
  <div class="col-md-4">
    <div class="login-card">
      <h3>Register</h3>
      <form method="post" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input class="form-control" name="name" value="{{ old('name') }}" required>
          @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="email" value="{{ old('email') }}" required>
          @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input class="form-control" name="password" type="password" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input class="form-control" name="password_confirmation" type="password" required>
        </div>
        <button class="btn btn-primary w-100 mt-4">Create account</button>
      </form>
    </div>
  </div>
</div>
@endsection