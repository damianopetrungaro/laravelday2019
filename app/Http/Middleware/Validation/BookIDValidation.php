<?php

declare(strict_types=1);

namespace OrderService\Http\Middleware\Validation;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OrderService\Service\FindBookID;
use OrderService\ValueObjects\BookID;

final class BookIDValidation
{
    /**
     * @var FindBookID
     */
    private $findBookID;

    public function __construct(FindBookID $findBookID)
    {
        $this->findBookID = $findBookID;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$bookID = ($this->findBookID)($request->get('book_id', ''))) {
            return new Response('book ID does not exists', 422);
        }
        $request[BookID::class] = $bookID;

        return $next($request);
    }
}
