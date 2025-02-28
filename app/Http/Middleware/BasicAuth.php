<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request);
        try {
            $serverAuthUser = $request->server('PHP_AUTH_USER');
            $serverAuthPassword = $request->server('PHP_AUTH_PW');
            $localAuthUser = env('AUTH_BASIC_USER');
            $localAuthPassword = env('AUTH_BASIC_PASSWORD');
            
            if($serverAuthUser === $localAuthUser && $serverAuthPassword === $localAuthPassword){
                // return $next($request);
            }

            // return new Response('Unauthorized', 401, ['WWW-Authenticate' => 'Basic']);

        } catch(Exception $error){

            return new Response($error);
        }
    }
}
