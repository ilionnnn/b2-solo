<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôle d'accès basé sur le rôle applicatif de l'utilisateur.
 *
 * Convention de rôles (colonne users.role) :
 *   0 = administrateur, 1 = utilisateur, 2 = modérateur
 *
 * Usage : ->middleware('role:moderator') ou ->middleware('role:admin,moderator')
 */
class RoleMiddleware
{
    /** Correspondance nom logique -> valeur stockée en base. */
    private const ROLES = [
        'admin' => 0,
        'user' => 1,
        'moderator' => 2,
    ];

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            abort(403);
        }

        $allowed = array_map(
            fn (string $role) => self::ROLES[$role] ?? -1,
            $roles
        );

        if (! in_array((int) auth()->user()->role, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
