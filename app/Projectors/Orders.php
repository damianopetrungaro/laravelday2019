<?php

declare(strict_types=1);

namespace OrderService\Projectors;

use OrderService\Events\OrderWasDelivered;
use OrderService\Events\OrderWasPaid;
use OrderService\Events\OrderWasPlaced;
use OrderService\Events\OrderWasRefunded;
use OrderService\Events\OrderWasShipped;
use OrderService\Model\Order;
use OrderService\Projectors\Instrumentation\OrdersInstrumentation;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;

final class Orders implements Projector
{
    use ProjectsEvents;

    /**
     * @var OrdersInstrumentation
     */
    private $instrumentation;

    public function __construct(OrdersInstrumentation $instrumentation)
    {
        $this->instrumentation = $instrumentation;
    }

    public function onOrderWasPlaced(OrderWasPlaced $event): void
    {
        $order = new Order([
            'id' => (string) $event->ID(),
            'book_id' => (string) $event->bookID(),
            'customer_id' => (string) $event->customerID(),
        ]);

        if (!$order->save()) {
            $this->instrumentation->errorOnOrderWasPlaced((string) $event->ID());
        }
    }

    public function onOrderWasPaid(OrderWasPaid $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->instrumentation->errorOrderNotFoundOnOrderWasPaid($aggregateUuid);

            return;
        }

        /** @var Order $order */
        if (!$order->update(['paid' => true])) {
            $this->instrumentation->errorOrderNotUpdatedOnOrderWasPaid($aggregateUuid);
        }
    }

    public function onOrderWasShipped(OrderWasShipped $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->instrumentation->errorOrderNotFoundOnOrderWasShipped($aggregateUuid);

            return;
        }

        /** @var Order $order */
        if (!$order->update(['shipped' => true])) {
            $this->instrumentation->errorOrderNotUpdatedOnOrderWasShipped($aggregateUuid);
        }
    }

    public function onOrderWasDelivered(OrderWasDelivered $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->instrumentation->errorOrderNotFoundOnOrderWasDelivered($aggregateUuid);

            return;
        }

        /** @var Order $order */
        if (!$order->update(['delivered' => true])) {
            $this->instrumentation->errorOrderNotUpdatedOnOrderWasDelivered($aggregateUuid);
        }
    }

    public function onOrderWasRefunded(OrderWasRefunded $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->instrumentation->errorOrderNotFoundOnOrderWasRefunded($aggregateUuid);

            return;
        }

        /** @var Order $order */
        if (!$order->update(['refunded' => true, 'refunded_by' => (string) $event->refundedBy()])) {
            $this->instrumentation->errorOrderNotUpdatedOnOrderWasRefunded($aggregateUuid);
        }
    }

    public function resetState(): void
    {
        Order::query()->truncate();
    }
}
