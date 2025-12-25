@extends('layouts.auth.forgot')

@section('content')
    <h2 class="text-center mb-4">Lupa Password</h2>

    @if(!isset($show_question))
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="identifier" class="form-label">Username atau Email</label>
                <input id="identifier" name="identifier" class="form-control" value="{{ old('identifier') }}" required>
                @error('identifier')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-primary w-100">Lanjutkan</button>
        </form>
    @else
        <form method="POST" action="{{ route('password.verify') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pertanyaan Keamanan</label>
                <p class="form-control-plaintext">{{ $question }}</p>
            </div>
            <div class="mb-3">
                <label for="answer" class="form-label">Jawaban</label>
                <input id="answer" name="answer" class="form-control" required>
                @error('answer')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-primary w-100">Verifikasi</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}">Kembali</a>
        </div>
    @endif
@endsection
