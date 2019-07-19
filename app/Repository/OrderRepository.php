<?php

declare(strict_types=1);

namespace OrderService\Repository;

use OrderService\Aggregates\Order;
use OrderService\ValueObjects\ID;

interface OrderRepository
{
    public function nextID(): ID;

    public function add(Order $order): void;

    public function getByID(ID $ID): Order;
}
