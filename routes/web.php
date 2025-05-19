<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;
use App\Models\Permission;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\LoginController; 

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

// Rota de login (exibe o formulário)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Rota que processa o login (POST)
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

// Página inicial redireciona para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Logout (precisa do Auth importado)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // Redireciona para login após logout
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Rotas protegidas (autenticadas)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard (qualquer usuário logado pode ver)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Acesso de usuários comuns com permissões específicas
    |--------------------------------------------------------------------------
    */
    Route::get('/produtos', function () {
        return view('management.produtos');
    })->middleware('can.page:produtos')->name('produtos.index');

    Route::get('/categorias', function () {
        return view('management.categorias');
    })->middleware('can.page:categorias')->name('categorias.index');

    Route::get('/marcas', function () {
        return view('management.marcas');
    })->middleware('can.page:marcas')->name('marcas.index');

    /*
    |--------------------------------------------------------------------------
    | Acesso exclusivo de administradores
    |--------------------------------------------------------------------------
    */
    Route::middleware('is.admin')->group(function () {

        Route::resource('permissions', PermissionController::class);

        // Formulário de criação de usuário
        Route::get('/usuarios/create', function () {
            $userTypes = UserType::all();
            $permissions = Permission::all(); 
            return view('auth.register', compact('userTypes', 'permissions'));
        })->name('usuarios.create');

        Route::resource('usuarios', UserController::class)->except(['show', 'create']);

        // Gerenciar perfil
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});


