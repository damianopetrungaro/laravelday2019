<?php

declare(strict_types=1);

namespace OrderService\Projectors;

use Illuminate\Support\Facades\DB;
use OrderService\Aggregates\Order;
use OrderService\Events\OrderWasRefunded;
use OrderService\Projectors\Instrumentation\MostRefundedBooksInstrumentation;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;
use Spatie\EventSourcing\StoredEvent;

final class MostRefundedBooks implements Projector
{
    use ProjectsEvents;

    /**
     * @var MostRefundedBooksInstrumentation
     */
    private $instrumentation;

    public function __construct(MostRefundedBooksInstrumentation $instrumentation)
    {
        $this->instrumentation = $instrumentation;
    }

    public function onOrderWasRefunded(OrderWasRefunded $event, StoredEvent $storedEvent): void
    {
        try {
            /** @var Order $order */
            $order = Order::retrieve($storedEvent->aggregate_uuid);
            DB::update(
                'INSERT INTO most_refunded (id, refunds) VALUES (:id, 1) ON DUPLICATE KEY UPDATE refunds = refunds+1',
                ['id' => (string) $order->bookID()]
            );
        } catch (\Throwable $e) {
            $this->instrumentation->errorOnOrderWasRefunded($storedEvent->aggregate_uuid);
        }
    }
}
