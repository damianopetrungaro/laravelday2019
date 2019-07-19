<?php

declare(strict_types=1);

namespace OrderService\Http\Middleware\Validation;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use OrderService\ValueObjects\BookDetails;
use OrderService\ValueObjects\Exception\CustomerFirstNameIsEmpty;

final class BookDetailsValidation
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $price = new Money($request->get('book_price_amount', ''), new Currency($request->get('book_price_currency', '')));
            $request[BookDetails::class] = new BookDetails(
                $request->get('book_title', ''),
                $request->get('book_author', ''),
                $price,
            );
        } catch (CustomerFirstNameIsEmpty | CustomerFirstNameIsEmpty | InvalidArgumentException $e) {
            return new Response($e->getMessage(), 422);
        }

        return $next($request);
    }
}
