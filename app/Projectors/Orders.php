<?php

namespace OrderService\Projectors;

use OrderService\Events\OrderWasDelivered;
use OrderService\Events\OrderWasPaid;
use OrderService\Events\OrderWasPlaced;
use OrderService\Events\OrderWasRefunded;
use OrderService\Events\OrderWasShipped;
use OrderService\Order;
use Psr\Log\LoggerInterface;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

final class Orders implements Projector
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

    public function onOrderWasPlaced(OrderWasPlaced $event): void
    {
        $order = new Order([
            'id' => (string)$event->ID(),
            'book_id' => (string)$event->bookID(),
            'customer_id' => (string)$event->customerID(),
        ]);

        if (!$order->save()) {
            $this->logger->alert('...');
        }
    }

    public function onOrderWasPaid(OrderWasPaid $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->logger->alert('...');
            return;
        }

        /** @var Order $order */
        if (!$order->update(['paid' => true])) {
            $this->logger->alert('...');
        }
    }


    public function onOrderWasShipped(OrderWasShipped $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->logger->alert('...');
            return;
        }

        /** @var Order $order */
        if (!$order->update(['shipped' => true])) {
            $this->logger->alert('...');
        }
    }

    public function onOrderWasDelivered(OrderWasDelivered $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->logger->alert('...');
            return;
        }

        /** @var Order $order */
        if (!$order->update(['delivered' => true])) {
            $this->logger->alert('...');
        }
    }

    public function onOrderWasRefunded(OrderWasRefunded $event, string $aggregateUuid): void
    {
        $order = Order::find($aggregateUuid);
        if (!$order) {
            $this->logger->alert('...');
            return;
        }

        /** @var Order $order */
        if (!$order->update(['refunded' => true, 'refunded_by' => (string)$event->refundedBy()])) {
            $this->logger->alert('...');
        }
    }
}
