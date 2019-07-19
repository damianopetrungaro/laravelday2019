<?php

declare(strict_types=1);

namespace OrderService\Events;

use DateTimeImmutable;
use Spatie\EventSourcing\ShouldBeStored;

final class OrderWasDelivered implements ShouldBeStored
{
    /**
     * @var DateTimeImmutable
     */
    private $deliveredAt;

    public function __construct(DateTimeImmutable $deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;
    }

    public function deliveredAt(): DateTimeImmutable
    {
        return $this->deliveredAt;
    }
}
