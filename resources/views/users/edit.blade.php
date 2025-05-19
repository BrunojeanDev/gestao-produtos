@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuário</h2>

    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ old('name', $usuario->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email', $usuario->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password">Senha</label>
            <div class="input-group input-group-sm">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="user_type_id">Tipo de Cadastro</label>
            <select name="user_type_id" id="user_type_id" class="form-control form-control-sm @error('user_type_id') is-invalid @enderror">
                <option value="" disabled selected>Selecione o Tipo do Usuário</option>
                @foreach ($userTypes as $userType)
                    <option value="{{ $userType->id }}" 
                        {{ old('user_type_id', $usuario->user_type_id) == $userType->id ? 'selected' : '' }}>
                        {{ $userType->type }}
                    </option>
                @endforeach
            </select>
            @error('user_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="permissions-container" class="mb-3">
            <label class="form-label">Permissões</label>
            <div class="form-check">
                @foreach ($permissions as $permission)
                    <input class="form-check-input" type="checkbox" name="permissions[]"
                        value="{{ $permission->id }}"
                        @checked($usuario->permissions->contains($permission->id))>
                    <label class="form-check-label">{{ $permission->name }}</label><br>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        function togglePermissions() {
            const selectedVal = $('#user_type_id').val();
            const $permissionsInputs = $('#permissions-container input[type=checkbox]');
            
            if (selectedVal === '1') {  
                $('#permissions-container').hide();
                $permissionsInputs.removeAttr('name');
            } else {
                $('#permissions-container').show();
                $permissionsInputs.attr('name', 'permissions[]');
            }
        }

        togglePermissions();

        $('#user_type_id').change(togglePermissions);

        $('.toggle-password').on('click', function () {
            const input = $('#password');
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
@endpush
