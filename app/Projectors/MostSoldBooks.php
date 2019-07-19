<?php

declare(strict_types=1);

namespace OrderService\Projectors;

use Illuminate\Support\Facades\DB;
use OrderService\Aggregates\Order;
use OrderService\Events\OrderWasPlaced;
use OrderService\Projectors\Instrumentation\MostSoldBooksInstrumentation;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;
use Spatie\EventSourcing\StoredEvent;

final class MostSoldBooks implements Projector
{
    use ProjectsEvents;

    /**
     * @var MostSoldBooksInstrumentation
     */
    private $instrumentation;

    public function __construct(MostSoldBooksInstrumentation $instrumentation)
    {
        $this->instrumentation = $instrumentation;
    }

    public function onOrderWasPlaced(OrderWasPlaced $event, StoredEvent $storedEvent): void
    {
        try {
            /** @var Order $order */
            $order = Order::retrieve($storedEvent->aggregate_uuid);
            DB::update(
                'INSERT INTO most_sold (id, sales) VALUES (:id, 1) ON DUPLICATE KEY UPDATE sales = sales+1',
                ['id' => (string) $order->bookID()]
            );
        } catch (\Throwable $e) {
            $this->instrumentation->errorOnOrderWasPlaced((string) $event->ID());
        }
    }
}
