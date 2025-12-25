@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Kategori Default</h3>
        <a href="{{ route('admin.default_categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table">
        <thead><tr><th>Nama</th><th>Tipe</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($cats as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->type }}</td>
                    <td>
                        <a href="{{ route('admin.default_categories.edit', $c->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.default_categories.destroy', $c->id) }}" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cats->links() }}
</div>
@endsection