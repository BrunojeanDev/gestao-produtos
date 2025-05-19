<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPagePermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = auth()->user();

        if (!$user || !$user->permissions->contains('name', $permission)) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        if (auth()->user()->is_admin == 1) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
