<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\Constants\ErrorConst;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guard = Arr::get($guards, '0');

        if ($guard && Auth::guard($guard)->check()) {
            return $next($request);
        }

        throw new HttpException(ErrorConst::UNAUTHORIZED, ErrorConst::getError(ErrorConst::UNAUTHORIZED));
    }
}