<?php

namespace OrderService\Projectors;

use OrderService\Book;
use OrderService\Events\OrderWasPaid;
use Psr\Log\LoggerInterface;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

final class MostSoldBooks implements Projector
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
        //find or insert
        Book::where('id', $aggregateUUID)->increment('sold');
    }
}
