<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Symfony\Component\HttpFoundation\Response;

class Sanitizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $inputs = $request->all();

        // Sanitize each input using HTMLPurifier
        $sanitized_inputs = array_map(function ($input) {
            return Purifier::clean($input);
        }, $inputs);

        // Replace the original inputs with sanitized ones
        $request->replace($sanitized_inputs);

        return $next($request);
    }
}
