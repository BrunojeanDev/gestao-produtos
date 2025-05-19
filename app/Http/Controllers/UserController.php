<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('permissions', 'userType')->paginate(10);
        return view('users.index', compact('usuarios'));
    }

    public function create(): View
    {   
        $permissions = Permission::all();
        $userTypes = UserType::all();
        return view('auth.register', compact('userTypes', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
            'user_type_id' => 'required|exists:user_types,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type_id' => $request->user_type_id,
        ]);

        if ($user->user_type_id == 1) {
            $user->permissions()->sync([]);
        } else {
            $user->permissions()->sync($request['permissions'] ?? []);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function edit(User $usuario)
    {
        $userTypes = UserType::all();
        $permissions = Permission::all();

        return view('users.edit', compact('usuario', 'userTypes', 'permissions'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$usuario->id}",
            'password' => 'nullable|string|min:6',
            'user_type_id' => 'required|exists:user_types,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->user_type_id = $data['user_type_id'];
    
        if (!empty($data['password'])) {
            $usuario->password = bcrypt($data['password']);
        }

        $usuario->save();

        if ($usuario->user_type_id == 1) { 
            $usuario->permissions()->sync([]); 
        } else {
            $usuario->permissions()->sync($data['permissions'] ?? []);
        }
    
        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
