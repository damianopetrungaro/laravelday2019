<?php

declare(strict_types=1);

namespace OrderService\ValueObjects;

use Money\Money;
use OrderService\ValueObjects\Exception\CustomerFirstNameIsEmpty;

final class BookDetails
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $author;
    /**
     * @var Money
     */
    private $price;

    public function __construct(string $title, string $author, Money $price)
    {
        if ('' === $title) {
            throw new CustomerFirstNameIsEmpty();
        }
        if ('' === $author) {
            throw new CustomerFirstNameIsEmpty();
        }

        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function isEqual(self $bookDetails): bool
    {
        return
            $this->title === $bookDetails->title &&
            $this->author === $bookDetails->author &&
            $this->price->equals($bookDetails->price);
    }

    private function __clone()
    {
    }
}
