@extends('layouts.app')

@section('title', 'Criar Permissão')

@section('content')
<div class="container mt-4">
    <h2>Criar Nova Permissão</h2>

    <form method="POST" action="{{ route('permissions.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome da Permissão</label>
            <input type="text" name="name" id="name"
                   class="form-control form-control-sm @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Criar Permissão</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
