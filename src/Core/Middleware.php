<?php

namespace App\Core;

/**
 * Middleware Interface
 * 
 * Define la estructura para los middlewares que se encadenan.
 */
interface Middleware
{
    public function handle(Request $request, callable $next): mixed;
}
