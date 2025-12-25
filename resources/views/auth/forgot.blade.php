@extends('layouts.auth')

@section('content')
<div class="container">
    <h2>Lupa Password</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="identifier" class="form-label">Username atau Email</label>
            <input id="identifier" name="identifier" class="form-control" value="{{ old('identifier') }}" required>
            @error('identifier')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary">Lanjut ke Pertanyaan Keamanan</button>
    </form>
</div>
@endsection
