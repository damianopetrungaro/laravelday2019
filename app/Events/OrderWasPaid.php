<?php

declare(strict_types=1);

namespace OrderService\Events;

use DateTimeImmutable;
use Spatie\EventSourcing\ShouldBeStored;

final class OrderWasPaid implements ShouldBeStored
{
    /**
     * @var DateTimeImmutable
     */
    private $paidAt;

    public function __construct(DateTimeImmutable $paidAt)
    {
        $this->paidAt = $paidAt;
    }

    public function paidAt(): DateTimeImmutable
    {
        return $this->paidAt;
    }
}
