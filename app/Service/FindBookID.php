<?php

declare(strict_types=1);

namespace OrderService\Service;

use OrderService\Model\Book;
use OrderService\ValueObjects\BookID;

final class FindBookID
{
    public function __invoke(string $id): ?BookID
    {
        if (!$book = Book::find($id)) {
            return null;
        }

        try {
            return BookID::fromUUID($book['id']);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
