<?php

namespace App\Http\Middleware;

use Config;
use Closure;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class ProviderApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Config::set('auth.providers.users.model', 'App\Provider');

        try {

            if (! $user = JWTAuth::parseToken()->authenticate(false, 'provider')) {
                return response()->json(['user_not_found'], 404);
            } else {
                \Auth::loginUsingId($user->id);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['error' => 'token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['error' => 'token_absent'], $e->getStatusCode());

        }

        return $next($request);
    }
}
