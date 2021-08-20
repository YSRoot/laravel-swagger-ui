<?php

namespace YSRoot\SwaggerUI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnsureIsAuthorized
{
    /**
     * Ensures is authorized to visit Swagger UI.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('local')) {
            return $next($request);
        }

        if (Gate::allows('viewSwaggerUI', [$request])) {
            return $next($request);
        }

        throw new HttpException(SymfonyResponse::HTTP_FORBIDDEN);
    }
}