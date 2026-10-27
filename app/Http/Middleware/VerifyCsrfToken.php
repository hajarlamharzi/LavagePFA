<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
    //    'api/reservations',
        'api/*', // Optionnel: désactiver CSRF pour toute l'API
    //     'reservations',
    //     'sanctum/csrf-cookie'
    '/login',
        'login',
    ];
}