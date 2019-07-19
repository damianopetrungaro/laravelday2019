<?php

declare(strict_types=1);

namespace OrderService\UseCases;

use OrderService\Repository\OrderRepository;
use OrderService\ValueObjects\ID;

final class MarkOrderAsShipped
{
    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ID $ID): void
    {
        $order = $this->repository->getByID($ID);
        $order->markAsShipped();
        $this->repository->add($order);
    }
}
