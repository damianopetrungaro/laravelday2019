<?php

declare(strict_types=1);

namespace OrderService\Events;

use DateTimeImmutable;
use Spatie\EventSourcing\ShouldBeStored;

final class OrderWasShipped implements ShouldBeStored
{
    /**
     * @var DateTimeImmutable
     */
    private $shippedAt;

    public function __construct(DateTimeImmutable $shippedAt)
    {
        $this->shippedAt = $shippedAt;
    }

    public function shippedAt(): DateTimeImmutable
    {
        return $this->shippedAt;
    }
}
