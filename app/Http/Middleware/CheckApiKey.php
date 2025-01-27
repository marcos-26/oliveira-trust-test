<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifique se o cabeçalho "x-api-key" está presente e é válido
        $apiKey = $request->header('x-api-key');

        if (!$apiKey || $apiKey !== env('API_KEY')) {
            return response()->json([
                'message' => 'Acesso não autorizado. Chave API inválida.'
            ], 401);
        }

        return $next($request);
    }
}
