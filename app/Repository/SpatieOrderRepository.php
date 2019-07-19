<?php

declare(strict_types=1);

namespace OrderService\Repository;

use OrderService\Aggregates\Order;
use OrderService\Repository\Exception\OrderNotAdded;
use OrderService\Repository\Exception\OrderNotFound;
use OrderService\Repository\Exception\OrderNotGotten;
use OrderService\Repository\Instrumentation\RepositoryInstrumentation;
use OrderService\ValueObjects\ID;
use Ramsey\Uuid\Uuid;

final class SpatieOrderRepository implements OrderRepository
{
    /**
     * @var RepositoryInstrumentation
     */
    private $instrumentation;

    public function __construct(RepositoryInstrumentation $instrumentation)
    {
        $this->instrumentation = $instrumentation;
    }

    public function nextID(): ID
    {
        return ID::fromUUID(Uuid::uuid4()->toString());
    }

    public function add(Order $order): void
    {
        try {
            $order->persist();
        } catch (\Throwable $e) {
            $this->instrumentation->errorAddingTheOrder($order, $e);
            throw new OrderNotAdded($order->ID(), $e);
        }
    }

    public function getByID(ID $ID): Order
    {
        try {
            /** @var Order $order */
            $order = Order::retrieve((string) $ID);
        } catch (\Throwable $e) {
            $this->instrumentation->errorGettingTheOrder($ID, $e);
            throw new OrderNotGotten($ID, $e);
        }

        if (!Order::isValid($order)) {
            throw new OrderNotFound($ID);
        }

        return $order;
    }
}
