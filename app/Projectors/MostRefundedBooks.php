<?php

namespace OrderService\Projectors;

use OrderService\Book;
use OrderService\Events\OrderWasPaid;
use OrderService\Events\OrderWasRefunded;
use Psr\Log\LoggerInterface;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

final class MostRefundedBooks implements Projector
{
    use ProjectsEvents;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onOrderWasPaid(OrderWasPaid $event, string $aggregateUUID): void
    {
        (new Book(['id', $aggregateUUID]))->save();
    }

    public function onOrderWasRefunded(OrderWasRefunded $event, string $aggregateUUID): void
    {
        //find or insert
        Book::where('id', $aggregateUUID)->increment('refunded');
    }
}
