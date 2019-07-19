<?php

declare(strict_types=1);

namespace OrderService\Http\Middleware\Validation;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OrderService\ValueObjects\Exception\InvalidID;
use OrderService\ValueObjects\ID;

final class IDValidation
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $request[ID::class] = ID::fromUUID($request->get('id', ''));
        } catch (InvalidID $e) {
            return new Response($e->getMessage(), 404);
        }

        return $next($request);
    }
}
