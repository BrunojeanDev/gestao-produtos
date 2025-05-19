@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Criar Novo Usuário</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password">Senha</label>
            <div class="input-group input-group-sm">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                <button type="button" class="btn btn-outline-secondary toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="user_type_id">Tipo de Cadastro</label>
            <select name="user_type_id" id="user_type_id" class="form-control form-control-sm @error('user_type_id') is-invalid @enderror" required>
                <option value="" disabled selected>Selecione o Tipo do Usuário</option>
                @foreach ($userTypes as $userType)
                    <option value="{{ $userType->id }}" {{ old('user_type_id') == $userType->id ? 'selected' : '' }}>
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
            @foreach ($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input permission-checkbox" id="perm_{{ $permission->id }}">
                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Criar Usuário</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.toggle-password').on('click', function () {
            let input = $('#password');
            let icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        function togglePermissions() {
            const userType = $('#user_type_id').val();
            const $container = $('#permissions-container');
            const $checkboxes = $('.permission-checkbox');

            if (userType === '1') {
                $container.hide();
                $checkboxes.each(function () {
                    $(this).removeAttr('name');
                });
            } else {
                $container.show();
                $checkboxes.each(function () {
                    $(this).attr('name', 'permissions[]');
                });
            }
        }

        togglePermissions();

        $('#user_type_id').change(togglePermissions);
    });
</script>
@endpush
