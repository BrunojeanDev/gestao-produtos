@extends('layouts.app')

@section('title', 'Gestão de Categorias')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gestão de Categorias</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                Voltar para o Dashboard
            </a>
        </div>

        <p>Você tem acesso à esta página.</p>
    </div>
@endsection
