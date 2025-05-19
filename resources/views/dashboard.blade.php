@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            @if (auth()->user()->user_type_id === 1)
                <h2 class="fw-semibold text-primary">Você está logado como <strong>Administrador</strong></h2>
            @else
                <h2 class="fw-semibold text-success">Você está logado como <strong>Usuário Comum</strong></h2>
            @endif
        </div>
    </div>
    <div class="py-4">
        <div class="card shadow-sm">
            <div class="card-body d-flex gap-3 justify-content-center">

                {{-- Botões para administradores --}}
                @if (auth()->user()->user_type_id === 1)
                    <a href="{{ route('usuarios.index') }}" class="btn btn-primary">
                        Usuários
                    </a>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                        Permissões
                    </a>
                {{-- Botões para usuários comuns com base nas permissões --}}
                @else
                    @php
                        $mapaPermissoes = [
                            'produtos' => ['label' => 'Produtos', 'route' => 'produtos.index', 'class' => 'btn btn-outline-primary'],
                            'categorias' => ['label' => 'Categorias', 'route' => 'categorias.index', 'class' => 'btn btn-outline-success'],
                            'marcas' => ['label' => 'Marcas', 'route' => 'marcas.index', 'class' => 'btn btn-outline-warning'],
                        ];
                    @endphp

                    @foreach (auth()->user()->permissions as $perm)
                        @if (isset($mapaPermissoes[$perm->name]))
                            <a href="{{ route($mapaPermissoes[$perm->name]['route']) }}" class="{{ $mapaPermissoes[$perm->name]['class'] }}">
                                {{ $mapaPermissoes[$perm->name]['label'] }}
                            </a>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection
